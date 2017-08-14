<?php

const DATA_FILE = __DIR__.'/data/storage.json';
const BASE_URL = 'https://api.telegram.org/bot'.BOT_TOKEN.'/';

function generateUniqueCode()
{
    return bin2hex(random_bytes(8));
}

function storeUsernameAndUniqueCode($username, $token)
{
    $storage = getStorage();
    $storage[$token] = $username;
    saveStorage($storage);
}

function getUsernameByUniqueCode($token)
{
    $storage = getStorage();

    if (array_key_exists($token, $storage)) {
        return $storage[$token];
    }

    return null;
}

function getStorage()
{
    if (file_exists(DATA_FILE)) {
        $contents = file_get_contents(DATA_FILE);
        return json_decode($contents, true);
    }

    return [];
}

function saveStorage(array $storage)
{
    file_put_contents(DATA_FILE, json_encode($storage, JSON_PRETTY_PRINT));
}

function getUpdates($offset)
{
    $query = http_build_query(['offset' => $offset, 'timeout' => 20, 'allowed_updates' => ['message']]);
    $url = BASE_URL.'getUpdates?'.$query;
    return makeRequest($url);
}

function sendMessage($chatId, $text)
{
    $query = http_build_query(['chat_id' => $chatId, 'text' => $text]);
    $url = BASE_URL.'sendMessage?'.$query;
    return makeRequest($url);
}

function makeRequest($url)
{
    $result = json_decode(file_get_contents($url), true);

    if ($result['ok'] !== true) {
        throw new RuntimeException('Request failed. Telegram API reported: '.$result['description']);
    }

    return $result['result'];
}

function e($v)
{
    return htmlspecialchars($v);
}

function str_startswith($str, $val)
{
    return strpos($str, $val) === 0;
}

function println($message, ...$args)
{
    echo sprintf($message, ...$args).PHP_EOL;
}