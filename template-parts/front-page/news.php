<?php
/* =============================================================
   TOP 8. お知らせ

   TODO: いまは Figma のダミー3件。WordPress の投稿（お知らせ）から
         取得する形に差し替えること。
   ============================================================= */

$top_news = [
    ['date' => '2023/00/00', 'title' => 'お知らせタイトルお知らせタイトルお知らせタイトルお知らせタイトル'],
    ['date' => '2023/00/00', 'title' => 'お知らせタイトルお知らせタイトルお知らせタイトルお知らせタイトル'],
    ['date' => '2023/00/00', 'title' => 'お知らせタイトルお知らせタイトルお知らせタイトルお知らせタイトル'],
];
?>
        <section class="p-news">
            <div class="p-news__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">お知らせ</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">news</span>
                </h2>

                <ul class="p-news__list">
                    <?php foreach ($top_news as $news) : ?>
                        <li class="c-list-news">
                            <!-- TODO: 1件ごとの URL（get_permalink()）にする -->
                            <a class="c-list-news__link" href="<?php echo esc_url(home_url('/news/')); ?>">
                                <time class="c-list-news__date"><?php echo esc_html($news['date']); ?></time>
                                <h3 class="c-list-news__title"><?php echo esc_html($news['title']); ?></h3>

                                <!-- 金の丸に白いシェブロン（Figma 実測 40×40 / 12×14） -->
                                <span class="c-list-news__arrow" aria-hidden="true">
                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" focusable="false">
                                        <path d="M0.0456135 13.9201L11.8175 7L0.0456135 0.0798832"
                                              stroke="currentColor" stroke-miterlimit="10"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="p-news__action">
                    <a class="c-btn-more" href="<?php echo esc_url(home_url('/news/')); ?>">
                        <span class="c-btn-more__label">お知らせ一覧はこちら</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
