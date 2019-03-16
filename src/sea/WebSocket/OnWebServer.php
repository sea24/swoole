<?php
/**
 * WebSocket服务对象回调
 */

namespace Src\Sea\WebSocket;

class OnWebServer extends Base
{
    private static $_execute = null;

    public function __construct()
    {
        parent::__construct();
        self::$_execute != null ?: self::$_execute = new Execute();
    }

    public function onOpen(\Swoole\WebSocket\Server $server, $request)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onMessage(\Swoole\WebSocket\Server $server, $frame)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onClose($ser, $fd)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    /*******************Server服务返回***********************/

    public function onTask($server, $worker_id, $task_id, $data)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onFinish($server, $task_id, $result)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onPacket($server, $data, $client)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onRequest(\swoole_http_request $request, \swoole_http_response $response)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

}