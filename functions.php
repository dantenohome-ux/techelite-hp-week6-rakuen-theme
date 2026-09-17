<?php
/* =============================================================
   テーマの基本設定と、CSS / JS の読み込み

   テーマ内のファイルを指すURLは、必ず get_template_directory_uri() で
   組む。静的サイトのように「/css/style.css」と書くと、WordPress を
   サブディレクトリに置いた瞬間に全部外れるため。

   ※ PHP の終了タグ ?> は書かない（末尾の空白が出力に混ざるのを防ぐ）
   ============================================================= */


/**
 * テーマがサポートする機能と、メニューの表示場所の登録。
 *
 * title-tag       … <title> を WordPress 側に出力させる。
 *                   各テンプレートに <title> を書かなくてよくなる。
 * post-thumbnails … 投稿・固定ページでアイキャッチ画像を使えるようにする。
 *
 * register_nav_menus() で登録した4箇所が、管理画面の
 * 「外観 → メニュー → メニュー設定（表示位置）」に並ぶ。
 */
function rakuen_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'global'     => 'グローバルナビ（ヘッダー）',
        'drawer'     => 'SPメニュー追加分（ドロワー下部）',
        'footer'     => 'フッターメニュー',
        'footer_sub' => 'フッターサブメニュー',
    ]);
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
 * ナビゲーションの既定の内容。
 *
 * 管理画面でメニューを作る前（＝表示位置にメニューが割り当てられていない間）に
 * 出す中身として使う。割り当て後は wp_nav_menu() の内容が使われ、こちらは
 * 呼ばれない。テーマを別の環境に移した直後でもナビが消えないようにするための保険。
 *
 * 予約ボタンはメニュー項目ではなく CTA なので、管理画面のメニューには載せず
 * 常にこの一覧から出す。
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


/**
 * 表示位置ごとに使うクラス名。
 *
 * wp_nav_menu() の既定の出力は menu-item などの WordPress 独自クラスになるが、
 * このサイトの CSS は静的サイト時代のクラス名（l-header__item など）で書かれている。
 * CSS を書き換えずに済ませるため、表示位置ごとに「本来付けたいクラス名」を
 * ここで一覧にし、出力時とフィルタの両方から参照する。
 *
 * @return array{menu: string, item: string, link: string}|array{}
 */
function rakuen_nav_classes(string $location): array
{
    $map = [
        'global'     => ['menu' => 'l-header__menu',                     'item' => 'l-header__item', 'link' => 'l-header__link'],
        'drawer'     => ['menu' => 'l-header__menu l-header__menu--sub', 'item' => 'l-header__item', 'link' => 'l-header__link'],
        'footer'     => ['menu' => 'l-footer__menu',                     'item' => 'l-footer__item', 'link' => 'l-footer__link'],
        'footer_sub' => ['menu' => 'l-footer__menu l-footer__menu--sub', 'item' => 'l-footer__item', 'link' => 'l-footer__link'],
    ];

    return $map[$location] ?? [];
}


/**
 * 指定した表示位置のメニューを出力する。
 *
 * header.php / footer.php からはこの関数だけを呼ぶ。
 *
 *   container   … 既定では <div> で囲まれるが、テンプレート側に <nav> があるので不要
 *   items_wrap  … <ul> のクラスを既存CSSのものに差し替える
 *   depth  = 1  … このサイトのナビは階層なし。子メニューを作っても出さない
 *   fallback_cb … 表示位置にメニューが未割り当てのときに呼ばれる関数
 */
function rakuen_nav_menu(string $location): void
{
    $classes = rakuen_nav_classes($location);

    if ($classes === []) {
        return;
    }

    wp_nav_menu([
        'theme_location' => $location,
        'container'      => false,
        'items_wrap'     => '<ul class="' . esc_attr($classes['menu']) . '">%3$s</ul>',
        'depth'          => 1,
        'fallback_cb'    => 'rakuen_nav_menu_fallback',
    ]);
}


/**
 * メニューが未割り当てのときの代わりの出力。
 *
 * wp_nav_menu() が引数の配列をそのまま渡してくるので、
 * どの表示位置から呼ばれたかは $args['theme_location'] で分かる。
 */
function rakuen_nav_menu_fallback(array $args): void
{
    $location = $args['theme_location'] ?? '';
    $classes  = rakuen_nav_classes($location);

    if ($classes === []) {
        return;
    }

    // 表示位置ごとに、既定の一覧のどれを組み合わせるか
    $groups = [
        'global'     => ['global'],
        'drawer'     => ['content', 'utility'],
        'footer'     => ['global', 'content'],
        'footer_sub' => ['utility'],
    ];

    $items = [];
    foreach ($groups[$location] ?? [] as $group) {
        $items = array_merge($items, rakuen_nav_items($group));
    }

    if ($items === []) {
        return;
    }

    echo '<ul class="' . esc_attr($classes['menu']) . '">';
    foreach ($items as $item) {
        echo '<li class="' . esc_attr($classes['item']) . '">';
        echo '<a class="' . esc_attr($classes['link']) . '" href="' . esc_url($item['href']) . '">' . esc_html($item['label']) . '</a>';
        echo '</li>';
    }
    echo '</ul>';
}


/**
 * メニュー項目の <li> に、既存CSSのクラスを足す。
 *
 * WordPress が付ける current-menu-item（現在地）はそのまま残す。
 * 現在地の見た目は CSS 側（.l-header__item.current-menu-item など）で付ける。
 *
 * @param array<int, string> $classes
 * @param WP_Post            $item
 * @param stdClass           $args
 * @return array<int, string>
 */
function rakuen_nav_menu_item_class(array $classes, $item, $args): array
{
    $map = rakuen_nav_classes($args->theme_location ?? '');

    if ($map !== []) {
        $classes[] = $map['item'];
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'rakuen_nav_menu_item_class', 10, 3);


/**
 * メニュー項目の <a> に、既存CSSのクラスを足す。
 *
 * 現在地の <a> に付く aria-current="page" は WordPress が自動で付けるため、
 * ここでは触らない。
 *
 * @param array<string, string> $atts
 * @param WP_Post               $item
 * @param stdClass              $args
 * @return array<string, string>
 */
function rakuen_nav_menu_link_attributes(array $atts, $item, $args): array
{
    $map = rakuen_nav_classes($args->theme_location ?? '');

    if ($map === []) {
        return $atts;
    }

    $atts['class'] = trim(($atts['class'] ?? '') . ' ' . $map['link']);

    return $atts;
}
add_filter('nav_menu_link_attributes', 'rakuen_nav_menu_link_attributes', 10, 3);
