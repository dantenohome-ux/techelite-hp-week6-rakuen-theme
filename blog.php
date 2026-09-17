<?php
/* =============================================================
   ブログ一覧（blog.php）

   Figma: PC `510:34`（1440×2877）/ SP `510:35`
   構成: パンくず → ページタイトル → カテゴリ絞り込み
         → 記事カード 3×3 → ページャー

   カードは TOP の新着ブログと同じ `.c-card-article` を使う。

   カテゴリ絞り込みとページャーは今回は見た目のみ。
   リンク先の URL 設計（?category= / ?page=）だけ先に確保しておき、
   絞り込み・ページ送りの処理は入れていない
   （site-structure.md の「ページ数が少ないうちは URL 設計だけ確保」に従う）。
   ============================================================= */

$page_title       = 'ブログ｜楽園雅苑';
$page_description = '楽園雅苑のブログ。周辺の観光地、温泉の豆知識、季節のお料理など、滞在をより楽しんでいただくための記事をお届けします。';

$breadcrumb = [
    ['href' => '/', 'label' => 'トップ'],
    ['label' => 'ブログ'],
];

require __DIR__ . '/includes/header.php';


/* ---- 掲載データ --------------------------------------------
   TODO: 記事は現在ダミー。CMS ないしデータファイルから読む形に置き換える。
         文言・日付は Figma のダミーをそのまま使っている。
   ------------------------------------------------------------ */

// 絞り込みのカテゴリ。slug は URL に、label は画面に出す
$categories = [
    ['slug' => '',       'label' => 'ALL'],
    ['slug' => 'sight',  'label' => '観光地'],
    ['slug' => 'tips',   'label' => '豆知識'],
    ['slug' => 'food',   'label' => '料理'],
];

// いま選ばれているカテゴリ。今回は絞り込み処理を入れないので
// 見た目の現在地表示にだけ使う
$current_category = isset($_GET['category']) ? (string) $_GET['category'] : '';

// 記事9件。Figma は3列×3行で、列ごとにカテゴリが決まっている。
// HTML は左上から横に並ぶので、1行ぶん（3列）を3回繰り返せばよい
$posts = [];
for ($row = 0; $row < 3; $row++) {
    foreach (['観光地', '豆知識', '料理'] as $category) {
        $posts[] = [
            'date'     => '2023/00/00',
            'title'    => 'ブログタイトルブログタイトルブログタイトルブログタイトル',
            'category' => $category,
        ];
    }
}

// ページャー。今回は見た目のみなので総ページ数は固定
$total_pages   = 5;
$current_page  = 1;
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">ブログ</h1>
        </div>

        <section class="p-blog-list">
            <div class="p-blog-list__inner l-inner">

                <!-- カテゴリ絞り込み。現在地は aria-current で示す -->
                <nav class="c-filter" aria-label="カテゴリで絞り込む">
                    <ul class="c-filter__list">
                        <?php foreach ($categories as $cat): ?>
                            <?php $is_on = ($cat['slug'] === $current_category); ?>
                            <li>
                                <a class="c-filter-chip<?php echo $is_on ? ' is-current' : ''; ?>"
                                   href="/blog.php<?php echo $cat['slug'] === '' ? '' : '?category=' . h($cat['slug']); ?>"
                                   <?php echo $is_on ? 'aria-current="page"' : ''; ?>><?php echo h($cat['label']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <ul class="p-blog-list__grid">
                    <?php foreach ($posts as $card): ?>
                        <?php
                        // h1「ブログ」の直下に並ぶカードなので、見出しは h2
                        $card['heading'] = 'h2';
                        require __DIR__ . '/includes/card-article.php';
                        ?>
                    <?php endforeach; ?>
                </ul>

                <?php
                $pagination_base = '/blog.php';
                require __DIR__ . '/includes/pagination.php';
                ?>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
