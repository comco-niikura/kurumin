<?php
/* Template Name: 管理者メニュー
*/
?>
<?php get_header(); ?>
<?php
    // TODO　header.phpで取得しているので、本来ならばこの処理は不要のはず
    $login_id = $_SESSION['login_id'];
?>
<?php if (!isset($login_id)) { ?>
// ログインしてない
<main>
ログインしていないのでアクセスできません。<br/><br/>
<a href="<?php echo esc_url( home_url() ); ?>/admin/admin_login/">ログイン</a>
</main>
<?php } else {
?>
<main>
    <div class="content">
        管理者メニュー
        <div class="d-flex flex-row justify-content-between flex-wrap">
            <div class="form_item flexiblebox">
                <a href="<?php echo esc_url( home_url() ); ?>/admin/admin_company_list/">申請者一覧</a>
            </div>
            <div class="form_item flexiblebox">
                <a href="">〇〇〇</a>
            </div>
            <div class="form_item flexiblebox">
                <a href="">〇〇〇</a>
            </div>
        </div>
    </div>
</main>
<?php } ?>
<?php get_footer(); ?>
