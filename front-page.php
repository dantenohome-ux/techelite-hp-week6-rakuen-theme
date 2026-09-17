<?php
/* =============================================================
   TOP（front-page.php）

   Figma: PC `1:2`（1440×10705）/ SP `17:2`（375×8190）
   構成: 1.ヒーロー 2.コンセプト 3.お部屋 4.プラン
         5.四季 6.アクセス 7.ブログ 8.お知らせ

   front-page.php は WordPress がトップページで最優先に使うテンプレート。
   「ホームページの表示」がどちらの設定でも、ここが表示される。

   各セクションは template-parts/front-page/ に1ファイルずつ分けて置き、
   get_template_part() で読み込む。直すときは該当セクションの
   ファイルだけを開けばよい。

   お部屋 / プラン / 四季 / アクセスはグローバルナビのアンカー先。
   各パーツの id は header.php のナビの href と対応している。
   ============================================================= */

get_header();

get_template_part('template-parts/front-page/hero');
get_template_part('template-parts/front-page/concept');
get_template_part('template-parts/front-page/room');
get_template_part('template-parts/front-page/plan');
get_template_part('template-parts/front-page/seasons');
get_template_part('template-parts/front-page/access');
get_template_part('template-parts/front-page/blog');
get_template_part('template-parts/front-page/news');

get_footer();
