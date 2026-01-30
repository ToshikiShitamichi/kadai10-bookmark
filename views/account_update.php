<?php
session_start();
include("../functions.php");

check_session_id();

// サインインユーザー情報を取得
$uId = $_SESSION['user']['uId'];
$uName = $_SESSION['user']['uName'];
$uMail = $_SESSION['user']['uMail'];

// 取得したセッションのクリア
unset($_SESSION['old'], $_SESSION['errors']);

include("../views/header.php");
?>
<div class="account-setting-container">
    <h2 class="account-setting-title">アカウント更新</h2>
    <form class="account-setting-form" action="../controllers/account_update.php" method="post">
        <div>
            <input type="text" name="uName" id="uName" placeholder="ユーザー名" required value="<?= $uName ?>">
        </div>
        <div>
            <input type="email" name="uMail" id="uMail" placeholder="メールアドレス" required value="<?= $uMail ?>">
            <!-- エラーメッセージが登録されていれば表示 -->
            <?php if (!empty($errors['uMail'])): ?>
                <span class="err-msg">
                    <?= $errors['uMail'] ?>
                </span>
            <?php endif; ?>
        </div>
        <button class="account-setting-btn">更新</button>
    </form>
    <a href="../views/account_setting.php">戻る</a>
</div>
</body>

</html>