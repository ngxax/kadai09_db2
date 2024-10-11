<?php
$message = ""; // メッセージ変数を初期化

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // POSTデータを取得
    $name  = $_POST["name"];
    $email = $_POST["email"];
    $select_day = $_POST["select_day"]; // ラジオボタンで選択した参加日を取得
    $memo  = $_POST["memo"];

    // CSVに保存するための形式に変換
    $c     = ",";
    $str = $name . $c . $email . $c . $select_day . $c . $memo;

    // data.csvファイルを追記モードで開く
    $file = fopen("data.csv", "a");

    // ファイルに書き込む処理
    if ($file) {
        fwrite($file, $str . "\n");
        fclose($file);
        // 成功メッセージを設定
        $message = "お申し込みありがとうございます！<br><br>

        当日、予定時刻になりましたら、以下のリンクよりお入りください。<br>
        ※zoomにて実施します<br>
        ※音声とビデオはオンにできる状態でご参加ください<br><br>

        <a href='https://us06web.zoom.us/j/000000000?pwd=guZGaarDLBCIrrFZbKOHL1bmOuwY7z.1&omn=81152522237' target='_blank'>Zoomミーティングリンク</a><br>
        ミーティングID: 000 000 000<br>
        パスコード: 000000<br><br>

        お会いできることを楽しみにしています。<br><br>

        -----------------------------------<br>
        ソーシャルファーム支援プロジェクト<br>
        代表 永井愛梨<br>
        TEL 080-0000-0000<br>
        Mail <a href='mailto:socialfirm.lab24@gmail.com'>socialfirm.lab24@gmail.com</a><br>
        -----------------------------------";
    } else {
        // エラーメッセージを設定
        $message = "エラーが発生しました。もう一度お試しください。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>ソーシャル交流会　参加フォーム</title>
</head>
<body>

<div class="container">
<h2>【U25】ソーシャル交流会</h2>
<h1> 参加フォーム</h1>
    
    <!-- メッセージを表示 -->
    <?php if (!empty($message)): ?>
        <div class="message-box"><?php echo $message; ?></div>
    <?php endif; ?>

    </form>
</div>

</body>
</html>
