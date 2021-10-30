<?php
class database{

    //定数の宣言
    const DB_NAME='kurumin';
    const HOST='localhost';
    const UTF='utf8';
    const USER='comco';
    const PASS='mysql';
/*
    const DB_NAME='comco_test';
    const HOST='mysql57.comco.sakura.ne.jp';
    const UTF='utf8';
    const USER='comco';
    const PASS='Star4871-';
*/

    /*
     *
     */
    function pdo(){
        /*phpのバージョンが5.3.6よりも古い場合はcharset=".self::UTFが必要無くなり、array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF')が必要になり、5.3.6以上の場合は必要ないがcharset=".self::UTFは必要になる。*/
        $dsn="mysql:dbname=".self::DB_NAME.";host=".self::HOST.";charset=".self::UTF;
        $user=self::USER;
        $pass=self::PASS;
        try{
            $pdo=new PDO($dsn,$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF, PDO::ATTR_PERSISTENT => true));
        }catch(Exception $e){
            echo 'error:pdo()' .$e->getMesseage;
            die();
        }
        //エラーを表示してくれる。
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /*
     *
     */
    function checkCompanyInfo($array){
        $sql = "SELECT count(*) AS cnt FROM company WHERE company_id=:company_id OR company_name=:company_name OR company_name_kana=:company_name_kana";

        $dbh = $this->pdo();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':company_id'=>$array['company_id'],
            ':company_name'=>$array['company_name'],
            ':company_name_kana'=>$array['company_name_kana']
        ));
        return $stmt->fetch();
    }

    /*
     *
     */
    function createNewApplication($array){
        $sql = "INSERT INTO company(company_id, company_name, company_name_kana, owner_name, zip, pref, city, tel_number, biz_outline)
            values(:company_id, :company_name, :company_name_kana, :owner_name, :zip, :pref, :city, :tel_number, :biz_outline)";

        $dbh = $this->pdo();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':company_id'=>$array['company_id'],
            ':company_name'=>$array['company_name'],
            ':company_name_kana'=>$array['company_name_kana'],
            ':owner_name'=>$array['owner_name'],
            ':zip'=>$array['zip'],
            ':pref'=>$array['pref'],
            ':city'=>$array['city'],
            ':tel_number'=>$array['tel_number'],
            ':biz_outline'=>$array['biz_outline']
        ));
        return $stmt;
    }

    /*
     * ユースケース　UC-B-1
     * ログインID、パスワードがusersテーブルに存在するかチェックする
     */
    function checkLogin($login_id, $password){
        $sql = "SELECT count(*) AS cnt FROM users WHERE login_id=:login_id AND password=:password";

        $dbh = $this->pdo();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':login_id'=>$login_id,
            ':password'=>$password
        ));
        return $stmt->fetch();
    }

    /*
     *
     */
    function selectCompanyList() {
        $sql = "SELECT * FROM company ORDER BY company_name_kana";
        $dbh = $this->pdo();
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*
     *
     */
    function selectCompany($company_id) {
        $sql = "SELECT * FROM company WHERE company_id=:company_id";
        $dbh = $this->pdo();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':company_id'=>$company_id
        ));
        return $stmt->fetch();
    }
}

?>
