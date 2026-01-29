<?php

function connect_db()
{
    $dbn = 'mysql:dbname=gs_lab_202601;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';
    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        exit('dbError:' . $e->getMessage());
    }
}

// サインイン状態のチェック関数
function check_session_id()
{
    if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] !== session_id()) {
        header('Location:sign_in.php');
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["session_id"] = session_id();
    }
}

// サインイン状態のチェック関数
function check_admin()
{
    if (!isset($_SESSION["user"]["is_admin"]) || $_SESSION["user"]["is_admin"] !== 1) {
        header('Location:home.php');
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["session_id"] = session_id();
    }
}
