<?php
/* =============================================================
   TOP 7. ブログ

   記事カード1枚ぶんの組み立ては、静的サイトと共通の
   includes/card-article.php に任せる（$card に内容を入れて require）。
   そのファイルが h() を使うため、includes/functions.php も先に読み込む。

   TODO: いまは Figma のダミー3件。WordPress の投稿から取得する形に
         差し替えること（その際 href は get_permalink() になる）。
   ============================================================= */

$theme_uri = get_template_directory_uri();

// h()（card-article.php が使う出力エスケープ）を読み込む
require_once get_template_directory() . '/includes/functions.php';

$top_posts = [
    ['date' => '2023/00/00', 'title' => 'ブログタイトルブログタイトルブログタイトルブログタイトル', 'category' => '観光地'],
    ['date' => '2023/00/00', 'title' => 'ブログタイトルブログタイトルブログタイトルブログタイトル', 'category' => '豆知識'],
    ['date' => '2023/00/00', 'title' => 'ブログタイトルブログタイトルブログタイトルブログタイトル', 'category' => '料理'],
];
?>
        <section class="p-blog">
            <div class="p-blog__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">ブログ</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">blog</span>
                </h2>

                <ul class="p-blog__list">
                    <?php foreach ($top_posts as $card) : ?>
                        <?php
                        // リンク先と画像は WordPress 用のパスを呼び出し側から渡す
                        // （card-article.php の既定値は静的サイト用のパスのため）
                        $card['href']  = home_url('/blog/');
                        $card['thumb'] = $theme_uri . '/assets/images/top/blog-thumb.jpg';
                        require get_template_directory() . '/includes/card-article.php';
                        ?>
                    <?php endforeach; ?>
                </ul>

                <div class="p-blog__action">
                    <a class="c-btn-more" href="<?php echo esc_url(home_url('/blog/')); ?>">
                        <span class="c-btn-more__label">ブログ一覧はこちら</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
