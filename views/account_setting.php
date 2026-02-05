<?php
session_start();
include("../functions.php");

check_session_id();

// サインインユーザー情報を取得
$firebase_uid = $_SESSION["firebase_uid"];
$email = $_SESSION["email"];
$display_name = $_SESSION["display_name"];
$photo_url = $_SESSION["photo_url"];
$provider = $_SESSION["provider"];

include("../views/header.php");
?>

<div class="account-setting-container">
    <h2 class="account-setting-title">アカウント設定</h2>
    <!-- サクセスメッセージが登録されていれば表示 -->
    <span id="success-msg" class="success-msg" style="display: none;"></span>
    <a href="../views/home.php">ホーム画面へ</a>
    <form class="account-setting-form">
        <div>
            <input id="displayName" name="displayName" placeholder="ユーザー名" readonly value="<?= $display_name ?>">
        </div>
        <a href="../views/account_update.php" class="account-setting-btn" style="color:black;background-color:#f0f0f0; text-decoration: none;">編集</a>
    </form>
    <a href="../views/account_delete.php" style="color: red;">アカウントを削除</a>
</div>

<!-- jQuery読み込み -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="module" src="../assets/js/firebase.js"></script>
</body>

</html>