<?php
/* =============================================================
   TOP 6. アクセス（#access）

   id="access" はグローバルナビのアンカー先。変更しないこと。
   ============================================================= */

$theme_uri = get_template_directory_uri();
?>
        <section class="p-access" id="access">
            <div class="p-access__inner l-inner">
                <h2 class="c-section-title">
                    <span class="c-section-title__ja">アクセス</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">access</span>
                </h2>
            </div>

            <!-- 地図は画面幅いっぱい。
                 TODO: Figma はスクリーンショット画像。実運用では
                       埋め込み地図（iframe）に差し替える想定 -->
            <img class="p-access__map" src="<?php echo esc_url($theme_uri . '/assets/images/top/access-map.jpg'); ?>"
                 alt="楽園雅苑の周辺地図" width="1440" height="600" loading="lazy">

            <div class="p-access__body l-inner">
                <div class="p-access__head">
                    <img class="p-access__logo" src="<?php echo esc_url($theme_uri . '/assets/images/common/logo.svg'); ?>"
                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="169" height="66" loading="lazy">
                    <!-- SP は郵便番号の後で改行する（Figma 準拠）。PC は1行 -->
                    <address class="p-access__address">〒879-5425<br class="u-br-sp"> 大分県由布市　庄内町渕</address>
                </div>

                <!-- Figma の SP では文と文の間に空行が入る（PC は詰めて3行）。
                     空行を作るために <br> を並べるのではなく、文ごとに段落を分けて
                     CSS 側で間隔を持たせている -->
                <div class="p-access__text">
                    <p>当宿からのアクセスは便利で、お車や公共交通機関をご利用いただけます。</p>
                    <p>自家用車をご利用の場合、ご宿泊の方には無料の駐車場がご用意されております。</p>
                    <p>公共交通機関をご利用の場合、最寄り駅からはバス、タクシー、またはレンタサイクルを利用してお越しいただけます。</p>
                </div>
            </div>
        </section>
