<?php
include("./functions.php");

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = connect_db();
    }

    // 新規登録(メール)
    public function createUserMail() {}

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
    public function getUser() {}

    // 更新
    public function updateUser() {}

    // 削除
    public function deleteUser() {}
}

?>
<script type="module" src="../firebase.js"></script>