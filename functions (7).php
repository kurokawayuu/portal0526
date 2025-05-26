<?php //子テーマ用関数
if ( !defined( 'ABSPATH' ) ) exit;

//子テーマ用のビジュアルエディタースタイルを適用
add_editor_style();

//以下に子テーマ用の関数を書く
function custom_login_styles() {
    wp_enqueue_style('custom-login-style', get_stylesheet_directory_uri() . '/login.css');
}
add_action('login_enqueue_scripts', 'custom_login_styles');

//ダッシュボードアクセスを禁止
function redirect_dashboard(){
    if(!current_user_can('administrator') && !current_user_can('info') && preg_match('/wp-admin\/index\.php$/', $_SERVER['SCRIPT_NAME'])){
        wp_redirect('https://kdmpls-portal.com/');
        exit;
    }
}

add_action('admin_init', 'redirect_dashboard');



// フォーラムタイトルを「交流の場」に変更する関数
function change_forum_title() {
    $title = '交流の場';
    return $title;
}
add_filter('bbp_get_forum_archive_title', 'change_forum_title');

// d4p-attachment-addfileクラスのテキストを変更する関数
function custom_change_file_upload_text() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // d4p-attachment-addfileクラスのテキストを「他のファイルを添付」に変更
            var elements = document.querySelectorAll('.d4p-attachment-addfile');
            elements.forEach(function(element) {
                if (element.innerText === 'Add another file') {
                    element.innerText = '他のファイルを添付';
                }
            });

            // bbp-forum-infoクラスのテキストを「カテゴリ」に変更
            var forumElements = document.querySelectorAll('.bbp-forum-info');
            forumElements.forEach(function(element) {
                if (element.innerText === 'フォーラム') {
                    element.innerText = 'カテゴリ';
                }
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_change_file_upload_text');
add_action('admin_footer', 'custom_change_file_upload_text');

function custom_insert_texts() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // h1.entry-title が存在する場合にのみ実行
            var entryTitle = document.querySelector('h1.entry-title');
            if (entryTitle) {
                // h1.entry-title のテキストを使って新規トピック作成テキストを生成
                var quotedTitle = '「' + entryTitle.textContent + '」';
                var newTopicText = quotedTitle + ' に新規トピックを作成';
                
                // .bbp-topic-form の一番上にテキストを挿入
                var bbpTopicForm = document.querySelector('.bbp-topic-form');
                if (bbpTopicForm) {
                    var newTopicElement = document.createElement('div');
                    newTopicElement.textContent = newTopicText;
                    newTopicElement.classList.add('topic-post'); // クラス名を追加
                    bbpTopicForm.insertAdjacentElement('afterbegin', newTopicElement);
                }

                // h1.entry-title のテキストを使って返信テキストを生成
                var replyText = quotedTitle + ' に返信';
                
                // .bbp-reply-form の一番上にテキストを挿入
                var bbpReplyForm = document.querySelector('.bbp-reply-form');
                if (bbpReplyForm) {
                    var replyElement = document.createElement('div');
                    replyElement.textContent = replyText;
                    replyElement.classList.add('reply-post'); // クラス名を追加
                    bbpReplyForm.insertAdjacentElement('afterbegin', replyElement);
                }
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_insert_texts');
add_action('admin_footer', 'custom_insert_texts');

function add_caution_text() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // #bbpress-forums ul.bbp-forums の最初にテキストを挿入
            var bbpForumsList = document.querySelector('#bbpress-forums ul.bbp-forums');
            if (bbpForumsList) {
                var cautionText = `
                    加盟店同士でポジティブな交流をしていただくための場です。<br>
<label class="guidelines" for="pop-up-s">ガイドライン</label>に沿って、積極的な交流を行い教室運営を活性化させましょう！
<input type="checkbox" id="pop-up-s" checked>
<div class="overlay">
<div class="window-s">
<label class="close" for="pop-up-s">×</label>
<div class="text">
<h2 class="h2-guidelines">●●ガイドライン</h2>
<p>ご利用前に必ずご一読くださいますようお願いいたします。</p>
<h3 class="h3-guidelines">◆ ●●の目的</h3>
業務をする上での工夫等、役立つ有益な情報を交換をすることを通して、お子さん・保護者の皆さんに対する支援の質を向上させ、職員の皆さまの業務負担を軽減させることを目的としています。
<h3 class="h3-guidelines">◆ 投稿について</h3>
●●の上記の目的に沿った投稿をしてください。<br>
以下の内容の投稿については、予告なく削除する場合がありますのであらかじめご了承ください。<br>
<ul class="ul-guidelines">
<li>他者の権利やプライバシーを侵害したり、個人を特定したりできる内容</li>
<li>誹謗中傷など他者を尊重しない内容</li>
<li>公序良俗に反する内容、政治・宗教・販売に関する内容</li>
<li>著作権等の権利を侵害する、あるいはその行為を示唆する内容</li>
<li>指定基準違反や不正行為を誘導する、あるいはそれらを示唆する内容</li>
<li>本部に対するご意見・ご要望・疑問等（直接SVまたは本部にお寄せください。）</li>
<li>その他、事務局が総合的観点から削除が適切と判断した内容</li>
</ul>
<h3 class="h3-guidelines">◆ 運営の免責について</h3>
●●の利用者間のトラブルにおいて、事務局は一切の責任を負わないものといたします。<br>
投稿された情報を活用するかどうかについては、各教室の判断で行ってください。
<h3 class="h3-guidelines">◆ テーマを投稿する前に</h3>
新規にテーマを立てる際には、すでに同じようなテーマがないか確認してから投稿をお願いします。<br>
同じようなテーマが増えると、どちらのテーマにコメントしたらいいか迷ったり、掲示板が見づらくなることがあります。
</div>
</div>    
</div>
                `;
                
                var cautionElement = document.createElement('div');
                cautionElement.classList.add('caution'); // クラス名を追加
                cautionElement.innerHTML = cautionText;
                
                bbpForumsList.insertAdjacentElement('beforebegin', cautionElement);

                // ページロード時に自動でポップアップを表示
                document.getElementById('pop-up-s').checked = true;
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'add_caution_text');
add_action('admin_footer', 'add_caution_text');


function custom_ajax_search_results($query, $search_form = null) {
    if (!$query instanceof WP_Query) {
        error_log("ERROR: $query is not an instance of WP_Query.");
        return $query;
    }

    error_log("DEBUG: WP_Query detected. Processing results...");

    if (empty($query->posts)) {
        error_log("DEBUG: No search results found.");
        return $query;
    }

    foreach ($query->posts as $post) {
        $post_id = $post->ID;

        // ✅ 投稿タイプを取得
        $post_type = get_post_type($post_id);
        $post_type_label = $post_type ? get_post_type_object($post_type)->labels->singular_name : '';

        // ✅ ACF のカスタムフィールド 'tag' からタグを取得
        $custom_tags = get_field('tag', $post_id);
        $custom_tag_list = '';

        if (!empty($custom_tags) && is_array($custom_tags)) {
            foreach ($custom_tags as $tag) {
                if (!empty($tag->name)) {
                    $custom_tag_list .= '<span class="tag">' . esc_html($tag->name) . '</span>';
                }
            }
        }

        // ✅ メタ情報を作成
        $meta_info = '<div class="search-bx">';
        $meta_info .= '<div class="type">' . esc_html($post_type_label) . '</div>';
        $meta_info .= '<div class="tag-bx">' . $custom_tag_list . '</div>';
        $meta_info .= '</div>';

        // ✅ 本文を取得し、フィルターを適用（カスタム投稿に対応）
        $post_content = get_post_field('post_content', $post_id);
        $formatted_content = apply_filters('the_content', $post_content);
        $excerpt_content = wp_trim_words(strip_tags($formatted_content), 30, '...');

        // ✅ メタ情報と本文を統合
        $post->meta = $meta_info;
        $post->post_excerpt = $meta_info . '<div class="excerpt">' . esc_html($excerpt_content) . '</div>';
        $post->post_content = $meta_info . '<div class="content">' . esc_html($excerpt_content) . '</div>';

        // ✅ `post_title` にタイトルを維持しつつ、本文の抜粋も加える
        $post->post_title = esc_html(get_the_title($post_id)) . ' - ' . esc_html($excerpt_content);

        error_log("DEBUG: Updated Post ID: $post_id | Type: $post_type_label | Tags: " . strip_tags($custom_tag_list));
    }

    return $query;
}

// ✅ フィルターを適用
add_filter('is_ajax_search_results', 'custom_ajax_search_results', 10, 2);


// 🔹 検索履歴を保存する関数（検索語句と日時のみ記録）
function log_ivory_search_query() {
    if (isset($_POST['s']) && !empty($_POST['s'])) {
        global $wpdb;
        $search_term = sanitize_text_field($_POST['s']);

        // デバッグログ出力
        error_log("🔍 受信データ: search_term={$search_term}");

        // データベースに検索履歴を保存（検索語句と日時のみ）
        $wpdb->insert(
            $wpdb->prefix . 'ivory_search_log',
            array(
                'search_time' => current_time('mysql'),
                'search_term' => $search_term
            ),
            array('%s', '%s')
        );

        // ✅ デバッグログに保存成功を記録
        if ($wpdb->last_error) {
            error_log("❌ データベース保存失敗: " . $wpdb->last_error);
            echo "❌ データベース保存失敗";
        } else {
            error_log("✅ データベースへの保存成功: " . $search_term);
            echo "✅ 検索履歴保存成功";
        }
    } else {
        echo "❌ 検索語句が送信されていません。";
    }
    wp_die();
}
add_action('wp_ajax_nopriv_ivory_search_log', 'log_ivory_search_query');
add_action('wp_ajax_ivory_search_log', 'log_ivory_search_query');

// 🔹 検索履歴の削除処理
function delete_ivory_search_log() {
    if (isset($_POST['log_id']) && !empty($_POST['log_id'])) {
        global $wpdb;
        $log_id = intval($_POST['log_id']);

        // 指定されたIDの検索履歴を削除
        $deleted = $wpdb->delete($wpdb->prefix . 'ivory_search_log', array('id' => $log_id), array('%d'));

        if ($deleted) {
            echo "✅ 検索履歴を削除しました";
        } else {
            echo "❌ 削除に失敗しました";
        }
    } else {
        echo "❌ 削除するIDが指定されていません";
    }
    wp_die();
}
add_action('wp_ajax_delete_ivory_search_log', 'delete_ivory_search_log');

// 🔹 管理画面に「検索履歴」メニューを追加
function add_ivory_search_log_menu() {
    add_menu_page(
        'Ivory Search履歴',
        '検索履歴',
        'manage_options',
        'ivory-search-log',
        'display_ivory_search_log',
        'dashicons-search',
        25
    );
}
add_action('admin_menu', 'add_ivory_search_log_menu');

// 🔹 検索履歴の一覧を表示（削除ボタン付き + ページネーション対応）
function display_ivory_search_log() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ivory_search_log';

    // ✅ 1ページあたり100件表示
    $per_page = 100;
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $per_page;

    // 総件数を取得
    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $total_pages = ceil($total_items / $per_page);

    // ページネーション付きでデータ取得
    $results = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name ORDER BY search_time DESC LIMIT %d OFFSET %d", $per_page, $offset)
    );

    echo '<div class="wrap"><h2>Ivory Search 履歴</h2>';
    echo '<table class="widefat"><thead><tr>';
    echo '<th>日時</th><th>検索語句</th><th>削除</th></tr></thead><tbody>';

    if ($results) {
        foreach ($results as $row) {
            echo "<tr id='log-{$row->id}'>
                    <td>{$row->search_time}</td>
                    <td>{$row->search_term}</td>
                    <td><button class='delete-log' data-id='{$row->id}'>削除</button></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>検索履歴がありません</td></tr>";
    }

    echo '</tbody></table>';

    // ✅ ページネーションボタンを表示
    echo '<div class="tablenav">';
    if ($total_pages > 1) {
        echo '<div class="tablenav-pages">';
        if ($current_page > 1) {
            echo '<a href="?page=ivory-search-log&paged=' . ($current_page - 1) . '" class="button">◀️ 前へ</a> ';
        }
        echo "ページ {$current_page} / {$total_pages} ";
        if ($current_page < $total_pages) {
            echo '<a href="?page=ivory-search-log&paged=' . ($current_page + 1) . '" class="button">次へ ▶️</a>';
        }
        echo '</div>';
    }
    echo '</div>';

    echo '</div>';

    // 削除処理用のJavaScript
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-log").forEach(button => {
            button.addEventListener("click", function() {
                let logId = this.getAttribute("data-id");
                if (confirm("本当に削除しますか？")) {
                    fetch(ajaxurl, {
                        method: "POST",
                        body: new URLSearchParams({
                            action: "delete_ivory_search_log",
                            log_id: logId
                        }),
                        headers: { "Content-Type": "application/x-www-form-urlencoded" }
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        if (data.includes("✅")) {
                            document.getElementById("log-" + logId).remove();
                        }
                    })
                    .catch(error => alert("❌ エラー: " + error));
                }
            });
        });
    });
    </script>';
}




