<?php
/* =============================================================
   共通フッター（<main> の閉じタグ 〜 </html>）

   各テンプレートの最後で get_footer() を呼ぶと、このファイルが読み込まれる。

   ナビのリンクは functions.php の rakuen_nav_items() から取り出す。
   header.php で作った変数はここからは見えない（WordPress はテンプレートを
   関数の中で読み込むため）ので、定義を関数側に置いている。

   宿ナビ（7項目） = global（5） ＋ content（2）
   サブナビ（3項目） = utility

   TODO: 手順3で wp_nav_menu() に置き換える。
   ============================================================= */

$theme_uri = get_template_directory_uri();

// フッター宿ナビは2つの一覧をつなげた7項目
$footer_nav = array_merge(rakuen_nav_items('global'), rakuen_nav_items('content'));
?>
    </main>

    <!-- ============================= フッター ============================= -->
    <footer class="l-footer">
        <div class="l-footer__inner">

            <!-- ロゴ（TOPへのリンクを兼ねる） -->
            <a class="l-footer__logo" href="<?php echo esc_url(home_url('/')); ?>">
                <!-- 生成りの地に載るので金版。Figma実測 PC 230.24×90 / SP 179.08×70 -->
                <img class="l-footer__logo-image" src="<?php echo esc_url($theme_uri . '/assets/images/common/logo.svg'); ?>"
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="230" height="90">
            </a>

            <!-- 宿ナビ（お部屋 / プラン / 四季 / アクセス / サービス / ブログ / お知らせ） -->
            <nav class="l-footer__nav" aria-label="サイトマップ">
                <ul class="l-footer__menu">
                    <?php foreach ($footer_nav as $item) : ?>
                        <li class="l-footer__item">
                            <a class="l-footer__link" href="<?php echo esc_url($item['href']); ?>"><?php echo esc_html($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <hr class="l-footer__divider">

            <!-- 宿の情報（NAP：Name / Address / Phone）
                 全ページのフッターに置くのが宿泊施設サイトの定石（ローカルSEO・信頼性）
                 TODO: 住所・電話番号・営業情報はすべてダミー。実データに差し替えること -->
            <div class="l-footer__info">
                <p class="l-footer__hotel-name"><?php bloginfo('name'); ?></p>
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
                    <?php foreach (rakuen_nav_items('utility') as $item) : ?>
                        <li class="l-footer__item">
                            <a class="l-footer__link" href="<?php echo esc_url($item['href']); ?>"><?php echo esc_html($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Figma の表記どおり年号なし。&copy; は © の実体参照 -->
            <p class="l-footer__copyright u-serif">&copy; RAKUGAEN.</p>

        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
