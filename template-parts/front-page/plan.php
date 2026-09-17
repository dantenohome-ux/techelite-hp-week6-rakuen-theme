<?php
/* =============================================================
   TOP 4. プラン（#plan）

   id="plan" はグローバルナビのアンカー先。変更しないこと。
   金額・時刻は Figma の実データ。
   ============================================================= */

$theme_uri = get_template_directory_uri();

$plans = [
    ['name' => 'スタンダードルーム', 'sub' => '- 自然のぬくもり -', 'price' => '30,000円/1部屋', 'in' => '16:00', 'out' => '10:00'],
    ['name' => 'デラックスルーム',   'sub' => '- 静寂の庭園 -',     'price' => '50,000円/1部屋', 'in' => '14:00', 'out' => '12:00'],
    ['name' => 'プレミアスィート',   'sub' => '- 桜花の調べ -',     'price' => '100,000円',      'in' => '15:00', 'out' => '11:00'],
];
?>
        <section class="p-plan" id="plan">
            <div class="p-plan__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">プラン</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">plan</span>
                </h2>

                <img class="p-plan__illust" src="<?php echo esc_url($theme_uri . '/assets/images/top/illust-plan.svg'); ?>" alt=""
                     width="235" height="78" loading="lazy">

                <ul class="p-plan__list">
                    <?php foreach ($plans as $plan) : ?>
                        <li class="c-card-plan">
                            <h3 class="c-card-plan__title">
                                <?php echo esc_html($plan['name']); ?><br>
                                <span class="c-card-plan__sub"><?php echo esc_html($plan['sub']); ?></span>
                            </h3>

                            <!-- 仕様は「項目：値」の対なので dl で組む -->
                            <dl class="c-card-plan__spec">
                                <div class="c-card-plan__spec-row">
                                    <dt>一泊の値段</dt>
                                    <dd><?php echo esc_html($plan['price']); ?></dd>
                                </div>
                                <div class="c-card-plan__spec-row">
                                    <dt>チェックイン時間</dt>
                                    <dd><?php echo esc_html($plan['in']); ?></dd>
                                </div>
                                <div class="c-card-plan__spec-row">
                                    <dt>チェックアウト時間</dt>
                                    <dd><?php echo esc_html($plan['out']); ?></dd>
                                </div>
                            </dl>

                            <!-- どのプランの予約か読み上げでも分かるようにしておく -->
                            <a class="c-btn-reserve c-btn-reserve--card" href="<?php echo esc_url(home_url('/contact/')); ?>">
                                予約<span class="u-visually-hidden">（<?php echo esc_html($plan['name']); ?>）</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