function enqueue_custom_js() {
    wp_enqueue_script('custom-search-log', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
    
    // JavaScript に WordPress の Ajax URL を渡す
    wp_localize_script('custom-search-log', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_js');




// メニューを追加
function add_order_log_menu() {
    add_menu_page(
        '注文履歴', // ページタイトル
        '注文履歴', // メニュータイトル
        'manage_options',
        'order_log',
        'display_order_log',
        'dashicons-list-view',
        26
    );
}
add_action('admin_menu', 'add_order_log_menu');

// テーブルのスタイルを追加
function add_custom_table_styles() {
    echo '<style>
        .custom-table-wrapper {
            overflow-x: auto;
            margin-bottom: 20px;
        }
        .wp-list-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .wp-list-table th, .wp-list-table td {
            word-wrap: break-word;
            white-space: normal;
            overflow: hidden;
        }
        .wp-list-table th {
            text-align: left;
        }
        .delete-button {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
    </style>';
}
add_action('admin_head', 'add_custom_table_styles');

function display_order_log() {
    global $wpdb;

    $items_per_page = 50;
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $items_per_page;

    // 表示するデータの開始日を設定（DATETIME形式に変更）
    $start_date = '2024-12-24 00:00:00'; // 正確な日時形式

    // フィルタ対象の商品リスト
    $allowed_products = [
        '封筒小', '封筒大', '教室紹介パンフ', '柳沢運動パンフ', '連絡帳', '冊子', 'のぼり1', 'のぼり2'
    ];

    // データを取得
    $query = $wpdb->prepare(
        "SELECT ID, post_date, post_content FROM {$wpdb->prefix}posts 
         WHERE post_type = 'flamingo_inbound' 
         AND post_date >= %s
         ORDER BY post_date DESC",
        $start_date
    );

    $results = $wpdb->get_results($query);

    // フィルタリング処理
    $filtered_results = array_filter($results, function ($row) use ($allowed_products) {
        // フォームURLが含まれている場合は除外
        if (stripos($row->post_content, 'https://kdmpls-portal.com/report/') !== false) {
            return false;
        }
        
        // 許可された商品リストに含まれているかチェック
        foreach ($allowed_products as $product) {
            if (stripos($row->post_content, $product) !== false) {
                return true;
            }
        }
        return false;
    });

    $total_items = count($filtered_results);
    $total_pages = ceil($total_items / $items_per_page);
    $filtered_results = array_slice($filtered_results, $offset, $items_per_page);

    echo '<div class="wrap"><h1>注文履歴</h1>';
    echo '<div class="custom-table-wrapper">';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr>';
    echo '<th>注文日</th>';
    echo '<th>納品先教室名</th>';
    echo '<th>法人名</th>';
    echo '<th>商品</th>';
    echo '<th>数量</th>';
    echo '<th>操作</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    foreach ($filtered_results as $row) {
        $content_lines = explode("\n", $row->post_content);
        $order_date = date("Y-m-d", strtotime($row->post_date));
        $delivery_class = isset($content_lines[1]) ? esc_html($content_lines[1]) : 'N/A';
        $corporation = isset($content_lines[2]) ? esc_html($content_lines[2]) : 'N/A';
        $product = isset($content_lines[3]) ? esc_html($content_lines[3]) : 'N/A';
        $quantity = isset($content_lines[4]) ? esc_html($content_lines[4]) : 'N/A';

        echo '<tr>';
        echo '<td>' . $order_date . '</td>';
        echo '<td>' . $delivery_class . '</td>';
        echo '<td>' . $corporation . '</td>';
        echo '<td>' . $product . '</td>';
        echo '<td>' . $quantity . '</td>';
        echo '<td><a href="' . esc_url(admin_url("admin.php?page=order_log&delete_id={$row->ID}")) . '" class="delete-button" onclick="return confirm(\'本当に削除しますか？\');">削除</a></td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';

    // ページネーション
    echo '<div style="text-align: center; margin-top: 20px;">';
    for ($i = 1; $i <= $total_pages; $i++) {
        $class = ($i == $current_page) ? 'button button-primary' : 'button';
        echo '<a href="' . esc_url(admin_url("admin.php?page=order_log&paged=$i")) . '" class="' . $class . '">' . $i . '</a> ';
    }
    echo '</div></div>';
}







function get_flamingo_submissions() {
    if (is_user_logged_in()) {
        $current_user_id = get_current_user_id();
        $current_user = wp_get_current_user();
        $nickname = $current_user->nickname;

        $args = array(
            'post_type'      => 'flamingo_inbound',
            'posts_per_page' => -1,
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'   => '_user_id',
                    'value' => $current_user_id,
                ),
                array(
                    'key'   => '_subject',
                    'value' => '月次報告',
                    'compare' => 'LIKE'
                ),
            ),
            'orderby' => 'date',
            'order'   => 'ASC' // 昇順に変更して最初のデータを取得
        );

        $query = new WP_Query($args);

        $months = array("４月", "５月", "６月", "７月", "８月", "９月", "１０月", "１１月", "１２月", "１月", "２月", "３月");

        $data_by_month = array_fill_keys($months, array(
            '見学数' => '',
            '成約件数' => '',
            '平日' => '',
            '休日' => '',
            '入所' => '',
            '退所' => '',
            '利用予定数' => '',
            '実際の利用数' => '',
            '欠席率' => '',
            '開所日数' => '',
            '前月契約人数' => '',
            '契約人数' => '',
            '平均利用数(人)' => '',
            '定員数' => '',
            '充足率(%)' => ''
        ));

        $contract_numbers_by_month = array(); // 各月の契約人数を記録
        $initial_contract_number = 0; // 初期化
        $initial_capacity = 0; // 定員数の初期化
        $initial_contract_saved = false; // 初回の保存フラグ

        // テーブルを表示
        echo '<div class="table-container">';

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $meta = get_post_meta(get_the_ID());

                $target_month = maybe_unserialize($meta['_field_menu-456'][0]);
                $target_month_display = is_array($target_month) ? $target_month[0] : $target_month;

                if (array_key_exists($target_month_display, $data_by_month) && empty($data_by_month[$target_month_display]['見学数'])) {
                    $planned_use = floatval(esc_html($meta['_field_text-7'][0]));
                    $actual_use = floatval(esc_html($meta['_field_text-8'][0]));

                    $absent_rate = $planned_use - $actual_use;
                    $absent_rate_percentage = $planned_use > 0 ? round(($absent_rate / $planned_use) * 100, 1) : 0;

                    $weekday = floatval(esc_html($meta['_field_text-3'][0]));
                    $holiday = floatval(esc_html($meta['_field_text-4'][0]));
                    $opening_days = $weekday + $holiday;

                    $入所 = floatval(esc_html($meta['_field_text-5'][0]));
                    $退所 = floatval(esc_html($meta['_field_text-6'][0]));
                    $capacity = floatval(esc_html($meta['_field_text-10'][0]));

                    if (!$initial_contract_saved) {
                        $initial_contract_number = floatval(esc_html($meta['_field_text-9'][0]));
                        $initial_contract_saved = true;
                    }

                    $previous_month_contracts = isset($contract_numbers_by_month[$previous_month]) ? $contract_numbers_by_month[$previous_month] : $initial_contract_number;
                    $current_contracts = $previous_month_contracts + $入所 - $退所;

                    $average_use = ($weekday + $holiday > 0) ? round($actual_use / ($weekday + $holiday), 1) : '';
                    $occupancy_rate = ($capacity > 0 && $average_use !== '') ? round(($average_use / $capacity) * 100, 1) : '';

                    $data_by_month[$target_month_display] = array(
                        '見学数' => esc_html($meta['_field_text-1'][0]),
                        '成約件数' => esc_html($meta['_field_text-2'][0]),
                        '平日' => $weekday,
                        '休日' => $holiday,
                        '入所' => $入所,
                        '退所' => $退所,
                        '利用予定数' => $planned_use,
                        '実際の利用数' => $actual_use,
                        '欠席率' => $absent_rate_percentage,
                        '開所日数' => $opening_days,
                        '前月契約人数' => $previous_month_contracts,
                        '契約人数' => $current_contracts,
                        '平均利用数(人)' => $average_use,
                        '定員数' => $capacity,
                        '充足率(%)' => $occupancy_rate
                    );

                    $contract_numbers_by_month[$target_month_display] = $current_contracts;
                    $previous_month = $target_month_display;
                }
            }
        } else {
            // 送信履歴がない場合のメッセージを表示
            echo '<div class="no-data-message">送信履歴がありません。</div>';
        }
$previous_planned_use = '――'; // 4月は前月がないので "――" をセット

foreach ($months as $index => $month) {
    $current_planned_use = $data_by_month[$month]['利用予定数'];

    // 1つ前の月の「利用予定数」を次の月に反映
    if ($index > 0) {
        $data_by_month[$months[$index]]['利用予定数'] = $previous_planned_use;
    } else {
        // 4月は前月がないので "――" にする
        $data_by_month[$months[$index]]['利用予定数'] = '――';
    }

    $previous_planned_use = $current_planned_use; // 次の月に渡すために更新
}


        echo '<table class="flamingo-report">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>項目</th>';
        foreach ($months as $month) {
            echo '<th>' . esc_html($month) . '</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $query_data = array(
            '問合せ' => array(
                '見学数' => '見学数',
                '成約件数' => '成約件数'
            ),
            '実績・予定' => array(
                '定員数' => '定員数',
                '開所日数' => '開所日数',
                '平日' => '平日',
                '休日' => '休日',
                '契約人数' => '契約人数',
                '前月契約人数' => '前月契約人数',
                '入所' => '入所',
                '退所' => '退所',
                '利用予定数' => '利用予定数',
                '実際の利用数' => '実際の利用数'
            ),
            '月間' => array(
                '欠席率' => '欠席率 (%)',
                '平均利用数(人)' => '平均利用数(人)',
                '充足率(%)' => '充足率 (%)'
            )
        );

        foreach ($query_data as $section => $fields) {
            echo '<tr class="section-header">';
            echo '<td colspan="' . (count($months) + 1) . '">' . esc_html($section) . '</td>';
            echo '</tr>';
            foreach ($fields as $field_key => $field_label) {
                echo '<tr>';
                echo '<td>' . esc_html($field_label) . '</td>';
                foreach ($months as $month) {
                    echo '<td>' . esc_html($data_by_month[$month][$field_key]) . '</td>';
                }
                echo '</tr>';
            }
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // .table-container

        wp_reset_postdata();
    } else {
        echo 'この情報を表示するにはログインが必要です。';
    }
}






// ショートコードを作成して、Flamingoの送信データを表示する
function flamingo_submission_shortcode() {
    ob_start();
    get_flamingo_submissions();
    return ob_get_clean();
}
add_shortcode('flamingo_submissions', 'flamingo_submission_shortcode');





// 既存のFlamingo投稿にユーザーIDを追加する関数
function add_user_id_to_existing_flamingo_posts() {
    $args = array(
        'post_type'      => 'flamingo_inbound',
        'posts_per_page' => -1, // すべての投稿を取得
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $user_id = get_post_meta(get_the_ID(), '_user_id', true);

            // ユーザーIDが設定されていない場合は設定
            if (!$user_id && is_user_logged_in()) {
                $user_id = get_current_user_id();
                update_post_meta(get_the_ID(), '_user_id', $user_id);
            }
        }
    }
    wp_reset_postdata();
}

// この関数を手動で呼び出して既存の投稿にユーザーIDを追加します
add_action('init', 'add_user_id_to_existing_flamingo_posts');

