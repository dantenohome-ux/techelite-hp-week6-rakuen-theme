<?php
/* =============================================================
   客室詳細（single-rooms.php）

   スペック表は ACF のフィールドから出す。値が空の項目は行ごと出さず、
   すべて空なら表そのものを出さない。
   表の見た目は運営会社ページと同じ `.c-table`。見出し・本文の文字は
   ブログ詳細の `.p-article__*` を使い回すが、外枠は `.p-article` ではなく
   専用の `.p-room-detail` にする（`.p-article__inner` は PC で本文＋サイドバーの
   2カラムグリッドなので、使うと表が右の300px列に入ってしまう）。
   ※ `.p-room` は TOP のお部屋セクション用なので使わない。
   ============================================================= */

// ACF のフィールド名 => 表示ラベル
$specs = [
    'room_type'       => '客室タイプ',
    'capacity'        => '定員',
    'room_size'       => '広さ',
    'view_type'       => '眺望',
    'price_per_night' => '1泊料金',
];

get_header();

get_template_part('template-parts/breadcrumb');

while (have_posts()) :
    the_post();

    // get_field() は項目ごとに1回だけ呼び、空でないものだけ残す
    $rows = [];
    foreach ($specs as $name => $label) {
        $value = get_field($name);

        if ($value === null || $value === false || $value === '') {
            continue;
        }

        // 料金は桁区切り＋「円」。数字以外が入っていたらそのまま出す
        if ($name === 'price_per_night' && is_numeric($value)) {
            $value = number_format((float) $value) . '円';
        }

        $rows[$label] = $value;
    }

    // 客室写真（ACF 画像フィールド `gallery`、1客室1枚）。返り値が「画像配列」でも
    // 「画像ID」でも動くように ID を取り出す。画像が無ければ何も出さない
    $image    = get_field('gallery');
    $image_id = is_array($image) ? (int) ($image['ID'] ?? 0) : (int) $image;
    ?>

    <article class="p-room-detail">
        <div class="p-room-detail__inner l-inner">

            <header>
                <h1 class="p-article__title"><?php the_title(); ?></h1>
            </header>

            <?php if ($image_id) : ?>
                <?php
                // srcset は WordPress が付ける。メディアの代替テキストが空なら客室名を使う
                echo wp_get_attachment_image($image_id, 'large', false, [
                    'class' => 'p-article__hero',
                    'alt'   => get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: get_the_title(),
                ]);
                ?>
            <?php endif; ?>

            <?php if ($rows !== []) : ?>
                <dl class="c-table p-room-detail__spec">
                    <?php foreach ($rows as $label => $value) : ?>
                        <div class="c-table__row">
                            <dt class="c-table__label"><?php echo esc_html($label); ?></dt>
                            <dd class="c-table__value"><?php echo esc_html($value); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            <?php endif; ?>

            <div class="p-article__body">
                <?php the_content(); ?>
            </div>

        </div>
    </article>

    <?php
endwhile;

get_footer();
