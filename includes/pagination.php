<?php
/* =============================================================
   ページャー（ブログ一覧・お知らせ一覧で共用）

   使い方：ページ側で次の3つを用意してから require する。

       $pagination_base = '/blog.php';  // リンク先のパス
       $total_pages     = 5;            // 総ページ数
       $current_page    = 1;            // 現在のページ
       require __DIR__ . '/includes/pagination.php';

   今回はページ送りの処理を入れていないため、リンクは
   `?page=n` の形を用意するだけで、中身は同じ内容が出る。
   URL 設計だけ先に決めておき、記事が増えたときに
   ここと一覧側の絞り込みを実装すればよい形にしている。

   現在のページはリンクにせず aria-current="page" を付ける
   （パンくずの最終項目と同じ考え方）。
   ============================================================= */

if (!empty($total_pages) && $total_pages > 1):
    $base    = $pagination_base ?? '';
    $current = $current_page ?? 1;

    /* ページ番号から URL を組み立てる。
       1ページ目だけ ?page=1 を付けないのは、同じ内容のページが
       2つの URL で見えてしまうのを避けるため */
    $url = function (int $page) use ($base): string {
        return $page === 1 ? $base : $base . '?page=' . $page;
    };
?>
        <nav class="c-pagination" aria-label="ページ送り">
            <ul class="c-pagination__list">
                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                    <li class="c-pagination__item">
                        <?php if ($page === $current): ?>
                            <span class="c-pagination__current" aria-current="page"><?php echo $page; ?></span>
                        <?php else: ?>
                            <a class="c-pagination__link" href="<?php echo h($url($page)); ?>">
                                <?php echo $page; ?><span class="u-visually-hidden">ページ目へ</span>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
<?php endif; ?>
