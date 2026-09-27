<?php
/* =============================================================
   記事カード1枚（ブログ一覧・カテゴリー一覧・関連記事で共通利用）

   見た目は TOP の新着ブログと同じ `.c-card-article`（style.css 7-4）。
   アイキャッチが無い記事は assets/images/noimage.png を出す。

   見出しのタグは $args['heading'] で 'h2' / 'h3' に切り替えられる。
   置かれる場所によって見出しの階層が変わるため（省略時は h2）。
     ブログ一覧・カテゴリー一覧 … h1 の直下なので h2
     関連記事               … セクション見出し h2 の下なので h3
   ============================================================= */

$heading = in_array($args['heading'] ?? '', ['h2', 'h3'], true) ? $args['heading'] : 'h2';

$category_names = wp_list_pluck(get_the_category(), 'name');
?>
<article class="c-card-article">
    <a class="c-card-article__link" href="<?php echo esc_url(get_permalink()); ?>">

        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('blog-thumb', ['class' => 'c-card-article__thumb', 'alt' => '']); ?>
        <?php else : ?>
            <img class="c-card-article__thumb" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/noimage.png'); ?>" alt="">
        <?php endif; ?>

        <div class="c-card-article__body">
            <time class="c-card-article__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                <?php echo esc_html(get_the_date('Y.m.d')); ?>
            </time>
            <<?php echo $heading; ?> class="c-card-article__title"><?php echo esc_html(get_the_title()); ?></<?php echo $heading; ?>>
            <?php if ($category_names) : ?>
                <span class="c-card-article__tag"><?php echo esc_html(implode(', ', $category_names)); ?></span>
            <?php endif; ?>
            <p class="c-card-article__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
        </div>

    </a>
</article>
