<?php
session_start();

include("../models/User.php");
$userModel = new User();

//データ取得
$firebase_uid = $_POST["firebase_uid"];
$email = $_POST["email"];
$display_name = $_POST["display_name"];
$photo_url = $_POST["photo_url"];
$provider = $_POST["provider"];

// SQL実行
$userModel->createUser($firebase_uid, $email, $display_name, $photo_url, $provider);

// サインインユーザー情報を保持
$_SESSION["session_id"]    = session_id();
$_SESSION["firebase_uid"]  = $firebase_uid;
$_SESSION["email"]         = $email;
$_SESSION["display_name"]  = $display_name;
$_SESSION["photo_url"]     = $photo_url;
$_SESSION["provider"]      = $provider;

header("Location:../views/account_setting.php");
exit();
