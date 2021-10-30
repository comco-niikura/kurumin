<?php
/* サイトURL取得 */
function shortcode_url() {
    return get_bloginfo('url');
}
add_shortcode('url', 'shortcode_url');

/* uploads URL取得 */
function shortcode_up() {
    $upload_dir = wp_upload_dir();
    return $upload_dir['baseurl'];
}
add_shortcode('uploads', 'shortcode_up');

// imgフォルダのパスを取得するショートコード
function get_img_url($atts, $content = null) {
    return get_template_directory_uri().'/img/';
}
add_shortcode('img', 'get_img_url');

//
function get_tmpl_url($atts, $content = null) {
    return get_template_directory_uri().'/';
}
add_shortcode('tmpl', 'get_tmpl_url');

/*
 * 固定記事にカテゴリを設定する
*/
/*
add_action( 'init', 'my_add_pages_categories' ) ;
function my_add_pages_categories()
{
    register_taxonomy_for_object_type( 'category', 'page' ) ;
}
add_action( 'pre_get_posts', 'my_set_page_categories' ) ;
function my_set_page_categories( $query )
{
    if ( $query->is_category== true && $query->is_main_query()){
        $query->set( 'post_type', array( 'post', 'page', 'nav_menu_item' )) ;
    }
}
*/

// 投稿＆固定ページ　本文編集エリア非表示
/*
add_action( 'init' , 'my_remove_post_editor_support' );
function my_remove_post_editor_support() {
remove_post_type_support( 'post', 'editor' );//本文
remove_post_type_support( 'page', 'editor' );//本文
}
*/

function my_session_start(){
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
        header('Expires: -1');
        header('Cache-Control:');
        header('Pragma:');
    }
}
add_action('init', 'my_session_start');

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/*
* Contact Form Entries拡張
* DBに書き込む前にフック処理
*/
function my_wpcf7_before_send_mail( $cf7) {
error_log('=== my_wpcf7_before_send_mail');

    $wpcf7 = WPCF7_ContactForm :: get_current() ;
    $submission = WPCF7_Submission :: get_instance() ;
    if ($submission) {
        $posted_data = $submission->get_posted_data() ;
        // nothing's here... do nothing...
        if ( empty ($posted_data) || !isset($_POST['_wpcf7'])) {
            return $cf7;
        }

        $form_id = $_POST['_wpcf7'];

        // 問い合わせフォームにあわせてカスタマイズする
        if($form_id==7) {
            $array = array(
            'company_name'=>$posted_data['company_name'],
            'company_name_kana'=>$posted_data['company_name_kana'],
            'company_id'=>$posted_data['company_id'],
            'owner_name'=>$posted_data['owner_name'],
            'zip'=>$posted_data['zip'],
            'pref'=>$posted_data['pref'],
            'city'=>$posted_data['city'],
            'tel_number'=>$posted_data['tel_number'],
            'fax_number'=>$posted_data['fax_number'],
            'hp_url'=>$posted_data['hp_url'],
            'biz_outline'=>$posted_data['biz_outline'],
            'dept_name'=>$posted_data['dept_name'],
            'your_name'=>$posted_data['your_name'],
            'tel_number2'=>$posted_data['tel_number2'],
            'your_email'=>$posted_data['your_email'],
            'employees_number'=>$posted_data['employees_number'],
            'employees_number2'=>$posted_data['employees_number2'],
            'kurumin_type1'=>$posted_data['kurumin_type1'],
            'kurumin1_date'=>$posted_data['kurumin1_date'],
            'kurumin_type2'=>$posted_data['kurumin_type2'],
            'kurumin2_date'=>$posted_data['kurumin2_date']
            );

            require_once 'modules/database.inc';
            $db_obj = new database();

            // 新規申請で申請済の会社から
            $result = $db_obj->checkCompanyInfo($array);
            $count = $result['cnt'];
            if($count>0) {
error_log("【登録済み】");

                // メール送信抑止
                add_filter( 'wpcf7_skip_mail',  '__return_true' );
                return $cf7;
            }

            $db_obj->createNewApplication($array);
        }
    }
    return $cf7 ;

}
add_action('wpcf7_before_send_mail', 'my_wpcf7_before_send_mail');



/*
 * 投稿ボタンをクリックされた時に呼び出される
 */
