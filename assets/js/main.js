/* =============================================================
   楽園雅苑 / main.js
   構成：1.SPハンバーガーメニュー  2.お部屋のタイプ切り替えタブ

   全体を即時関数（IIFE）で包んでいるのは、中で作った変数が
   グローバルに漏れて他のスクリプトとぶつかるのを防ぐため。
   ============================================================= */
(function () {
    'use strict';

    /* =============================================================
       1. SPハンバーガーメニュー

       ボタンを押すとナビ（＝SPドロワー）が開き、
         ・見た目：.is-open を付け外しして CSS 側で開閉・×への変形
         ・支援技術：aria-expanded と aria-label を実態に合わせて更新
         ・背面：body に .is-nav-open を付けてスクロールを止める
       の3つを常にセットで切り替える。
       ============================================================= */
    function initHamburger() {
        var hamburger = document.getElementById('hamburger');
        var nav = document.getElementById('global-nav');

        // どちらか無いページでは何もしない（エラーで後続処理が止まらないように）
        if (!hamburger || !nav) return;

        // CSS のブレークポイントと同じ値。PC幅になったかの判定に使う。
        // ヘッダーが横並びに切り替わるのは 1240px から（style.css と対応）。
        // ここを 768px にしておくと、まだハンバーガーが見えている幅で
        // 「PCになった」と判断してドロワーを閉じてしまう
        var mqPc = window.matchMedia('(min-width: 1240px)');

        function isOpen() {
            return nav.classList.contains('is-open');
        }

        function openNav() {
            hamburger.classList.add('is-open');
            nav.classList.add('is-open');
            document.body.classList.add('is-nav-open');
            hamburger.setAttribute('aria-expanded', 'true');
            hamburger.setAttribute('aria-label', 'メニューを閉じる');
        }

        function closeNav() {
            hamburger.classList.remove('is-open');
            nav.classList.remove('is-open');
            document.body.classList.remove('is-nav-open');
            hamburger.setAttribute('aria-expanded', 'false');
            hamburger.setAttribute('aria-label', 'メニューを開く');
        }

        // ボタンで開閉
        hamburger.addEventListener('click', function () {
            if (isOpen()) {
                closeNav();
            } else {
                openNav();
            }
        });

        // ナビ内のリンクを押したら閉じる。
        // リンク1つずつにリスナーを付けず、親でまとめて受ける（イベント委譲）。
        // TOP内アンカー（#room など）は画面遷移が起きないので、
        // 閉じる処理を書かないとドロワーが開いたままになる
        nav.addEventListener('click', function (event) {
            if (event.target.closest('a')) {
                closeNav();
            }
        });

        // Escキーで閉じ、フォーカスを開閉ボタンに戻す
        // （閉じた後にキーボードの居場所が分からなくなるのを防ぐ）
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isOpen()) {
                closeNav();
                hamburger.focus();
            }
        });

        // PC幅になったら強制的に閉じる。
        // SPで開いたまま画面を広げると、ナビは横並びに戻るのに
        // body のスクロール停止だけが残ってしまうため。
        // resize を毎回拾うより軽い
        mqPc.addEventListener('change', function (event) {
            if (event.matches) closeNav();
        });
    }


    /* =============================================================
       2. お部屋のタイプ切り替えタブ（TOP のみ）

       WAI-ARIA の tabs パターンに合わせている：
         ・見えているタブは1つだけがフォーカスを受け取る（ローミングtabindex）
           → Tab キーでタブ列を素通りでき、中身へ早く進める
         ・左右キーで隣のタブへ、Home/End で端へ移動し、移動先を即表示する
         ・状態は aria-selected が正。CSS もそれを見て色を変えている

       JS が動かない場合は .is-ready が付かず、
       CSS 側でタブ列を隠して全パネルを縦に並べたままにする
       （情報が読めなくなるのを避けるため）。
       ============================================================= */
    function initRoomTabs() {
        var root = document.getElementById('room-tabs');
        if (!root) return;   // TOP 以外には無い

        var tabs = Array.prototype.slice.call(
            root.querySelectorAll('[role="tab"]')
        );
        if (tabs.length === 0) return;

        function panelOf(tab) {
            return document.getElementById(tab.getAttribute('aria-controls'));
        }

        // 表示を1つに絞る。moveFocus は キー操作のときだけ true にして、
        // クリック時に画面が跳ねないようにする
        function select(next, moveFocus) {
            tabs.forEach(function (tab) {
                var selected = (tab === next);
                var panel = panelOf(tab);

                tab.setAttribute('aria-selected', selected ? 'true' : 'false');
                tab.setAttribute('tabindex', selected ? '0' : '-1');
                if (panel) panel.hidden = !selected;
            });

            if (moveFocus) next.focus();
        }

        tabs.forEach(function (tab, index) {
            tab.addEventListener('click', function () {
                select(tab, false);
            });

            tab.addEventListener('keydown', function (event) {
                var last = tabs.length - 1;
                var to;

                switch (event.key) {
                    case 'ArrowLeft':  to = index === 0 ? last : index - 1; break;
                    case 'ArrowRight': to = index === last ? 0 : index + 1; break;
                    case 'Home':       to = 0; break;
                    case 'End':        to = last; break;
                    default: return;   // それ以外のキーは邪魔しない
                }

                event.preventDefault();   // 左右キーでの横スクロールを止める
                select(tabs[to], true);
            });
        });

        // ここで初めてタブとして振る舞い始める。
        // クラスを付けるのが最後なのは、付けた瞬間に CSS が
        // パネルを隠すため、隠す準備が整ってからにしたいから
        root.classList.add('is-ready');
    }


    /* =============================================================
       フォーム（ご予約の入力・確認）

       JavaScript が無くても送信・検証・二重送信の防止はサーバー側で
       完結している。ここでやるのは、その上に載せる2つの補助だけ。
         1. エラーがあったとき、その一覧へフォーカスを移す
         2. 送信中はボタンを押せなくする
       ============================================================= */
    function initForm() {

        /* ---- 1. エラー一覧へフォーカスを移す ----
           サーバー側の検証で戻ってきたとき、画面はページ先頭に表示される。
           role="alert" で読み上げはされるが、キーボード利用者は
           エラー箇所まで自分で辿る必要があるため、先頭に置いた一覧へ
           フォーカスを移して「ここから直せる」状態にする */
        var alertBox = document.getElementById('form-alert');
        if (alertBox) {
            alertBox.focus();
        }

        /* ---- 2. 送信中はボタンを押せなくする ----
           回線が遅いときにボタンを連打されるのを防ぐ。
           サーバー側でもワンタイムトークンで二重送信を弾いているので、
           これは「押しても反応が無い」という不安を減らすための補助 */
        var forms = document.querySelectorAll('.c-form');

        Array.prototype.forEach.call(forms, function (form) {
            form.addEventListener('submit', function () {
                var button = form.querySelector('.c-btn-submit');
                if (!button) {
                    return;
                }

                /* disabled をすぐ付けると、そのボタンの値が送信内容に
                   含まれなくなるブラウザがある。送信の処理が始まってから
                   付けたいので、いったん処理を譲ってから実行する */
                window.setTimeout(function () {
                    button.disabled = true;
                    button.textContent = '送信中…';
                }, 0);
            });
        });
    }


    /* =============================================================
       初期化
       defer を付けずに </body> 直前で読み込んでいるので、
       この時点で HTML は読み終わっている
       ============================================================= */
    initHamburger();
    initRoomTabs();
    initForm();
})();
