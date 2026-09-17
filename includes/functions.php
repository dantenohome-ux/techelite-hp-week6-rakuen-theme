<?php
/* =============================================================
   サイト全体で使う小さな関数

   「毎回書くと長い・書き忘れると困る」処理を短くまとめただけの
   ラッパー関数を置く。ページ固有の処理はここには入れない。

   header.php / footer.php がそれぞれ読み込むので、
   どのページからでも使える。

   ※ 二重読み込みで関数が重複定義されないよう、
      読み込む側は require ではなく require_once を使うこと。
   ============================================================= */


/**
 * HTMLに値を出すときのエスケープ。
 *
 * htmlspecialchars($v, ENT_QUOTES, 'UTF-8') と同じだが、
 * 毎回3つの引数を書くのは長く、書き忘れがそのまま脆弱性になる。
 * 短い名前にして「出力は必ずこれを通す」という決まりを守りやすくしている。
 *
 *   ENT_QUOTES … シングルクォートも変換する（属性値の中に入れても壊れない）
 *   'UTF-8'    … 文字コードの指定。省略時の既定に頼らず明示する
 *
 * 例：h('<script>') → '&lt;script&gt;'
 */
function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}


/**
 * いま表示しているページのファイル名を返す（例：'about.php'）。
 *
 * $_SERVER['PHP_SELF'] は '/about.php' のようにパス付きで入っているので、
 * basename() でファイル名だけを取り出す。
 * グローバルナビの現在地判定と、OGP の og:url の組み立てに使う。
 *
 * ?? '' は「PHP_SELF が無い環境（CLI など）でも落ちないように」の保険。
 */
function current_page(): string
{
    return basename($_SERVER['PHP_SELF'] ?? '');
}


/**
 * いま見ているページが、渡したファイル名のどれかに当てはまるか。
 *
 * ナビの1項目に「この項目を現在地として光らせるファイル」を複数持たせたい
 * ことがあるため、配列で受け取る。
 * 例：「お問い合わせ」は contact.php / confirm.php / thanks.php のどれでも現在地。
 *
 * 第3引数の true は厳密比較（型も一致するもののみ）。
 * 空配列を渡すと必ず false になる ＝「現在地にしない項目」を表せる
 * （TOP 内アンカーの お部屋 / プラン / 四季 / アクセス がこれに当たる）。
 */
function is_current(array $files): bool
{
    return in_array(current_page(), $files, true);
}
