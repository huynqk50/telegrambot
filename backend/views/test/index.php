<?php

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$bot_api_key  = '538094903:AAEO3s99sIyrxsPtwpTGhXy7wnT5_Ji1nDg';
$bot_username = 'huytestforwardbot';

$admin_users = [
//    123,
];
// Define all paths for your custom commands in this array (leave as empty array if not used)
$commands_paths = [
//  __DIR__ . '/Commands/',
];
// Enter your MySQL database credentials
$mysql_credentials = [
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => 'Lk3w*6ps5-otar',
    'database' => 'telegram',
];

try {
    // Create Telegram API object
    $telegram = new Telegram($bot_api_key, $bot_username);
    // Add commands paths containing your custom commands
    $telegram->addCommandsPaths($commands_paths);
    // Enable admin users
    $telegram->enableAdmins($admin_users);
    // Enable MySQL
    $telegram->enableMySql($mysql_credentials);
    // Logging (Error, Debug and Raw Updates)
    //Longman\TelegramBot\TelegramLog::initErrorLog(__DIR__ . "/{$bot_username}_error.log");
    //Longman\TelegramBot\TelegramLog::initDebugLog(__DIR__ . "/{$bot_username}_debug.log");
    //Longman\TelegramBot\TelegramLog::initUpdateLog(__DIR__ . "/{$bot_username}_update.log");
    // If you are using a custom Monolog instance for logging, use this instead of the above
    //Longman\TelegramBot\TelegramLog::initialize($your_external_monolog_instance);
    // Set custom Upload and Download paths
    //$telegram->setDownloadPath(__DIR__ . '/Download');
    //$telegram->setUploadPath(__DIR__ . '/Upload');
    // Here you can set some command specific parameters
    // e.g. Google geocode/timezone api key for /date command
    //$telegram->setCommandConfig('date', ['google_api_key' => 'your_google_api_key_here']);
    // Botan.io integration
    //$telegram->enableBotan('your_botan_token');
    // Requests Limiter (tries to prevent reaching Telegram API limits)
    $telegram->enableLimiter();
    // Handle telegram getUpdates request
    Request::initialize($telegram);
    $server_response = Request::sendMessage(['chat_id' => -307954796, 'text' => 'Your utf8 text 😜 ...']);
    
    if ($server_response->isOk()) {
        $update_count = count($server_response->getResult());
        echo date('Y-m-d H:i:s', time()) . ' - Processed ' . $update_count . ' updates';
        echo (var_export($server_response->toJson()));
        foreach ($server_response->getResult() as  $r) {
            
        }
    } else {
        echo date('Y-m-d H:i:s', time()) . ' - Failed to fetch updates' . PHP_EOL;
        echo $server_response->printError();
    }
} catch (TelegramException $e) {
    echo $e->getMessage();
    // Log telegram errors
    TelegramLog::error($e);
} catch (TelegramLogException $e) {
    // Catch log initialisation errors
    echo $e->getMessage();
}
?>

