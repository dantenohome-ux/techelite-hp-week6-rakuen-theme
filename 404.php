<?php
/* =============================================================
   404（ページが見つかりません）

   Figma にこのページのデザインは無いため、既存の部品だけで組んでいる。
   ページ見出し（.p-page-head）と、TOP へ戻るボタン（.c-btn-more）。
   新しい見た目は足していない。

   .htaccess の ErrorDocument からこのファイルを指している。
   その場合 PHP は 200 を返してしまうので、先頭で 404 を送り直す。
   「見つからない」と表示しながら 200 を返すと、検索エンジンに
   中身のあるページとして登録されてしまうため。
   ============================================================= */

http_response_code(404);

$page_title       = 'ページが見つかりません｜楽園雅苑';
$page_description = 'お探しのページは見つかりませんでした。';
$page_noindex     = true;

$breadcrumb = [
    ['href' => '/', 'label' => 'トップ'],
    ['label' => 'ページが見つかりません'],
];

require __DIR__ . '/includes/header.php';
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">ページが見つかりません</h1>
        </div>

        <section class="p-notfound">
            <div class="p-notfound__inner l-inner">

                <p class="p-page-lead">お探しのページは、移動または削除された可能性があります。お手数ですが、トップページからお探しください。</p>

                <div class="p-notfound__action">
                    <a class="c-btn-more" href="/">
                        <span class="c-btn-more__label">トップページへ</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
