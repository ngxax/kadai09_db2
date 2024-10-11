<?php
$id= $_GET["id"];
// 1. DB接続
include("funcs.php");
$pdo = db_conn();

// 2. データ取得SQL作成
$sql = "SELECT * FROM gs_participants_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  // 数値の場合 PDO::PARAM_INT
$status = $stmt->execute();

// 3. データ表示
if ($status == false) {
    sql_error($stmt);
}

// 全データ取得
$v = $stmt->fetch(); // PDO::FETCH_ASSOC [カラム名のみで取得できるモード]
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>ソーシャル交流会 更新</title>
</head>
<body>

<div class="container">
    <h2>【U25】ソーシャル交流会</h2>
    <h1>更新フォーム</h1>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <!-- Main[Start] -->
    <form method="POST" action="insert.php">        
        <label for="name">お名前:</label>
        <input type="text" id="name" name="name" required value="<?= htmlspecialchars($v['name'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="email">EMAIL:</label>
        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($v['email'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="radio">参加日を選択してください:</label>
        <div class="radio-group">
            <div>
                <input type="radio" id="day1" name="select_day" value="9/26.Thu 20:00-21:00" <?= $v['select_day'] == '9/26.Thu 20:00-21:00' ? 'checked' : '' ?>>
                <label for="day1">9/26.Thu 20:00-21:00</label>
            </div>
            <div>
                <input type="radio" id="day2" name="select_day" value="10/3.Thu 20:00-21:00" <?= $v['select_day'] == '10/3.Thu 20:00-21:00' ? 'checked' : '' ?>>
                <label for="day2">10/3.Thu 20:00-21:00</label>
            </div>
            <div>
                <input type="radio" id="day3" name="select_day" value="10/10.Thu 20:00-21:00" <?= $v['select_day'] == '10/10.Thu 20:00-21:00' ? 'checked' : '' ?>>
                <label for="day3">10/10.Thu 20:00-21:00</label>
            </div>
        </div>

        <label for="memo">備考：</label>
        <textarea id="memo" name="memo" cols="30" rows="5"><?= htmlspecialchars($v['memo'], ENT_QUOTES, 'UTF-8') ?></textarea>

        <button type="submit">送信</button>
    </form>
</div>

</body>
</html>
