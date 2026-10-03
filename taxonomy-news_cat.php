<?php
/* =============================================================
   お知らせのカテゴリー別一覧（taxonomy-news_cat.php）

   詳細ページのカテゴリーバッジから来る絞り込みページ。
   見た目は archive-news.php と同じ。見出しだけカテゴリー名にする。
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb');
?>

<div class="p-page-head">
    <h1 class="p-page-head__title"><?php single_term_title(); ?></h1>
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
            <p class="p-news-list__empty">このカテゴリーのお知らせはまだありません。</p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer();
