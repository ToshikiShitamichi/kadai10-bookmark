<?php
session_start();

if (isset($_SESSION["session_id"]) && $_SESSION["session_id"] === session_id()) {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
    header('Location:home.php');
    exit();
}

include("../models/User.php");
$userModel = new User();

//データ取得
$uName = $_POST["uName"];
$uMail = $_POST["uMail"];
$raw_password = $_POST["password"];

// SQL実行
$record = $userModel->countUser($uMail);

// 同一メールアドレスのレコード件数
if ($record["count"] === 1) {
    // 入力された情報を保持
    $_SESSION['old'] = [
        'uName' => $uName,
        'uMail' => $uMail,
    ];
    // エラーメッセージを登録
    $_SESSION['errors'] = [
        'uMail' => 'このメールアドレスはすでに登録されています。',
    ];
    // サインアップ画面再表示
    header("Location:./sign_up.php");
    exit();
}

// パスワードのハッシュ化
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// SQL実行
$userModel->createUserMail($uName, $uMail, $hashed_password);

// SQL実行
$record = $userModel->getUser($uMail);

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
