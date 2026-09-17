<?php
/* =============================================================
   お知らせ一覧（news.php）

   Figma: PC `510:264`（1440×2632）/ SP `510:265`
   構成: パンくず → ページタイトル → お知らせ10件 → ページャー

   1行は TOP の新着お知らせと同じ `.c-list-news` を使う。
   ページャーもブログ一覧と同じ `includes/pagination.php`。

   ページ送りは今回は見た目のみ（URL 設計だけ先に確保）。
   ============================================================= */

$page_title       = 'お知らせ｜楽園雅苑';
$page_description = '楽園雅苑からのお知らせ。営業時間の変更、季節のご案内、施設のメンテナンス情報などをお伝えします。';

$breadcrumb = [
    ['href' => '/', 'label' => 'トップ'],
    ['label' => 'お知らせ'],
];

require __DIR__ . '/includes/header.php';


/* ---- 掲載データ --------------------------------------------
   TODO: 現在はダミー10件。文言・日付は Figma のダミーのまま。
   ------------------------------------------------------------ */
$news = [];
for ($i = 0; $i < 10; $i++) {
    $news[] = [
        'date'  => '2023/00/00',
        'title' => 'お知らせタイトルお知らせタイトルお知らせタイトルお知らせタイトル',
    ];
}

$total_pages  = 5;
$current_page = 1;
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">お知らせ</h1>
        </div>

        <section class="p-news-list">
            <div class="p-news-list__inner l-inner">

                <ul class="p-news-list__list">
                    <?php foreach ($news as $item): ?>
                        <li class="c-list-news">
                            <!-- TODO: 1件ごとの URL（/news-detail.php?slug=…）にする -->
                            <a class="c-list-news__link" href="/news-detail.php">
                                <time class="c-list-news__date"><?php echo h($item['date']); ?></time>
                                <h2 class="c-list-news__title"><?php echo h($item['title']); ?></h2>

                                <span class="c-list-news__arrow" aria-hidden="true">
                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" focusable="false">
                                        <path d="M0.0456135 13.9201L11.8175 7L0.0456135 0.0798832"
                                              stroke="currentColor" stroke-miterlimit="10"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <?php
                $pagination_base = '/news.php';
                require __DIR__ . '/includes/pagination.php';
                ?>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
