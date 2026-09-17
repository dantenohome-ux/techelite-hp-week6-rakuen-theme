<?php
/* =============================================================
   テーマの基本設定と、CSS / JS の読み込み

   テーマ内のファイルを指すURLは、必ず get_template_directory_uri() で
   組む。静的サイトのように「/css/style.css」と書くと、WordPress を
   サブディレクトリに置いた瞬間に全部外れるため。

   ※ PHP の終了タグ ?> は書かない（末尾の空白が出力に混ざるのを防ぐ）
   ============================================================= */


/**
 * テーマがサポートする機能の登録。
 *
 * title-tag       … <title> を WordPress 側に出力させる。
 *                   各テンプレートに <title> を書かなくてよくなる。
 * post-thumbnails … 投稿・固定ページでアイキャッチ画像を使えるようにする。
 */
function rakuen_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'rakuen_setup');


/**
 * CSS / JS の読み込み。
 *
 * テンプレートに <link> / <script> を直接書かず、必ずここで登録する。
 * そうしておくと読み込み順（依存関係）を WordPress が解決してくれる。
 *
 * ver に filemtime()（ファイルの最終更新時刻）を渡しているのは、
 * CSS を直したのにブラウザが古い内容を使い続ける事故を防ぐため。
 */
function rakuen_enqueue_assets(): void
{
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    // Noto Serif JP（明朝）400 / 600。
    // Figma は見出しから本文まですべて明朝のため、ゴシックは読み込まない。
    // display=swap … フォントの到着を待たず、先に代替フォントで表示する
    wp_enqueue_style(
        'rakuen-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;600&display=swap',
        [],
        null
    );

    // サイト本体のCSS。フォントのあとに読み込ませたいので依存に指定する
    $style_rel  = '/assets/css/style.css';
    $style_file = $theme_dir . $style_rel;
    wp_enqueue_style(
        'rakuen-style',
        $theme_uri . $style_rel,
        ['rakuen-fonts'],
        file_exists($style_file) ? (string) filemtime($style_file) : null
    );

    // ハンバーガーメニュー等のスクリプト。
    // 最後の true は「</body> の直前で読み込む」の意味（表示の妨げにならない）
    $script_rel  = '/assets/js/main.js';
    $script_file = $theme_dir . $script_rel;
    wp_enqueue_script(
        'rakuen-main',
        $theme_uri . $script_rel,
        [],
        file_exists($script_file) ? (string) filemtime($script_file) : null,
        true
    );
}
add_action('wp_enqueue_scripts', 'rakuen_enqueue_assets');


/**
 * ナビゲーションの定義（暫定）。
 *
 * header.php と footer.php の両方から同じリンク一覧を使うための置き場所。
 * ※ header.php で定義した変数は footer.php からは見えない（WordPress は
 *   テンプレートを関数の中で読み込むため）。そこで関数にまとめている。
 *
 * TODO: 手順3で register_nav_menus() + wp_nav_menu() に置き換える。
 *       置き換えたらこの関数は削除すること。
 *
 * @param string $group 'global' | 'content' | 'utility' | 'reserve'
 * @return array<int, array{href: string, label: string}>
 */
function rakuen_nav_items(string $group): array
{
    $items = [
        // メインの5項目。前半4つは TOP 内のセクションへのアンカー
        'global' => [
            ['href' => home_url('/#room'),    'label' => 'お部屋'],
            ['href' => home_url('/#plan'),    'label' => 'プラン'],
            ['href' => home_url('/#seasons'), 'label' => '四季'],
            ['href' => home_url('/#access'),  'label' => 'アクセス'],
            ['href' => home_url('/service/'), 'label' => '楽園雅苑のサービス'],
        ],
        // 更新系コンテンツ
        'content' => [
            ['href' => home_url('/blog/'), 'label' => 'ブログ'],
            ['href' => home_url('/news/'), 'label' => 'お知らせ'],
        ],
        // 会社情報・規約類
        'utility' => [
            ['href' => home_url('/about/'),   'label' => '運営会社情報'],
            ['href' => home_url('/privacy/'), 'label' => 'プライバシーポリシー'],
            ['href' => home_url('/terms/'),   'label' => '利用規約'],
        ],
        // 予約ボタン（ナビ項目ではなくCTAなので1件だけ）
        'reserve' => [
            ['href' => home_url('/contact/'), 'label' => '予約'],
        ],
    ];

    return $items[$group] ?? [];
}
