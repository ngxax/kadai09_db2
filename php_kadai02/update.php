<?php
//1. POSTデータ取得
$name       = $_POST["name"];
$email      = $_POST["email"];
$select_day = $_POST["select_day"];
$memo       = $_POST["memo"];
$id         = $_POST["id"];

//2. DB接続（関数化された関数を使用）
include("funcs.php");
$pdo = db_conn();

//3. データ更新SQL作成
$sql = "UPDATE gs_participants_table 
        SET name=:name, email=:email, select_day=:select_day, memo=:memo 
        WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',   $name,   PDO::PARAM_STR);   // nameは文字列
$stmt->bindValue(':email',  $email,  PDO::PARAM_STR);   // emailも文字列
$stmt->bindValue(':select_day', $select_day, PDO::PARAM_STR); // select_dayも文字列
$stmt->bindValue(':memo',   $memo,   PDO::PARAM_STR);   // memoも文字列
$stmt->bindValue(':id',     $id,     PDO::PARAM_INT);   // idは整数

// 実行処理
$status = $stmt->execute();

//4. データ登録処理後
if($status == false){
    // SQLエラー時の処理
    sql_error($stmt);
} else {
    // 成功時にリダイレクト
    redirect("select.php");
}
?>
