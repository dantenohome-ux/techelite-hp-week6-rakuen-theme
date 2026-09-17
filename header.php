<?php
/* =============================================================
   共通ヘッダー（<!DOCTYPE> 〜 <main> の開始タグまで）

   各テンプレートの先頭で get_header() を呼ぶと、このファイルが読み込まれる。
   ＝ ここを1箇所直せば、全ページのヘッダーに反映される。

   静的サイト版（includes/header.php）からの主な変更点：
     ・<title> は add_theme_support('title-tag') に任せて書かない
     ・CSS / JS / フォントの読み込みは functions.php の wp_enqueue に移した
     ・テーマ内の画像は get_template_directory_uri() で組む
     ・リンク先は home_url()、出力は esc_url() / esc_html() でエスケープ

   TODO: ナビは手順3で wp_nav_menu() に置き換える。
         現在地のハイライトも、その際に current-menu-item で行う。
   ============================================================= */

$theme_uri = get_template_directory_uri();

// TOP かどうか。TOP だけヘッダーの背景帯を外し、ヒーロー画像に透過で重ねる（Figma準拠）
$is_top = is_front_page();

// 説明文は「設定 → 一般 → キャッチフレーズ」の値を使う
$site_description = get_bloginfo('description', 'display');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if ($site_description !== '') : ?>
    <meta name="description" content="<?php echo esc_attr($site_description); ?>">
<?php endif; ?>

    <!-- OGP（SNSシェア時のカード表示用）
         TODO: og:image は画像（ogp.png）を用意したうえで追加すること -->
    <meta property="og:type" content="<?php echo $is_top ? 'website' : 'article'; ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
<?php if ($site_description !== '') : ?>
    <meta property="og:description" content="<?php echo esc_attr($site_description); ?>">
<?php endif; ?>
    <meta property="og:url" content="<?php echo esc_url(is_singular() ? get_permalink() : home_url('/')); ?>">
    <meta property="og:locale" content="ja_JP">

    <!-- Twitter Card（画像未設定のため summary。og:image を用意したら
         summary_large_image に変更する） -->
    <meta name="twitter:card" content="summary">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <!-- 支援技術向け：ナビを読み飛ばして本文へ移動するリンク（フォーカス時だけ見える） -->
    <a class="c-skip-link" href="#main">本文へスキップ</a>

    <!-- ============================= ヘッダー ============================= -->
    <!-- TOP のみ背景帯なし（ヒーロー画像の上に透過で重なる） -->
    <header class="l-header<?php echo $is_top ? ' l-header--transparent' : ''; ?>">
        <div class="l-header__inner">

            <!-- ロゴが TOP へのリンクを兼ねる（ヘッダーに「TOP」の文字リンクは置かない） -->
            <a class="l-header__logo" href="<?php echo esc_url(home_url('/')); ?>">
                <!-- 濃色のヘッダーに載るので白版。Figma実測 PC 150×58.63 / SP 102.33×40 -->
                <img class="l-header__logo-image" src="<?php echo esc_url($theme_uri . '/assets/images/common/logo-white.svg'); ?>"
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="150" height="59">
            </a>

            <!-- SP ではこの nav 全体が全画面ドロワーになる（開閉は assets/js/main.js が制御）。
                 id="global-nav" は main.js が参照しているので変更しないこと -->
            <nav class="l-header__nav" id="global-nav" aria-label="メインナビゲーション">

                <!-- 主要5項目。PC ではこれだけが横並びで見える。
                     中身は管理画面「外観 → メニュー」の
                     「グローバルナビ（ヘッダー）」で編集する -->
                <?php rakuen_nav_menu('global'); ?>

                <!-- ここから下は SP ドロワーのみ表示（PC ではフッターが受け持つ）。
                     Figma の SP メニューは5項目しかなく下層ページへ到達できないため、
                     ブログ・お知らせ・運営会社情報などを補っている -->
                <div class="l-header__drawer-sub">
                    <?php rakuen_nav_menu('drawer'); ?>

                    <!-- ドロワー内の予約ボタン（ヘッダー右のピルは SP でも常時見えているが、
                         メニューを開いたまま予約できるようにこちらにも置く） -->
                    <?php foreach (rakuen_nav_items('reserve') as $item) : ?>
                        <a class="c-btn-reserve c-btn-reserve--drawer" href="<?php echo esc_url($item['href']); ?>"><?php echo esc_html($item['label']); ?></a>
                    <?php endforeach; ?>
                </div>
            </nav>

            <!-- ヘッダー右に常設する予約ボタン（PC 140×40 / SP 80×26） -->
            <?php foreach (rakuen_nav_items('reserve') as $item) : ?>
                <a class="c-btn-reserve c-btn-reserve--header" href="<?php echo esc_url($item['href']); ?>"><?php echo esc_html($item['label']); ?></a>
            <?php endforeach; ?>

            <!-- SP用ハンバーガー（開閉は assets/js/main.js が制御）
                 aria-controls で「このボタンが操作する対象」を、
                 aria-expanded で「いま開いているか」を支援技術に伝える。
                 id="hamburger" は main.js が参照しているので変更しないこと -->
            <button class="l-header__hamburger" id="hamburger" type="button"
                    aria-label="メニューを開く" aria-expanded="false" aria-controls="global-nav">
                <span class="l-header__hamburger-lines" aria-hidden="true">
                    <span class="l-header__hamburger-line"></span>
                    <span class="l-header__hamburger-line"></span>
                    <span class="l-header__hamburger-line"></span>
                </span>
                <span class="l-header__hamburger-label u-serif" aria-hidden="true">menu</span>
            </button>

        </div>
    </header>

    <main id="main">
