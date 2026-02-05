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
    <h2 class="account-setting-title">アカウント更新</h2>
    <form class="account-setting-form" id="accountUpdateForm">
        <div>
            <input type="text" name="display_name" id="display_name" placeholder="ユーザー名" required value="<?= $display_name ?>">
        </div>
        <button class="account-setting-btn" type="submit">更新</button>
    </form>
    <a href="../views/account_setting.php">戻る</a>

    <!-- PHPに送る用hiddenフォーム -->
    <form id="postToPhpForm" action="../controllers/account_update.php" method="post" style="display:none;">
        <input type="hidden" name="firebase_uid" id="firebase_uid">
        <input type="hidden" name="email" id="post_email">
        <input type="hidden" name="display_name" id="post_display_name">
        <input type="hidden" name="photo_url" id="post_photo_url">
        <input type="hidden" name="provider" id="post_provider">
    </form>
</div>

<!-- jQuery読み込み -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="module" src="../assets/js/firebase.js"></script>
</body>

</html>