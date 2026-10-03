<?php
/* =============================================================
   お知らせ詳細（single-news.php）

   見た目は single.php のブログ詳細（.p-article）と同じ型を使い回し、
   `.p-news-detail` でお知らせ固有の余白だけ差し替える
   （style.css の「お知らせ詳細（p-news-detail）」コメント参照）。
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb');

while (have_posts()) :
    the_post();

    $terms = get_the_terms(get_the_ID(), 'news_cat');
    $cat   = (!empty($terms) && !is_wp_error($terms)) ? $terms[0] : null;
    ?>

    <article class="p-news-detail">
        <div class="p-news-detail__inner l-inner">

            <header>
                <h1 class="p-article__title p-news-detail__title"><?php the_title(); ?></h1>
                <div class="p-article__meta">
                    <time class="p-article__date p-news-detail__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date('Y.m.d')); ?>
                    </time>
                    <?php if ($cat) : ?>
                        <span class="c-card-article__tag p-article__cat">
                            <a href="<?php echo esc_url(get_term_link($cat)); ?>"><?php echo esc_html($cat->name); ?></a>
                        </span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', ['class' => 'p-article__hero']); ?>
            <?php endif; ?>

            <div class="p-article__body p-news-detail__body">
                <?php the_content(); ?>
            </div>

            <div class="p-news-detail__action">
                <a class="c-btn-more c-btn-more--back" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">
                    <span class="c-btn-more__label">お知らせ一覧へ</span>
                    <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                         fill="none" aria-hidden="true" focusable="false">
                        <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                    </svg>
                </a>
            </div>

        </div>
    </article>

    <?php
endwhile;

get_footer();
