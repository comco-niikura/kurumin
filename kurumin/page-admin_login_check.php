<?php
/* Template Name: 管理者ログインチェック
*/
?>
<?php
    $count = 0;
    require_once 'modules/common.inc';
    $post = sanitize($_POST);
    $login_id = $post["login_id"];
    $password = $post["password"];
    if(isset($login_id) && isset($password)) {
        require_once 'modules/database.inc';
        $db_obj = new database();

        $result = $db_obj->checkLogin($login_id, $password);
        $count = $result['cnt'];
    }
    if ($count==0) { ?>
        <?php get_header(); ?>
        <main class="main">
		<div class="content">
			IDもしくはパスワードが間違っています<br />
			<form>
				<input type="button" onclick="history.back()" value="戻る">
			</form>
		</div>
        </main>
        <?php get_footer(); ?>
    <?php } else {
        // ログイン成功
        $_SESSION['login_id'] = $login_id;
        header( "location: " . home_url() . "/admin/admin_menu/");
    }
?>
