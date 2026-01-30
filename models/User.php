<?php
session_start();
include("../functions.php");

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = connect_db();
    }

    // 同一アドレス検出
    public function countUser($uMail)
    {
        $sql = 'SELECT count(*) as count FROM users_table WHERE uMail = :uMail';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uMail', $uMail, PDO::PARAM_STR);
        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record;
    }

    // 新規登録(メール)
    public function createUserMail($uName, $uMail, $hashed_password)
    {
        $sql = 'INSERT INTO users_table(uId,uName,uMail,password,is_admin,created_at,updated_at,deleted_at)VALUES(NULL,:uName,:uMail,:password,0,now(),now(),NULL)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uName', $uName, PDO::PARAM_STR);
        $stmt->bindValue(':uMail', $uMail, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
    }

    // 新規登録(Google)
    public function createUserGoogle() {}

    // 新規登録(GitHub)
    public function createUserGithub() {}

    // サインイン(メール)
    public function loginUserMail() {}

    // サインイン(Google)
    public function loginUserGoogle() {}

    // サインイン(GitHub)
    public function loginUserGithub() {}

    // 表示
    public function getUser($uMail)
    {
        $sql = 'SELECT * FROM users_table WHERE uMail = :uMail AND deleted_at is NULL';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uMail', $uMail, PDO::PARAM_STR);
        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record;
    }

    // 更新
    public function updateUser() {}

    // 削除
    public function deleteUser() {}
}

?>
<script type="module" src="../firebase.js"></script>