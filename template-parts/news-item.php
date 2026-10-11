<?php
/* =============================================================
   お知らせ一覧の1行（TOP・お知らせ一覧・カテゴリー別一覧で共通利用）

   見た目は TOP のお知らせウィジェットと同じ `.c-list-news`。
   行全体が1つの <a> のため、カテゴリーバッジはリンクにしない
   （<a> の入れ子になってしまうので）。絞り込みのリンクは詳細ページ側にある。

   見出しのタグは $args['heading'] で 'h2' / 'h3' に切り替えられる
   （省略時は h2）。置かれる場所によって見出しの階層が変わるため。
     お知らせ一覧・カテゴリー別一覧 … h1 の直下なので h2
     TOP                          … セクション見出し h2 の下なので h3
   ============================================================= */

$heading = in_array($args['heading'] ?? '', ['h2', 'h3'], true) ? $args['heading'] : 'h2';
$terms   = get_the_terms(get_the_ID(), 'news_cat');
$cat     = (!empty($terms) && !is_wp_error($terms)) ? $terms[0] : null;
?>
<li class="c-list-news">
    <a class="c-list-news__link" href="<?php echo esc_url(get_permalink()); ?>">
        <div class="c-list-news__meta">
            <time class="c-list-news__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                <?php echo esc_html(get_the_date('Y.m.d')); ?>
            </time>
            <?php if ($cat) : ?>
                <span class="c-card-article__tag"><?php echo esc_html($cat->name); ?></span>
            <?php endif; ?>
        </div>
        <<?php echo $heading; ?> class="c-list-news__title"><?php echo esc_html(get_the_title()); ?></<?php echo $heading; ?>>

        <!-- 金の丸に白いシェブロン（Figma 実測 40×40 / 12×14） -->
        <span class="c-list-news__arrow" aria-hidden="true">
            <svg width="12" height="14" viewBox="0 0 12 14" fill="none" focusable="false">
                <path d="M0.0456135 13.9201L11.8175 7L0.0456135 0.0798832"
                      stroke="currentColor" stroke-miterlimit="10"/>
            </svg>
        </span>
    </a>
</li>
