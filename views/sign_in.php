<?php
session_start();

$old = $_SESSION['old'] ?? ['uMail' => ''];
$errors = $_SESSION['errors'] ?? [];

// 取得したセッションのクリア
unset($_SESSION['old'], $_SESSION['errors']);

include("../views/header.php");
?>

<div class="signin-container">
    <h2 class="signin-title">サインイン</h2>
    <form class="signin-form" action="../controllers/login_user.php" method="post">
        <div>
            <input type="email" name="uMail" id="uMail" placeholder="メールアドレス" required value="<?= $old["uMail"] ?>">
            <!-- エラーメッセージが登録されていれば表示 -->
            <?php if (!empty($errors['uMail'])): ?>
                <span class="err-msg">
                    <?= $errors['uMail'] ?>
                </span>
            <?php endif; ?>
        </div>
        <div>
            <input type="password" name="password" id="password" placeholder="パスワード" required>
            <!-- エラーメッセージが登録されていれば表示 -->
            <?php if (!empty($errors['password'])): ?>
                <span class="err-msg">
                    <?= $errors['password'] ?>
                </span>
            <?php endif; ?>
        </div>
        <button class="signin-btn">サインイン</button>
    </form>
    <hr>
    <div class="signin-btn-group">
        <a class="signin-btn">Googleで続ける</a>
        <a class="signin-btn">GitHubで続ける</a>
    </div>
    <span>アカウントをお持ちでないですか？<a href="../views/sign_up.php">アカウントを作成</a></span>
</div>
</body>

</html>