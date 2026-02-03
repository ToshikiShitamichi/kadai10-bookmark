<?php
session_start();
if (isset($_SESSION["session_id"]) && $_SESSION["session_id"] === session_id()) {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
    header("Location:../views/home.php");
    exit();
}
include("../views/header.php");
?>

<div class="signup-container">
    <h2 class="signup-title">アカウントを作成</h2>
    <!-- メール/パスワード登録フォーム -->
    <span id="err-mail" class="err-msg" style="display: none;">すでに登録されているか、別の方法でログイン済みです。</span>
    <form class="signup-form" id="mailSignUpForm">
        <div>
            <input id="displayName" name="displayName" placeholder="ユーザー名" required>
        </div>
        <div>
            <input id="email" name="email" placeholder="メールアドレス" type="email" required>

        </div>
        <div>
            <input id="password" name="password" placeholder="パスワード（6文字以上）" type="password" required>
        </div>
        <button class="signup-btn" type="submit">新規登録</button>
    </form>
    <hr>
    <div class="signup-btn-group">
        <a class="signup-btn" id="btnGoogle">Googleで続ける</a>
        <a class="signup-btn" id="btnGithub">GitHubで続ける</a>
    </div>
    <span>すでにアカウントをお持ちですか？<a href="../views/sign_in.php">サインインする</a></span>

    <!-- PHPに送る用hiddenフォーム -->
    <form id="postToPhpForm" action="../controllers/sign_up.php" method="post" style="display:none;">
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