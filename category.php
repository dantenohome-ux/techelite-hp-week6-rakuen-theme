<?php
/* =============================================================
   カテゴリー絞り込み一覧（category.php）

   見た目は home.php のブログ一覧（.p-blog-list）と共通。
   見出しは spec どおり single_cat_title() を使う。
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb');
?>

<div class="p-page-head">
    <h1 class="p-page-head__title"><?php single_cat_title('カテゴリー：'); ?></h1>
</div>

<section class="p-blog-list">
    <div class="p-blog-list__inner l-inner">

        <?php if (category_description()) : ?>
            <p class="p-page-lead"><?php echo wp_kses_post(category_description()); ?></p>
        <?php endif; ?>

        <?php if (have_posts()) : ?>

            <div class="p-blog-list__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post-card'); ?>
                <?php endwhile; ?>
            </div>

            <?php get_template_part('template-parts/pagination'); ?>

        <?php else : ?>
            <p class="p-blog-list__empty">このカテゴリーの記事はまだありません。</p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer();
