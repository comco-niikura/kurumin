<?php
/* Template Name: 申請者詳細
*/
?>
<?php
    // ログインしてなければエラー
    if (!isset($_SESSION['login_id'])) {
        wp_safe_redirect(home_url('admin/admin_login/'));
        exit();
    }

    if(!isset( $_POST['company_id'])) {
        // エラー
        wp_safe_redirect(home_url('admin/admin_login/'));
        exit();
    }
?>
<?php get_header(); ?>
<?php
    if (!isset($_SESSION['login_id'])) {
        wp_safe_redirect(home_url());
        exit();
    }

    if(!isset( $_POST['company_id'])) {
        // エラー
        wp_safe_redirect(home_url());
        exit();
    }
    $company_id = $_POST['company_id'];
    require_once 'modules/database.inc';
    $db_obj = new database();

    // 会社詳細取得
    $company = $db_obj->selectCompany($company_id);
?>

<main>
    <div class="content">
        <form action="" method="post" onsubmit="return approval()">
        <div class="admin_corp_detail">
            <h2>申請者詳細</h2>
            <table class="corp_detail"><tbody>
                 <tr>
                     <th>法人番号</th>
                     <td><?php echo $company['company_id']; ?></td>
                 </tr>
                <tr>
                    <th>事業主</th>
                    <td><?php echo $company['company_name']; ?></td>
                </tr>
                <tr>
                    <th>代表者名</th>
                    <td><?php echo $company['owner_name']; ?></td>
                </tr>
                <tr>
                    <th>代表電話番号</th>
                    <td><?php echo $company['tel_number']; ?></td>
                </tr>
                <tr>
                    <th>所在地</th>
                    <td><?php echo $company['pref'].$company['city']; ?></td>
                </tr>
                <tr>
                    <th>申請状況</th>
                    <td>申請承認中</td>
                </tr>
                <tr>
                    <th>承認状態</th>
                    <td>承認済み：担当Ａ、担当Ｂ</td>
                </tr>
            </tbody></table>
        </div>
        <div class="button_block">
            <input type="submit" class="button approval_button approval_button" value="承認する">
<!--
            <input type="button" class="approval_button no_approval_button" value="承認解除する">　<input type="button" class="approval_button no_approval_button" value="確定解除する">
-->
        </div>
        <div class="button_block">
            <input type="button" class="back_button" onclick="history.back()" value="戻　る">
        </div>
    </form>
    </div>
</main>
<?php get_footer(); ?>
