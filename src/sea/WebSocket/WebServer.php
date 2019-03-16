<?php
/**
 * 创建WebSocket服务
 */

namespace Src\Sea\WebSocket;

class WebServer extends Base
{
    private static $_onServer = null;

    public function __construct($config)
    {
        parent::__construct();
        self::$_config = (object)config(sprintf("seaswoole.WebSocket.%s", $config));
        self::$_server = new \Swoole\WebSocket\Server(self::$_config->host, self::$_config->port);
        self::$_onServer != null ?: self::$_onServer = new OnWebServer();
        $this->start();
    }

    private function start()
    {
        /**
         * 初始化设置
         */
        self::$_server->set([
            self::$_config->set,
        ]);

        $onServer = self::$_onServer;

        //WebSocket建立连接后进行握手
        self::$_server->on('open', [$onServer, 'onOpen']);

        //WebSocket客户端与服务器建立连接并完成握手后
        self::$_server->on('message', [$onServer, 'onMessage']);

        //Worker进程/Task进程启动时
        self::$_server->on('close', [$onServer, 'onClose']);

        /*******************Server服务事件***********************/
        //任务投递
        self::$_server->on('task', [$onServer, 'onTask']);

        //投递成功返回
        self::$_server->on('finish', [$onServer, 'onFinish']);

        //接收UDP数据包
        self::$_server->on('packet', [$onServer, 'onPacket']);

        //Http请求
        self::$_server->on('request', [$onServer, 'onRequest']);

        //启动
        self::$_server->start();
    }

}