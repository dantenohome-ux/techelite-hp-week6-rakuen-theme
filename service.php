<?php
/* =============================================================
   楽園雅苑のサービス（service.php）

   Figma: PC `538:2291`（1440×5595）/ SP `538:2380`
   構成: 1.温泉 2.施設情報（客室 / レストラン・ダイニング）
         3.その他施設・サービス（会議室 / マッサージ）

   セクション見出しは TOP の `.c-section-title`（和文＋縦線＋欧文）とは
   別型で、中央寄せの見出しの下に 90×2px の金のバーが入る。
   繰り返すので `.c-service-head` として共通化した。
   ============================================================= */

$page_title       = '楽園雅苑のサービス｜楽園雅苑';
$page_description = '桜庭温泉の泉質と効能、客室・レストラン・会議室・マッサージなど、楽園雅苑でお過ごしいただくための施設とサービスをご案内します。';

$breadcrumb = [
    ['href' => '/', 'label' => 'トップ'],
    ['label' => 'サービス'],
];

require __DIR__ . '/includes/header.php';


/* ---- 掲載データ ------------------------------------------------
   写真はすべて Figma からの書き出し。
   客室は 380×280 の3枚組、それ以外は 580×370 の2枚組で、
   Figma でも同じ並びが3回繰り返される。
   ---------------------------------------------------------------- */

// 温泉の泉質・効能テーブル
$onsen_quality = '「桜庭温泉」の泉質は、硫黄泉とナトリウム・カルシウム硫酸塩泉が混ざり合った特別な組み合わせです。硫黄の特有の香りと透明感のある湯色が特徴で、温泉浴後に肌がつるつるになる感覚を提供します。';

$onsen_effects = [
    '疲労回復: 泉質の特性から、疲れた筋肉をほぐし、日々のストレスや疲れを和らげます。',
    '皮膚の健康: 温泉のミネラルが肌に潤いを与え、肌トラブルを緩和します。',
    '血行促進: 温まった温泉効果で血行が促進され、身体全体をリフレッシュします。',
    '神経のリラックス: 温かい泉質が神経を鎮め、リラックスした状態をもたらします。',
];
$onsen_effects_note = 'このような泉質と効能は、体のリラックスやリフレッシュに役立ちます。';

// 温泉セクションの写真2枚。Figma では SP フレームにのみ存在する
$onsen_photos = [
    ['file' => 'service-onsen-01', 'alt' => '内湯の浴槽'],
    ['file' => 'service-onsen-02', 'alt' => '露天風呂'],
];

// 客室の写真3枚（380×280）
$room_photos = [
    ['file' => 'service-room-01', 'alt' => '和室の客室'],
    ['file' => 'service-room-02', 'alt' => '庭園を望む和室'],
    ['file' => 'service-room-03', 'alt' => '露天風呂付きの客室'],
];

// 2枚組で並ぶ写真。セクションごとに文言だけ差し替える
$dining_photos = [
    ['file' => 'service-dining-01',  'alt' => '個室のお食事処'],
    ['file' => 'service-dining-02',  'alt' => '地元の食材を使った会席料理'],
];
$hall_photos = [
    ['file' => 'service-hall-01',    'alt' => '会議用に設えた和室'],
    ['file' => 'service-hall-02',    'alt' => 'イベントスペース'],
];
$massage_photos = [
    ['file' => 'service-massage-01', 'alt' => 'マッサージチェア'],
    ['file' => 'service-massage-02', 'alt' => '施術用のベッド'],
];