function my_wpcf7_posted_data( $posted_data) {
error_log('=== my_wpcf7_posted_data');
    if ( empty ($posted_data) || !isset($_POST['_wpcf7'])) {
error_log('=== my_wpcf7_posted_data【posted_data empty】');
        return $posted_data;
    }
    $form_id = $_POST['_wpcf7'];

    // 問い合わせフォームにあわせてカスタマイズする
    if($form_id==7) {
        if(empty($posted_data['company_name']) || empty($posted_data['company_name_kana']) || empty($posted_data['company_id'])) {
            // メール送信抑止
            add_filter( 'wpcf7_skip_mail',  '__return_true' );
            return $posted_data;

        }

        $array = array(
            'company_name'=>$posted_data['company_name'],
            'company_name_kana'=>$posted_data['company_name_kana'],
            'company_id'=>$posted_data['company_id']
        );
        require_once 'modules/database.inc';
        $db_obj = new database();

        // 新規申請で申請済の会社から
        $result = $db_obj->checkCompanyInfo($array);
        $count = $result['cnt'];
        if($count>0) {
            error_log("【登録済み】");


            // $contact_form = WPCF7_ContactForm::get_current();
        	// $tags         = $contact_form->scan_form_tags();
            //
        	// foreach ( $tags as $tag ) {
        	// 	$field = $tag['name'];
            //     error_log('【'.$field.'】');
            //
            //     if($field==='company_name') {
            //     	unset( $posted_data[ $field ] );
        	// 		$posted_data[ $field ] = array( '' );
            //     }
        	// }

            // $posted_data['company_name'] = array( '' );
            // $posted_data['company_name_kana'] = array( '' );
            // $posted_data['company_id'] = array( '' );


            $posted_data['company_name'] = '';
            $posted_data['company_name_kana'] = '';
            $posted_data['company_id'] = '';

            $_POST['company_name'] = '';
            $_POST['company_name_kana'] = '';
            $_POST['company_id'] = '';
            return $posted_data;
        }
    }
    return $posted_data ;
}
add_action('wpcf7_posted_data', 'my_wpcf7_posted_data');


function my_user_register_valid($errors) {
    error_log('=== my_user_register_valid');
    $custom_error = new WP_Error();
    // foreach ( $errors -> errors as $key => $val ) {
    //     $tmp = str_replace($rep1,$rep2,$val[0]);
    //     $custom_error -> add($key, $tmp);
    // }
    return $custom_error;
}
add_filter( 'registration_errors', 'my_user_register_valid', 10 );



function my_wpcf7_submit( $cf7) {
error_log('=== my_wpcf7_submit');
    return $cf7;
}
add_action('wpcf7_submit', 'my_wpcf7_submit');


function my_wpcf7_save_contact_form( $cf7) {
error_log('=== my_wpcf7_save_contact_form');
    return $cf7;
}
add_action('wpcf7_save_contact_form', 'my_wpcf7_save_contact_form');


function my_wpcf7_post_edit_form_tag( $cf7) {
error_log('=== my_wpcf7_post_edit_form_tag');
    return $cf7;
}
add_action('wpcf7_post_edit_form_tag', 'my_wpcf7_post_edit_form_tag');


function my_wpcf7_mail_sent( $cf7) {
error_log('=== my_wpcf7_mail_sent');
    return $cf7;
}
add_action('wpcf7_mail_sent', 'my_wpcf7_mail_sent');


function my_wpcf7_mail_failed( $cf7) {
error_log('=== my_wpcf7_mail_failed');
    return $cf7;
}
add_action('wpcf7_mail_failed', 'my_wpcf7_mail_failed');


function my_wpcf7_init( $cf7) {
error_log('=== my_wpcf7_init');
    return $cf7;
}
add_action('wpcf7_init', 'my_wpcf7_init');


function my_wpcf7_contact_form( $cf7) {
error_log('=== my_wpcf7_contact_form');
    return $cf7;
}
add_action('wpcf7_contact_form', 'my_wpcf7_contact_form');


function my_wpcf7_config_validator_validate( $cf7) {
error_log('=== my_wpcf7_config_validator_validate');
    return $cf7;
}
add_action('wpcf7_config_validator_validate', 'my_wpcf7_config_validator_validate');


function my_wpcf7_after_save( $cf7) {
error_log('=== my_wpcf7_after_save');
    return $cf7;
}
add_action('wpcf7_after_save', 'my_wpcf7_after_save');


function my_wpcf7_after_update( $cf7) {
error_log('=== my_wpcf7_after_update');
    return $cf7;
}
add_action('wpcf7_after_update', 'my_wpcf7_after_update');


function wpcf7_after_create( $cf7) {
error_log('=== wpcf7_after_create');
    return $cf7;
}
add_action('wpcf7_after_create', 'my_wpcf7_after_create');






//お問い合わせフォームの送信後にサンクスページへ飛ばす
add_action( 'wp_footer', 'add_thanks_page' );
function add_thanks_page() {

/*
echo <<< EOD
 <script>
document.addEventListener( 'wpcf7mailsent', function( event ) {
 location = 'http://localhost/kurumin/application_form_thanks/'; // 遷移先のURL
}, false );
</script>
EOD;
*/
}


add_action( 'wpcf7submit', 'check_input' );
function check_input() {
    error_log("【check_input】");
}
?>
