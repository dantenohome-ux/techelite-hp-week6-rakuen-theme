<?php
/* =============================================================
   ご予約：入力画面（contact.php）

   Figma: PC `510:30`（1440×3202）/ SP `510:31`（375×3163）
   構成: パンくず → ページタイトル → リード文 → 区切り線
         → 入力フォーム13項目 → 区切り線 → 注記 → 送信ボタン

   PC はラベルを左（330px）・入力欄を右（570px）に並べた2カラム、
   SP はラベルを入力欄の上に積む1カラム。

   検証に通ったら入力値をセッションに預けて confirm.php へ移動する。
   項目の定義と検証は includes/form.php に置いてある。
   ============================================================= */

require_once __DIR__ . '/includes/form.php';

form_session_start();


/* ---- POST の処理 --------------------------------------------
   HTML を1文字でも出す前に済ませる。
   リダイレクト（Location ヘッダー）は本文より先に送る必要があるため。
   ------------------------------------------------------------ */

// 初期値。確認画面から「修正する」で戻ってきたときはセッションの値が入る
$values = $_SESSION['reserve_values'] ?? array_fill_keys(array_keys(reserve_fields()), '');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $values = reserve_input($_POST);

    if (!csrf_valid($_POST['csrf_token'] ?? null)) {
        // 時間が経ってセッションが切れた場合もここに来る。
        // 入力内容は画面に残したまま、送り直してもらう
        $errors['_form'] = '前回の送信から時間が経過したため、内容を確認できませんでした。お手数ですが、もう一度「確認画面へ」を押してください。';
    } else {
        $errors = validate_reservation($values);
    }

    // 入力途中の値も預けておく（再読み込みしても消えないように）
    $_SESSION['reserve_values'] = $values;

    if (!$errors) {
        // 前回の予約の「完了した」印を消す。
        // 残したままだと、今回の予約を送らずに /thanks.php を開いたときに
        // 完了画面が見えてしまう
        unset($_SESSION['reserve_done']);

        form_redirect('/confirm.php');
    }
}


$page_title       = 'ご予約｜楽園雅苑';
$page_description = '楽園雅苑のご予約フォームです。ご希望の宿泊日・お部屋のタイプ・人数をご入力ください。';

$breadcrumb = [
    ['href' => '/', 'label' => 'トップ'],
    ['label' => 'ご予約'],
];

require __DIR__ . '/includes/header.php';

$fields = reserve_fields();

/* 入力欄を1つ出すための小さなヘルパー。
   13項目それぞれに同じ属性（id・aria-invalid・エラー文の紐付け）を
   手で書くと必ずどこかで抜けるので、ここでまとめて組み立てる。 */
