<?php
// スペック項目をまとめて定義
$specs = array(
  'room_type'       => '客室タイプ',
  'capacity'        => '定員',
  'room_size'       => '広さ',
  'view_type'       => '眺望',
  'price_per_night' => '1泊料金',
);
?>

<?php if (array_filter(array_map('get_field', array_keys($specs)))) : ?>
  <table class="spec-table">
    <?php foreach ($specs as $name => $label) : ?>
      <?php if (get_field($name)) : ?>
        <tr>
          <th><?php echo esc_html($label); ?></th>
          <td><?php echo esc_html(get_field($name)); ?></td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </table>
<?php endif; ?>