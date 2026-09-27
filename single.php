<?php
/* =============================================================
   ブログ詳細（single.php）

   見た目は既存の `.p-article`（style.css 9-6）に合わせる。
   サイドバー（目次・人気記事）と関連記事は Figma 上は同じ型に
   含まれるが、関連記事は TOP の新着3件と同じPR（手順5）で
   サブループとして追加する予定なので、ここでは本文＋メタ＋
   タグ＋前後リンクだけの1カラムで組む。
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

        </div>
    </article>

    <?php
endwhile;

get_footer();
