<?php
/* =============================================================
   パンくず（TOP 以外の全ページ）

   使い方：ページ側で $breadcrumb に配列を用意してから require する。
   最後の項目が現在地。href を書かなければリンクにならない。

       <?php
       $breadcrumb = [
           ['href' => '/', 'label' => 'トップ'],
           ['label' => '運営会社情報'],
       ];
       require __DIR__ . '/includes/breadcrumb.php';
       ?>

   仕様は breadcrumb-spec.md に準拠：
     ・最後の項目はリンクにせず aria-current="page" を付ける
     ・区切りの「＞」は HTML に書かず CSS の ::before で描く
       （読み上げで「大なり」と読まれるノイズを避けるため）
     ・ラベルはページタイトルではなくナビ用の短い名前

   $breadcrumb が未定義／空のときは何も出力しない（TOP 用）。
   ============================================================= */

if (!empty($breadcrumb)):
    $last = count($breadcrumb) - 1;
?>
        <!-- l-inner を兼ねさせて、本文と同じ左右の位置に揃える
             （Figma: PC x=120 / SP x=20） -->
        <nav class="c-breadcrumb l-inner" aria-label="パンくず">
            <ol class="c-breadcrumb__list">
                <?php foreach ($breadcrumb as $i => $crumb): ?>
                    <li class="c-breadcrumb__item">
                        <?php if ($i === $last): ?>
                            <span class="c-breadcrumb__current" aria-current="page"><?php echo h($crumb['label']); ?></span>
                        <?php else: ?>
                            <a class="c-breadcrumb__link" href="<?php echo h($crumb['href']); ?>"><?php echo h($crumb['label']); ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
<?php endif; ?>
