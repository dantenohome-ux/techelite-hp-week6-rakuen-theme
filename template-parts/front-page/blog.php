<?php
/* =============================================================
   TOP 7. ブログ

   投稿の新着3件をサブループで表示する。カードは一覧・関連記事と
   完全共通の template-parts/post-card.php（.c-card-article）。
   TOPは h2 の下なので heading は h3、Figmaのカード高さに
   抜粋は含まないため excerpt は false にする。

   メインループ（front-page.php 自体はループを回していない）とは
   別のクエリなので、使い終わったら wp_reset_postdata() で
   グローバル $post を固定ページ（TOP）のものに戻す。
   ============================================================= */

$recent_posts = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'no_found_rows'  => true,
]);
?>
        <section class="p-blog">
            <div class="p-blog__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">ブログ</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">blog</span>
                </h2>

                <?php if ($recent_posts->have_posts()) : ?>
                    <div class="p-blog__list">
                        <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                            <?php get_template_part('template-parts/post-card', null, ['heading' => 'h3', 'excerpt' => false]); ?>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>

                <div class="p-blog__action">
                    <a class="c-btn-more" href="<?php echo esc_url(home_url('/blog/')); ?>">
                        <span class="c-btn-more__label">ブログ一覧はこちら</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
