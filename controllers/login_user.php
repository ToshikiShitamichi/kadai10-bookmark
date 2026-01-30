<?php
session_start();

include("../models/User.php");
$userModel = new User();

//データ取得
$uMail = $_POST["uMail"];
$password = $_POST["password"];

// SQL実行
$record = $userModel->getUser($uMail);

// 同一メールアドレスのレコードが存在しない場合
if (!$record) {
    // 入力された情報を保持
    $_SESSION['old'] = ['uMail' => $uMail];
    // エラーメッセージを登録
    $_SESSION['errors'] = ['uMail' => 'メールアドレスが正しくありません'];
    // サインイン画面再表示
    header("Location:sign_in.php");
    exit();
}

// パスワードが一致しない
if (!password_verify($password, $record["password"])) {
    // 入力された情報を保持
    $_SESSION['old'] = ['uMail' => $uMail];
    // エラーメッセージを登録
    $_SESSION['errors'] = ['password' => 'パスワードが正しくありません'];
    // サインイン画面再表示
    header("Location:sign_in.php");
    exit();
}

// サインインユーザー情報を保持
$_SESSION['session_id'] = session_id();
$_SESSION['user'] = [
    'uId' => $record['uId'],
    'uName' => $record['uName'],
    'uMail' => $record['uMail'],
    'is_admin' => $record['is_admin']
];

// ホーム画面に遷移
header("Location:../views/home.php");
exit();