// フッターにユーザーのニックネームを設定する関数
function set_user_nickname_in_contact_form() {
    // ユーザーのニックネームを取得
    $user = wp_get_current_user();
    if ($user) {
        $nickname = esc_attr($user->nickname);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var nameField = document.querySelector('input[name=\"your-name\"]');
                if (nameField) {
                    nameField.value = '{$nickname}';
                }
            });
        </script>";
    }
}
add_action('wp_footer', 'set_user_nickname_in_contact_form');

// Contact Form 7 のフィールドに readonly 属性を追加するフィルターフック
function wpcf7_form_elements($content) {
    // フォームフィールドに readonly 属性を追加
    $content = str_replace(
        '<input type="text" name="your-name"',
        '<input type="text" name="your-name" readonly',
        $content
    );
    return $content;
}
add_filter('wpcf7_form_elements', 'wpcf7_form_elements');


// ユーザーがログインしているか確認
if (is_user_logged_in()) {
    // 現在のユーザーオブジェクトを取得
    $current_user = wp_get_current_user();
    
    // ユーザーのニックネームを取得
    $nickname = $current_user->nickname;
} else {
    // ユーザーがログインしていない場合の処理
    $nickname = 'ゲスト';
}






// フォームタグを動的に変更するフック
add_filter('wpcf7_form_tag', 'populate_form_tags', 10, 2);
function populate_form_tags($tag, $instance) {
    $user_id = get_current_user_id();
    $previous_data = get_previous_flamingo_data($user_id); // データ取得関数を利用

    if ($previous_data) {
        // フォームフィールドごとにデータをセット
        switch ($tag['name']) {
            case 'full_time_experienced_5plus':
                $tag['values'] = array( isset($previous_data['_field_full_time_experienced_5plus'][0]) ? $previous_data['_field_full_time_experienced_5plus'][0] : '0' );
                break;
            case 'full_time_experienced_under_5':
                $tag['values'] = array( isset($previous_data['_field_full_time_experienced_under_5'][0]) ? $previous_data['_field_full_time_experienced_under_5'][0] : '0' );
                break;
            case 'full_time_conversion_5plus':
                $tag['values'] = array( isset($previous_data['_field_full_time_conversion_5plus'][0]) ? $previous_data['_field_full_time_conversion_5plus'][0] : '0' );
                break;
            case 'full_time_conversion_under_5':
                $tag['values'] = array( isset($previous_data['_field_full_time_conversion_under_5'][0]) ? $previous_data['_field_full_time_conversion_under_5'][0] : '0' );
                break;
            case 'physical_therapist':
                $tag['values'] = array( isset($previous_data['_field_physical_therapist'][0]) ? $previous_data['_field_physical_therapist'][0] : '0' );
                break;
            case 'behavior_training':
                $tag['values'] = array( isset($previous_data['_field_behavior_training'][0]) ? $previous_data['_field_behavior_training'][0] : '0' );
                break;
            case 'text-9':
                // 前月契約人数の計算 (前月契約人数 + 入所 - 退所)
                $previous_contracts = isset($previous_data['_field_text-9'][0]) ? floatval($previous_data['_field_text-9'][0]) : 0;
                $admission = isset($previous_data['_field_text-5'][0]) ? floatval($previous_data['_field_text-5'][0]) : 0;
                $discharge = isset($previous_data['_field_text-6'][0]) ? floatval($previous_data['_field_text-6'][0]) : 0;
                $current_contracts = $previous_contracts + $admission - $discharge;
                
                $tag['values'] = array($current_contracts);
                break;
            case 'text-10':
                $tag['values'] = array( isset($previous_data['_field_text-10'][0]) ? $previous_data['_field_text-10'][0] : '' );
                break;
        }
    }

    return $tag;
}

// ユーザーのFlamingoデータ取得
function get_previous_flamingo_data($user_id) {
    $args = array(
        'post_type' => 'flamingo_inbound',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_user_id',
                'value' => $user_id,
                'compare' => '='
            ),
            array(
                'key' => '_subject',
                'value' => '月次報告',
                'compare' => 'LIKE'
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 1 // 最新の1件を取得
    );
    $flamingo_data = get_posts($args);
    
    if (!empty($flamingo_data)) {
        $post_id = $flamingo_data[0]->ID;
        return get_post_meta($post_id); // メタデータを取得
    }

    return false; // データがない場合
}

add_action('init', function() {
    load_plugin_textdomain('gotmls');
    load_plugin_textdomain('ewww-image-optimizer');
    load_plugin_textdomain('wp-statistics');
    load_plugin_textdomain('all-in-one-wp-migration');
});


// FC研修提出フォーム用
function filter_wpcf7_form_tag( $scanned_tag, $replace ) {
    if ( empty( $scanned_tag ) ) {
        return $scanned_tag;
    }

    global $post;

    if ( $scanned_tag['name'] === 'training01' ) {
        // CFSのループフィールドを取得
        $training_loop = CFS()->get('trainingloop', $post->ID);

        // 初期選択肢として「選択してください」を追加
        $scanned_tag['values'][] = '';
        $scanned_tag['labels'][] = '選択してください';

        if ( !empty( $training_loop ) ) {
            foreach ( $training_loop as $training ) {
                if ( isset( $training['training01'] ) && isset( $training['lecturer01'] ) && isset( $training['attending lecture01'] ) ) {
                    
                    // 各フィールドの値を取得
                    $training_value = esc_html( $training['training01'] );
                    $lecturer_value = esc_html( $training['lecturer01'] );
                    $lecture_value = esc_html( $training['attending lecture01'] );

                    // ドロップダウンメニューの選択肢を作成
                    $scanned_tag['values'][] = $training_value;
                    $scanned_tag['labels'][] = $training_value;

                    // JavaScript用のデータ（training01 → lecturer01 & attending lecture01 の対応）
                    $training_data[] = [
                        'training01' => $training_value,
                        'lecturer01' => $lecturer_value,
                        'attending_lecture01' => $lecture_value,
                    ];
                }
            }
        }

        // JavaScriptに trainingData を渡す
        if ( !empty( $training_data ) ) {
            wp_localize_script( 'cf7-custom-script', 'trainingData', ['data' => $training_data] );
        }
    }

    return $scanned_tag;
}
add_filter( 'wpcf7_form_tag', 'filter_wpcf7_form_tag', 11, 2 );

