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

    public function createUser($firebase_uid, $email, $display_name, $photo_url, $provider)
    {
        $sql = 'INSERT INTO users(firebase_uid, email, display_name, photo_url, last_provider) VALUES (:firebase_uid,:email,:display_name,:photo_url,:provider) ON DUPLICATE KEY UPDATE email = VALUES(email), display_name = VALUES(display_name), photo_url = VALUES(photo_url), last_provider = VALUES(last_provider)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':firebase_uid', $firebase_uid, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':display_name', $display_name, PDO::PARAM_STR);
        $stmt->bindValue(':photo_url', $photo_url, PDO::PARAM_STR);
        $stmt->bindValue(':provider', $provider, PDO::PARAM_STR);
        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
    }

    // 
    // 旧コード
    // 

    // 作成時同一アドレス検出
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

    // 更新時同一アドレス検出
    public function sameAddressUser($uId, $uMail)
    {
        $sql = 'SELECT count(*) as count FROM users_table WHERE uMail = :uMail AND uId != :uId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uId', $uId, PDO::PARAM_INT);
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
    public function updateUser($uId, $uName, $uMail)
    {
        $sql = 'UPDATE users_table SET uName = :uName, uMail = :uMail, updated_at = now() WHERE uId = :uId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uId', $uId, PDO::PARAM_INT);
        $stmt->bindValue(':uName', $uName, PDO::PARAM_STR);
        $stmt->bindValue(':uMail', $uMail, PDO::PARAM_STR);
        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
    }

    // 削除
    public function deleteUser($uId)
    {
        $sql = 'UPDATE users_table SET deleted_at = now() WHERE uId = :uId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uId', $uId, PDO::PARAM_INT);
        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
    }
}

?>
<script type="module" src="../firebase.js"></script>