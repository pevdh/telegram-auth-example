<?php
require __DIR__.'/../config.php';
require __DIR__.'/../functions.php';


ob_start();

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $uniqueCode = generateUniqueCode();
    storeUsernameAndUniqueCode($username, $uniqueCode);

    $url = sprintf('https://telegram.me/%s?start=%s', BOT_NAME, $uniqueCode);
}

?>
<!DOCTYPE html>
<head>
    <title>Telegram Bot Authentication Example</title>
</head>
<body>
<?php if (isset($url, $username)): ?>
    <p>
        Hi <?= e($username) ?>.
        To start chatting with @<?= e(BOT_NAME) ?>, please visit <a href="<?= e($url) ?>">this URL</a>.
    </p>
<?php else: ?>
    <form action="index.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Your username" />

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
<?php endif; ?>
</body>

<?php
echo ob_get_clean();
