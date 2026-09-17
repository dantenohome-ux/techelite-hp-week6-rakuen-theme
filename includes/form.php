<?php
/* =============================================================
   予約フォームの定義・検証・セッション管理

   contact.php（入力）→ confirm.php（確認）→ thanks.php（完了）の
   3画面で共用する。画面ごとに散らばると項目の追加漏れが起きるため、
   「どんな項目があるか」「何を正しいとするか」はこのファイルだけが持つ。

   画面遷移の考え方（PRG パターン）
     入力 --POST--> 検証OK ならセッションに保存し confirm.php へ 303 リダイレクト
     確認 --POST--> 送信処理 → 完了フラグを立てて thanks.php へ 303 リダイレクト

   POST の結果をそのまま表示せずリダイレクトを挟むのは、
   完了画面でブラウザを再読み込みしても再送信されないようにするため。
   ============================================================= */

require_once __DIR__ . '/functions.php';


/* =============================================================
   セッション
   ============================================================= */

/**
 * 3画面で入力値を持ち回るためのセッションを開始する。
 *
 * すでに開始済みなら何もしない（各ページの先頭で気軽に呼べるようにするため）。
 * Cookie の属性は既定値に任せず明示する：
 *   httponly … JavaScript から読めなくする（XSS でセッションを盗まれにくくする）
 *   samesite … 他サイトからの遷移で Cookie を送らない（CSRF の緩和）
 *   secure   … HTTPS のときだけ送る。開発環境（http）では付けない
 */
function form_session_start(): void
{
    if (session_status() !== PHP_SESSION_NONE) {
        return;
    }

    $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => $is_https,
        'path'     => '/',
    ]);
    session_start();
}


/**
 * 指定した URL へ移動して、その場で実行を終える。
 *
 * 303 See Other は「POST の結果はこの URL を GET して見てください」の意味。
 * 302 でも動くが、303 のほうが PRG の意図が正確に伝わる。
 *
 * exit を忘れるとリダイレクトを送ったあとも下の HTML が出力されてしまうので、
 * 必ずこの関数を通して移動する。
 */
function form_redirect(string $path): void
{
    header('Location: ' . $path, true, 303);
    exit;
}


/* =============================================================
   CSRF 対策

   「利用者が意図していないのに、別サイトに仕込まれたフォームから
   送信させられる」攻撃を防ぐ。セッションにだけ入っている合言葉を
   hidden で一緒に送らせ、一致しない POST は受け付けない。
   ============================================================= */

/** セッションの CSRF トークンを返す（無ければ作る） */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        // random_bytes は暗号論的に安全な乱数。rand() や uniqid() では推測される
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}


/**
 * 送られてきたトークンが正しいか。
 *
 * hash_equals は「先頭何文字まで一致したか」で処理時間が変わらない比較。
 * === だと不一致の位置で早く抜けるため、時間差からトークンを1文字ずつ
 * 推測される余地が残る。
 */
function csrf_valid(mixed $token): bool
{
    return !empty($_SESSION['csrf_token'])
        && is_string($token)
        && hash_equals($_SESSION['csrf_token'], $token);
}


/* =============================================================
   選択肢

   プルダウンの中身。confirm.php で「保存された値が本当に選択肢の
   ひとつか」を確かめるのにも使う（画面に出していない値を送られても
   受け付けないようにするため）。
   ============================================================= */

/**
 * 宿泊日の選択肢。
 *
 * キー  … 保存・比較に使う値（2026-09-04）
 * 値    … 画面に出す文言（2026/09/04）
 *
 * 明日から $days 日ぶんを並べる。当日予約は受け付けない前提。
 * TODO: 実運用では空室状況を見て、埋まっている日を除くことになる。
 */
function reserve_date_options(int $days = 90): array
{
    $options = [];
    $date    = new DateTimeImmutable('tomorrow');

    for ($i = 0; $i < $days; $i++) {
        $day = $date->modify("+{$i} day");
        $options[$day->format('Y-m-d')] = $day->format('Y/m/d');
    }
    return $options;
}


/**
 * 部屋タイプ（＝宿泊プラン）の選択肢。
 *
 * Figma では入力画面のラベルが「ご希望の宿泊プラン」、確認画面が
 * 「部屋のタイプ」と食い違っているが、指すものは同じなので1項目で扱う。
 * 中身は TOP ページの $rooms / $plans と同じ3種類。
 */
