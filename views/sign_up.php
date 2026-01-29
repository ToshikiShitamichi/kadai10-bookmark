<?php
$old = $_SESSION['old'] ?? ['uName' => '', 'uMail' => ''];
$errors = $_SESSION['errors'] ?? [];

// 取得したセッションのクリア
unset($_SESSION['old'], $_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>事業企画</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="signup-container">
        <h2 class="signup-title">アカウントを作成</h2>
        <form class="signup-form" action="./sign_up.php" method="post">
            <div>
                <input type="text" name="uName" id="uName" placeholder="ユーザー名" required value="<?= $old["uName"] ?>">
            </div>
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
            </div>
            <button class="signup-btn">新規登録</button>
        </form>
        <hr>
        <div class="signup-btn-group">
            <a class="signup-btn">Googleで続ける</a>
            <a class="signup-btn">GitHubで続ける</a>
        </div>
        <span>すでにアカウントをお持ちですか？<a href="./sign_in.php">サインインする</a></span>
    </div>

</body>

</html>