<?php
/* =============================================================
   タグ絞り込み一覧（tag.php）

   category.php と同じ型（.p-blog-list）。見出しは single_tag_title()、
   説明文があれば tag_description() を .p-page-lead で表示する。
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb');
?>

<div class="p-page-head">
    <h1 class="p-page-head__title"><?php single_tag_title('タグ：'); ?></h1>
</div>

<section class="p-blog-list">
    <div class="p-blog-list__inner l-inner">

        <?php if (tag_description()) : ?>
            <p class="p-page-lead"><?php echo wp_kses_post(tag_description()); ?></p>
        <?php endif; ?>

        <?php if (have_posts()) : ?>

            <div class="p-blog-list__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post-card'); ?>
                <?php endwhile; ?>
            </div>

            <?php get_template_part('template-parts/pagination'); ?>

        <?php else : ?>
            <p class="p-blog-list__empty">このタグの記事はまだありません。</p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer();
