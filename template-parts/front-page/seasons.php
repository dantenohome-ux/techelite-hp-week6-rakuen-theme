<?php
/* =============================================================
   TOP 5. 四季（#seasons）

   id="seasons" はグローバルナビのアンカー先。変更しないこと。
   ============================================================= */

$theme_uri = get_template_directory_uri();

// 四季セクションの帯写真5枚。装飾なので alt は空にする
$season_strip = ['strip-01', 'strip-02', 'strip-03', 'strip-04', 'strip-05'];
?>
        <section class="p-seasons" id="seasons">
            <div class="p-seasons__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">四季</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">seasons</span>
                </h2>

                <p class="p-seasons__lead">「楽園雅苑」は、大分県自然の美しさが四季折々に変化する場所です。春には桜花が舞い、夏には新緑が輝き、秋には紅葉が魅了し、冬には雪景色が広がります。四季折々の風景や風味を楽しむためのアクティビティや特別なイベントが用意されています。どの季節に訪れても、自然の美しさに囲まれた楽園で贅沢なひとときを過ごしませんか？</p>
            </div>

            <!-- 大きい写真は左端まで、2枚目は中央寄り。装飾なので alt は空 -->
            <div class="p-seasons__photos">
                <img class="p-seasons__photo p-seasons__photo--large"
                     src="<?php echo esc_url($theme_uri . '/assets/images/top/seasons-01.jpg'); ?>" alt="" width="1020" height="536" loading="lazy">
                <img class="p-seasons__illust p-seasons__illust--01"
                     src="<?php echo esc_url($theme_uri . '/assets/images/top/illust-seasons-01.svg'); ?>" alt="" width="211" height="93" loading="lazy">

                <!-- 3枚目の添え写真（Figma SP `18:212`）。
                     Figma では SP フレームにしか無いが、PC にも出す方針 -->
                <img class="p-seasons__photo p-seasons__photo--small"
                     src="<?php echo esc_url($theme_uri . '/assets/images/top/seasons-03.jpg'); ?>" alt="" width="238" height="307" loading="lazy">

                <img class="p-seasons__photo p-seasons__photo--mid"
                     src="<?php echo esc_url($theme_uri . '/assets/images/top/seasons-02.jpg'); ?>" alt="" width="586" height="338" loading="lazy">
                <img class="p-seasons__illust p-seasons__illust--02"
                     src="<?php echo esc_url($theme_uri . '/assets/images/top/illust-seasons-02.svg'); ?>" alt="" width="155" height="55" loading="lazy">
            </div>

            <!-- 横一列の帯。左右とも画面外にはみ出す（Figma 準拠）。
                 中身は装飾なので、リストごと支援技術から隠す -->
            <div class="p-seasons__strip" aria-hidden="true">
                <?php foreach ($season_strip as $name) : ?>
                    <img class="p-seasons__strip-item"
                         src="<?php echo esc_url($theme_uri . '/assets/images/top/' . $name . '.jpg'); ?>" alt=""
                         width="340" height="244" loading="lazy">
                <?php endforeach; ?>
            </div>

            <div class="p-seasons__action l-inner">
                <a class="c-btn-more" href="<?php echo esc_url(home_url('/service/')); ?>">
                    <span class="c-btn-more__label">楽園雅苑のサービス</span>
                    <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                         fill="none" aria-hidden="true" focusable="false">
                        <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                    </svg>
                </a>
            </div>
        </section>
