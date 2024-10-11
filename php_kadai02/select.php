<?php
// 1. DB接続
try {
    // $pdo = new PDO('mysql:dbname=gs_participants_db;charset=utf8;host=localhost', 'root', ''); // DB接続設定を確認
    $pdo = new PDO('mysql:dbname=socialfirm-lab_participants;charset=utf8;host=','','');

} catch (PDOException $e) {
    exit('DB_CONNECT: ' . $e->getMessage());
}

// 2. 参加者リストを取得するSQL作成
$sql = "SELECT * FROM gs_participants_table"; // 適切なテーブル名を使用
$stmt = $pdo->query($sql);
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. select_dayデータを集計するSQL作成
$sql = "SELECT select_day, COUNT(*) as count FROM gs_participants_table GROUP BY select_day";
$stmt = $pdo->query($sql);
$select_day_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4. JSONデータのエンコード
$json_participants = json_encode($participants, JSON_UNESCAPED_UNICODE);
$json_select_day_data = json_encode($select_day_data, JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーリストとグラフ</title>
    <style>
        /* 全体のスタイル */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fffbea;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff7cc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ffbf00;
            font-size: 2em;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #ffdb4d;
            color: #333;
            font-weight: bold;
        }

        td {
            background-color: #fff7cc;
        }

        tr:nth-child(even) td {
            background-color: #fff2b3;
        }

        tr:hover td {
            background-color: #ffee99;
        }

        /* ボタンスタイル */
        .button {
            display: block;
            width: 220px;
            padding: 12px;
            margin: 20px auto;
            background-color: #ffbf00;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            background-color: #e6ac00;
            transform: scale(1.05); /* ボタンの拡大効果 */
        }

        .button:active {
            transform: scale(0.95); /* 押下時の縮小効果 */
        }

        /* レスポンシブ対応 */
        @media screen and (max-width: 768px) {
            .container {
                width: 95%;
                margin: 30px auto;
                padding: 15px;
            }

            h1 {
                font-size: 1.5em;
            }

            th, td {
                padding: 10px;
                font-size: 0.9em;
            }

            .button {
                width: 180px;
                padding: 10px;
                font-size: 1em;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                width: 100%;
                margin: 20px auto;
                padding: 10px;
            }

            h1 {
                font-size: 1.2em;
            }

            table, th, td {
                font-size: 0.8em;
            }

            th, td {
                padding: 8px;
            }

            .button {
                width: 160px;
                padding: 8px;
                font-size: 0.9em;
            }
        }

        /* グラフ用のスタイル */
        #barchart {
            width: 100%;
            height: 400px; /* 高さを固定 */
            min-height: 300px; /* 最小高さを設定 */
        }
    </style>
    <!-- Google Chartsのロード -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Google Chartsを読み込む
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            const jsonData = <?= $json_select_day_data ?>;

            // グラフのデータフォーマットに変換
            var dataArray = [['参加希望日', '人数']];
            jsonData.forEach(function(row) {
                dataArray.push([row['select_day'], parseInt(row['count'])]);
            });

            var data = google.visualization.arrayToDataTable(dataArray);

            // グラフのオプションを設定
            var options = {
                title: '参加希望日別の人数',
                chartArea: {width: '50%'},
                hAxis: {
                    title: '人数',
                    minValue: 0
                },
                vAxis: {
                    title: '参加希望日'
                }
            };

            // グラフを描画
            var chart = new google.visualization.BarChart(document.getElementById('barchart'));
            chart.draw(data, options);
        }

        // ウィンドウサイズ変更時にグラフを再描画
        window.onresize = function() {
            drawChart();
        };
    </script>
</head>

<body>
    <div class="container">
        <h1>参加者リスト</h1>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>名前</th>
                    <th>Email</th>
                    <th>参加希望日</th>
                    <th>メモ</th>
                    <th>申し込み日</th>
                    <th>更新</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($participants as $value) { ?>
                <tr>
                    <td><?= htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($value["name"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($value["email"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($value["select_day"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($value["memo"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($value["indate"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><a href="detail.php?id=<?= htmlspecialchars($value['id'], ENT_QUOTES, 'UTF-8') ?>"><img src="./img/koshin.png" alt="" width="15px"></a></td>
                    <td><a href="delete.php?id=<?= htmlspecialchars($value['id'], ENT_QUOTES, 'UTF-8') ?>"><img src="./img/dustbox.png" alt="" width="15px"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <h1>参加希望日別の参加者数</h1>
        <div id="barchart"></div>

        <a href="index.php" class="button">ホームに戻る</a>
    </div>

    <script>
        const jsonParticipants = '<?= $json_participants ?>';
        const obj = JSON.parse(jsonParticipants);
        console.log(obj);
    </script>
</body>
</html>
