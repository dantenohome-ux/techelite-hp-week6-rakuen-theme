<?php
/* =============================================================
   TOP（index.php）

   Figma: PC `1:2`（1440×10705）/ SP `17:2`（375×8190）
   構成: 1.ヒーロー 2.コンセプト 3.お部屋 4.プラン
         5.四季 6.アクセス 7.ブログ 8.お知らせ

   $page_title / $page_description は設定しない。
   未設定のとき header.php 側が TOP 用の既定値を使うため。

   お部屋 / プラン / 四季 / アクセスはグローバルナビのアンカー先。
   id は header.php の $global_nav に書いた href と対応している。
   ============================================================= */
require __DIR__ . '/includes/header.php';


/* ---- 掲載データ --------------------------------------------
   TODO: ブログ・お知らせは PR4（blog.php / news.php）を作る際に
         共通のデータ取得へ移す。いまは TOP の見た目を確認するための
         仮データで、文言・日付は Figma のダミーをそのまま使っている。

   お部屋の3タイプは Figma の「プラン」セクションと同じ並び。
   本文（body）はスタンダードのみ Figma に実文があり、残り2つは
   同じ文型で仮に書いている（TODO: 実際の紹介文に差し替え）。
   写真も Figma には1枚しか無いため3タイプで共用している。
   ------------------------------------------------------------ */

$rooms = [
    [
        'id'    => 'standard',
        'name'  => 'スタンダードルーム',
        'sub'   => '- 自然のぬくもり -',
        'lead'  => '自然のぬくもり',
        'image' => '/images/top/room-standard.jpg',
        'body'  => '「自然のぬくもり」スタンダードルームは、自然との共感を感じるお部屋です。山の景色を楽しむことができ、ナチュラルリトリートプランには朝食が含まれています。心地よいぬくもりとくつろぎのひとときを提供します。',
    ],
    [
        'id'    => 'deluxe',
        'name'  => 'デラックスルーム',
        'sub'   => '- 静寂の庭園 -',
        'lead'  => '静寂の庭園',
        'image' => '/images/top/room-deluxe.jpg',
        'body'  => '「静寂の庭園」デラックスルームは、庭園の静けさに包まれるお部屋です。四季の移ろいを窓辺から眺めることができ、庭園逍遥プランには夕食が含まれています。日常から離れた静かなひとときを提供します。',
    ],
    [
        'id'    => 'premier',
        'name'  => 'プレミアスィート',
        'sub'   => '- 桜花の調べ -',
        'lead'  => '桜花の調べ',
        'image' => '/images/top/room-premier.jpg',
        'body'  => '「桜花の調べ」プレミアスィートは、桜の景色を望む最上級のお部屋です。専用の露天風呂を備え、特別会席プランには朝夕の食事が含まれています。何にも代えがたい贅沢なひとときを提供します。',
    ],
];

// プランカード3枚。金額・時刻は Figma の実データ
$plans = [
    ['name' => 'スタンダードルーム', 'sub' => '- 自然のぬくもり -', 'price' => '30,000円/1部屋', 'in' => '16:00', 'out' => '10:00'],
    ['name' => 'デラックスルーム',   'sub' => '- 静寂の庭園 -',     'price' => '50,000円/1部屋', 'in' => '14:00', 'out' => '12:00'],
    ['name' => 'プレミアスィート',   'sub' => '- 桜花の調べ -',     'price' => '100,000円',      'in' => '15:00', 'out' => '11:00'],
];

// 四季セクションの帯写真5枚。装飾なので alt は空にする
$season_strip = ['strip-01', 'strip-02', 'strip-03', 'strip-04', 'strip-05'];

$top_posts = [
    ['date' => '2023/00/00', 'title' => 'ブログタイトルブログタイトルブログタイトルブログタイトル', 'category' => '観光地'],
    ['date' => '2023/00/00', 'title' => 'ブログタイトルブログタイトルブログタイトルブログタイトル', 'category' => '豆知識'],
    ['date' => '2023/00/00', 'title' => 'ブログタイトルブログタイトルブログタイトルブログタイトル', 'category' => '料理'],
];

