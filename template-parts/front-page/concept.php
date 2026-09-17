<?php
/* =============================================================
   TOP 2. コンセプト
   ============================================================= */

$theme_uri = get_template_directory_uri();
?>
        <section class="p-concept">
            <div class="p-concept__inner l-inner">
                <div class="p-concept__body">
                    <img class="p-concept__logo" src="<?php echo esc_url($theme_uri . '/assets/images/common/logo.svg'); ?>"
                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="260" height="102">
                    <p class="p-concept__text">
                        自然美に囲まれた楽園で、<br>
                        贅沢な癒しのひとときを<br>
                        お過ごしください。
                    </p>
                </div>

                <!-- 大小2枚を重ねた組み写真。装飾なので alt は空 -->
                <div class="p-concept__images">
                    <img class="p-concept__image p-concept__image--large"
                         src="<?php echo esc_url($theme_uri . '/assets/images/top/concept-01.jpg'); ?>" alt="" width="610" height="460" loading="lazy">
                    <img class="p-concept__image p-concept__image--small"
                         src="<?php echo esc_url($theme_uri . '/assets/images/top/concept-02.jpg'); ?>" alt="" width="250" height="250" loading="lazy">
                </div>
            </div>
        </section>
