<?php
/* =============================================================
   ブログ詳細（single.php）

   見た目は既存の `.p-article`（style.css 9-6）に合わせる。

   .p-article__inner は1240px以上で2カラムグリッド（本文+サイド
   バー）になる。サイドバー（目次・人気記事）は今回のPRの範囲外
   のため実装していないが、その分の2列目を空けたままにすると
   グリッドの自動配置で子要素がバラバラに列へ割り振られてしまう。
   そのため本文側の要素は全部 .p-article__main でひとまとめにし、
   グリッドの1列目だけを占めるようにする（2列目は何も置かず空欄）。

   末尾の関連記事は、現在の記事と同じカテゴリーからランダムに3件
   拾うサブループ（WP_Query）。メインループとは別のクエリなので、
   使い終わったら wp_reset_postdata() でグローバル $post を戻す。
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb', null, [
    'items' => [
        ['href' => home_url('/'), 'label' => 'トップ'],
        ['href' => get_permalink(get_option('page_for_posts')), 'label' => 'ブログ'],
        ['label' => get_the_title()],
    ],
]);

while (have_posts()) :
    the_post();

    $category_list = get_the_category_list(', ');
    $tags          = get_the_tags();
    ?>

    <article class="p-article">
        <div class="p-article__inner l-inner">
            <div class="p-article__main">

                <header>
                    <h1 class="p-article__title"><?php the_title(); ?></h1>
                    <div class="p-article__meta">
                        <time class="p-article__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date('Y.m.d')); ?>
                        </time>
                        <?php if ($category_list) : ?>
                            <span class="c-card-article__tag p-article__cat"><?php echo $category_list; ?></span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', ['class' => 'p-article__hero']); ?>
                <?php endif; ?>

                <div class="p-article__body post__body">
                    <?php the_content(); ?>
                </div>

                <?php if ($tags) : ?>
                    <ul class="p-article__tags">
                        <?php foreach ($tags as $tag) : ?>
                            <li class="p-article__tag">
                                <a href="<?php echo esc_url(get_tag_link($tag)); ?>">#<?php echo esc_html($tag->name); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <nav class="p-article__nav" aria-label="前後の記事">
                    <div class="p-article__nav-prev"><?php previous_post_link('%link', '← 前の記事'); ?></div>
                    <div class="p-article__nav-next"><?php next_post_link('%link', '次の記事 →'); ?></div>
                </nav>

                <?php
                $related_cat_ids = wp_get_post_categories(get_the_ID());

                if (!empty($related_cat_ids)) :
                    $related_query = new WP_Query([
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'category__in'   => $related_cat_ids,
                        'post__not_in'   => [get_the_ID()],
                        'orderby'        => 'rand',
                        'no_found_rows'  => true,
                    ]);

                    if ($related_query->have_posts()) :
                        ?>
                        <section class="p-related">
                            <h2 class="p-related__title">こんな記事も読まれています</h2>
                            <div class="p-related__list">
                                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                    <?php get_template_part('template-parts/post-card', null, ['heading' => 'h3']); ?>
                                <?php endwhile; ?>
                            </div>
                        </section>
                        <?php
                    endif;

                    wp_reset_postdata();
                endif;
                ?>

            </div>
        </div>
    </article>

    <?php
endwhile;

get_footer();
