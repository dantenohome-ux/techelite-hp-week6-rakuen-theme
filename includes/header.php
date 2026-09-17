<?php
/* =============================================================
   共通ヘッダー（<!DOCTYPE> 〜 <main> の開始タグまで）

   使い方：各ページの先頭で $page_title / $page_description を
   設定してから require する。設定しなければトップページの値になる。

       <?php
       $page_title       = '運営会社情報｜楽園雅苑';
       $page_description = '楽園雅苑を運営する桜庭観光株式会社のご案内です。';
       require __DIR__ . '/includes/header.php';
       ?>

   ナビゲーションの定義（$global_nav ほか）もこのファイルに置き、
   footer.php がそれをそのまま使い回す。
   ＝ サイト内リンクの定義は、このファイル1箇所だけ。
   ============================================================= */

// h()（出力用エスケープ）/ current_page() / is_current() を使うため。
// require_once なので、すでに読み込まれていれば何も起きない
require_once __DIR__ . '/functions.php';

// ?? は「左辺が未定義または null なら右辺を使う」演算子（null合体演算子）
$page_title       = $page_title       ?? '楽園雅苑 - 桜庭温泉の隠れ家 -';
$page_description = $page_description ?? '桜庭温泉の静かな山あいに佇む全12室の温泉旅館「楽園雅苑」。四季の移ろいを望む客室と、地の恵みを生かした会席料理でお迎えします。';

/* 検索結果に出したくないページで true にする。
   予約の確認・完了画面（本人しか意味を持たない）と 404 が該当する。
   ページ側で $page_noindex = true; と書いてから読み込む */
$page_noindex     = $page_noindex     ?? false;

// 表示中のファイル名（例：about.php）。ナビの現在地判定と og:url に使う
$current_page = current_page();

// TOP かどうか。TOP だけヘッダーの背景帯を外し、ヒーロー画像に透過で重ねる（Figma準拠）
$is_top = ($current_page === 'index.php');

// OGP用の絶対URL（ドメインはダミー）。TOP だけファイル名を付けない
$site_url = 'https://rakugaen.example.com';
$page_url = $site_url . '/' . ($is_top ? '' : $current_page);


/* ---- ナビゲーション定義 ------------------------------------
   ページを増やすときは、該当する配列に1行足すだけでよい。

   href    … リンク先。ルート相対パス（先頭が /）で書く。
             .htaccess でディレクトリ型URL（/about/）にする際も、
             書き換えるのはここだけで済む。
   label   … 画面に出す文言。
   current … そのファイルを開いているとき、この項目を現在地として
             印を付けるファイル名の一覧。
             お部屋 / プラン / 四季 / アクセス は TOP 内アンカーなので
             空にしてある（TOPで4項目が同時に光るのを避けるため）。

   3つに分けている理由は、置き場所ごとに出す組み合わせが違うから：
     ヘッダーPCナビ  … $global_nav ＋ 予約ボタン
     SPドロワー      … $global_nav ＋ $content_nav ＋ $utility_nav ＋ 予約ボタン
     フッター宿ナビ  … $global_nav ＋ $content_nav（＝7項目）
     フッターサブナビ… $utility_nav（＝3項目）
   ------------------------------------------------------------ */

// メインの5項目。前半4つは TOP 内のセクションへのアンカー
$global_nav = [
    ['href' => '/index.php#room',    'label' => 'お部屋',            'current' => []],
    ['href' => '/index.php#plan',    'label' => 'プラン',            'current' => []],
    ['href' => '/index.php#seasons', 'label' => '四季',              'current' => []],
    ['href' => '/index.php#access',  'label' => 'アクセス',           'current' => []],
    ['href' => '/service.php',       'label' => '楽園雅苑のサービス',  'current' => ['service.php']],
];

// 更新系コンテンツ。一覧ページを開いても、詳細ページを開いても現在地にする
$content_nav = [
    ['href' => '/blog.php', 'label' => 'ブログ',   'current' => ['blog.php', 'blog-detail.php']],
    ['href' => '/news.php', 'label' => 'お知らせ', 'current' => ['news.php', 'news-detail.php']],
];

// 会社情報・規約類。フッター下段とSPドロワーの下部に出す
$utility_nav = [
    ['href' => '/about.php',   'label' => '運営会社情報',        'current' => ['about.php']],
    ['href' => '/privacy.php', 'label' => 'プライバシーポリシー', 'current' => ['privacy.php']],
    ['href' => '/terms.php',   'label' => '利用規約',            'current' => ['terms.php']],
];

