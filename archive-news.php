<?php
/* =============================================================
   お知らせ一覧（archive-news.php）

   見た目は home.php のブログ一覧と同じ下層ページの型
   （パンくず → ページ見出し → 本文）に、TOP のお知らせウィジェット
   （template-parts/front-page/news.php）と同じ `.c-list-news`
   （日付＋タイトル＋金の矢印）を組み合わせる。

   カテゴリーは get_the_terms() で取得し、先頭の1件だけを
   日付の横にバッジ表示する（the_category() は使わない）。
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb');
?>

<div class="p-page-head">
    <h1 class="p-page-head__title">お知らせ</h1>
</div>

<section class="p-news-list">
    <div class="p-news-list__inner l-inner">

        <?php if (have_posts()) : ?>

            <ul class="p-news__list">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/news-item'); ?>
                <?php endwhile; ?>
            </ul>

            <div class="c-pagination">
                <?php
                the_posts_pagination([
                    'mid_size'           => 1,
                    'prev_text'          => '← 前へ',
                    'next_text'          => '次へ →',
                    'screen_reader_text' => 'ページ送り',
                ]);
                ?>
            </div>

        <?php else : ?>
            <p class="p-news-list__empty">お知らせはまだありません。</p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer();
