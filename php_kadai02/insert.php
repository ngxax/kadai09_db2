<?php
//1. POSTデータ取得
$name       = $_POST["name"];
$email      = $_POST["email"];
$select_day = $_POST["select_day"];
$memo       = $_POST["memo"];

//2. DB接続
try {
    //データベース接続設定（MAMPではパスワードが 'root', XAMPPではパスワードなし）
    $pdo = new PDO('mysql:dbname=socialfirm-lab_participants;charset=utf8;host=', '', '');
    // $pdo = new PDO('mysql:dbname=gs_participants_db;charset=utf8;host=localhost', 'root', '');

} catch (PDOException $e) {
    exit('DB_CONNECT_ERROR:'.$e->getMessage());
}

//3. データ登録SQL作成
$sql = "INSERT INTO gs_participants_table (name, email, select_day, memo, indate) 
        VALUES (:name, :email, :select_day, :memo, sysdate());";
$stmt = $pdo->prepare($sql);

// データバインド（クリーニング処理）
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':select_day', $select_day, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);

// SQL実行
$status = $stmt->execute();

//4. データ登録処理後
if ($status == false) {
    // SQLエラーがあればエラーメッセージを表示
    $error = $stmt->errorInfo();
    exit("SQL_ERROR: " . $error[2]);
} else {
    // 登録が成功した場合、index.phpへリダイレクト
    header("Location: index.php");
    exit();
}
?>
