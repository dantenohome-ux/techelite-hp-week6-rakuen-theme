<?php
/* =============================================================
   共通フッター（<main> の閉じタグ 〜 </html>）

   header.php とセットで使う。各ページの最後で require する。

   ナビのリンクは header.php で定義した $global_nav / $content_nav /
   $utility_nav をそのまま使い回す（リンク定義をサイト内で1箇所に保つため）。

   宿ナビ（7項目） = $global_nav（5） ＋ $content_nav（2）
   サブナビ（3項目） = $utility_nav
   ============================================================= */

// h()（出力用エスケープ）を使うため。すでに読み込まれていれば何も起きない
require_once __DIR__ . '/functions.php';

// header.php を通さずに読み込まれた場合でも落ちないようにしておく
$global_nav  = $global_nav  ?? [];
$content_nav = $content_nav ?? [];
$utility_nav = $utility_nav ?? [];

// フッター宿ナビは2つの配列をつなげた7項目
$footer_nav = array_merge($global_nav, $content_nav);
?>
    </main>

    <!-- ============================= フッター ============================= -->
    <footer class="l-footer">
        <div class="l-footer__inner">

            <!-- ロゴ（TOPへのリンクを兼ねる） -->
            <a class="l-footer__logo" href="/">
                <!-- 生成りの地に載るので金版。Figma実測 PC 230.24×90 / SP 179.08×70 -->
                <img class="l-footer__logo-image" src="/images/common/logo.svg"
                     alt="楽園雅苑" width="230" height="90">
            </a>

            <!-- 宿ナビ（お部屋 / プラン / 四季 / アクセス / サービス / ブログ / お知らせ） -->
            <nav class="l-footer__nav" aria-label="サイトマップ">
                <ul class="l-footer__menu">
                    <?php foreach ($footer_nav as $item): ?>
                        <?php $is_current = is_current($item['current']); ?>
                        <li class="l-footer__item">
                            <a class="l-footer__link<?php echo $is_current ? ' is-current' : ''; ?>"
                               href="<?php echo h($item['href']); ?>"
                               <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo h($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <hr class="l-footer__divider">

            <!-- 宿の情報（NAP：Name / Address / Phone）
                 全ページのフッターに置くのが宿泊施設サイトの定石（ローカルSEO・信頼性）
                 TODO: 住所・電話番号・営業情報はすべてダミー。実データに差し替えること -->
            <div class="l-footer__info">
                <p class="l-footer__hotel-name">楽園雅苑</p>
                <address class="l-footer__address">
                    〒000-0000　○○県桜庭市桜庭温泉 1-2-3<br>
                    TEL <a class="l-footer__tel" href="tel:0000000000">00-0000-0000</a>
                    <span class="l-footer__hours">（受付 9:00〜20:00）</span>
                </address>
                <p class="l-footer__operator">運営：桜庭観光株式会社</p>
            </div>

            <!-- サブナビ（運営会社情報 / プライバシーポリシー / 利用規約） -->
            <nav class="l-footer__nav l-footer__nav--sub" aria-label="サブナビゲーション">
                <ul class="l-footer__menu l-footer__menu--sub">
                    <?php foreach ($utility_nav as $item): ?>
                        <?php $is_current = is_current($item['current']); ?>
                        <li class="l-footer__item">
                            <a class="l-footer__link<?php echo $is_current ? ' is-current' : ''; ?>"
                               href="<?php echo h($item['href']); ?>"
                               <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo h($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Figma の表記どおり年号なし。&copy; は © の実体参照 -->
            <p class="l-footer__copyright u-serif">&copy; RAKUGAEN.</p>

        </div>
    </footer>

    <script src="/js/main.js"></script>
</body>
</html>