function reserve_plan_options(): array
{
    return [
        'standard' => 'スタンダードルーム',
        'deluxe'   => 'デラックスルーム',
        'premier'  => 'プレミアスィート',
    ];
}


/** 人数の選択肢を「1名」「2名」…の形で作る */
function reserve_count_options(int $min, int $max): array
{
    $options = [];
    for ($i = $min; $i <= $max; $i++) {
        $options[(string) $i] = $i . '名';
    }
    return $options;
}


/**
 * 入力項目の定義。
 *
 * label    … 入力画面のラベル
 * confirm  … 確認画面のラベル（入力画面と違うときだけ書く）
 * required … 必須か（Figma で赤い ＊ が付いている項目）
 * options  … プルダウンの場合の選択肢
 *
 * 並び順がそのまま確認画面の表示順になる。
 */
function reserve_fields(): array
{
    return [
        'name'     => ['label' => 'お名前',           'required' => true],
        'email'    => ['label' => 'メールアドレス',     'required' => true],
        'tel'      => ['label' => '電話番号',          'required' => true],

        // 住所は4項目に分かれているが、確認画面では1行にまとめて出す
        'zip'      => ['label' => '郵便番号',          'required' => true],
        'pref'     => ['label' => '都道府県',          'required' => true],
        'city'     => ['label' => '市区町村',          'required' => true],
        'street'   => ['label' => '町域・番地・建物名', 'required' => true],

        'checkin'  => ['label' => 'チェックイン日',    'required' => true, 'options' => reserve_date_options()],
        'checkout' => ['label' => 'チェックアウト日',  'required' => true, 'options' => reserve_date_options()],
        'plan'     => ['label' => 'ご希望の宿泊プラン', 'required' => true, 'options' => reserve_plan_options(),
                       'confirm' => '部屋のタイプ'],
        'adults'   => ['label' => '大人の人数',        'required' => true, 'options' => reserve_count_options(1, 10)],
        'children' => ['label' => 'お子様の人数',      'required' => true, 'options' => reserve_count_options(0, 10)],

        'request'  => ['label' => '特別リクエスト',    'required' => false],
    ];
}


/* =============================================================
   検証
   ============================================================= */

/**
 * POST された値を整えて取り出す。
 *
 * ・配列で送られてきた項目は文字列として扱えないので空にする
 *   （name="tel[]" のように細工された POST への備え）
 * ・前後の空白と、貼り付けで混入しがちな制御文字を取り除く
 * ・改行は特別リクエストだけ残す（他の項目に改行は入らない）
 */
function reserve_input(array $source): array
{
    $values = [];

    foreach (reserve_fields() as $key => $field) {
        $raw = $source[$key] ?? '';
        if (!is_string($raw)) {
            $raw = '';
        }

        // 特別リクエスト以外は改行も削る
        $pattern = ($key === 'request') ? '/[^\P{C}\n]/u' : '/\p{C}/u';
        $raw     = (string) preg_replace($pattern, '', $raw);

        $values[$key] = trim($raw);
    }
    return $values;
}


/**
 * 入力値を検証し、項目名 => エラー文言 の配列を返す。
 * 問題が無ければ空配列。
 *
 * 文字数は mb_strlen（文字単位）で数える。strlen だと UTF-8 の
 * 日本語が1文字3バイトとして数えられ、実際より短い入力で弾かれる。
 */
