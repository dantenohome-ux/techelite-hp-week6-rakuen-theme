<?php
/* =============================================================
   パンくず（TOP 以外の全ページ）

   使い方：各テンプレートから引数なしで呼ぶだけ。

       get_template_part('template-parts/breadcrumb');

   表示する項目は、このファイルの中で is_singular() / is_tax() などの
   条件分岐から組み立てる。ページごとの違いはここ1か所にまとまっている。
   最後の項目が現在地。href を書かなければリンクにならない。

   仕様は静的サイト版（includes/breadcrumb.php）と同じ：
     ・最後の項目はリンクにせず aria-current="page" を付ける
     ・区切りの「＞」は HTML に書かず CSS の ::before で描く
       （読み上げで「大なり」と読まれるノイズを避けるため）
     ・ラベルはページタイトルではなくナビ用の短い名前

   どの条件にも当てはまらないとき（TOP など）は何も出力しない。
   ============================================================= */

$blog_url = get_permalink(get_option('page_for_posts'));
$items    = [];

if (is_singular('post')) {
    // ブログ詳細
    $items[] = ['href' => $blog_url, 'label' => 'ブログ'];
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
} elseif (is_home()) {
    // ブログ一覧
    $items[] = ['label' => 'ブログ'];
} elseif (is_category()) {
    // ブログのカテゴリー一覧
    $items[] = ['href' => $blog_url, 'label' => 'ブログ'];
    $items[] = ['label' => single_cat_title('', false)];
} elseif (is_tag()) {
    // ブログのタグ一覧
    $items[] = ['href' => $blog_url, 'label' => 'ブログ'];
    $items[] = ['label' => single_tag_title('', false)];
} elseif (is_archive()) {
    // 日付などのその他のアーカイブ
    $items[] = ['href' => $blog_url, 'label' => 'ブログ'];
    $items[] = ['label' => wp_strip_all_tags(get_the_archive_title())];
} elseif (is_404()) {
    $items[] = ['label' => 'ページが見つかりません'];
} elseif (is_page()) {
    // 固定ページ（運営会社・サービスなど）
    $items[] = ['label' => get_the_title()];
}

if ($items !== []) {
    array_unshift($items, ['href' => home_url('/'), 'label' => 'トップ']);
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
