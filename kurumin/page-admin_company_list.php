<?php
/* Template Name: 申請者一覧
*/
?>
<?php
    // ログインしてなければエラー
    if (!isset($_SESSION['login_id'])) {
        wp_safe_redirect(home_url('admin/admin_login/'));
        exit();
    }
?>
<?php get_header(); ?>
<?php
require_once 'modules/database.inc';
$db_obj = new database();

// 会社一覧取得
$companys = $db_obj->selectCompanyList();

?>
<main>
    <div class="content">

<div class="admin_company_list">
    <h2>申請者一覧</h2>
    <form>
        <div class="search_cond_block">
            <dl><dt>法人番号</dt><dd><input type="text"></dd></dl>
            <dl><dt>会社名</dt><dd><input type="text"></dd></dl>
            <dl><dt>代表電話番号</dt><dd><input type="text"></dd></dl>
            <dl><dt>状況</dt>
                <dd><div class="check_status_block">
                    <span class="check_status"><input type="checkbox" name="status" value="1">申請済</span>
                    <span class="check_status"><input type="checkbox" name="status" value="2">審査中</span>
                    <span class="check_status"><input type="checkbox" name="status" value="3">申請取り消し</span>
                </div></dd>
            </dl>
            <button class="button" type="button">検索</button>
        </div>
    </form>
    <div class="search_cond_block">
        <button class="button" type="button" onclick="location.href='<?php echo esc_url( home_url() ); ?>/admin/admin_application_form/'">新規登録</button>
    </div>

            <table><tbody>
                <tr>
                    <th class="company_id">法人番号</th>
                    <th class="company_name">会社名</th>
                    <th class="company_name_kana">会社名（かな）</th>
                    <th class="owner_name">代表者名</th>
                    <th class="tel_number">代表電話番号</th>
                </tr>

                <?php
                foreach ($companys as $company){
                    $company_id = $company['company_id'];
                    $company_name = $company['company_name'];
                    $company_name_kana = $company['company_name_kana'];
                    $owner_name = $company['owner_name'];
                    $tel_number = $company['tel_number'];
                    ?>
                    <tr class="company_list">
                        <td><?php echo $company_id; ?></td>
                        <td><?php echo $company_name; ?></td>
                        <td><?php echo $company_name_kana; ?></td>
                        <td><?php echo $owner_name; ?></td>
                        <td><?php echo $tel_number; ?></td>
                    </tr>
                    <input type="hidden" name="company_id" value=<?php echo $company_id; ?>>
                <?php } ?>
            </tbody></table>
</div>
<div class="button_block">
    <input type="button" class="back_button" onclick="history.back()" value="戻　る">
</div>
</div>
</main>
<?php get_footer(); ?>
