<?php
/* =============================================================
   TOP 1. ヒーロー

   ヘッダーが透過で重なる。文字が沈まないよう写真の上に暗幕を敷く。
   ============================================================= */

$theme_uri = get_template_directory_uri();
?>
        <section class="p-hero">
            <img class="p-hero__image" src="<?php echo esc_url($theme_uri . '/assets/images/top/hero.jpg'); ?>" alt=""
                 width="1440" height="900" fetchpriority="high">

            <div class="p-hero__inner l-inner">
                <h1 class="p-hero__catch">大自然と調和する、<br class="u-br-sp">極上の癒し。</h1>
                <p class="p-hero__lead">
                    大分の自然環境と共に、<br>
                    身も心も癒やされる<br class="u-br-sp">至福のひとときを提供します。
                </p>
            </div>

            <!-- 縦組みの飾り。Figma の綴りが SCROOLL（L が2つ）なのでそのままにしている。
                 装飾なので支援技術からは隠す -->
            <div class="p-hero__scroll" aria-hidden="true">
                <span class="p-hero__scroll-text">SCROOLL</span>
            </div>
        </section>
