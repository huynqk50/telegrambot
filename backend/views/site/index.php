<?php

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
if (count($statistics) > 0) {
    foreach ($statistics as $username => $item) {
        $user = $item['user'];
        $actions = $item['actions'];
?>
<div class="row" style="margin: 0.5em auto">  
    <div class="col-md-12">
        <?= Html::a($user->username, Url::to(['user/update', 'id' => $user->id], true)) ?>
    </div>
    <div class="col-md-12">
        <?= $actions['create']['t_action'] ?> <span class="text-success"><?= count($actions['create']['objects']) ?></span>
        &middot; <?= $actions['update']['t_action'] ?> <span class="text-primary"><?= count($actions['update']['objects']) ?></span>
        &middot; <?= $actions['delete']['t_action'] ?> <span class="text-danger"><?= count($actions['delete']['objects']) ?></span>
    </div>
    <?php
    foreach ($actions['create']['objects'] as $object) {
    ?>
    <div class="col-md-12">
        <time class="text-detail"><?= $object['time'] ?></time>
        <?= Html::a($actions['create']['t_action'], Url::to([Inflector::camel2id($object['name']) . '/create'], true), ['class' => 'text-black']) ?>
        <?php
        if ($object['model'] !== null) {
            echo Html::a($object['t_name'], Url::to([Inflector::camel2id($object['name']) . '/update', 'id' => $object['model']->id], true), ['class' => 'text-success']);
            echo ' ' . Html::a(
                (strlen($object['model']->getLink()) > 60 ? '...' : '') . substr($object['model']->getLink(), -60),
                $object['model']->getLink(),
                [
                    'target' => '_blank',
                    'class' => 'text-gray',
                    'onmouseover' => '$(this).toggleClass("text-orange")',
                    'onmouseout' => '$(this).removeClass("text-orange")'
                ]
            );
        } else {
            echo "<span class=\"text-success\">{$object['t_name']}</span>";
            if ($object['deleted_by'] !== null) {
                echo " <span class=\"text-gray\">(Đã xóa bởi {$object['deleted_by']})</span>";
            }
        }
        ?>
    </div>
    <?php
    }
    ?>
</div>
<?php
    }
} 


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
$mysql_credentials = Yii::$app->params['telegram_db'];

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
    
    $commands = [
        '/whoami',
        "/echo I'm a bot!",
    ];
     $telegram->runCommands($commands);
    // Handle telegram getUpdates request
    $server_response = $telegram->handleGetUpdates();
    $sourceChatId = -307954796;
    $desChatId = -291325027;
    if ($server_response->isOk()) {
        $update_count = count($server_response->getResult());
        echo date('Y-m-d H:i:s', time()) . ' - Processed ' . $update_count . ' updates';
        echo (var_export($server_response->toJson(), true));
//        foreach ($server_response->getResult() as  $r) {
//            
//            if (is_a($r, '\Longman\TelegramBot\Entities\Update')) {
//                 $message = $r->getMessage();
//                 if ($message->getChat() && $message->getChat()->id == $sourceChatId) {
//                     Request::initialize($telegram);
//                    $response = Request::sendMessage(['chat_id' => $desChatId, 'text' => $message->getText()]);
//                 }
//            } else {
//                echo "object is not type update";
//            }
//        }
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