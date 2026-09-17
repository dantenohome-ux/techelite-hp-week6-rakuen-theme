<?php
/* =============================================================
   運営会社情報（about.php）

   Figma: PC `510:2`（1440×2004）/ SP `510:3`（375×1758）
   構成: パンくず → ページタイトル → 会社概要テーブル

   テーブルは PC で「ラベル列230px ＋ 値列670px」の横並び、
   SP では縦積みに変わる。見た目の切り替えは CSS 側（.c-table）で行い、
   マークアップは dl 1つで共通にしている。
   ============================================================= */

$page_title       = '運営会社情報｜楽園雅苑';
$page_description = '温泉宿「楽園雅苑」を運営する桜庭観光株式会社の会社概要です。所在地・連絡先・事業内容をご案内します。';

// パンくず（最後の項目が現在地。href を書かなければリンクにならない）
$breadcrumb = [
    ['href' => '/',  'label' => 'トップ'],
    ['label' => '運営会社情報'],
];

require __DIR__ . '/includes/header.php';


/* ---- 会社概要 ------------------------------------------------
   すべて Figma の実データ。
   type は値の出し方の違いだけを表す：
     text … そのまま表示
     mail … mailto: のリンク
     url  … 外部サイトへのリンク
     html … 長文（両端揃えで組む）
   ------------------------------------------------------------ */
$company = [
    ['label' => '会社名',        'type' => 'text', 'value' => '桜庭観光株式会社'],
    ['label' => '所在地',        'type' => 'text', 'value' => '〒879-5425 大分県由布市庄内町渕'],
    ['label' => '電話番号',      'type' => 'tel',  'value' => '0123-456-7890'],
    ['label' => 'メールアドレス', 'type' => 'mail', 'value' => 'info@sakuraba-ryokan.com'],
    ['label' => 'ウェブサイト',   'type' => 'url',  'value' => '楽園雅苑ウェブサイト',
                                  'href'  => 'https://www.sakuraba-ryokan.com/'],
    ['label' => '代表者名',      'type' => 'text', 'value' => '山田太郎'],
    ['label' => '創立年',        'type' => 'text', 'value' => '1998年'],
    ['label' => '事業内容',      'type' => 'text', 'value' => '温泉宿「楽園雅苑」の運営'],
    ['label' => '会社概要',      'type' => 'long', 'value' => '桜庭観光株式会社は、大分県内で美しい自然環境と伝統的な温泉文化を提供するリゾート施設を運営する会社です。私たちの温泉宿「楽園雅苑」では、四季折々の美しい景色と温泉を楽しむ贅沢な滞在を提供しております。'],
];
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">運営会社情報</h1>
        </div>

        <section class="p-about">
            <div class="p-about__inner l-inner">
                <!-- 「項目と値」の組み合わせなので dl で組む。
                     1組を div でくくっているのは、罫線と余白を行単位で持たせるため -->
                <dl class="c-table">
                    <?php foreach ($company as $row): ?>
                        <div class="c-table__row">
                            <dt class="c-table__label"><?php echo h($row['label']); ?></dt>
                            <dd class="c-table__value<?php echo $row['type'] === 'long' ? ' c-table__value--long' : ''; ?>">
                                <?php if ($row['type'] === 'mail'): ?>
                                    <a class="c-table__link" href="mailto:<?php echo h($row['value']); ?>"><?php echo h($row['value']); ?></a>
                                <?php elseif ($row['type'] === 'tel'): ?>
                                    <!-- 電話番号はスマートフォンでそのまま発信できるようにする。
                                         href からハイフンを取り除く -->
                                    <a class="c-table__link c-table__link--tel" href="tel:<?php echo h(str_replace('-', '', $row['value'])); ?>"><?php echo h($row['value']); ?></a>
                                <?php elseif ($row['type'] === 'url'): ?>
                                    <!-- 別タブで開く外部リンク。rel を付けて開いた先から
                                         元のページを操作されないようにする -->
                                    <a class="c-table__link" href="<?php echo h($row['href']); ?>"
                                       target="_blank" rel="noopener noreferrer"><?php echo h($row['value']); ?></a>
                                <?php else: ?>
                                    <?php echo h($row['value']); ?>
                                <?php endif; ?>
                            </dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