function validate_reservation(array $values): array
{
    $errors = [];
    $fields = reserve_fields();

    // ---- 必須チェック（まとめて） ----
    foreach ($fields as $key => $field) {
        if (!empty($field['required']) && $values[$key] === '') {
            $errors[$key] = $field['label'] . 'を入力してください。';
        }
    }
    // プルダウンは「入力」ではなく「選択」なので文言を変える
    foreach ($fields as $key => $field) {
        if (isset($errors[$key]) && isset($field['options'])) {
            $errors[$key] = $field['label'] . 'を選択してください。';
        }
    }

    // ---- 項目ごとの形式チェック ----
    // 未入力の項目は上で報告済みなので、ここでは中身がある場合だけ見る

    if ($values['name'] !== '' && mb_strlen($values['name']) > 50) {
        $errors['name'] = 'お名前は50文字以内で入力してください。';
    }

    if ($values['email'] !== '') {
        if (mb_strlen($values['email']) > 254) {
            $errors['email'] = 'メールアドレスは254文字以内で入力してください。';
        } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'メールアドレスの形式が正しくありません。';
        }
    }

    // 数字とハイフンのみ。ハイフンを除いた数字が10〜11桁（固定電話・携帯）
    if ($values['tel'] !== '') {
        $digits = preg_replace('/[^0-9]/', '', $values['tel']);
        if (!preg_match('/\A[0-9-]+\z/', $values['tel']) || strlen($digits) < 10 || strlen($digits) > 11) {
            $errors['tel'] = '電話番号は半角数字とハイフンで、10〜11桁で入力してください。';
        }
    }

    if ($values['zip'] !== '' && !preg_match('/\A\d{3}-?\d{4}\z/', $values['zip'])) {
        $errors['zip'] = '郵便番号は「000-0000」の形式で入力してください。';
    }

    if ($values['pref'] !== '' && mb_strlen($values['pref']) > 10) {
        $errors['pref'] = '都道府県は10文字以内で入力してください。';
    }

    if ($values['city'] !== '' && mb_strlen($values['city']) > 50) {
        $errors['city'] = '市区町村は50文字以内で入力してください。';
    }

    if ($values['street'] !== '' && mb_strlen($values['street']) > 100) {
        $errors['street'] = '町域・番地・建物名は100文字以内で入力してください。';
    }

    if ($values['request'] !== '' && mb_strlen($values['request']) > 1000) {
        $errors['request'] = '特別リクエストは1000文字以内で入力してください。';
    }

    // ---- プルダウンは「選択肢の中の値か」を確かめる ----
    // 画面に出していない値を送られても受け付けないようにする
    foreach ($fields as $key => $field) {
        if (!isset($field['options']) || $values[$key] === '' || isset($errors[$key])) {
            continue;
        }
        if (!array_key_exists($values[$key], $field['options'])) {
            $errors[$key] = $field['label'] . 'は一覧から選択してください。';
        }
    }

    // ---- 日付の前後関係 ----
    // 両方が選択肢として正しいときだけ比べる
    if ($values['checkin'] !== '' && $values['checkout'] !== ''
        && !isset($errors['checkin']) && !isset($errors['checkout'])
        && $values['checkout'] <= $values['checkin']) {
        // Y-m-d は文字列のまま比べても日付順になる（0埋めの固定長のため）
        $errors['checkout'] = 'チェックアウト日はチェックイン日より後の日付を選択してください。';
    }

    return $errors;
}


/**
 * 保存された値を、確認画面に出す「ラベル => 表示する文言」の配列にする。
 *
 * ・プルダウンは保存値（deluxe）ではなく表示名（デラックスルーム）に直す
 * ・住所4項目は Figma に合わせて1件にまとめる
 */
function reserve_summary(array $values): array
{
    $fields  = reserve_fields();
    $summary = [];

    foreach ($fields as $key => $field) {
        // 住所は zip の位置に1件だけ出し、他3つは飛ばす
        if (in_array($key, ['pref', 'city', 'street'], true)) {
            continue;
        }

        if ($key === 'zip') {
            $summary[] = [
                'label' => 'ご住所',
                // 郵便番号・都道府県・市区町村・町域は改行して並べる
                'lines' => [
                    '〒' . $values['zip'],
                    $values['pref'] . ' ' . $values['city'],
                    $values['street'],
                ],
            ];
            continue;
        }

        $text = $values[$key];
        if (isset($field['options'])) {
            $text = $field['options'][$text] ?? $text;
        }

        $summary[] = [
            'label' => $field['confirm'] ?? $field['label'],
            // 特別リクエストは改行をそのまま活かしたいので行に分ける
            'lines' => ($text === '') ? ['—'] : preg_split('/\R/u', $text),
        ];
    }
    return $summary;
}


/* =============================================================
   送信
   ============================================================= */

/**
 * 予約内容を送信する。
 *
 * TODO: いまは中身が空の仮実装で、常に成功を返す。
 *       実運用では以下のどちらかに置き換える。
 *         ・mail() / PHPMailer で宿とお客様へメールを送る
 *         ・予約管理システムの API へ渡す
 *       いずれの場合も、送信元アドレスやヘッダーに入力値を
 *       そのまま入れないこと（メールヘッダーインジェクション対策）。
 *
 * @return bool 送信できたか
 */
function send_reservation(array $values): bool
{
    return true;
}
