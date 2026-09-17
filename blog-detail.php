<?php
/* =============================================================
   ブログ詳細（blog-detail.php）

   Figma: PC `510:46`（1440×3879）/ SP `510:47`
   構成: パンくず（3階層）
         → 記事本体 860px ＋ サイドバー 300px の2カラム
         → 関連記事「こんな記事も読まれています」

   記事の中身は Figma がすべてダミー文言なので、そのまま再現している。
   TODO: CMS ないしデータファイルから読む形に置き換える。

   SP では2カラムをやめ、サイドバーを記事の下へ回す。
   ============================================================= */

$page_title       = 'タイトルタイトルタイトルタイトルタイトル｜楽園雅苑';
$page_description = '楽園雅苑のブログ記事です。';

// 3階層。最後は記事タイトルをそのまま入れる（breadcrumb-spec.md 準拠）
$breadcrumb = [
    ['href' => '/',         'label' => 'トップ'],
    ['href' => '/blog.php', 'label' => 'ブログ'],
    ['label' => 'タイトルタイトルタイトルタイトルタイトル'],
];

require __DIR__ . '/includes/header.php';


/* ---- 記事データ（すべて Figma のダミー） -------------------- */

$article = [
    'date'     => '2023/00/00',
    'category' => '観光地',
    'title'    => 'タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル',
];

// 目次。h2 の下に h3 が3つずつ入る入れ子構造
$toc = [
    [
        'id'    => 'h2-1',
        'label' => 'H2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミー',
        'children' => [
            'h3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミー',
            'h3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミー',
            'h3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミー',
        ],
    ],
    [
        'id'    => 'h2-2',
        'label' => 'H2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミーH2ダミー',
        'children' => [
            'h3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミー',
            'h3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミー',
            'h3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミーh3ダミー',
        ],
    ],
];

$body_dummy = '本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー';

// 記事内のテーブル（6行）
$article_table = [];
for ($i = 0; $i < 6; $i++) {
    $article_table[] = [
        'label' => 'ダミーダミーダミー',
        'value' => 'ダミーダミーダミーダミーダミーダミーダミーダミー',
    ];
}

// 人気記事10件（サイドバー）
$popular = [];
for ($i = 0; $i < 10; $i++) {
    $popular[] = ['title' => 'タイトルタイトルタイトルタイトルタイトルタ…'];
}

// 関連記事2件
$related = [];
for ($i = 0; $i < 2; $i++) {
    $related[] = [
        'date'     => '2023/00/00',
        'title'    => 'ブログタイトルブログタイトルブログタイトルブログタイトル',
        'category' => '豆知識',
    ];
}
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-article">
            <div class="p-article__inner l-inner">

                <!-- ============ 記事本体 ============ -->
                <article class="p-article__main">

                    <h1 class="p-article__title"><?php echo h($article['title']); ?></h1>

                    <div class="p-article__meta">
                        <time class="p-article__date"><?php echo h($article['date']); ?></time>
                        <span class="c-card-article__tag"><?php echo h($article['category']); ?></span>
                    </div>

                    <img class="p-article__hero" src="/images/top/blog-thumb.jpg"
                         alt="" width="780" height="470" loading="lazy">

                    <!-- 目次。h2 の下に h3 が入る入れ子なので ol を二重にする -->
                    <nav class="c-toc" aria-labelledby="toc-heading">
                        <p class="c-toc__heading" id="toc-heading">目次</p>
                        <ol class="c-toc__list">
                            <?php foreach ($toc as $i => $item): ?>
                                <li class="c-toc__item">
                                    <a class="c-toc__link" href="#<?php echo h($item['id']); ?>"><?php echo h($item['label']); ?></a>
                                    <ol class="c-toc__sublist">
                                        <?php foreach ($item['children'] as $child): ?>
                                            <li class="c-toc__subitem">
                                                <a class="c-toc__sublink" href="#<?php echo h($item['id']); ?>"><?php echo h($child); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ol>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </nav>

                    <!-- ============ 本文 ============ -->
                    <div class="p-article__body">

                        <h2 class="p-article__h2" id="h2-1">H2ダミーH2ダミーH2ダミーH2ダミーH2ダミー</h2>

                        <p><?php echo h($body_dummy); ?><strong>強調文強調文強調文強調文</strong>本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー</p>

                        <h3 class="p-article__h3" id="h2-2">H3ダミーH3ダミーH3ダミーH3ダミーH3ダミーH3ダミー</h3>

                        <!-- mark はブラウザ既定で黄色の背景が付くが、
                             Figma の指定色（#ffe86d）に揃えている -->
                        <p><?php echo h($body_dummy); ?><mark>本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー</mark>本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー本文ダミー</p>

                        <dl class="c-table p-article__table">
                            <?php foreach ($article_table as $row): ?>
                                <div class="c-table__row">
                                    <dt class="c-table__label"><?php echo h($row['label']); ?></dt>
                                    <dd class="c-table__value"><?php echo h($row['value']); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                </article>

                <!-- ============ サイドバー ============ -->
                <aside class="p-article__side" aria-labelledby="popular-heading">
                    <h2 class="p-article__side-title" id="popular-heading">人気記事</h2>

                    <ol class="c-rank-list">
                        <?php foreach ($popular as $item): ?>
                            <li class="c-rank-list__item">
                                <!-- TODO: 記事ごとの URL にする -->
                                <a class="c-rank-list__link" href="/blog-detail.php">
                                    <!-- Figma はグレーの矩形（サムネの仮置き）。
                                         実運用ではその記事のサムネイルが入る -->
                                    <img class="c-rank-list__thumb" src="/images/top/blog-thumb.jpg"
                                         alt="" width="53" height="34" loading="lazy">
                                    <span class="c-rank-list__title"><?php echo h($item['title']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </aside>
            </div>
        </div>


        <!-- ============ 関連記事 ============ -->
        <section class="p-related">
            <div class="p-related__inner l-inner">
                <h2 class="p-related__title">こんな記事も読まれています</h2>

                <ul class="p-related__list">
                    <?php foreach ($related as $card): ?>
                        <?php
                        // 関連記事は横長。セクション見出し h2 の下なので見出しは h3（既定）
                        $card['variant'] = 'wide';
                        require __DIR__ . '/includes/card-article.php';
                        ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