$top_news = [
    ['date' => '2023/00/00', 'title' => 'お知らせタイトルお知らせタイトルお知らせタイトルお知らせタイトル'],
    ['date' => '2023/00/00', 'title' => 'お知らせタイトルお知らせタイトルお知らせタイトルお知らせタイトル'],
    ['date' => '2023/00/00', 'title' => 'お知らせタイトルお知らせタイトルお知らせタイトルお知らせタイトル'],
];
?>

        <!-- ==================== 1. ヒーロー ==================== -->
        <!-- ヘッダーが透過で重なる。文字が沈まないよう写真の上に暗幕を敷く -->
        <section class="p-hero">
            <img class="p-hero__image" src="/images/top/hero.jpg" alt=""
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


        <!-- ==================== 2. コンセプト ==================== -->
        <section class="p-concept">
            <div class="p-concept__inner l-inner">
                <div class="p-concept__body">
                    <img class="p-concept__logo" src="/images/common/logo.svg" alt="楽園雅苑"
                         width="260" height="102">
                    <p class="p-concept__text">
                        自然美に囲まれた楽園で、<br>
                        贅沢な癒しのひとときを<br>
                        お過ごしください。
                    </p>
                </div>

                <!-- 大小2枚を重ねた組み写真。装飾なので alt は空 -->
                <div class="p-concept__images">
                    <img class="p-concept__image p-concept__image--large"
                         src="/images/top/concept-01.jpg" alt="" width="610" height="460" loading="lazy">
                    <img class="p-concept__image p-concept__image--small"
                         src="/images/top/concept-02.jpg" alt="" width="250" height="250" loading="lazy">
                </div>
            </div>
        </section>


        <!-- ==================== 3. お部屋 ==================== -->
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
                        <?php foreach ($rooms as $i => $room): ?>
                            <button class="p-room__tab" type="button"
                                    role="tab"
                                    id="room-tab-<?php echo h($room['id']); ?>"
                                    aria-controls="room-panel-<?php echo h($room['id']); ?>"
                                    aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                                    tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>">
                                <span class="p-room__tab-name"><?php echo h($room['name']); ?></span>
                                <span class="p-room__tab-sub"><?php echo h($room['sub']); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <?php foreach ($rooms as $i => $room): ?>
                        <div class="p-room__panel"
                             role="tabpanel"
                             id="room-panel-<?php echo h($room['id']); ?>"
                             aria-labelledby="room-tab-<?php echo h($room['id']); ?>"
                             tabindex="0"
                             <?php echo $i === 0 ? '' : 'hidden'; ?>>
                            <img class="p-room__photo" src="<?php echo h($room['image']); ?>"
                                 alt="<?php echo h($room['name'] . 'の客室'); ?>"
                                 width="1200" height="650" loading="lazy">
                            <div class="p-room__detail">
                                <h3 class="p-room__detail-title"><?php echo h($room['lead']); ?></h3>
                                <p class="p-room__detail-text"><?php echo h($room['body']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <img class="p-room__illust" src="/images/top/illust-room.svg" alt=""
                 width="241" height="128" loading="lazy">
        </section>


        <!-- ==================== 4. プラン ==================== -->
        <section class="p-plan" id="plan">
            <div class="p-plan__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">プラン</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">plan</span>
                </h2>

                <img class="p-plan__illust" src="/images/top/illust-plan.svg" alt=""
                     width="235" height="78" loading="lazy">

                <ul class="p-plan__list">
                    <?php foreach ($plans as $plan): ?>
                        <li class="c-card-plan">
                            <h3 class="c-card-plan__title">
                                <?php echo h($plan['name']); ?><br>
                                <span class="c-card-plan__sub"><?php echo h($plan['sub']); ?></span>
                            </h3>

                            <!-- 仕様は「項目：値」の対なので dl で組む -->
                            <dl class="c-card-plan__spec">
                                <div class="c-card-plan__spec-row">
                                    <dt>一泊の値段</dt>
                                    <dd><?php echo h($plan['price']); ?></dd>
                                </div>
                                <div class="c-card-plan__spec-row">
                                    <dt>チェックイン時間</dt>
                                    <dd><?php echo h($plan['in']); ?></dd>
                                </div>
                                <div class="c-card-plan__spec-row">
                                    <dt>チェックアウト時間</dt>
                                    <dd><?php echo h($plan['out']); ?></dd>
                                </div>
                            </dl>

                            <!-- どのプランの予約か読み上げでも分かるようにしておく -->
                            <a class="c-btn-reserve c-btn-reserve--card" href="/contact.php">
                                予約<span class="u-visually-hidden">（<?php echo h($plan['name']); ?>）</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>


        <!-- ==================== 5. 四季 ==================== -->
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
                     src="/images/top/seasons-01.jpg" alt="" width="1020" height="536" loading="lazy">
                <img class="p-seasons__illust p-seasons__illust--01"
                     src="/images/top/illust-seasons-01.svg" alt="" width="211" height="93" loading="lazy">

                <!-- 3枚目の添え写真（Figma SP `18:212`）。
                     Figma では SP フレームにしか無いが、PC にも出す方針 -->
                <img class="p-seasons__photo p-seasons__photo--small"
                     src="/images/top/seasons-03.jpg" alt="" width="238" height="307" loading="lazy">

                <img class="p-seasons__photo p-seasons__photo--mid"
                     src="/images/top/seasons-02.jpg" alt="" width="586" height="338" loading="lazy">
                <img class="p-seasons__illust p-seasons__illust--02"
                     src="/images/top/illust-seasons-02.svg" alt="" width="155" height="55" loading="lazy">
            </div>

            <!-- 横一列の帯。左右とも画面外にはみ出す（Figma 準拠）。
                 中身は装飾なので、リストごと支援技術から隠す -->
            <div class="p-seasons__strip" aria-hidden="true">
                <?php foreach ($season_strip as $name): ?>
                    <img class="p-seasons__strip-item"
                         src="/images/top/<?php echo h($name); ?>.jpg" alt=""
                         width="340" height="244" loading="lazy">
                <?php endforeach; ?>
            </div>

            <div class="p-seasons__action l-inner">
                <a class="c-btn-more" href="/service.php">
                    <span class="c-btn-more__label">楽園雅苑のサービス</span>
                    <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                         fill="none" aria-hidden="true" focusable="false">
                        <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                    </svg>
                </a>
            </div>
        </section>


        <!-- ==================== 6. アクセス ==================== -->
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
            <img class="p-access__map" src="/images/top/access-map.jpg"
                 alt="楽園雅苑の周辺地図" width="1440" height="600" loading="lazy">

            <div class="p-access__body l-inner">
                <div class="p-access__head">
                    <img class="p-access__logo" src="/images/common/logo.svg" alt="楽園雅苑"
                         width="169" height="66" loading="lazy">
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


        <!-- ==================== 7. ブログ ==================== -->
        <section class="p-blog">
            <div class="p-blog__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">ブログ</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">blog</span>
                </h2>

                <ul class="p-blog__list">
                    <?php foreach ($top_posts as $card): ?>
                        <?php require __DIR__ . '/includes/card-article.php'; ?>
                    <?php endforeach; ?>
                </ul>

                <div class="p-blog__action">
                    <a class="c-btn-more" href="/blog.php">
                        <span class="c-btn-more__label">ブログ一覧はこちら</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>


        <!-- ==================== 8. お知らせ ==================== -->
        <section class="p-news">
            <div class="p-news__inner l-inner">

                <h2 class="c-section-title">
                    <span class="c-section-title__ja">お知らせ</span>
                    <span class="c-section-title__line" aria-hidden="true"></span>
                    <span class="c-section-title__en">news</span>
                </h2>

                <ul class="p-news__list">
                    <?php foreach ($top_news as $news): ?>
                        <li class="c-list-news">
                            <!-- TODO: PR4 で1件ごとの URL（/news-detail.php?slug=…）にする -->
                            <a class="c-list-news__link" href="/news-detail.php">
                                <time class="c-list-news__date"><?php echo h($news['date']); ?></time>
                                <h3 class="c-list-news__title"><?php echo h($news['title']); ?></h3>

                                <!-- 金の丸に白いシェブロン（Figma 実測 40×40 / 12×14） -->
                                <span class="c-list-news__arrow" aria-hidden="true">
                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" focusable="false">
                                        <path d="M0.0456135 13.9201L11.8175 7L0.0456135 0.0798832"
                                              stroke="currentColor" stroke-miterlimit="10"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="p-news__action">
                    <a class="c-btn-more" href="/news.php">
                        <span class="c-btn-more__label">お知らせ一覧はこちら</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
