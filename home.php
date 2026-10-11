<?php
/* =============================================================
   ブログ一覧（home.php）

   「投稿ページ」に割り当てた固定ページを開いたときに使われる
   テンプレート。メインループをそのまま新着順の一覧として出す。

   見た目は運営会社・規約類と同じ下層ページの型
   （パンくず → ページ見出し → 本文）に、ブログ一覧用の
   `.p-blog-list`（style.css 9-4）を組み合わせる。
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb');
?>

<div class="p-page-head">
    <h1 class="p-page-head__title">ブログ</h1>
</div>

<section class="p-blog-list">
    <div class="p-blog-list__inner l-inner">

        <?php if (have_posts()) : ?>

            <div class="p-blog-list__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post-card'); ?>
                <?php endwhile; ?>
            </div>

            <?php get_template_part('template-parts/pagination'); ?>

        <?php else : ?>
            <p class="p-blog-list__empty">記事がまだありません。</p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer();