// フォームにスクリプトを追加
function enqueue_cf7_custom_script() {
    wp_enqueue_script( 'cf7-custom-script', get_template_directory_uri() . '/js/cf7-custom.js', ['jquery'], null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_cf7_custom_script' );


//セレクトメニュー用
remove_action( 'wpcf7_swv_create_schema', 'wpcf7_swv_add_select_enum_rules', 20, 2 );










/**
 * Flamingo の送信データをユーザーごとに取得し、テーブルとして出力するサンプル
 * - 各月のデータはグループ化し、左側に「４～９月」、右側に「１０～３月」を表示
 * - 送信データが新たに追加されるたびに行が増え、同じ月の複数データは月セルを rowspan で結合
 * - 全体で有効な研修名データがなければ、テーブル中央に大きな赤文字で「送信履歴がありません。」を表示
 * - テーブルの「月」と「受講」列の幅は 80px に設定
 */
function get_flamingo_training_submissions() {
    if ( ! is_user_logged_in() ) {
        echo 'この情報を表示するにはログインが必要です。';
        return;
    }
    
    $current_user_id = get_current_user_id();
    $args = array(
        'post_type'      => 'flamingo_inbound',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'   => '_user_id',
                'value' => $current_user_id,
            ),
        ),
        'orderby' => 'date',
        'order'   => 'ASC',
    );
    $query = new WP_Query( $args );
    
    // 送信データを格納する配列
    $training_data = array();
    
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $meta = get_post_meta( get_the_ID() );
            
            // 研修受講日付フィールド（[date* date-583]）の値を取得
            $date_display = '';
            $sort_date = '0000-00-00'; // デフォルト値
            
            if ( isset( $meta['_field_date-583'][0] ) && !empty( $meta['_field_date-583'][0] ) ) {
                $date_value = $meta['_field_date-583'][0];
                $timestamp  = strtotime( $date_value );
                
                if ( $timestamp !== false ) {
                    $date_display = date( 'Y/m/d', $timestamp ); // YYYY/MM/DD形式
                    $sort_date = date( 'Y-m-d', $timestamp ); // ソート用
                }
            }
            
            // 日付が空または無効な場合は、このエントリーをスキップする
            if ( empty( $date_display ) ) {
                continue; // 次のループへ移動
            }
            
            // 研修名フィールド（[select training01]）の値を取得（シリアライズの場合はアンシリアライズ）
            $training_name = isset( $meta['_field_training01'][0] ) ? maybe_unserialize( $meta['_field_training01'][0] ) : '';
            if ( is_array( $training_name ) ) {
                $training_name = $training_name[0];
            }
            
            // 受講者氏名フィールドから氏名を取得 (text-462)
            $attendee_name = '';
            
            // 具体的なフィールドIDを使用して受講者氏名を取得
            if ( isset( $meta['_field_text-462'][0] ) && !empty( $meta['_field_text-462'][0] ) ) {
                $attendee_name = $meta['_field_text-462'][0];
            }
            
            // バックアップ: フィールドIDが変更された場合に備えて他のパターンも確認
            if ( empty( $attendee_name ) ) {
                // 受講者氏名を含む可能性のあるフィールド名
                $name_field_patterns = array(
                    '_field_your-name',
                    '_field_attendee', 
                    '_field_name',
                    '_field_fullname',
                    '_field_氏名',
                    '_field_受講者',
                    '_field_受講者氏名'
                );
                
                // メタデータから氏名フィールドを探す
                foreach ( $meta as $field_key => $field_value ) {
                    // 既知のパターンに一致するか確認
                    if ( in_array( $field_key, $name_field_patterns ) && !empty( $field_value[0] ) ) {
                        $attendee_name = $field_value[0];
                        break;
                    }
                    
                    // text-で始まるフィールドやキーに「name」「氏名」「受講者」などを含むフィールドを確認
                    if ( (strpos( $field_key, '_field_text-' ) === 0 || 
                          strpos( $field_key, 'name' ) !== false || 
                          strpos( $field_key, '氏名' ) !== false || 
                          strpos( $field_key, '受講者' ) !== false) && 
                          !empty( $field_value[0] ) ) {
                        $attendee_name = $field_value[0];
                        break;
                    }
                }
            }
            
            // データ配列に追加
            $training_data[] = array(
                'date'          => $date_display,
                'sort_date'     => $sort_date,
                'training_name' => $training_name,
                'attendee'      => $attendee_name,
            );
        }
        wp_reset_postdata();
    }
    
    // 日付でソート
    usort( $training_data, function( $a, $b ) {
        return strcmp( $a['sort_date'], $b['sort_date'] );
    });
    
    // データがあるかチェック
    $has_data = !empty( $training_data );
    
    // テーブル出力
    echo '<div class="training-records-container">';
    echo '<table class="compact" style="width:100%;">';
    echo '<thead>';
    echo '<tr>';
    echo '<th style="width:80px; text-align:left;">受講日</th>';
    echo '<th style="text-align:left;">研修名</th>';
    echo '<th style="width:100px; text-align:left;">受講者氏名</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    if ( $has_data ) {
        foreach ( $training_data as $entry ) {
            echo '<tr>';
            echo '<td style="width:80px; text-align:left;">' . esc_html( $entry['date'] ) . '</td>';
            echo '<td style="text-align:left;">' . esc_html( $entry['training_name'] ) . '</td>';
            echo '<td style="width:100px; text-align:left;">' . esc_html( $entry['attendee'] ) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="3" style="text-align:center; font-size:1.5em; color:red;">送信履歴がありません。</td></tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
/**
 * ショートコード [flamingo_training_submissions] を作成
 */
function flamingo_training_submissions_shortcode() {
    ob_start();
    get_flamingo_training_submissions();
    return ob_get_clean();
}
add_shortcode( 'flamingo_training_submissions', 'flamingo_training_submissions_shortcode' );




add_action('wpcf7_mail_sent', function ($contact_form) {
    if ($contact_form->id() == 3475) {  // ← フォームIDを修正
        session_start();
        $year = date('Y');
        $month = date('m');
        $pdf_filename = "document-pdf.pdf"; // PDFのファイル名
        $_SESSION['cf7_pdf_download'] = home_url("/wp-content/uploads/$year/$month/$pdf_filename");  // PDFの保存パス
    }
});







function add_fc_training_menu() {
    // メインメニュー追加
    add_menu_page(
        'FC研修受講記録 教室別一覧', // ページタイトル
        'FC研修受講記録',           // メニュータイトル
        'read',                     // 権限(閲覧のみ)
        'fc-training-classrooms',   // スラッグ
        'handle_fc_training_display',// コールバック関数
        'dashicons-welcome-learn-more',// アイコン
        25                          // メニュー位置
    );

    // サブメニュー追加（FC研修登録）
    add_submenu_page(
        'fc-training-classrooms', // 親メニューのスラッグ
        'FC研修登録',             // サブメニューのページタイトル
        'FC研修登録',             // サブメニューのメニュータイトル
        'read',                   // 権限(閲覧のみ)
        'fc-training-registration', // スラッグ（ユニークにする）
        'redirect_to_fc_training' // コールバック関数
    );
}
add_action('admin_menu', 'add_fc_training_menu');

// サブメニューのページをリダイレクト
function redirect_to_fc_training() {
    wp_redirect('https://kdmpls-portal.com/wp-admin/post.php?post=3529&action=edit');
    exit;
}
/**
 * 教室の「受講状況テーブル」を表示する関数
 * - 左テーブル: ４～９月
 * - 右テーブル: １０～３月
 * - 研修名が Array の場合に対応(implode)
 */
function display_fc_training_classroom_table($classroom) {
    if (!current_user_can('read')) {
        wp_die(__('このページにアクセスする権限がありません。'));
    }

    // 対象となる月の順序リスト
    $ordered_months = array("４月", "５月", "６月", "７月", "８月", "９月", "１０月", "１１月", "１２月", "１月", "２月", "３月");
    // 左テーブル: 4～9月
    $left_months  = array_slice($ordered_months, 0, 6);
    // 右テーブル: 10～3月
    $right_months = array_slice($ordered_months, 6);

    // WP_Query で該当投稿をすべて取得
    $meta_query = array(
        'relation' => 'AND',
        array(
            'key'     => '_subject',
            'value'   => 'FC研修受講記録提出',
            'compare' => 'LIKE',
        ),
        array(
            'key'     => '_field_your-name',
            'value'   => $classroom,
            'compare' => '=',
        ),
    );
    $args = array(
        'post_type'      => 'flamingo_inbound',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'ASC',
        'meta_query'     => $meta_query,
    );
    $query = new WP_Query($args);

    // 月ごとにデータをまとめる配列
    // 予め全月分を初期化
    $data_grouped = array();
    foreach ($ordered_months as $m) {
        $data_grouped[$m] = array();
    }

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // 研修名 (Array→文字列 変換)
            $training_name = get_post_meta($post_id, '_field_training01', true);
            if (is_array($training_name)) {
                $training_name = implode(', ', $training_name);
            }
            if ($training_name === '') {
                $training_name = 'N/A';
            }

            // 受講者
            $participant = get_post_meta($post_id, '_field_text-462', true);
            if ($participant === '') {
                $participant = 'N/A';
            }

            // 受講日から月を判定
            $date_str = get_post_meta($post_id, '_field_date-583', true);
            // デフォルトは現在の月に対応する "○月" (例: date('n')=4→"４月")
            $current_month_num = date('n'); // 1～12
            // 「1～3」は "１月～３月"、「4～9」は "４月～９月"、「10～12」は "１０月～１２月"
            // 適宜変換関数を用意（下記switch等）
            $month_jp = convertMonthToZenkaku($current_month_num); 

            if (!empty($date_str)) {
                // 例: "2025-01-10" / "2025/01/10" / "2025年01月10日" などにマッチ
                if (preg_match('/(\d{4})[-\/年](\d{1,2})[-\/月]/', $date_str, $mch)) {
                    $month_num = intval($mch[2]);
                    $month_jp = convertMonthToZenkaku($month_num);
                }
            }

            // 格納
            $data_grouped[$month_jp][] = array(
                'training_name' => $training_name,
                'participant'   => $participant,
                // 受講の有無を "〇" として表示
                'attended'      => '〇'
            );
        }
        wp_reset_postdata();
    }

    // 画面出力
    echo '<h2>受講状況（年度カレンダー）</h2>';

    // 横に2つのテーブルを並べる
    echo '<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">';

    // 左テーブル (4～9月)
    echo '<table class="widefat fixed striped" style="width: 48%; min-width: 300px;">';
    echo '<thead><tr><th style="width:80px;">月</th><th>研修名</th><th>受講者</th><th style="width:50px;">受講</th></tr></thead><tbody>';

    foreach ($left_months as $month) {
        if (!empty($data_grouped[$month])) {
            $rows = $data_grouped[$month];
            $rowspan = count($rows);
            for ($i=0; $i<$rowspan; $i++) {
                echo '<tr>';
                if ($i === 0) {
                    // 月セルはrowspanでまとめる
                    echo '<td rowspan="' . esc_attr($rowspan) . '">' . esc_html($month) . '</td>';
                }
                echo '<td>' . esc_html($rows[$i]['training_name']) . '</td>';
                echo '<td>' . esc_html($rows[$i]['participant']) . '</td>';
                echo '<td style="text-align:center;">' . esc_html($rows[$i]['attended']) . '</td>';
                echo '</tr>';
            }
        } else {
            // 該当データなし
            echo '<tr>';
            echo '<td>' . esc_html($month) . '</td>';
            echo '<td></td><td></td><td></td>';
            echo '</tr>';
        }
    }
    echo '</tbody></table>';

    // 右テーブル (10～3月)
    echo '<table class="widefat fixed striped" style="width: 48%; min-width: 300px;">';
    echo '<thead><tr><th style="width:80px;">月</th><th>研修名</th><th>受講者</th><th style="width:50px;">受講</th></tr></thead><tbody>';

    foreach ($right_months as $month) {
        if (!empty($data_grouped[$month])) {
            $rows = $data_grouped[$month];
            $rowspan = count($rows);
            for ($i=0; $i<$rowspan; $i++) {
                echo '<tr>';
                if ($i === 0) {
                    echo '<td rowspan="' . esc_attr($rowspan) . '">' . esc_html($month) . '</td>';
                }
                echo '<td>' . esc_html($rows[$i]['training_name']) . '</td>';
                echo '<td>' . esc_html($rows[$i]['participant']) . '</td>';
                echo '<td style="text-align:center;">' . esc_html($rows[$i]['attended']) . '</td>';
                echo '</tr>';
            }
        } else {
            // 該当データなし
            echo '<tr>';
            echo '<td>' . esc_html($month) . '</td>';
            echo '<td></td><td></td><td></td>';
            echo '</tr>';
        }
    }

    echo '</tbody></table>';
    echo '</div>'; // 2テーブルを並べるコンテナ
}

/**
 * 月番号(1～12) → 全角表記 ("１月"～"１２月") に変換する簡易関数
 */
function convertMonthToZenkaku($month_num) {
    switch($month_num) {
        case 1: return '１月';
        case 2: return '２月';
        case 3: return '３月';
        case 4: return '４月';
        case 5: return '５月';
        case 6: return '６月';
        case 7: return '７月';
        case 8: return '８月';
        case 9: return '９月';
        case 10:return '１０月';
        case 11:return '１１月';
        case 12:return '１２月';
    }
    return 'N/A';
}

/**
 * 2) 表示を振り分ける関数
 */
function handle_fc_training_display() {
    if (!current_user_can('read')) {
        wp_die(__('このページにアクセスする権限がありません。'));
    }
    
    // ?action=list & classroom=xxx → 教室別一覧
    if (isset($_GET['action']) && $_GET['action'] === 'list' && isset($_GET['classroom'])) {
        if (isset($_GET['record_id'])) {
            // 詳細ページ
            $record_id = intval($_GET['record_id']);
            display_fc_training_detail($record_id);
        } else {
            // 教室別の一覧
            $classroom = sanitize_text_field($_GET['classroom']);
            display_fc_training_classroom_records($classroom);
        }
    } else {
        // デフォルト → 教室一覧
        display_fc_training_classrooms();
    }
}

/**
 * 3) 教室一覧を表示する
 *  - _subject に "FC研修受講記録提出" を含む投稿を全部取得
 *  - 教室名(_field_your-name)ごとに分けて最新日時を表示
 */
function display_fc_training_classrooms() {
    if (!current_user_can('read')) {
        wp_die(__('このページにアクセスする権限がありません。'));
    }
    
    echo '<div class="wrap">';
    echo '<h1>FC研修受講記録 教室別一覧</h1>';
    
    // 検索フォーム
    $search_classroom = isset($_GET['search_classroom']) ? sanitize_text_field($_GET['search_classroom']) : '';
    echo '<form method="GET" style="margin-bottom: 1em;">';
    echo '<input type="hidden" name="page" value="fc-training-classrooms">';
    echo '教室名: <input type="text" name="search_classroom" value="' . esc_attr($search_classroom) . '" style="width:250px;"> ';
    echo '<input type="submit" value="検索" class="button button-primary">';
    echo '<a href="?page=fc-training-classrooms" class="button" style="margin-left:1em;">リセット</a>';
    echo '</form>';
    
    // すべての「_subject LIKE 'FC研修受講記録提出'」投稿を取得
    $args = array(
        'post_type'      => 'flamingo_inbound',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => '_subject',
                'value'   => 'FC研修受講記録提出',
                'compare' => 'LIKE',
            ),
        ),
    );
    $query = new WP_Query($args);
    
    // 教室名→最新投稿日時 のマッピング
    $classrooms_data = array();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id  = get_the_ID();
            $post_date= get_post()->post_date;
            
            // 教室名を取得
            $classroom_name = get_post_meta($post_id, '_field_your-name', true);
            if (empty($classroom_name)) {
                continue;
            }
            // 検索
            if (!empty($search_classroom) && stripos($classroom_name, $search_classroom) === false) {
                continue;
            }
            
            // 最新日時を管理
            if (!isset($classrooms_data[$classroom_name])) {
                $classrooms_data[$classroom_name] = $post_date;
            } else {
                // より新しい日付を
                if (strtotime($post_date) > strtotime($classrooms_data[$classroom_name])) {
                    $classrooms_data[$classroom_name] = $post_date;
                }
            }
        }
        wp_reset_postdata();
    }
    
    if (empty($classrooms_data)) {
        echo '<p>教室のデータがありません。</p>';
        echo '</div>';
        return;
    }
    
    // 教室名でソート
    ksort($classrooms_data);
    
    echo '<table class="widefat fixed striped">';
    echo '<thead><tr><th>教室名</th><th>最新送信日</th><th>操作</th></tr></thead>';
    echo '<tbody>';
    foreach ($classrooms_data as $name => $latest_date) {
        $latest_date_f = esc_html(date_i18n('Y年m月d日 H:i', strtotime($latest_date)));
        $name_esc = esc_html($name);
        echo '<tr>';
        echo "<td>{$name_esc}</td>";
        echo "<td>{$latest_date_f}</td>";
        echo "<td><a href='?page=fc-training-classrooms&action=list&classroom=" . urlencode($name) . "' class='button'>送信一覧</a></td>";
        echo '</tr>';
    }
    echo '</tbody></table>';
    
    echo '</div>'; // .wrap
}

/**
 * 4) 教室の送信一覧ページ
 *    - 研修名や受講日で検索可能
 */
