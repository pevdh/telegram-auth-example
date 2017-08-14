#!/usr/bin/env php
<?php
if (PHP_SAPI !== 'cli') {
    echo 'Please run this script in the CLI';
    exit();
}

require __DIR__.'/../config.php';
require __DIR__.'/../functions.php';

$updateOffset = 0;

while (true) {
    println('Getting new updates [offset=%s]', $updateOffset);
    $updates = getUpdates($updateOffset);

    foreach ($updates as $update) {
        $updateOffset = max($updateOffset, $update['update_id']);

        $message = $update['message'];

        $chatId = $message['chat']['id'];

        // E.g. "/start <uniqueCode>"
        $text = $message['text'];

        if (!str_startswith($text, '/start')) {
            continue;
        }

        $username = null;

        $parts = explode(' ' , $text);
        if (count($parts) === 2) { // ['/start', '<uniqueCode>']
            $uniqueCode = $parts[1];
            $username = getUsernameByUniqueCode($uniqueCode);
        }

        if ($username !== null) {
            println('Received message from known user "'.$username.'"!');
            sendMessage($chatId, 'Hello there, '.$username.'! I am glad you made it!');
        } else {
            println('Received message from an unknown user :(');
            sendMessage($chatId, 'Hello! Unfortunately I do not know you :(');
        }
    }

    $updateOffset++;
}
