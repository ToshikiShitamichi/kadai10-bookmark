<?php
session_start();

include("../models/User.php");
$userModel = new User();

// サインインユーザー情報を取得
$uId = $_SESSION['user']['uId'];

// SQL実行
$userModel->deleteUser($uId);

$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();

// トップ画面に遷移
header("Location:../index.html");
exit();
