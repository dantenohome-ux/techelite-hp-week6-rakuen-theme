<?php
/* =============================================================
   ご予約：完了画面（thanks.php）

   Figma: PC `18:737`（1440×1826）/ SP `18:789`（375×1618）
   構成: パンくず（4階層）→ ページタイトル → 本文2ブロック

   ※ Figma の PC フレームには本文が無く、SP フレームにだけ本文がある。
     見出しだけでは「何が完了し、次に何が起きるか」が伝わらないため、
     SP の本文を PC にも出している（PC/SP で内容が食い違う箇所のうち、
     内容が多いほうを採った）。

   送信を終えた人だけが見られる画面。confirm.php が立てた印を確かめ、
   無ければ入力画面へ送り返す（URL を直接開いても完了と表示しないため）。

   検索結果に出ても意味が無いので noindex にしている。
   ============================================================= */

require_once __DIR__ . '/includes/form.php';

form_session_start();

if (empty($_SESSION['reserve_done'])) {
    form_redirect('/contact.php');
}

$page_title       = '予約が完了しました｜楽園雅苑';
$page_description = 'ご予約ありがとうございます。予約の受付が完了しました。';
$page_noindex     = true;

$breadcrumb = [
    ['href' => '/',            'label' => 'トップ'],
    ['href' => '/contact.php', 'label' => 'ご予約'],
    ['href' => '/confirm.php', 'label' => '予約内容の確認'],
    ['label' => '予約完了'],
];

require __DIR__ . '/includes/header.php';
?>

        <?php require __DIR__ . '/includes/breadcrumb.php'; ?>

        <div class="p-page-head">
            <h1 class="p-page-head__title">予約が完了しました</h1>
        </div>

        <section class="p-thanks">
            <div class="p-thanks__inner l-inner">

                <!-- Figma では段落どうしの間隔が空いていないので、
                     ブロック内の p には余白を付けていない（CSS 側で 0）。
                     文としては別々なので、<br> ではなく段落に分けている -->
                <div class="p-thanks__block">
                    <p>「楽園雅苑 - 桜庭温泉の隠れ家 -」へのご予約、誠にありがとうございます。お客様の予約が正常に受け付けられました。</p>
                    <p>ご注意事項:</p>
                    <p>ご予約に関する特別なリクエストや変更がある場合、お手続きの前に当宿のスタッフがご連絡いたします。</p>
                    <p>予約内容の変更やキャンセルについては、ご予約確認メールに記載の手順に従ってご連絡いただけます。</p>
                </div>

                <div class="p-thanks__block">
                    <p>「楽園雅苑」でのご滞在が、素晴らしい思い出とくつろぎに満ちたひとときとなることを心より願っております。何かご質問やご要望がある場合は、いつでもご連絡いただけます。</p>
                    <p>お客様にお会いできることを楽しみにしております。</p>
                </div>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
