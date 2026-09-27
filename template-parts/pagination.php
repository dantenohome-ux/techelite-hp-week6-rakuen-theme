<?php
/* =============================================================
   ページネーション（home.php / category.php / tag.php / archive.php で共通）
   ============================================================= */
?>
<div class="c-pagination">
    <?php
    the_posts_pagination([
        'mid_size'           => 1,
        'prev_text'          => '← 前へ',
        'next_text'          => '次へ →',
        'screen_reader_text' => 'ページ送り',
    ]);
    ?>
</div>
