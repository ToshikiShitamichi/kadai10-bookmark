<?php
session_start();
include("../functions.php");

check_session_id();

$old = $_SESSION['old'] ?? ['uName' => '', 'uMail' => ''];
$errors = $_SESSION['errors'] ?? [];

// 取得したセッションのクリア
unset($_SESSION['old'], $_SESSION['errors']);

include("../views/header.php");
?>

<div class="account-setting-container">
    <h2 class="account-setting-title">アカウント削除</h2>
    <form class="account-setting-form" action="../controllers/account_delete.php" method="post">
        <p style="color: red;">アカウントを削除すると、これまでのデータはすべて削除されます</p>
        <button style="color:white; background-color: red;" class="account-setting-btn">削除</button>
        <a href="./account_setting.php" class="account-setting-btn" style="color:black; text-decoration: none;">キャンセル</a>
    </form>
</div>
</body>

</html>