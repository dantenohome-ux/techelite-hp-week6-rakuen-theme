<?php
/* =============================================================
   パンくず（TOP 以外の全ページ）

   使い方：項目の配列を $args の 'items' に入れて呼ぶ。
   最後の項目が現在地。href を書かなければリンクにならない。

       get_template_part('template-parts/breadcrumb', null, [
           'items' => [
               ['href' => home_url('/'), 'label' => 'トップ'],
               ['label' => get_the_title()],
           ],
       ]);

   'items' を渡さずに呼んだ場合（page-service.php / archive-news.php /
   single-news.php など）は、is_singular() 等から自分で項目を組み立てる。
   既存の呼び出し側（items を渡しているテンプレート）の動作は変えない。

   仕様は静的サイト版（includes/breadcrumb.php）と同じ：
     ・最後の項目はリンクにせず aria-current="page" を付ける
     ・区切りの「＞」は HTML に書かず CSS の ::before で描く
       （読み上げで「大なり」と読まれるノイズを避けるため）
     ・ラベルはページタイトルではなくナビ用の短い名前

   項目が無いときは何も出力しない（TOP 用）。
   ============================================================= */

$items = is_array($args) ? ($args['items'] ?? null) : null;

if ($items === null) {
    $items = [];

    if (is_singular('post')) {
        // ブログ詳細
        $items[] = ['href' => get_permalink(get_option('page_for_posts')), 'label' => 'ブログ'];
        $items[] = ['label' => get_the_title()];
    } elseif (is_singular('news')) {
        // お知らせ詳細
        $items[] = ['href' => get_post_type_archive_link('news'), 'label' => 'お知らせ'];
        $items[] = ['label' => get_the_title()];
    } elseif (is_singular('rooms')) {
        // 客室詳細
        $items[] = ['href' => get_post_type_archive_link('rooms'), 'label' => '客室'];
        $items[] = ['label' => get_the_title()];
    } elseif (is_post_type_archive('news')) {
        // お知らせ一覧
        $items[] = ['label' => 'お知らせ'];
    } elseif (is_tax('news_cat')) {
        // お知らせのカテゴリー別一覧
        $items[] = ['href' => get_post_type_archive_link('news'), 'label' => 'お知らせ'];
        $items[] = ['label' => single_term_title('', false)];
    } elseif (is_category()) {
        $items[] = ['href' => get_permalink(get_option('page_for_posts')), 'label' => 'ブログ'];
        $items[] = ['label' => single_cat_title('', false)];
    } elseif (is_page()) {
        $items[] = ['label' => get_the_title()];
    }

    if ($items !== []) {
        array_unshift($items, ['href' => home_url('/'), 'label' => 'トップ']);
    }
}

if ($items === []) {
    return;
}

$last = count($items) - 1;
?>
        <!-- l-inner を兼ねさせて、本文と同じ左右の位置に揃える
             （Figma: PC x=120 / SP x=20） -->
        <nav class="c-breadcrumb l-inner" aria-label="パンくず">
            <ol class="c-breadcrumb__list">
                <?php foreach ($items as $i => $crumb) : ?>
                    <li class="c-breadcrumb__item">
                        <?php if ($i === $last || empty($crumb['href'])) : ?>
                            <span class="c-breadcrumb__current" aria-current="page"><?php echo esc_html($crumb['label']); ?></span>
                        <?php else : ?>
                            <a class="c-breadcrumb__link" href="<?php echo esc_url($crumb['href']); ?>"><?php echo esc_html($crumb['label']); ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
