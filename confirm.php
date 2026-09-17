<?php
/* =============================================================
   ご予約：確認画面（confirm.php）

   Figma: PC `18:583`（1440×2292）/ SP `18:657`（375×2118）
   構成: パンくず（3階層）→ ページタイトル → 区切り線
         → 入力内容の一覧 → 区切り線 → 注記 → 送信ボタン

   PC はラベル左・内容右の2カラムで、上下だけに区切り線。
   SP は1行ごとに区切り線を引き、ラベルの下に内容を置く。

   この画面は「セッションに正しい入力値がある人」だけが見られる。
   直接 URL を開いた場合や、値が壊れている場合は入力画面へ戻す。
   ============================================================= */

require_once __DIR__ . '/includes/form.php';

form_session_start();


/* ---- 表示してよい状態か確かめる ------------------------------ */

$values = $_SESSION['reserve_values'] ?? null;

/* セッションに入力値が無い場合の行き先。
   ・すでに送信を終えている（送信後に戻る／二重送信）→ 完了画面
   ・そもそも入力を経ていない                        → 入力画面 */
if (!is_array($values)) {
    form_redirect(!empty($_SESSION['reserve_done']) ? '/thanks.php' : '/contact.php');
}

// 保存された値をもう一度検証する。
// 入力画面を通っていれば必ず通るが、セッションが古い（選択できる日付が
// 過ぎている等）場合にここで気付ける
if (validate_reservation($values)) {
    form_redirect('/contact.php');
}


/* ---- POST の処理（＝送信の実行） ----------------------------- */

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_valid($_POST['csrf_token'] ?? null)) {
        $errors['_form'] = '前回の送信から時間が経過したため、内容を確認できませんでした。お手数ですが、もう一度「送信する」を押してください。';

    } elseif (empty($_SESSION['reserve_submit_token'])
              || ($_POST['submit_token'] ?? null) !== $_SESSION['reserve_submit_token']) {
        /* 二重送信の対策。
           この画面を表示するたびに1回限りの合言葉を作り、送信時に
           照合してすぐ捨てる。ボタンを続けて2回押した場合、2回目は
           合言葉が残っていないのでここに来る。
           すでに1回目が通っている＝予約は成立しているので、
           エラーにはせず完了画面へ送る */
        form_redirect('/thanks.php');

    } else {
        // 合言葉を先に捨てる。送信処理の途中で例外が出ても、
        // 同じ合言葉で二重に送られることがないようにするため
        unset($_SESSION['reserve_submit_token']);

        if (send_reservation($values)) {
            // 完了画面で内容を出さないので、預かった入力値はここで捨てる。
            // 代わりに「完了した」という印だけ残す
            unset($_SESSION['reserve_values']);
            $_SESSION['reserve_done'] = true;

            form_redirect('/thanks.php');
        }

        $errors['_form'] = '送信に失敗しました。お手数ですが、時間をおいてもう一度お試しください。';
    }
}

// この表示に対する1回限りの合言葉を作る（送信のたびに新しくなる）
$submit_token = bin2hex(random_bytes(16));
$_SESSION['reserve_submit_token'] = $submit_token;


$page_title       = 'ご予約の確認｜楽園雅苑';
$page_description = 'ご入力いただいた予約内容の確認画面です。';
// 入力した本人にしか意味が無い画面なので検索結果に出さない
$page_noindex     = true;

$breadcrumb = [
    ['href' => '/',            'label' => 'トップ'],
    ['href' => '/contact.php', 'label' => 'ご予約'],
    ['label' => '予約内容の確認'],
];

require __DIR__ . '/includes/header.php';

$summary = reserve_summary($values);
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">ご予約の確認</h1>
        </div>

        <section class="p-confirm">
            <div class="p-confirm__inner l-inner">

                <?php if ($errors): ?>
                    <div class="c-form__alert" id="form-alert" role="alert" tabindex="-1">
                        <p class="c-form__alert-title">送信できませんでした</p>
                        <ul class="c-form__alert-list">
                            <?php foreach ($errors as $message): ?>
                                <li><?php echo h($message); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <hr class="c-divider">

                <!-- 「項目名とその内容」の組が並ぶので dl を使う。
                     1組を div で囲むのは、PC で2カラム・SP で罫線付きの
                     行として扱うため（dt と dd を直接 flex にすると
                     行のまとまりを作れない） -->
                <dl class="c-summary">
                    <?php foreach ($summary as $item): ?>
                        <div class="c-summary__row">
                            <dt class="c-summary__label"><?php echo h($item['label']); ?></dt>
                            <dd class="c-summary__value">
                                <?php foreach ($item['lines'] as $i => $line): ?>
                                    <?php echo $i > 0 ? '<br>' : ''; ?><?php echo h($line); ?>
                                <?php endforeach; ?>
                            </dd>
                        </div>
                    <?php endforeach; ?>
                </dl>

                <hr class="c-divider">

                <p class="p-confirm__note">上記の内容で送信いたします</p>

                <form class="c-form" action="/confirm.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo h(csrf_token()); ?>">
                    <input type="hidden" name="submit_token" value="<?php echo h($submit_token); ?>">

                    <div class="c-form__action">
                        <button class="c-btn-submit" type="submit">送信する</button>
                    </div>
                </form>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
