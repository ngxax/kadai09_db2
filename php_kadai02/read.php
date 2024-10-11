<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="read.css" type="text/css">
    <title>ユーザーリスト</title>
</head>
<body>

<div class="container">
    <h1>参加者リスト</h1>
    <table>
        <thead>
            <tr>
                <th>名前</th>
                <th>Email</th>
                <th>参加希望日</th>
                <th>メモ</th>
            </tr>
        </thead>
        <tbody>

        <?php
        // 読み込み対象のファイルパス
        $file_path = "data.csv";

        // ファイルが存在するか確認
        if (file_exists($file_path)) {
            // ファイルを読み込みモードで開く ("r"モード)
            $file = fopen($file_path, "r");

            // ファイルが正常に開けたかどうかを確認
            if ($file) {
                // ファイルを1行ずつ読み込んでテーブルに出力
                while (($line = fgets($file)) !== false) {
                    // カンマで分割
                    $data = explode(",", $line);
                    // データが4列あるか確認
                    if (count($data) == 4) {
                        $name = htmlspecialchars(trim($data[0]), ENT_QUOTES, 'UTF-8');
                        $email = htmlspecialchars(trim($data[1]), ENT_QUOTES, 'UTF-8');
                        $select_day = htmlspecialchars(trim($data[2]), ENT_QUOTES, 'UTF-8');
                        $memo = htmlspecialchars(trim($data[3]), ENT_QUOTES, 'UTF-8');
                        echo "<tr>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$email}</td>";
                        echo "<td>{$select_day}</td>";
                        echo "<td>{$memo}</td>";
                        echo "</tr>";
                    }
                }
                // ファイルを閉じる
                fclose($file);
            } else {
                echo "<tr><td colspan='4'>エラー: ファイルを開くことができませんでした。</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>エラー: ファイルが見つかりません。</td></tr>";
        }
        ?>

        </tbody>
    </table>

    <button onclick="location.href='index.php';">ホームに戻る</button>
</div>

</body>
</html>
