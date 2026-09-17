<?php
/* =============================================================
   固定ページ（page.php）

   個別のテンプレート（page-about.php / page-service.php）が
   無い固定ページはすべてこのファイルで表示する。

   見出しは the_title()、本文は the_content() なので、
   管理画面「固定ページ」で書いた内容がそのまま出る。

   本文の入れ物は、静的サイトの利用規約・プライバシーポリシーと
   同じ `.p-legal` を使う（新しいクラスを足さずに済ませるため）。
   ============================================================= */

get_header();

while (have_posts()) :
    the_post();

    get_template_part('template-parts/breadcrumb', null, [
        'items' => [
            ['href' => home_url('/'), 'label' => 'トップ'],
            ['label' => get_the_title()],
        ],
    ]);
    ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title"><?php the_title(); ?></h1>
        </div>

        <section class="p-legal">
            <div class="p-legal__inner l-inner">
                <div class="p-legal__body">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>

    <?php
endwhile;

get_footer();
