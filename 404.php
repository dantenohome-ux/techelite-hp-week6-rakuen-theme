<?php
/* =============================================================
   404（ページが見つかりません）

   WordPress は、該当する投稿・固定ページが見つからないときに
   このファイルを使う（テンプレート名が予約されている）。

   Figma にこのページのデザインは無いため、既存の部品だけで組んでいる。
   ページ見出し（.p-page-head）と、TOP へ戻るボタン（.c-btn-more）。
   新しい見た目は足していない。

   静的サイト版からの変更点：
     ・http_response_code(404) は不要（WordPress が 404 を返す）
     ・<title> と noindex も不要
       （title-tag と WordPress の自動 noindex に任せる）
     ・パンくずは template-parts/breadcrumb.php を使う
     ・リンク先は home_url()
   ============================================================= */

get_header();

get_template_part('template-parts/breadcrumb', null, [
    'items' => [
        ['href' => home_url('/'), 'label' => 'トップ'],
        ['label' => 'ページが見つかりません'],
    ],
]);
?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">ページが見つかりません</h1>
        </div>

        <section class="p-notfound">
            <div class="p-notfound__inner l-inner">

                <p class="p-page-lead">お探しのページは、移動または削除された可能性があります。お手数ですが、トップページからお探しください。</p>

                <div class="p-notfound__action">
                    <a class="c-btn-more" href="<?php echo esc_url(home_url('/')); ?>">
                        <span class="c-btn-more__label">トップページへ</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

<?php
get_footer();
