<?php
/* =============================================================
   記事カード1枚（TOPの新着ブログ・ブログ一覧・関連記事で共用）

   使い方：1枚ぶんの内容を $card に入れてから require する。

       <?php foreach ($posts as $card): ?>
           <?php
           $card['href']    = '/blog-detail.php';
           $card['heading'] = 'h2';
           require __DIR__ . '/includes/card-article.php';
           ?>
       <?php endforeach; ?>

   $card のキー
     date     … 日付（表示用の文字列。例 2023/00/00）※必須
     title    … 記事タイトル ※必須
     category … カテゴリ名（タグとして出す）※必須
     href     … リンク先。省略時はブログ詳細
     thumb    … サムネイルのパス。省略時は共通のダミー画像
     variant  … 'wide' を渡すと横長（関連記事用）。省略時は通常
     heading  … 見出しのタグ名。'h2' か 'h3'。省略時は h3

   見出しのタグを呼び出し側から変えられるようにしているのは、
   置かれる場所によって見出しの階層が変わるため。
     ブログ一覧    … h1「ブログ」の直下なので h2
     TOP・関連記事 … セクションの h2 の下なので h3
   受け取った値はそのままタグ名にせず、下の一覧にあるものだけを使う。

   ※ 画像の幅・高さは variant から決めている（Figma実測）。
      呼び出し側で個別に指定できるようにすると、同じ見た目のはずの
      カードがページごとにずれていくため。
   ============================================================= */

$card_variant = ($card['variant'] ?? '') === 'wide' ? 'wide' : '';

// 見出しタグは許可した2つ以外を受け付けない
$card_heading = in_array($card['heading'] ?? '', ['h2', 'h3'], true)
    ? $card['heading']
    : 'h3';

// Figma実測：通常 380×230 / 横長（関連記事）415×250
$card_size = $card_variant === 'wide' ? [415, 250] : [380, 230];
?>
<li class="c-card-article<?php echo $card_variant === 'wide' ? ' c-card-article--wide' : ''; ?>">
    <!-- TODO: 記事ごとの URL（/blog-detail.php?slug=…）にする -->
    <a class="c-card-article__link" href="<?php echo h($card['href'] ?? '/blog-detail.php'); ?>">
        <!-- alt を空にしているのは、隣の見出しと同じ内容になり
             読み上げが二重になるため（装飾扱いにする） -->
        <img class="c-card-article__thumb"
             src="<?php echo h($card['thumb'] ?? '/images/top/blog-thumb.jpg'); ?>"
             alt="" width="<?php echo $card_size[0]; ?>" height="<?php echo $card_size[1]; ?>" loading="lazy">
        <div class="c-card-article__body">
            <!-- datetime は機械可読な形。表示は Figma のダミー表記のまま -->
            <time class="c-card-article__date"><?php echo h($card['date']); ?></time>
            <<?php echo $card_heading; ?> class="c-card-article__title"><?php echo h($card['title']); ?></<?php echo $card_heading; ?>>
            <span class="c-card-article__tag"><?php echo h($card['category']); ?></span>
        </div>
    </a>
</li>
