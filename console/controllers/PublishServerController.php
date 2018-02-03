<?php
namespace console\controllers;

use console\models\PublishServer;
use console\models\Pusher;
use Ratchet\Http\HttpServer;
use Ratchet\Server\FlashPolicy;
use Ratchet\Server\IoServer;
use Ratchet\Wamp\WampServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use yii\console\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PublishServerController
 *
 * @author huynq
 */
class PublishServerController extends Controller {
    //put your code here
    
    public function actionIndex() {

    echo (date('Y-m-d H:i:s'). " ********** server start *********** \n");
    $loop   = Factory::create();
    $pusher = new Pusher;

    // Listen for the web server to make a ZeroMQ push after an ajax request
    $context = new \React\ZMQ\Context($loop);
    $pull = $context->getSocket(\ZMQ::SOCKET_PULL);
    $pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
    $pull->on('message', array($pusher, 'onBlogEntry'));

    // Set up our WebSocket server for clients wanting real-time updates
    $webSock = new Server($loop);
    $webSock->listen(8080, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
    $webServer = new IoServer(
        new HttpServer(
            new WsServer(
                new WampServer(
                    $pusher
                )
            )
        ),
        $webSock
    );

//    var_dump($loop);
//    die();
    $loop->run();
    }
    
    
    
    public function actionHe() {
        echo ('haha');
    }
}
