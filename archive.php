<?php
/* =============================================================
   汎用アーカイブ（archive.php）

   カテゴリー以外のアーカイブ（タグ・日付など）で使われる。
   カテゴリーアーカイブは category.php が優先されるため、
   ここでは the_archive_title() を汎用の見出しとして使う。

   見た目は home.php のブログ一覧（.p-blog-list）と共通。
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb', null, [
    'items' => [
        ['href' => home_url('/'), 'label' => 'トップ'],
        ['href' => get_permalink(get_option('page_for_posts')), 'label' => 'ブログ'],
        ['label' => wp_strip_all_tags(get_the_archive_title())],
    ],
]);
?>

<div class="p-page-head">
    <h1 class="p-page-head__title"><?php the_archive_title(); ?></h1>
</div>

<section class="p-blog-list">
    <div class="p-blog-list__inner l-inner">

        <?php if (have_posts()) : ?>

            <div class="p-blog-list__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post-card'); ?>
                <?php endwhile; ?>
            </div>

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
            <p class="p-blog-list__empty">該当する記事がありません。</p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer();