function display_fc_training_classroom_records($classroom) {
    if (!current_user_can('read')) {
        wp_die(__('このページにアクセスする権限がありません。'));
    }
    
    echo '<div class="wrap">';
    echo '<h1>教室「' . esc_html($classroom) . '」の受講記録</h1>';
    
    // 受講状況テーブルを表示（オプション）
// display_fc_training_classroom_table($classroom);
    
    // 検索フォーム
    $search_training = isset($_GET['search_training']) ? sanitize_text_field($_GET['search_training']) : '';
    $search_date     = isset($_GET['search_date'])     ? sanitize_text_field($_GET['search_date'])     : '';
    
    echo '<form method="GET" style="margin-bottom: 1em;">';
    echo '<input type="hidden" name="page" value="fc-training-classrooms">';
    echo '<input type="hidden" name="action" value="list">';
    echo '<input type="hidden" name="classroom" value="' . esc_attr($classroom) . '">';
    echo '研修名: <input type="text" name="search_training" value="' . esc_attr($search_training) . '" style="width:200px;"> ';
    echo '受講日: <input type="date" name="search_date" value="' . esc_attr($search_date) . '" style="width:150px;"> ';
    echo '<input type="submit" value="検索" class="button button-primary">';
    echo '<a href="?page=fc-training-classrooms&action=list&classroom=' . urlencode($classroom) . '" class="button" style="margin-left:1em;">リセット</a>';
    echo '</form>';
    
    // WP_Query で検索
    $meta_query = array(
        'relation' => 'AND',
        array(
            'key'     => '_subject',
            'value'   => 'FC研修受講記録提出',
            'compare' => 'LIKE',
        ),
        array(
            'key'     => '_field_your-name',
            'value'   => $classroom,
            'compare' => '=',
        ),
    );
    if (!empty($search_training)) {
        $meta_query[] = array(
            'key'     => '_field_training01',
            'value'   => $search_training,
            'compare' => 'LIKE',
        );
    }
    if (!empty($search_date)) {
        $meta_query[] = array(
            'key'     => '_field_date-583',
            'value'   => $search_date,
            'compare' => 'LIKE',
        );
    }
    
    $args = array(
        'post_type'      => 'flamingo_inbound',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => $meta_query,
    );
    $query = new WP_Query($args);
    
    if (!$query->have_posts()) {
        echo '<p>該当するデータがありません。</p>';
        echo '<a href="?page=fc-training-classrooms" class="button button-primary">教室一覧に戻る</a>';
        echo '</div>';
        return;
    }
    
    // 一覧テーブル
    echo '<h2>送信履歴</h2>';
    echo '<table class="widefat fixed striped">';
    echo '<thead><tr><th>研修名</th><th>受講日</th><th>受講者</th><th>詳細</th></tr></thead><tbody>';
    
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        
        // 研修名
        $training_name = get_post_meta($post_id, '_field_training01', true);
        // Array → 文字列
        if (is_array($training_name)) {
            $training_name = implode(', ', $training_name);
        }
        if ($training_name === '') {
            $training_name = 'N/A';
        }
        
        // 受講日
        $training_date = get_post_meta($post_id, '_field_date-583', true);
        if ($training_date === '') {
            $training_date = 'N/A';
        }
        
        // 受講者
        $participant = get_post_meta($post_id, '_field_text-462', true);
        if ($participant === '') {
            $participant = 'N/A';
        }
        
        echo '<tr>';
        echo '<td>' . esc_html($training_name) . '</td>';
        echo '<td>' . esc_html($training_date) . '</td>';
        echo '<td>' . esc_html($participant) . '</td>';
        echo '<td><a href="?page=fc-training-classrooms&action=list&classroom=' . urlencode($classroom) 
             . '&record_id=' . $post_id . '" class="button">詳細を見る</a></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
    
    wp_reset_postdata();
    
    echo '<a href="?page=fc-training-classrooms" class="button button-primary" style="margin-top:1em;">教室一覧に戻る</a>';
    echo '</div>'; // .wrap
}


/**
 * 5) 詳細ページ
 *    - 指定投稿IDからメタキーをget_post_meta() → テーブル表示
 *    - "Array"になりうる項目は is_array() + implode()
 */
function display_fc_training_detail($record_id) {
    if (!current_user_can('read')) {
        wp_die(__('このページにアクセスする権限がありません。'));
    }
    
    $post = get_post($record_id);
    if (!$post || $post->post_status !== 'publish') {
        echo '<p>記録が見つかりません。</p>';
        echo '<a href="?page=fc-training-classrooms" class="button">教室一覧に戻る</a>';
        return;
    }
    
    // メタ取得
    $classroom      = get_post_meta($record_id, '_field_your-name', true);
    $training_name  = get_post_meta($record_id, '_field_training01', true);
    $training_date  = get_post_meta($record_id, '_field_date-583', true);
    $lecturer       = get_post_meta($record_id, '_field_lecturer01', true);
    $attending_way  = get_post_meta($record_id, '_field_attending_lecture01', true);
    $participant    = get_post_meta($record_id, '_field_text-462', true);

    // 1.この研修で学んだこと
    $answer_1 = get_post_meta($record_id, '_field_textarea-578', true);
    // 2.この研修を受けて教室で取り組みたいこと
    $answer_2 = get_post_meta($record_id, '_field_textarea-345', true);
    // 3.研修の満足度(1~5) => Arrayの可能性
    $answer_3 = get_post_meta($record_id, '_field_satisfaction', true);
    // 4.研修の理解度(1~5)
    $answer_4 = get_post_meta($record_id, '_field_comprehension', true);
    // 5.講師の説明(1~5)
    $answer_5 = get_post_meta($record_id, '_field_explanation', true);
    // 6.本研修への質問・感想
    $answer_7 = get_post_meta($record_id, '_field_textarea-790', true);
    // 7.今後行ってほしい研修
    $answer_8 = get_post_meta($record_id, '_field_textarea-382', true);

    // Array対策 → implode
    // 研修名
    if (is_array($training_name)) {
        $training_name = implode(', ', $training_name);
    }
    // 満足度
    if (is_array($answer_3)) {
        $answer_3 = implode(', ', $answer_3);
    }
    // 理解度
    if (is_array($answer_4)) {
        $answer_4 = implode(', ', $answer_4);
    }
    // 講師の説明
    if (is_array($answer_5)) {
        $answer_5 = implode(', ', $answer_5);
    }
    // 受講方法
    if (is_array($attending_way)) {
        $attending_way = implode(', ', $attending_way);
    }

    echo '<div class="wrap">';
    echo '<h1>受講記録詳細</h1>';
    echo '<p><strong>投稿日時:</strong> ' . esc_html($post->post_date) . '</p>';

    echo '<table class="widefat fixed striped">';
    echo '<tbody>';

    echo '<tr><th>教室名</th><td>' . esc_html($classroom) . '</td></tr>';
    echo '<tr><th>研修名</th><td>' . esc_html($training_name) . '</td></tr>';
    echo '<tr><th>研修受講日付</th><td>' . esc_html($training_date) . '</td></tr>';
    echo '<tr><th>講師名</th><td>' . esc_html($lecturer) . '</td></tr>';
    echo '<tr><th>受講方法</th><td>' . esc_html($attending_way) . '</td></tr>';
    echo '<tr><th>受講者氏名</th><td>' . esc_html($participant) . '</td></tr>';

    echo '<tr><th>1.この研修で学んだこと</th><td>' . nl2br(esc_html($answer_1)) . '</td></tr>';
    echo '<tr><th>2.この研修を受けて教室で取り組みたいこと</th><td>' . nl2br(esc_html($answer_2)) . '</td></tr>';
    echo '<tr><th>3.研修の満足度（1～5）</th><td>' . esc_html($answer_3) . '</td></tr>';
    echo '<tr><th>4.研修の理解度（1～5）</th><td>' . esc_html($answer_4) . '</td></tr>';
    echo '<tr><th>5.講師の説明（1～5）</th><td>' . esc_html($answer_5) . '</td></tr>';
    echo '<tr><th>6.本研修への質問・感想</th><td>' . nl2br(esc_html($answer_7)) . '</td></tr>';
    echo '<tr><th>7.今後行ってほしい研修</th><td>' . nl2br(esc_html($answer_8)) . '</td></tr>';

    echo '</tbody></table>';

    // 戻るボタン
    echo '<div style="margin-top: 20px;">';
    if (!empty($classroom)) {
        echo '<a href="?page=fc-training-classrooms&action=list&classroom=' . urlencode($classroom) 
             . '" class="button button-primary">一覧に戻る</a> ';
    }
    echo '<a href="?page=fc-training-classrooms" class="button">教室一覧に戻る</a>';
    echo '</div>';

    echo '</div>'; // .wrap
}










/**
 * 月次報告（Flamingo Inbound）を取得するヘルパー関数
 * - post_type = 'flamingo_inbound'
 * - メタキー _subject に「月次報告」を含むもののみ返す (部分一致)
 */
function get_monthly_report_posts() {
    $args = array(
        'post_type'      => 'flamingo_inbound',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => '_subject',
                'value'   => '月次報告',
                'compare' => 'LIKE', // 部分一致
            ),
        ),
    );
    $query = new WP_Query($args);

    return $query->posts;
}
// WordPress管理画面のサイドバーに「月次報告」を追加 (既存のコードはそのまま)
function add_monthly_report_menu() {
    add_menu_page(
        '月次報告一覧',
        '月次報告',
        'read',
        'monthly_report',
        'display_monthly_reports_by_classroom',
        'dashicons-list-view',
        6
    );
}
add_action('admin_menu', 'add_monthly_report_menu');

/**
 * 月次報告を教室名別に一覧表示する関数
 * - 検索フォームつき
 */
