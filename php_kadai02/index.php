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
    <?php if (!empty($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

        <!-- Main[Start] -->
        <form method="POST" action="insert.php">        
        <label for="name">お名前:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">EMAIL:</label>
        <input type="email" id="email" name="email" required>

        <label for="radio">参加日を選択してください:</label>
        <div class="radio-group">
            <div>
                <input type="radio" id="day1" name="select_day" value="9/26.Thu 20:00-21:00">
                <label for="day1">9/26.Thu 20:00-21:00</label>
            </div>
            <div>
                <input type="radio" id="day2" name="select_day" value="10/3.Thu 20:00-21:00">
                <label for="day2">10/3.Thu 20:00-21:00</label>
            </div>
            <div>
                <input type="radio" id="day3" name="select_day" value="10/10.Thu 20:00-21:00">
                <label for="day3">10/10.Thu 20:00-21:00</label>
            </div>
        </div>

        <label for="memo">備考：</label>
        <textarea id="memo" name="memo" cols="30" rows="5"></textarea>

        <button type="submit">送信</button>
    </form>
</div>

</body>
</html>
