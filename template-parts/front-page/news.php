<?php
/* =============================================================
   TOP 8. お知らせ

   お知らせ（カスタム投稿タイプ news）の新着3件をサブループで表示する。
   1行は一覧・カテゴリー別一覧と共通の template-parts/news-item.php
   （.c-list-news）。TOPは h2 の下なので heading は h3。

   メインループ（front-page.php 自体はループを回していない）とは
   別のクエリなので、使い終わったら wp_reset_postdata() で
   グローバル $post を固定ページ（TOP）のものに戻す。
   ============================================================= */

$recent_news = new WP_Query([
    'post_type'      => 'news',
    'posts_per_page' => 3,
    'no_found_rows'  => true,
]);
?>
        <section class="p-news">
            <div class="p-news__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">お知らせ</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">news</span>
                </h2>

                <?php if ($recent_news->have_posts()) : ?>
                    <ul class="p-news__list">
                        <?php while ($recent_news->have_posts()) : $recent_news->the_post(); ?>
                            <?php get_template_part('template-parts/news-item', null, ['heading' => 'h3']); ?>
                        <?php endwhile; ?>
                    </ul>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>

                <div class="p-news__action">
                    <a class="c-btn-more" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">
                        <span class="c-btn-more__label">お知らせ一覧はこちら</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