function display_monthly_reports_by_classroom() {
    $search_term = isset($_GET['classroom_search']) ? sanitize_text_field($_GET['classroom_search']) : '';

    // 「_subject に '月次報告' を含む」投稿をすべて取得
    $posts = get_monthly_report_posts();

    // 教室別にまとめる
    $classrooms   = array();
    $latest_dates = array();

    if (!empty($posts)) {
        foreach ($posts as $post) {
            // ---- 各メタキーから「教室名」を取得 ----
            //  例: 「_field_your-name」フィールドに教室名が入っている場合
            $classroom_name = get_post_meta($post->ID, '_field_your-name', true);
            $classroom_name = trim($classroom_name);

            if (!empty($classroom_name)) {
                // 検索語に合致するかチェック
                if (empty($search_term) || stripos($classroom_name, $search_term) !== false) {
                    if (!isset($classrooms[$classroom_name])) {
                        $classrooms[$classroom_name] = array();
                        $latest_dates[$classroom_name] = $post->post_date;
                    }
                    // 最新投稿日時を更新
                    if (strtotime($post->post_date) > strtotime($latest_dates[$classroom_name])) {
                        $latest_dates[$classroom_name] = $post->post_date;
                    }

                    // 教室ごとに投稿を追加
                    $classrooms[$classroom_name][] = array(
                        'id'    => $post->ID,
                        'title' => $post->post_title,
                        'date'  => $post->post_date,
                    );
                }
            }
        }
    }

    // --- 画面出力 ---
    echo '<div class="wrap">';
    echo '<h1>月次報告 教室別一覧</h1>';

    // 検索フォーム
    echo '<div class="tablenav top">';
    echo '<form method="get" class="search-form">';
    echo '<input type="hidden" name="page" value="monthly_report" />';
    echo '<div class="search-box">';
    echo '<label for="classroom-search">教室名：</label>';
    echo '<input type="text" id="classroom-search" name="classroom_search" value="' . esc_attr($search_term) . '" placeholder="教室名を入力" />';
    echo '<input type="submit" class="button button-primary" value="検索" />';
    if (!empty($search_term)) {
        echo '&nbsp;<a href="' . admin_url('admin.php?page=monthly_report') . '" class="button">リセット</a>';
    }
    echo '</div>';
    echo '</form>';
    echo '<br class="clear" />';
    echo '</div>';

    if (empty($classrooms)) {
        if (!empty($search_term)) {
            echo '<p>「' . esc_html($search_term) . '」に一致する教室の月次報告はありません。</p>';
        } else {
            echo '<p>月次報告がありません。</p>';
        }
    } else {
        if (!empty($search_term)) {
            echo '<p>「' . esc_html($search_term) . '」の検索結果: ' . count($classrooms) . '件の教室が見つかりました。</p>';
        }

        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>教室名</th><th>最新送信日</th><th>操作</th></tr></thead><tbody>';

        foreach ($classrooms as $name => $reports) {
            echo '<tr>';
            echo '<td>' . esc_html($name) . '</td>';
            echo '<td>' . esc_html($latest_dates[$name]) . '</td>';
            echo '<td><a href="' . admin_url('admin.php?page=classroom_report_list&classroom=' . urlencode($name)) . '" class="button">送信一覧</a></td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    }

    echo '</div>';

    // スタイル
    echo '<style>
        .tablenav.top {
            margin-bottom: 15px;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        #classroom-search {
            padding:5px 8px;
            width:250px;
            height:30px;
        }
        label[for="classroom-search"] {
            font-weight:bold;
        }
        .wp-list-table a.button {
            text-decoration:none;
            padding:4px 8px;
            display:inline-block;
        }
    </style>';
}
function add_classroom_report_list_page() {
    add_submenu_page(
        null,
        '教室別月次報告一覧',
        '教室別月次報告一覧',
        'read',
        'classroom_report_list',
        'display_classroom_report_list'
    );
}
add_action('admin_menu', 'add_classroom_report_list_page');

/**
 * 指定された教室の投稿(= 同じ _field_your-name)を一覧表示
 */
function display_classroom_report_list() {
    if (!isset($_GET['classroom'])) {
        echo '<div class="wrap"><h1>無効なリクエストです。</h1></div>';
        return;
    }
    $classroom = sanitize_text_field($_GET['classroom']);

    // 全投稿を取得
    $all_reports = get_monthly_report_posts();

    $classroom_reports = array();
    foreach ($all_reports as $post) {
        $meta_value = get_post_meta($post->ID, '_field_your-name', true);
        if ($meta_value === $classroom) {
            $classroom_reports[] = $post;
        }
    }

    echo '<div class="wrap">';
    echo '<h1>' . esc_html($classroom) . ' 月次報告一覧</h1>';

    // サマリー表を表示（下記関数へ）
    display_classroom_monthly_summary_table($classroom_reports, $classroom);

    if (empty($classroom_reports)) {
        echo '<p>月次報告がありません。</p>';
    } else {
        // 送信履歴
        echo '<h2>送信履歴</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>教室名</th><th>報告タイトル</th><th>投稿日時</th><th>詳細</th></tr></thead><tbody>';
        foreach ($classroom_reports as $report) {
            echo '<tr>';
            echo '<td>' . esc_html($classroom) . '</td>';
            echo '<td>' . esc_html($report->post_title) . '</td>';
            echo '<td>' . esc_html($report->post_date) . '</td>';
            echo '<td><a href="' . admin_url('admin.php?page=monthly_report_detail&id=' . $report->ID) . '" class="button">詳細を見る</a></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    echo '<div class="navigation-buttons">';
    echo '<a href="' . admin_url('admin.php?page=monthly_report') . '" class="button">教室一覧に戻る</a>';
    echo '</div>';
    echo '</div>';

    // スタイル
    echo '<style>
        .navigation-buttons {
            margin-top:20px;
            text-align:right;
        }
        .wp-list-table a.button {
            text-decoration:none;
            padding:4px 8px;
        }
    </style>';
}
/**
 * 教室別の月次データを集計して表示
 * - $reports: その教室の flamingo_inbound 投稿配列
 * - $classroom_name: 教室名
 */
function display_classroom_monthly_summary_table($reports, $classroom_name) {
    if (empty($reports)) return;

    // 月リスト（例：全角数字で書いている場合）
    $months = array("４月","５月","６月","７月","８月","９月","１０月","１１月","１２月","１月","２月","３月");

    // 月毎に初期データ
    $data_by_month = array_fill_keys($months, array(
        '見学数'         => '',
        '成約件数'       => '',
        '平日'          => '',
        '休日'          => '',
        '入所'          => '',
        '退所'          => '',
        '利用予定数'     => '',
        '実際の利用数'   => '',
        '欠席率'         => '',
        '開所日数'       => '',
        '前月契約人数'   => '',
        '契約人数'       => '',
        '平均利用数(人)' => '',
        '定員数'        => '',
        '充足率(%)'      => ''
    ));

    $contract_numbers_by_month = array();
    $initial_contract_saved = false;
    $initial_contract_number = 0;
    $previous_month = null;

    foreach ($reports as $post) {
        // 月データを取得 (例: _field_menu-456)
        $target_month = get_post_meta($post->ID, '_field_menu-456', true);

        // もし配列なら単一文字列にまとめる (checklist / select multiple 対策)
        if (is_array($target_month)) {
            $target_month = implode('', $target_month); 
            // 例: array("４月") → "４月"
        }

        // 全角・半角の不一致を吸収 (お好みで)
        // $target_month = mb_convert_kana($target_month, 'KV', 'UTF-8');
        // これにより "4月" → "４月" になるなど（環境に合わせて要調整）

        // 月リストにないならスキップ
        if (!in_array($target_month, $months)) {
            continue;
        }

        // 既にこの月のデータが埋まっていればスキップ
        if (!empty($data_by_month[$target_month]['見学数'])) {
            continue;
        }

        // 各種データを取得
        $prev_contracts = get_post_meta($post->ID, '_field_text-9',  true); // 前月契約人数
        $capacity       = get_post_meta($post->ID, '_field_text-10', true); // 定員数(4月のみ)
        $visit_count    = get_post_meta($post->ID, '_field_text-1',  true); // 見学数
        $sign_count     = get_post_meta($post->ID, '_field_text-2',  true); // 成約件数
        $weekday        = get_post_meta($post->ID, '_field_text-3',  true); // 平日
        $holiday        = get_post_meta($post->ID, '_field_text-4',  true); // 休日
        $admission      = get_post_meta($post->ID, '_field_text-5',  true); // 入所
        $discharge      = get_post_meta($post->ID, '_field_text-6',  true); // 退所
        $planned_use    = get_post_meta($post->ID, '_field_text-7',  true); // 利用予定数
        $actual_use     = get_post_meta($post->ID, '_field_text-8',  true); // 実際の利用数

        // 数値に変換 (floatval)
        $prev_contracts = floatval($prev_contracts);
        $capacity       = floatval($capacity);
        $visit_count    = floatval($visit_count);
        $sign_count     = floatval($sign_count);
        $weekday        = floatval($weekday);
        $holiday        = floatval($holiday);
        $admission      = floatval($admission);
        $discharge      = floatval($discharge);
        $planned_use    = floatval($planned_use);
        $actual_use     = floatval($actual_use);

        // 欠席率
        $absent_rate = ($planned_use > 0)
            ? round((($planned_use - $actual_use) / $planned_use) * 100, 1)
            : 0;
        // 開所日数
        $opening_days = $weekday + $holiday;

        // 初回(=最初の投稿)なら前月契約人数を記録
        if (!$initial_contract_saved) {
            $initial_contract_number = $prev_contracts;
            $initial_contract_saved = true;
        }

        // 前月契約者数
        $previous_month_contracts_value = isset($contract_numbers_by_month[$previous_month])
            ? $contract_numbers_by_month[$previous_month]
            : $initial_contract_number;

        // 現在契約人数 = 前月 + 入所 - 退所
        $current_contracts = $previous_month_contracts_value + $admission - $discharge;

        // 平均利用数
        $average_use = ($opening_days > 0) ? round($actual_use / $opening_days, 1) : 0;
        // 充足率
        $occupancy_rate = ($capacity > 0 && $average_use > 0)
            ? round(($average_use / $capacity) * 100, 1)
            : 0;

        // データ格納
        $data_by_month[$target_month] = array(
            '見学数'         => $visit_count,
            '成約件数'       => $sign_count,
            '平日'          => $weekday,
            '休日'          => $holiday,
            '入所'          => $admission,
            '退所'          => $discharge,
            '利用予定数'     => $planned_use,
            '実際の利用数'   => $actual_use,
            '欠席率'         => $absent_rate,
            '開所日数'       => $opening_days,
            '前月契約人数'   => $previous_month_contracts_value,
            '契約人数'       => $current_contracts,
            '平均利用数(人)' => $average_use,
            '定員数'        => $capacity,
            '充足率(%)'      => $occupancy_rate
        );

        // 次の月に引き継ぐため保存
        $contract_numbers_by_month[$target_month] = $current_contracts;
        $previous_month = $target_month;
    }

    // 利用予定数の前月繰り越し
    $prev_planned_use = '――';
    foreach ($months as $index => $m) {
        $current_planned_use = $data_by_month[$m]['利用予定数'];
        if ($index > 0) {
            $data_by_month[$m]['利用予定数'] = $prev_planned_use;
        } else {
            $data_by_month[$m]['利用予定数'] = '――';
        }
        $prev_planned_use = $current_planned_use;
    }

    // --- テーブル表示 ---
    echo '<h2>' . esc_html($classroom_name) . ' 月次集計</h2>';
    echo '<div class="table-container" style="overflow-x:auto;">';
    echo '<table class="widefat fixed striped flamingo-report" style="min-width:100%;">';
    echo '<thead><tr><th>項目</th>';
    foreach ($months as $m) {
        echo '<th>' . esc_html($m) . '</th>';
    }
    echo '</tr></thead><tbody>';

    // 表示セクション
    $sections = array(
        '問合せ' => array(
            '見学数'   => '見学数',
            '成約件数' => '成約件数'
        ),
        '実績・予定' => array(
            '定員数'         => '定員数',
            '開所日数'       => '開所日数',
            '平日'           => '平日',
            '休日'           => '休日',
            '契約人数'       => '契約人数',
            '前月契約人数'   => '前月契約人数',
            '入所'           => '入所',
            '退所'           => '退所',
            '利用予定数'     => '利用予定数',
            '実際の利用数'   => '実際の利用数'
        ),
        '月間' => array(
            '欠席率'        => '欠席率 (%)',
            '平均利用数(人)' => '平均利用数(人)',
            '充足率(%)'      => '充足率 (%)'
        )
    );

    foreach ($sections as $section_label => $fields) {
        echo '<tr class="section-header" style="background-color:#f0f0f0;">';
        echo '<td colspan="' . (count($months)+1) . '"><strong>' . esc_html($section_label) . '</strong></td>';
        echo '</tr>';
        foreach ($fields as $field_key => $label) {
            echo '<tr>';
            echo '<td><strong>' . esc_html($label) . '</strong></td>';
            foreach ($months as $m) {
                $val = $data_by_month[$m][$field_key];
                $style = '';

                // 数値 or "率" を含むフィールドは右寄せ
                if (is_numeric($val) || strpos($field_key, '率') !== false) {
                    $style = ' style="text-align:right;"';
                }
                // 欠席率、充足率などで、% が付いていなければ追加
                if ((strpos($field_key,'率') !== false || strpos($label,'率') !== false)
                    && is_numeric($val)
                    && strpos($val, '%') === false
                ) {
                    $val .= '%';
                }

                echo '<td' . $style . '>' . esc_html($val) . '</td>';
            }
            echo '</tr>';
        }
    }

    echo '</tbody></table>';
    echo '</div>';

    // スタイル
    echo '<style>
        .flamingo-report {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        .flamingo-report th, .flamingo-report td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .flamingo-report th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .section-header td {
            background-color: #eaeaea;
            font-weight: bold;
        }
        .table-container {
            margin-bottom: 30px;
        }
    </style>';
}


/**
 * 月次報告詳細ページを追加
 */
function add_monthly_report_detail_page() {
    add_submenu_page(
        null,                             // 親メニューなし（直接アクセスのみ）
        '月次報告詳細',                    // ページタイトル
        '月次報告詳細',                    // サブメニュー名
        'read',                 // 権限
        'monthly_report_detail',          // スラッグ
        'display_monthly_report_detail'   // コールバック関数
    );
}
add_action('admin_menu', 'add_monthly_report_detail_page');

/**
 * 月次報告の詳細を表示する関数
 * - フラミンゴ投稿 ( post_type = 'flamingo_inbound' ) の ID ( ?id=XX ) を受け取り、詳細をテーブル表示する
 */
function display_monthly_report_detail() {
    // パラメータ 'id' がなければエラー
    if (!isset($_GET['id'])) {
        echo '<div class="wrap"><h1>無効なリクエストです。</h1></div>';
        return;
    }

    $post_id = intval($_GET['id']);
    $post = get_post($post_id);
    // 該当投稿がなければエラー
    if (!$post) {
        echo '<div class="wrap"><h1>データが見つかりません。</h1></div>';
        return;
    }

    // 画面出力開始
    echo '<div class="wrap">';
    echo '<h1>' . esc_html($post->post_title) . '</h1>';
    echo '<p><strong>投稿日時:</strong> ' . esc_html($post->post_date) . '</p>';

    /**
     * 1) 月次チェックリスト
     *    (チェック項目 + 詳細説明) を「title」と「desc」に分けて map 化
     */
    echo '<h2>月次チェックリスト</h2>';
    echo '<table class="widefat fixed striped">';
    echo '<thead><tr><th>項目</th><th>状況</th></tr></thead><tbody>';

    // 「_field_checklist-1」等への対応付け。title と desc の2つの情報を持たせる
    $checklist_map = array(
        '_field_checklist-1' => array(
            'title' => '【01】個別支援計画…',
            'desc'  => '6ヶ月に1回以上個別支援計画の見直しがされている。'
        ),
        '_field_checklist-2' => array(
            'title' => '【02】個別支援計画…',
            'desc'  => '個別支援計画書作成の際、5領域および支援時間・延長支援計画を記載したフォーマットへ変更し、それらに沿った個別支援計画の作成ができている。'
        ),
        '_field_checklist-3' => array(
            'title' => '【03】個別支援計画…',
            'desc'  => '作成した個別支援計画を相談支援事業所に提出した。'
        ),
        '_field_checklist-4' => array(
            'title' => '【04】個別支援記録…',
            'desc'  => '日々の記録が記載されている。'
        ),
        '_field_checklist-5' => array(
            'title' => '【05】利用者契約等…',
            'desc'  => '報酬改定に伴う運営規定・契約書・重要事項説明書を作成し運用を始めている。'
        ),
        '_field_checklist-6' => array(
            'title' => '【06】利用者契約等…',
            'desc'  => '重要事項の内容の変更箇所を通知または承認契約書（変更承諾書）を交わしている。'
        ),
        '_field_checklist-7' => array(
            'title' => '【07】サービス提供実績…',
            'desc'  => '実績記録票 / 活動日誌：入室（支援開始）時間と退室（支援終了）時間、算定時間（基本報酬の対象となる計画時間）の記載がある。'
        ),
        '_field_checklist-8' => array(
            'title' => '【08】サービス提供実績…',
            'desc'  => '利用者都合の支援時間短縮の場合、備考欄に記載がある。'
        ),
        '_field_checklist-9' => array(
            'title' => '【09】受給者証…',
            'desc'  => '受給者証（更新後の）控えが保管されている。'
        ),
        '_field_checklist-10' => array(
            'title' => '【10】職員・勤務表…',
            'desc'  => '職種、氏名、勤務時間等の整理をした勤務表が作成されている。'
        ),
        '_field_checklist-11' => array(
            'title' => '【11】職員・勤務表…',
            'desc'  => '基準配置・加配加算等の取得計画がされている。'
        ),
        '_field_checklist-12' => array(
            'title' => '【12】職員・勤務表…',
            'desc'  => '申し送り書類・ミーティング議事録を作成し、共有されている。'
        ),
        '_field_checklist-13' => array(
            'title' => '【13】研修・訓練…',
            'desc'  => '避難訓練が行われている。（年2回）'
        ),
        '_field_checklist-14' => array(
            'title' => '【14】研修・訓練…',
            'desc'  => '感染症対策の研修訓練が行われている。（年2回）'
        ),
        '_field_checklist-15' => array(
            'title' => '【15】研修・訓練…',
            'desc'  => '感染症BCP、非常災害発生時BCPの策定後、研修訓練が行われている。（各年1回）'
        ),
        '_field_checklist-16' => array(
            'title' => '【16】研修・訓練…',
            'desc'  => '安全計画の策定がされ、安全点検、安全指導、研修訓練等が開始されている。'
        ),
        '_field_checklist-17' => array(
            'title' => '【17】研修・訓練…',
            'desc'  => '虐待防止・身体拘束適正化の研修が行われている。'
        ),
        '_field_checklist-18' => array(
            'title' => '【18】委員会の開催…',
            'desc'  => '虐待防止委員会・身体拘束適正化委員会が開催されている。'
        ),
        '_field_checklist-19' => array(
            'title' => '【19】委員会の開催…',
            'desc'  => '今年度2回目の感染症対策委員会が開催されている。'
        ),
        '_field_checklist-20' => array(
            'title' => '【20】本部提供物…',
            'desc'  => '毎月25日頃に届く柳沢プログラム冊子を確認している。'
        ),
        '_field_checklist-21' => array(
            'title' => '【21】本部提供物…',
            'desc'  => 'ポータルサイトの運動療育動画を確認し基本の動きやアレンジがイメージできている。'
        ),
        '_field_checklist-22' => array(
            'title' => '【22】本部提供物…',
            'desc'  => 'ポータルサイトで配信されている教材や資料を活用している。'
        ),
        '_field_checklist-23' => array(
            'title' => '【23】本部提供物…',
            'desc'  => 'FC研修の受講をしレポートを提出している。'
        ),
    );

    // それぞれのキーに対して、DBに保存された「はい/いいえ」などを取得
    foreach ($checklist_map as $meta_key => $item) {
        $val = get_post_meta($post_id, $meta_key, true);
        // 配列なら結合
        if (is_array($val)) {
            $val = implode(', ', $val);
        }

        // タイトル(上部) と 説明文(小文字) を出力
        $title_html = esc_html($item['title']);
        $desc_html  = '<br><small>' . esc_html($item['desc']) . '</small>';

        echo '<tr>';
        echo '<td>' . $title_html . $desc_html . '</td>';
        echo '<td>' . esc_html($val) . '</td>';
        echo '</tr>';
    }

    // ヒヤリハット等 (例: '_field_textarea-675')
    $hiyari = get_post_meta($post_id, '_field_textarea-675', true);
    if (!empty($hiyari)) {
        echo '<tr><td>任意：ヒヤリハット事例等</td><td>' . nl2br(esc_html($hiyari)) . '</td></tr>';
    }

    echo '</tbody></table>';

    /**
     * 2) 在籍状況
     */
    echo '<h2>在籍状況</h2>';
    echo '<table class="widefat fixed striped">';
    echo '<thead><tr><th>項目</th><th>人数</th></tr></thead><tbody>';

    $teacher_map = array(
        '_field_full_time_experienced_5plus'   => '常勤専従(5年以上)',
        '_field_full_time_experienced_under_5' => '常勤専従(5年未満)',
        '_field_full_time_conversion_5plus'    => '常勤換算(5年以上)',
        '_field_full_time_conversion_under_5'  => '常勤換算(5年未満)',
        '_field_physical_therapist'           => '理学療法士等',
        '_field_behavior_training'            => '強度行動障害実践研修 修了者'
    );

    foreach ($teacher_map as $key => $label) {
        $val = get_post_meta($post_id, $key, true);
        // 数値の場合は intval/floatval してもOK。ここではそのまま文字表示
        echo '<tr>';
        echo '<td>' . esc_html($label) . '</td>';
        echo '<td>' . esc_html($val) . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';

    /**
     * 3) 月次報告 (詳細)
     */
    echo '<h2>月次報告</h2>';
    echo '<table class="widefat fixed striped">';
    echo '<thead><tr><th>項目</th><th>値</th></tr></thead><tbody>';

    // フィールド名とラベル対応
    $report_map = array(
        '教室名'             => '_field_your-name',
        '対象月'             => '_field_menu-456',    // 配列になる場合あり → 下で implode
        '定員数(4月のみ)'     => '_field_text-10',
        '前月契約人数(4月)'   => '_field_text-9',
        '見学数'             => '_field_text-1',
        '成約件数'           => '_field_text-2',
        '平日'               => '_field_text-3',
        '休日'               => '_field_text-4',
        '入所'               => '_field_text-5',
        '退所'               => '_field_text-6',
        '利用予定数'         => '_field_text-7',
        '実際の利用数'       => '_field_text-8'
    );

    foreach ($report_map as $label => $meta_key) {
        $val = get_post_meta($post_id, $meta_key, true);

        // 配列ならカンマ区切り等で連結
        if (is_array($val)) {
            $val = implode(', ', $val);
        }

        // 空文字の場合は「――」と表示
        if ($val === '') {
            $val = '――';
        }

        echo '<tr>';
        echo '<td>' . esc_html($label) . '</td>';
        echo '<td>' . esc_html($val) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';

    // 戻るボタン
    echo '<div class="navigation-buttons">';
    // 「教室一覧に戻る」リンクのため教室名を取得
    $classroom_name = get_post_meta($post_id, '_field_your-name', true);
    if (!empty($classroom_name)) {
        echo '<a href="' . admin_url('admin.php?page=classroom_report_list&classroom=' . urlencode($classroom_name)) . '" class="button">一覧に戻る</a> ';
    }
    echo '<a href="' . admin_url('admin.php?page=monthly_report') . '" class="button">教室一覧に戻る</a>';
    echo '</div>'; // .navigation-buttons

    echo '</div>'; // .wrap

    // 簡単なスタイル
    echo '<style>
        .navigation-buttons {
            margin-top:20px;
            text-align:right;
        }
        .navigation-buttons .button {
            margin-left:10px;
        }
        .widefat small {
            display:block;
            color:#666;
            font-size:12px;
            margin-top:3px;
        }
    </style>';
}


// FCフォーム下書き機能スクリプトを追加
// FCフォーム下書き機能スクリプトを追加
function add_fc_form_draft_script() {
    // スクリプトを登録
    wp_register_script('fc-form-draft', '', [], '1.1', true);
    
    // インラインスクリプトとして上記のJavaScriptコードを追加
    wp_add_inline_script('fc-form-draft', '// FC研修受講記録フォーム用下書き保存機能
document.addEventListener("DOMContentLoaded", function() {
  // Contact Form 7のフォームを取得 - 複数フォームに対応
  const formIds = ["3475"]; // フォームIDを配列で指定（複数フォーム対応可）
  const wpcf7Forms = document.querySelectorAll(".wpcf7-form");
  
  // フォームが存在しない場合は処理を終了
  if (!wpcf7Forms.length) return;
  
  // 各フォームに対して処理
  wpcf7Forms.forEach(wpcf7Form => {
    // フォームのIDを確認
    const wpcf7Element = wpcf7Form.closest(".wpcf7");
    if (!wpcf7Element) return;
    
    // フォームIDを取得
    let currentFormId = "";
    for (const id of formIds) {
      if (wpcf7Element.id.includes("wpcf7-f" + id)) {
        currentFormId = id;
        break;
      }
    }
    
    // 対象フォームでなければスキップ
    if (!currentFormId) return;
    
    // ストレージキー
    const storageKey = "fc_training_form_draft_" + currentFormId;
    
    // 最終保存日時を保存するキー
    const saveTimeKey = storageKey + "_lastSave";
    
    // フォーム要素を取得
    const formElements = wpcf7Form.querySelectorAll("input, textarea, select");
    
    // "自動表示" テキストを含む要素の近くのinput要素を特定する関数
    function isAutoDisplayField(element) {
      if (!element.parentNode) return false;
      
      // 親要素内のテキストを検索
      const parentText = element.parentNode.textContent || "";
      if (parentText.includes("自動表示")) return true;
      
      // 前の兄弟要素を検索（より広範囲に検索）
      let prevSibling = element.previousElementSibling;
      while (prevSibling) {
        const siblingText = prevSibling.textContent || "";
        if (siblingText.includes("自動表示")) return true;
        prevSibling = prevSibling.previousElementSibling;
      }
      
      // 親のtd要素を取得し、その前のth要素のspan.requiredの近くにある"自動表示"テキストを検索
      const parentTd = element.closest("td");
      if (parentTd) {
        const prevTh = parentTd.previousElementSibling;
        if (prevTh && prevTh.tagName === "TH") {
          const spanElements = prevTh.querySelectorAll("span");
          for (const span of spanElements) {
            if (span.textContent.includes("自動表示")) return true;
          }
        }
      }
      
      return false;
    }
    
    // フォーマットされた日時を取得する関数
    function getFormattedDateTime() {
      const now = new Date();
      const year = now.getFullYear();
      const month = String(now.getMonth() + 1).padStart(2, "0");
      const day = String(now.getDate()).padStart(2, "0");
      const hours = String(now.getHours()).padStart(2, "0");
      const minutes = String(now.getMinutes()).padStart(2, "0");
      
      return `${year}/${month}/${day} ${hours}:${minutes}`;
    }
    
    // 下書きを保存する関数
    function saveDraft() {
      const formData = {};
      
      formElements.forEach(element => {
        // nameがない要素はスキップ
        if (!element.name) return;
        
        // submitボタンはスキップ
        if (element.type === "submit") return;
        
        // 自動表示フィールドの場合は保存する（readonlyでも）
        const isAutoDisplay = isAutoDisplayField(element);
        
        // 自動表示フィールドでなく、かつreadonly属性を持つ要素はスキップ
        if (!isAutoDisplay && element.hasAttribute("readonly")) return;
        
        // 要素タイプごとの処理
        if (element.type === "radio") {
          if (element.checked) {
            formData[element.name] = element.value;
          }
        } else if (element.type === "checkbox") {
          if (element.checked) {
            // 複数チェックボックスの場合は配列で保存
            if (!formData[element.name]) {
              formData[element.name] = [];
            }
            formData[element.name].push(element.value);
          }
        } else {
          formData[element.name] = element.value;
        }
      });
      
      // データをlocalStorageに保存
      localStorage.setItem(storageKey, JSON.stringify(formData));
      
      // 最終保存日時を記録
      const saveTime = getFormattedDateTime();
      localStorage.setItem(saveTimeKey, saveTime);
      
      // 保存状態を表示
      updateStatus(`下書きを保存しました（${saveTime}）`, 2000);
    }
    
    // 下書きを読み込む関数
    function loadDraft() {
      const savedData = localStorage.getItem(storageKey);
      if (!savedData) return;
      
      const formData = JSON.parse(savedData);
      const saveTime = localStorage.getItem(saveTimeKey) || "不明";
      
      formElements.forEach(element => {
        // nameがない要素はスキップ
        if (!element.name) return;
        
        // submitボタンはスキップ
        if (element.type === "submit") return;
        
        // 自動表示フィールドの場合は復元する（readonlyでも）
        const isAutoDisplay = isAutoDisplayField(element);
        
        // 自動表示フィールドでなく、かつreadonly属性を持つ要素はスキップ
        if (!isAutoDisplay && element.hasAttribute("readonly")) return;
        
        // データが存在する場合のみ処理
        if (formData[element.name] !== undefined) {
          if (element.type === "radio") {
            element.checked = (element.value === formData[element.name]);
          } else if (element.type === "checkbox") {
            if (Array.isArray(formData[element.name])) {
              element.checked = formData[element.name].includes(element.value);
            } else {
              element.checked = (element.value === formData[element.name]);
            }
          } else {
            element.value = formData[element.name];
          }
          
          // 変更イベントをトリガーする（依存する可能性のあるスクリプト用）
          const event = new Event("change", { bubbles: true });
          element.dispatchEvent(event);
        }
      });
      
      updateStatus(`下書きを読み込みました（最終保存: ${saveTime}）`, 2000);
    }
    
    // ステータス表示を更新する関数
    function updateStatus(message, timeout = 0) {
      const statusEl = document.querySelector(".draft-status");
      if (statusEl) {
        statusEl.textContent = message;
        if (timeout > 0) {
          setTimeout(() => {
            const saveTime = localStorage.getItem(saveTimeKey) || "";
            const baseMessage = "下書きは自動保存されます";
            statusEl.textContent = saveTime ? `${baseMessage}（最終保存: ${saveTime}）` : baseMessage;
          }, timeout);
        }
      }
    }
    
    // フォーム要素の変更を監視
    formElements.forEach(element => {
      // submitボタンはスキップ
      if (element.type === "submit") return;
      
      // 自動表示フィールドの場合は監視する（readonlyでも）
      const isAutoDisplay = isAutoDisplayField(element);
      
      // 自動表示フィールドでなく、かつreadonly属性を持つ要素はスキップ
      if (!isAutoDisplay && element.hasAttribute("readonly")) return;
      
      // 変更イベントの監視
      element.addEventListener("change", saveDraft);
      
      // テキスト入力要素はリアルタイム監視（タイピング検出の調整）
      if (element.tagName === "TEXTAREA" || 
          element.type === "text" || 
          element.type === "date" || 
          element.type === "number" || 
          element.type === "email" || 
          element.type === "tel") {
        let typingTimer;
        // キー入力時のタイマーリセット
        element.addEventListener("keydown", function() {
          clearTimeout(typingTimer);
        });
        // キー入力停止後に保存
        element.addEventListener("keyup", function() {
          clearTimeout(typingTimer);
          typingTimer = setTimeout(saveDraft, 1000);
        });
        // その他の入力イベント（ペースト等）
        element.addEventListener("input", function() {
          clearTimeout(element.saveTimeout);
          element.saveTimeout = setTimeout(saveDraft, 1000);
        });
      }
    });
    
    // フォーム送信イベントの監視
    document.addEventListener("wpcf7mailsent", function(event) {
      // 同じフォームIDの場合のみ処理
      if (event.detail.contactFormId === currentFormId) {
        localStorage.removeItem(storageKey);
        localStorage.removeItem(saveTimeKey);
        console.log("フォーム送信成功: 下書きを削除しました");
      }
    });
    
    // フォーム送信エラー時のイベント
    document.addEventListener("wpcf7invalid", function(event) {
      if (event.detail.contactFormId === currentFormId) {
        // エラー時にも最新の状態を保存
        saveDraft();
        updateStatus("入力内容に問題があります。修正後も下書きは保存されます。", 4000);
      }
    });
    
    // 下書き管理UI
    const controlsDiv = document.createElement("div");
    controlsDiv.className = "draft-controls";
    controlsDiv.style.cssText = "margin: 15px 0; padding: 12px; background-color: #f0f8ff; border: 1px solid #cce5ff; border-radius: 4px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;";
    
    // ステータス表示
    const statusContainer = document.createElement("div");
    statusContainer.style.cssText = "flex: 1; display: flex; align-items: center; min-width: 250px; margin-right: 10px;";
    
    const statusIcon = document.createElement("span");
    statusIcon.innerHTML = "&#128190;"; // 保存アイコン
    statusIcon.style.marginRight = "8px";
    statusIcon.style.fontSize = "20px";
    
    const statusSpan = document.createElement("span");
    statusSpan.className = "draft-status";
    statusSpan.textContent = "下書きは自動保存されます";
    statusSpan.style.fontSize = "14px";
    
    statusContainer.appendChild(statusIcon);
    statusContainer.appendChild(statusSpan);
    controlsDiv.appendChild(statusContainer);
    
    // ボタン用コンテナ
    const buttonContainer = document.createElement("div");
    buttonContainer.style.display = "flex";
    buttonContainer.style.gap = "10px";
    buttonContainer.style.marginTop = "5px";
    buttonContainer.style.marginBottom = "5px";
    
    // 下書き再読込ボタン
    const reloadButton = document.createElement("button");
    reloadButton.type = "button";
    reloadButton.className = "reload-draft-btn";
    reloadButton.textContent = "下書きを再読込";
    reloadButton.style.cssText = "padding: 6px 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;";
    reloadButton.addEventListener("click", function() {
      loadDraft();
    });
    buttonContainer.appendChild(reloadButton);
    
    // 下書き削除ボタン
    const clearButton = document.createElement("button");
    clearButton.type = "button";
    clearButton.className = "clear-draft-btn";
    clearButton.textContent = "下書きを削除";
    clearButton.style.cssText = "padding: 6px 12px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;";
    clearButton.addEventListener("click", function() {
      if (confirm("下書きを削除してもよろしいですか？")) {
        localStorage.removeItem(storageKey);
        localStorage.removeItem(saveTimeKey);
        wpcf7Form.reset();
        updateStatus("下書きを削除しました");
        setTimeout(() => {
          location.reload();
        }, 1000);
      }
    });
    buttonContainer.appendChild(clearButton);
    controlsDiv.appendChild(buttonContainer);
    
    // フォームの先頭に挿入
    const firstHeading = wpcf7Form.querySelector("h1.h1-order");
    if (firstHeading) {
      firstHeading.parentNode.insertBefore(controlsDiv, firstHeading);
    } else {
      wpcf7Form.insertBefore(controlsDiv, wpcf7Form.firstChild);
    }
    
    // ページ読み込み時に自動で下書きを復元
    window.addEventListener("load", function() {
      setTimeout(loadDraft, 300); // DOMが完全に読み込まれた後、少し遅延させて実行
    });
  });
});');
    
    // スタイルを追加
    wp_add_inline_style('contact-form-7', '
    .draft-controls {
        animation: highlight-bg 1s ease-out;
    }
    
    @keyframes highlight-bg {
        0% { background-color: #e3f2fd; }
        100% { background-color: #f0f8ff; }
    }
    ');

    // スクリプトを登録・エンキュー
    wp_enqueue_script('fc-form-draft');
}
add_action('wp_enqueue_scripts', 'add_fc_form_draft_script');

// リダイレクト前に確実に下書きを削除するスクリプト
function add_form_redirect_script() {
    wp_register_script('fc-form-redirect', '', [], '1.0', true);
    
    $script = '
    document.addEventListener("DOMContentLoaded", function() {
      // 既存のリダイレクトスクリプトを上書き
      const oldHandler = window.addEventListener;
      window.addEventListener = function(event, handler, options) {
        if (event === "wpcf7mailsent") {
          // 既存のwpcf7mailsentイベントハンドラを上書き
          const newHandler = function(e) {
            // フォームIDが3475の場合
            if (e.detail.contactFormId == "3475") {
              // 下書きデータ削除のキーを設定
              const storageKeys = [
                "fc_training_form_draft_3475",
                "fc_training_form_draft_3475_lastSave"
              ];
              
              // 確実に下書きデータを削除
              storageKeys.forEach(key => {
                localStorage.removeItem(key);
                sessionStorage.removeItem(key); // 念のためsessionStorageも
              });
              
              console.log("フォーム送信成功: 下書きを削除しました");
              
              // 0.5秒後にリダイレクト（下書き削除を確実に実行する時間を確保）
              setTimeout(function() {
                window.location.href = "/training-end/";
              }, 500);
              
              // 元のイベントをキャンセル（リダイレクト処理を遅延させるため）
              e.preventDefault();
              e.stopPropagation();
              return false;
            } else {
              // 別のフォームの場合は元のハンドラを呼び出す
              return handler.apply(this, arguments);
            }
          };
          
          // 修正したハンドラで登録
          return oldHandler.call(this, event, newHandler, options);
        } else {
          // wpcf7mailsent以外のイベントは元のままスルー
          return oldHandler.call(this, event, handler, options);
        }
      };
      
      // バックアップ：直接フォーム要素にイベントリスナーを設定
      const setupDirectFormListener = function() {
        const form = document.querySelector(".wpcf7-form");
        if (!form) return;
        
        form.addEventListener("submit", function(e) {
          // フォームのIDを確認
          const wpcf7Element = form.closest(".wpcf7");
          if (!wpcf7Element || !wpcf7Element.id.includes("wpcf7-f3475")) return;
          
          // 下書きデータ削除のキーを設定
          const storageKeys = [
            "fc_training_form_draft_3475",
            "fc_training_form_draft_3475_lastSave"
          ];
          
          // あらゆるストレージから下書きデータを削除
          storageKeys.forEach(key => {
            try {
              localStorage.removeItem(key);
              sessionStorage.removeItem(key);
            } catch (err) {
              console.error("ストレージ削除エラー:", err);
            }
          });
          
          console.log("フォーム送信時: 下書きを削除しました");
        });
      };
      
      // DOM読み込み後にセットアップ
      setTimeout(setupDirectFormListener, 1000);
      
      // ページ遷移前の最終チェック
      window.addEventListener("beforeunload", function(e) {
        // フォームが送信された後のページ遷移なら下書きを確実に削除
        const submittedForm = document.querySelector(".wpcf7-form.sent");
        if (submittedForm) {
          const wpcf7Element = submittedForm.closest(".wpcf7");
          if (wpcf7Element && wpcf7Element.id.includes("wpcf7-f3475")) {
            // すべての関連キーを削除
            const storageKeys = [
              "fc_training_form_draft_3475",
              "fc_training_form_draft_3475_lastSave"
            ];
            
            storageKeys.forEach(key => {
              localStorage.removeItem(key);
              sessionStorage.removeItem(key);
            });
            
            console.log("ページ遷移前: 下書きを削除しました");
          }
        }
      });
    });
    ';
    
    wp_add_inline_script('fc-form-redirect', $script);
    wp_enqueue_script('fc-form-redirect');
}
add_action('wp_enqueue_scripts', 'add_form_redirect_script');