<?php
/* =============================================================
   汎用テンプレート（index.php）

   WordPress が「ほかに合うテンプレートが無い」ときに使う受け皿。
   TOP は手順2で作る front-page.php が担当するため、ここは
   投稿一覧・アーカイブなどが落ちてきたときの最低限の表示にとどめる。

   見た目は既存CSSの `.p-page-head` / `.p-legal` / `.l-inner` を流用する。
   ============================================================= */

get_header();
?>

        <div class="p-page-head">
            <h1 class="p-page-head__title"><?php
                if (is_home() || is_front_page()) {
                    bloginfo('name');
                } else {
                    echo esc_html(wp_strip_all_tags(get_the_archive_title()));
                }
            ?></h1>
        </div>

        <section class="p-legal">
            <div class="p-legal__inner l-inner">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article <?php post_class('p-legal__section'); ?>>
                            <h2 class="p-legal__title">
                                <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="p-legal__body">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="p-page-lead">表示できる記事がありません。</p>
                <?php endif; ?>
            </div>
        </section>

<?php
get_footer();
