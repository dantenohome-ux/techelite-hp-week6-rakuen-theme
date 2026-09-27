<?php
/* =============================================================
   記事カード1枚（ブログ一覧・カテゴリー一覧・関連記事で共通利用）

   見た目は TOP の新着ブログと同じ `.c-card-article`（style.css 7-4）。
   アイキャッチが無い記事は assets/images/noimage.png を出す。

   カテゴリーは get_the_category_list() でクリック可能なリンクにする。
   カード全体を1つの<a>にすると入れ子リンクになってしまうため、
   サムネイルとタイトルをそれぞれ別の<a>として持たせている
   （抜粋・日付はリンクにしない）。

   見出しのタグは $args['heading'] で 'h2' / 'h3' に切り替えられる。
   置かれる場所によって見出しの階層が変わるため（省略時は h2）。
     ブログ一覧・カテゴリー一覧 … h1 の直下なので h2
     TOP・関連記事           … セクション見出し h2 の下なので h3

   $args['excerpt'] を false にすると抜粋を出さない。
   TOP の新着3件は Figma のカード高さ（380×398）に抜粋を含まない
   ため、そこだけ false を渡す。
   ============================================================= */

$heading  = in_array($args['heading'] ?? '', ['h2', 'h3'], true) ? $args['heading'] : 'h2';
$show_excerpt = ($args['excerpt'] ?? true) !== false;
$permalink = get_permalink();
$category_list = get_the_category_list(', ');
?>
<article class="c-card-article">

    <a class="c-card-article__link" href="<?php echo esc_url($permalink); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('blog-thumb', ['class' => 'c-card-article__thumb', 'alt' => '']); ?>
        <?php else : ?>
            <img class="c-card-article__thumb" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/noimage.png'); ?>" alt="">
        <?php endif; ?>
    </a>

    <div class="c-card-article__body">
        <time class="c-card-article__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
            <?php echo esc_html(get_the_date('Y.m.d')); ?>
        </time>
        <<?php echo $heading; ?> class="c-card-article__title">
            <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html(get_the_title()); ?></a>
        </<?php echo $heading; ?>>
        <?php if ($category_list) : ?>
            <span class="c-card-article__tag"><?php echo $category_list; ?></span>
        <?php endif; ?>
        <?php if ($show_excerpt) : ?>
            <p class="c-card-article__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
        <?php endif; ?>
    </div>

</article>
