<?php
/* =============================================================
   お知らせ一覧の1行（お知らせ一覧・カテゴリー別一覧で共通利用）

   見た目は TOP のお知らせウィジェットと同じ `.c-list-news`。
   行全体が1つの <a> のため、カテゴリーバッジはリンクにしない
   （<a> の入れ子になってしまうので）。絞り込みのリンクは詳細ページ側にある。
   ============================================================= */

$terms = get_the_terms(get_the_ID(), 'news_cat');
$cat   = (!empty($terms) && !is_wp_error($terms)) ? $terms[0] : null;
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
        <h3 class="c-list-news__title"><?php echo esc_html(get_the_title()); ?></h3>

        <!-- 金の丸に白いシェブロン（Figma 実測 40×40 / 12×14） -->
        <span class="c-list-news__arrow" aria-hidden="true">
            <svg width="12" height="14" viewBox="0 0 12 14" fill="none" focusable="false">
                <path d="M0.0456135 13.9201L11.8175 7L0.0456135 0.0798832"
                      stroke="currentColor" stroke-miterlimit="10"/>
            </svg>
        </span>
    </a>
</li>
