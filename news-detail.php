<?php
/* =============================================================
   お知らせ詳細（news-detail.php）

   Figma: PC `510:443`（1440×1731）/ SP `510:468`（375×1480）
   構成: パンくず（3階層）→ 日付 → タイトル → 本文 → 一覧に戻る

   ブログ詳細と違い、目次・サイドバー・関連記事は無い。
   本文は1200px 幅いっぱいに流す1カラム。

   見出しと日付はブログ詳細と同じ見た目なので `.p-article__title` /
   `.p-article__date` をそのまま使い回している。

   本文の中身は Figma がすべてダミー文言なので、そのまま再現している。
   TODO: CMS ないしデータファイルから読む形に置き換える。
   ============================================================= */

$news = [
    'date'  => '2023/00/00',
    'title' => 'タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル',
    'body'  => '本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー',
];

$page_title       = 'タイトルタイトルタイトルタイトルタイトル｜楽園雅苑';
$page_description = '楽園雅苑からのお知らせです。';

// 3階層。最後はお知らせのタイトル（breadcrumb-spec.md 準拠で5単位に省略）
$breadcrumb = [
    ['href' => '/',         'label' => 'トップ'],
    ['href' => '/news.php', 'label' => 'お知らせ'],
    ['label' => 'タイトルタイトルタイトルタイトルタイトル'],
];

require __DIR__ . '/includes/header.php';
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <article class="p-news-detail">
            <div class="p-news-detail__inner l-inner">

                <time class="p-article__date p-news-detail__date" datetime="2023-01-01"><?php echo h($news['date']); ?></time>

                <h1 class="p-article__title p-news-detail__title"><?php echo h($news['title']); ?></h1>

                <div class="p-news-detail__body">
                    <p><?php echo h($news['body']); ?></p>
                </div>

                <div class="p-news-detail__action">
                    <!-- 矢印が左を向く「戻る」向きのボタン。
                         向きだけが違うので、同じ SVG を CSS で左右反転している -->
                    <a class="c-btn-more c-btn-more--back" href="/news.php">
                        <span class="c-btn-more__label">一覧に戻る</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </article>

<?php require __DIR__ . '/includes/footer.php'; ?>
