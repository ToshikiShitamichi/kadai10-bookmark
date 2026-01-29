<?php
session_start();
include("./pdo.php");

if (isset($_SESSION["session_id"]) && $_SESSION["session_id"] === session_id()) {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
    header('Location:home.php');
    exit();
}

// POSTリクエストが来たとき
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //データ取得
    $uName = $_POST["uName"];
    $uMail = $_POST["uMail"];
    $raw_password = $_POST["password"];

    // SQL実行
    $sql = '
SELECT
count(*) as count
FROM
users_table
WHERE
uMail = :uMail
';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uMail', $uMail, PDO::PARAM_STR);
    try {
        $status = $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    // 同一メールアドレスのレコード件数
    if ($record["count"] === 1) {
        // 入力された情報を保持
        $_SESSION['old'] = [
            'uName' => $uName,
            'uMail' => $uMail,
        ];
        // エラーメッセージを登録
        $_SESSION['errors'] = [
            'uMail' => 'このメールアドレスはすでに登録されています。',
        ];
        // サインアップ画面再表示
        header("Location:sign_up.php");
        exit();
    }

    // パスワードのハッシュ化
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // SQL実行
    $sql = '
INSERT INTO users_table(
    uId,
    uName,
    uMail,
    password,
    is_admin,
    created_at,
    updated_at,
    deleted_at
)
VALUES(
    NULL,
    :uName,
    :uMail,
    :password,
    0,
    now(),
    now(),
    NULL
)
';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uName', $uName, PDO::PARAM_STR);
    $stmt->bindValue(':uMail', $uMail, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
    try {
        $status = $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }

    // SQL実行
    $sql = '
SELECT
    *
FROM
    users_table
WHERE
    uMail = :uMail
AND
    deleted_at is NULL
';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uMail', $uMail, PDO::PARAM_STR);
    try {
        $status = $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    // サインインユーザー情報を保持
    $_SESSION['session_id'] = session_id();
    $_SESSION['user'] = [
        'uId' => $record['uId'],
        'uName' => $record['uName'],
        'uMail' => $record['uMail'],
        'is_admin' => $record['is_admin']
    ];

    // ホーム画面に遷移
    header("Location:home.php");
    exit();
}

?>