// 営業時間
$dining_hours = [
    '朝食7:00 ~ 10:00 (ラストオーダー 9:30)',
    'ランチ11:30 ~ 14:00 (ラストオーダー 13:30)',
    'ディナー18:00 ~ 21:00 (ラストオーダー 20:30)',
];
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">楽園雅苑のサービス</h1>
        </div>


        <!-- ==================== 1. 温泉 ==================== -->
        <section class="p-service">
            <div class="p-service__inner l-inner">

                <h2 class="c-service-head">
                    <span class="c-service-head__text">温泉</span>
                </h2>

                <!-- SP は「癒しの源泉、」の後で改行する（Figma 準拠）。PC は1行 -->
                <p class="p-service__lead">癒しの源泉、<br class="u-br-sp">心と体を満たす至福の温泉体験</p>

                <p class="p-service__text">「楽園雅苑 - 桜庭温泉の隠れ家 -」では、自然の恵みに満ちた温泉を誇ります。当館の温泉は、大自然の地下深くから湧き出る温泉源を利用し、厳選された泉質が心と体を癒やします。その美しい湯色と温かさは、まるで天然の温もりを感じるかのよう。疲れた心と体を癒し、日々の喧騒から解放される贅沢な時間を提供します。楽園雅苑の温泉で、極上の癒しとリフレッシュをご体験ください。</p>

                <!-- この2枚は Figma の SP フレームにのみ置かれており、
                     PC フレームは同じ位置が約490pxの空白になっている。
                     空白のままでは温泉の様子が伝わらないため、PC でも表示している
                     （寸法は同ページのレストラン等と同じ 580×370） -->
                <ul class="c-photo-grid c-photo-grid--2 p-service__photos--onsen">
                    <?php foreach ($onsen_photos as $p): ?>
                        <li>
                            <img src="/images/service/<?php echo h($p['file']); ?>.jpg"
                                 alt="<?php echo h($p['alt']); ?>" width="580" height="370" loading="lazy">
                        </li>
                    <?php endforeach; ?>
                </ul>

                <dl class="c-table p-service__table">
                    <div class="c-table__row">
                        <dt class="c-table__label">泉質</dt>
                        <dd class="c-table__value c-table__value--long"><?php echo h($onsen_quality); ?></dd>
                    </div>
                    <div class="c-table__row">
                        <dt class="c-table__label">効能</dt>
                        <dd class="c-table__value c-table__value--long">
                            <ul class="c-table__list">
                                <?php foreach ($onsen_effects as $effect): ?>
                                    <li><?php echo h($effect); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="c-table__note"><?php echo h($onsen_effects_note); ?></p>
                        </dd>
                    </div>
                </dl>
            </div>
        </section>


        <!-- ==================== 2. 施設情報 ==================== -->
        <section class="p-service">
            <div class="p-service__inner l-inner">

                <h2 class="c-service-head">
                    <span class="c-service-head__text">施設情報</span>
                </h2>

                <!-- ---- 客室 ---- -->
                <h3 class="p-service__subhead">客室</h3>

                <p class="p-service__text p-service__text--center">
                    プレミアスィート、デラックスルーム、スタンダードルームの豊富な選択肢。<br class="u-br-pc">
                    快適なベッドとモダンな設備完備。<br class="u-br-pc">
                    自然の風景を望む客室や温泉露天風呂付き客室をご用意しております。
                </p>

                <ul class="c-photo-grid c-photo-grid--3">
                    <?php foreach ($room_photos as $p): ?>
                        <li>
                            <img src="/images/service/<?php echo h($p['file']); ?>.jpg"
                                 alt="<?php echo h($p['alt']); ?>" width="380" height="280" loading="lazy">
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="p-service__action">
                    <a class="c-btn-more" href="/index.php#plan">
                        <span class="c-btn-more__label">宿泊プランを見る</span>
                        <svg class="c-btn-more__arrow" width="21" height="7" viewBox="0 0 21.2125 6.85466"
                             fill="none" aria-hidden="true" focusable="false">
                            <path d="M0 6.35466H20L13.9623 0.35466" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>

                <!-- ---- レストラン・ダイニング ---- -->
                <h3 class="p-service__subhead">レストラン・ダイニング</h3>

                <p class="p-service__text p-service__text--center">
                    地元の食材を使用した料理を楽しめるレストラン。<br class="u-br-pc">
                    お部屋食や個室も用意され、贅沢な食体験を提供。
                </p>

                <ul class="c-photo-grid c-photo-grid--2">
                    <?php foreach ($dining_photos as $p): ?>
                        <li>
                            <img src="/images/service/<?php echo h($p['file']); ?>.jpg"
                                 alt="<?php echo h($p['alt']); ?>" width="580" height="370" loading="lazy">
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="p-service__hours">
                    <?php foreach ($dining_hours as $line): ?>
                        <p class="p-service__hours-line"><?php echo h($line); ?></p>
                    <?php endforeach; ?>
                    <p class="p-service__hours-note">※ 営業時間は季節や施設の状況によって変更される場合がございますので、事前にご確認ください。</p>
                </div>
            </div>
        </section>


        <!-- ============== 3. その他施設・サービス ============== -->
        <section class="p-service">
            <div class="p-service__inner l-inner">

                <h2 class="c-service-head">
                    <span class="c-service-head__text">その他施設・サービス</span>
                </h2>

                <!-- ---- 会議室、イベントスペース ---- -->
                <h3 class="p-service__subhead">会議室、イベントスペース</h3>

                <ul class="c-photo-grid c-photo-grid--2">
                    <?php foreach ($hall_photos as $p): ?>
                        <li>
                            <img src="/images/service/<?php echo h($p['file']); ?>.jpg"
                                 alt="<?php echo h($p['alt']); ?>" width="580" height="370" loading="lazy">
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- ---- マッサージ ---- -->
                <h3 class="p-service__subhead">マッサージ</h3>

                <ul class="c-photo-grid c-photo-grid--2">
                    <?php foreach ($massage_photos as $p): ?>
                        <li>
                            <img src="/images/service/<?php echo h($p['file']); ?>.jpg"
                                 alt="<?php echo h($p['alt']); ?>" width="580" height="370" loading="lazy">
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