$field_attrs = function (string $key) use ($fields, $errors): string {
    $attrs = ' id="' . h($key) . '" name="' . h($key) . '"';

    if (!empty($fields[$key]['required'])) {
        $attrs .= ' required';
    }
    if (isset($errors[$key])) {
        // エラーがある入力欄は、支援技術にもそう伝えたうえで
        // 対応するエラー文を読み上げ対象に含める
        $attrs .= ' aria-invalid="true" aria-describedby="' . h($key) . '-error"';
    }
    return $attrs;
};
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">ご予約</h1>
        </div>

        <section class="p-contact">
            <div class="p-contact__inner l-inner">

                <p class="p-page-lead">「楽園雅苑 - 桜庭温泉の隠れ家 -」へのご予約、心よりお待ちしております。お手数をおかけいたしますが、以下のフォームに必要事項をご記入の上、ご送信ください。</p>

                <hr class="c-divider">

                <?php if ($errors): ?>
                    <!-- エラーの一覧。role="alert" で、表示された時点で読み上げられる。
                         tabindex="-1" は JS でここへフォーカスを移せるようにするため -->
                    <div class="c-form__alert" id="form-alert" role="alert" tabindex="-1">
                        <p class="c-form__alert-title">入力内容をご確認ください</p>
                        <ul class="c-form__alert-list">
                            <?php foreach ($errors as $key => $message): ?>
                                <li>
                                    <?php if ($key === '_form'): ?>
                                        <?php echo h($message); ?>
                                    <?php else: ?>
                                        <a href="#<?php echo h($key); ?>"><?php echo h($message); ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form class="c-form" action="/contact.php" method="post">

                    <!-- 別サイトのフォームから送信されたものを弾くための合言葉 -->
                    <input type="hidden" name="csrf_token" value="<?php echo h(csrf_token()); ?>">

                    <!-- ============ お名前・メール・電話 ============ -->
                    <?php foreach (['name' => 'text', 'email' => 'email', 'tel' => 'tel'] as $key => $type): ?>
                        <div class="c-form__row">
                            <label class="c-form__label" for="<?php echo h($key); ?>">
                                <?php echo h($fields[$key]['label']); ?><span class="c-form__required" aria-hidden="true">＊</span>
                            </label>
                            <div class="c-form__field">
                                <input class="c-form__input" type="<?php echo h($type); ?>"
                                       value="<?php echo h($values[$key]); ?>"
                                       autocomplete="<?php echo $key === 'name' ? 'name' : ($key === 'email' ? 'email' : 'tel'); ?>"
                                       <?php echo $field_attrs($key); ?>>
                                <?php if (isset($errors[$key])): ?>
                                    <p class="c-form__error" id="<?php echo h($key); ?>-error"><?php echo h($errors[$key]); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- ============ ご住所（4項目のまとまり） ============
                         fieldset ではなく role="group" を使っている。
                         fieldset の legend は表示位置を CSS で動かしにくく、
                         Figma の「ラベル列に置く」配置が作れないため -->
                    <div class="c-form__row c-form__row--group" role="group" aria-labelledby="address-label">
                        <span class="c-form__label" id="address-label">
                            ご住所<span class="c-form__required" aria-hidden="true">＊</span>
                        </span>
                        <div class="c-form__field">
                            <?php
                            $address_fields = [
                                'zip'    => ['autocomplete' => 'postal-code',    'inputmode' => 'numeric'],
                                'pref'   => ['autocomplete' => 'address-level1', 'inputmode' => 'text'],
                                'city'   => ['autocomplete' => 'address-level2', 'inputmode' => 'text'],
                                'street' => ['autocomplete' => 'address-line1',  'inputmode' => 'text'],
                            ];
                            ?>
                            <?php foreach ($address_fields as $key => $opt): ?>
                                <div class="c-form__subrow">
                                    <label class="c-form__sublabel<?php echo $key === 'street' ? ' c-form__sublabel--two-line' : ''; ?>" for="<?php echo h($key); ?>">
                                        <?php if ($key === 'street'): ?>
                                            <!-- Figma は PC だけ「町域・番地／建物名」で改行している -->
                                            町域・番地<span class="u-inline-sp">・</span><br class="u-br-pc">建物名
                                        <?php else: ?>
                                            <?php echo h($fields[$key]['label']); ?>
                                        <?php endif; ?>
                                    </label>
                                    <div class="c-form__subfield">
                                        <input class="c-form__input" type="text"
                                               value="<?php echo h($values[$key]); ?>"
                                               autocomplete="<?php echo h($opt['autocomplete']); ?>"
                                               inputmode="<?php echo h($opt['inputmode']); ?>"
                                               <?php echo $field_attrs($key); ?>>
                                        <?php if (isset($errors[$key])): ?>
                                            <p class="c-form__error" id="<?php echo h($key); ?>-error"><?php echo h($errors[$key]); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- ============ プルダウン5項目 ============ -->
                    <?php foreach (['checkin', 'checkout', 'plan', 'adults', 'children'] as $key): ?>
                        <div class="c-form__row">
                            <label class="c-form__label<?php echo $key === 'children' ? ' c-form__label--two-line' : ''; ?>" for="<?php echo h($key); ?>">
                                <?php echo h($fields[$key]['label']); ?><span class="c-form__required" aria-hidden="true">＊</span>
                                <?php if ($key === 'children'): ?>
                                    <span class="c-form__note">(12歳未満)</span>
                                <?php endif; ?>
                            </label>
                            <div class="c-form__field">
                                <!-- 未選択のときだけ文字を薄くしたいので :invalid で色を変える。
                                     そのために先頭の選択肢は value を空にしてある -->
                                <select class="c-form__select" <?php echo $field_attrs($key); ?>>
                                    <option value="">選択してください</option>
                                    <?php foreach ($fields[$key]['options'] as $value => $label): ?>
                                        <option value="<?php echo h($value); ?>"
                                                <?php echo $values[$key] === (string) $value ? 'selected' : ''; ?>><?php echo h($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors[$key])): ?>
                                    <p class="c-form__error" id="<?php echo h($key); ?>-error"><?php echo h($errors[$key]); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- ============ 特別リクエスト（任意） ============ -->
                    <div class="c-form__row">
                        <label class="c-form__label" for="request">特別リクエスト</label>
                        <div class="c-form__field">
                            <textarea class="c-form__textarea" rows="8"
                                      <?php echo $field_attrs('request'); ?>><?php echo h($values['request']); ?></textarea>
                            <?php if (isset($errors['request'])): ?>
                                <p class="c-form__error" id="request-error"><?php echo h($errors['request']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr class="c-divider c-divider--form">

                    <p class="p-contact__note">予約を確認するため、お客様の連絡先情報をご提供いただきます。ご予約に関する詳細情報や特別なリクエストがございましたら、お知らせください。心よりお待ちしております。</p>

                    <div class="c-form__action">
                        <button class="c-btn-submit" type="submit">確認画面へ</button>
                    </div>
                </form>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
