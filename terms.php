<?php
/* =============================================================
   利用規約（terms.php）＝ 仮置きページ

   Figma にこのページのデザインは無い。
   ただしフッターとSPドロワーの $utility_nav から常にリンクしているため、
   リンク切れにしないための受け皿としてこのファイルを置いている。

   見た目はプライバシーポリシー（privacy.php）と同じ `.p-legal` を使う。
   デザインが起こされたら、そちらに合わせて作り直すこと。

   TODO: 条文が確定したら、privacy.php と同じ形の $sections に
         中身を入れて「準備中」の案内を消す。
         法務の確認を経ていない文章を、それらしく置かないこと。
   ============================================================= */

$page_title       = '利用規約｜楽園雅苑';
$page_description = '楽園雅苑のウェブサイトおよび宿泊サービスのご利用にあたっての規約です。';

$breadcrumb = [
    ['href' => '/', 'label' => 'トップ'],
    ['label' => '利用規約'],
];

require __DIR__ . '/includes/header.php';

// 掲載を予定している条の一覧。中身が入るまでは見出しだけを示す
$planned = [
    '第１．適用範囲',
    '第２．宿泊契約の成立',
    '第３．宿泊の登録',
    '第４．宿泊料金のお支払い',
    '第５．宿泊契約の解除（キャンセル）',
    '第６．ご利用時間',
    '第７．ご利用にあたっての遵守事項',
    '第８．当館の責任',
    '第９．寄託物等の取扱い',
    '第１０．準拠法及び管轄裁判所',
];
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">利用規約</h1>
        </div>

        <section class="p-legal">
            <div class="p-legal__inner l-inner">

                <p class="p-page-lead">本規約は現在準備中です。内容が確定しましたら、こちらのページに掲載いたします。ご不便をおかけしますが、ご予約・ご利用に関するお問い合わせは、お電話にて承っております。</p>

                <section class="p-legal__section">
                    <h2 class="p-legal__title">掲載予定の内容</h2>

                    <div class="p-legal__body">
                        <ul class="p-legal__list">
                            <?php foreach ($planned as $item): ?>
                                <li><?php echo h($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </section>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