// 予約ボタン。ナビ項目ではなくCTAなので配列にせず単体で持つ
$reserve_nav = [
    'href'    => '/contact.php',
    'label'   => '予約',
    'current' => ['contact.php', 'confirm.php', 'thanks.php'],
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($page_title); ?></title>
    <meta name="description" content="<?php echo h($page_description); ?>">
<?php if ($page_noindex): ?>
    <meta name="robots" content="noindex">
<?php endif; ?>

    <!-- ファビコン（画像は images/common/ に後から配置してください） -->
    <link rel="icon" href="/images/common/favicon.ico" sizes="any">
    <link rel="icon" href="/images/common/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/images/common/apple-touch-icon.png">

    <!-- OGP（SNSシェア時のカード表示用。URL・画像はダミーです） -->
    <meta property="og:type" content="<?php echo $is_top ? 'website' : 'article'; ?>">
    <meta property="og:site_name" content="楽園雅苑">
    <meta property="og:title" content="<?php echo h($page_title); ?>">
    <meta property="og:description" content="<?php echo h($page_description); ?>">
    <meta property="og:url" content="<?php echo h($page_url); ?>">
    <meta property="og:image" content="<?php echo h($site_url); ?>/images/ogp.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="楽園雅苑の外観">
    <meta property="og:locale" content="ja_JP">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo h($page_title); ?>">
    <meta name="twitter:description" content="<?php echo h($page_description); ?>">
    <meta name="twitter:image" content="<?php echo h($site_url); ?>/images/ogp.png">

    <!-- Webフォント：Noto Serif JP（明朝）のみ。
         Figma は本文・見出し・ナビ・フッターまですべて明朝で、
         ゴシックを使う箇所が無いため Noto Sans JP は読み込まない。

         ウェイトも CSS で実際に使っている 400（本文・見出し）と
         600（記事本文の strong）だけに絞っている。
         日本語フォントは1ウェイトあたりの容量が大きく、使わないものを
         並べると表示開始が目に見えて遅くなるため。

         display=swap … フォントの到着を待たずに代替フォントで先に表示する -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- このCSSは日本語の字形を細かく分けた指定が並ぶため約60KBある。
         そのまま読み込むと、届くまでページが表示され始めない。
         いったん media="print"（＝印刷用）として読み込ませて表示待ちの
         対象から外し、届いた時点で media を all に戻して適用する。
         display=swap を付けているので、どちらにせよ最初は代替フォントで
         表示され、あとから明朝に入れ替わる動きは変わらない。
         JavaScript が無い環境のために noscript で通常の読み込みも置く -->
    <link rel="preload" as="style"
          href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;600&display=swap">
    <link rel="stylesheet" media="print" onload="this.media='all'; this.onload=null;"
          href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;600&display=swap">
    <noscript>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;600&display=swap">
    </noscript>

    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <!-- 支援技術向け：ナビを読み飛ばして本文へ移動するリンク（フォーカス時だけ見える） -->
    <a class="c-skip-link" href="#main">本文へスキップ</a>

    <!-- ============================= ヘッダー ============================= -->
    <!-- TOP のみ背景帯なし（ヒーロー画像の上に透過で重なる） -->
    <header class="l-header<?php echo $is_top ? ' l-header--transparent' : ''; ?>">
        <div class="l-header__inner">

            <!-- ロゴが TOP へのリンクを兼ねる（ヘッダーに「TOP」の文字リンクは置かない） -->
            <a class="l-header__logo" href="/">
                <!-- 濃色のヘッダーに載るので白版。Figma実測 PC 150×58.63 / SP 102.33×40 -->
                <img class="l-header__logo-image" src="/images/common/logo-white.svg"
                     alt="楽園雅苑" width="150" height="59">
            </a>

            <!-- SP ではこの nav 全体が全画面ドロワーになる（開閉は js/main.js が制御） -->
            <nav class="l-header__nav" id="global-nav" aria-label="メインナビゲーション">

                <!-- 主要5項目。PC ではこれだけが横並びで見える -->
                <ul class="l-header__menu">
                    <?php foreach ($global_nav as $item): ?>
                        <?php $is_current = is_current($item['current']); ?>
                        <li class="l-header__item">
                            <a class="l-header__link<?php echo $is_current ? ' is-current' : ''; ?>"
                               href="<?php echo h($item['href']); ?>"
                               <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo h($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- ここから下は SP ドロワーのみ表示（PC ではフッターが受け持つ）。
                     Figma の SP メニューは5項目しかなく下層ページへ到達できないため、
                     ブログ・お知らせ・運営会社情報などを補っている -->
                <div class="l-header__drawer-sub">
                    <ul class="l-header__menu l-header__menu--sub">
                        <?php foreach (array_merge($content_nav, $utility_nav) as $item): ?>
                            <?php $is_current = is_current($item['current']); ?>
                            <li class="l-header__item">
                                <a class="l-header__link<?php echo $is_current ? ' is-current' : ''; ?>"
                                   href="<?php echo h($item['href']); ?>"
                                   <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo h($item['label']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- ドロワー内の予約ボタン（ヘッダー右のピルは SP でも常時見えているが、
                         メニューを開いたまま予約できるようにこちらにも置く） -->
                    <a class="c-btn-reserve c-btn-reserve--drawer" href="<?php echo h($reserve_nav['href']); ?>"><?php echo h($reserve_nav['label']); ?></a>
                </div>
            </nav>

            <!-- ヘッダー右に常設する予約ボタン（PC 140×40 / SP 80×26） -->
            <?php $is_current = is_current($reserve_nav['current']); ?>
            <a class="c-btn-reserve c-btn-reserve--header"
               href="<?php echo h($reserve_nav['href']); ?>"
               <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo h($reserve_nav['label']); ?></a>

            <!-- SP用ハンバーガー（開閉は js/main.js が制御）
                 aria-controls で「このボタンが操作する対象」を、
                 aria-expanded で「いま開いているか」を支援技術に伝える -->
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
