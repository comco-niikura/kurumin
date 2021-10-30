<?php get_header(); ?>
<main>
    <div class="content">
        <form action="/kurumin/admin/admin_login_check/" method="post">
            <table><tbody>
                <tr>
                    <td>ログインID</td><td><input type="text" name="login_id"></td>
                </tr>
                <tr>
                    <td>パスワード</td><td><input type="password" name="password"></td>
                </tr>
            </tbody></table>
            <button type="submit">ログイン</button>
        </form>
    </div>
</main>
<?php get_footer(); ?>
