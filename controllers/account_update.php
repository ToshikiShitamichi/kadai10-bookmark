<?php
session_start();

include("../models/User.php");
$userModel = new User();

// サインインユーザー情報を取得
$uId = $_SESSION['user']['uId'];

//データ取得
$uName = $_POST["uName"];
$uMail = $_POST["uMail"];

// SQL実行
$userModel->sameAddressUser($uId, $uMail);

// 同一メールアドレスのレコードが存在する場合
if ($record["count"] === 1) {
    // 入力された情報を保持
    $_SESSION['old'] = [
        'uName' => $uName,
        'uMail' => $uMail,
    ];
    // エラーメッセージを登録
    $_SESSION['errors'] = [
        'uMail' => 'このメールアドレスはすでに使用されています。',
    ];
    // アカウント設定画面再表示
    header("Location:../views/account_update.php");
    exit();
}

// SQL実行
$userModel->updateUser($uId, $uName, $uMail);


// サインインユーザー情報を更新
$_SESSION['user']['uName'] = $uName;
$_SESSION['user']['uMail'] = $uMail;

// サクセスメッセージを登録
$_SESSION['success'] = 'アカウント情報を更新しました';

header("Location:../views/account_setting.php");
exit();
