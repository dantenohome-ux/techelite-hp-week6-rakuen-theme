<?php
/* =============================================================
   TOP 3. お部屋（#room）

   id="room" はグローバルナビのアンカー先。変更しないこと。
   タブの切り替えは assets/js/main.js（#room-tabs）が制御する。

   TODO: 3タイプの内容は Figma のダミー。スタンダード以外の本文と
         写真は仮のもの。実際の紹介文・写真に差し替えること。
   ============================================================= */

$theme_uri = get_template_directory_uri();

$rooms = [
    [
        'id'    => 'standard',
        'name'  => 'スタンダードルーム',
        'sub'   => '- 自然のぬくもり -',
        'lead'  => '自然のぬくもり',
        'image' => $theme_uri . '/assets/images/top/room-standard.jpg',
        'body'  => '「自然のぬくもり」スタンダードルームは、自然との共感を感じるお部屋です。山の景色を楽しむことができ、ナチュラルリトリートプランには朝食が含まれています。心地よいぬくもりとくつろぎのひとときを提供します。',
    ],
    [
        'id'    => 'deluxe',
        'name'  => 'デラックスルーム',
        'sub'   => '- 静寂の庭園 -',
        'lead'  => '静寂の庭園',
        'image' => $theme_uri . '/assets/images/top/room-deluxe.jpg',
        'body'  => '「静寂の庭園」デラックスルームは、庭園の静けさに包まれるお部屋です。四季の移ろいを窓辺から眺めることができ、庭園逍遥プランには夕食が含まれています。日常から離れた静かなひとときを提供します。',
    ],
    [
        'id'    => 'premier',
        'name'  => 'プレミアスィート',
        'sub'   => '- 桜花の調べ -',
        'lead'  => '桜花の調べ',
        'image' => $theme_uri . '/assets/images/top/room-premier.jpg',
        'body'  => '「桜花の調べ」プレミアスィートは、桜の景色を望む最上級のお部屋です。専用の露天風呂を備え、特別会席プランには朝夕の食事が含まれています。何にも代えがたい贅沢なひとときを提供します。',
    ],
];
?>
        <!-- 背景いっぱいに写真を敷き、その上に白文字で載せる -->
        <section class="p-room" id="room">
            <div class="p-room__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">お部屋</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">room</span>
                </h2>

                <p class="p-room__lead">「楽園雅苑」の豪華なお部屋は、大分県自然の美しさと格式の高いサービスが調和した完璧な空間を提供します。桜花の調べが響くプレミアスィート、静寂の庭園に囲まれたデラックスルーム、そして自然のぬくもりを感じるスタンダードルーム。どの部屋も極上の癒しとくつろぎがお待ちしております。贅沢な温泉体験と非日常のくつろぎをお楽しみください。</p>

                <!-- 3タイプの切り替え。
                     JS が動かない環境では is-ready が付かないので、
                     3枚とも縦に並んだまま読める（CSS 側で hidden を打ち消している） -->
                <div class="p-room__tabs" id="room-tabs">
                    <div class="p-room__tablist" role="tablist" aria-label="お部屋のタイプ">
                        <?php foreach ($rooms as $i => $room) : ?>
                            <button class="p-room__tab" type="button"
                                    role="tab"
                                    id="room-tab-<?php echo esc_attr($room['id']); ?>"
                                    aria-controls="room-panel-<?php echo esc_attr($room['id']); ?>"
                                    aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                                    tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>">
                                <span class="p-room__tab-name"><?php echo esc_html($room['name']); ?></span>
                                <span class="p-room__tab-sub"><?php echo esc_html($room['sub']); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <?php foreach ($rooms as $i => $room) : ?>
                        <div class="p-room__panel"
                             role="tabpanel"
                             id="room-panel-<?php echo esc_attr($room['id']); ?>"
                             aria-labelledby="room-tab-<?php echo esc_attr($room['id']); ?>"
                             tabindex="0"
                             <?php echo $i === 0 ? '' : 'hidden'; ?>>
                            <img class="p-room__photo" src="<?php echo esc_url($room['image']); ?>"
                                 alt="<?php echo esc_attr($room['name'] . 'の客室'); ?>"
                                 width="1200" height="650" loading="lazy">
                            <div class="p-room__detail">
                                <h3 class="p-room__detail-title"><?php echo esc_html($room['lead']); ?></h3>
                                <p class="p-room__detail-text"><?php echo esc_html($room['body']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <img class="p-room__illust" src="<?php echo esc_url($theme_uri . '/assets/images/top/illust-room.svg'); ?>" alt=""
                 width="241" height="128" loading="lazy">
        </section>
