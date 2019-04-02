<?php
/**
 * TCP服务对象回调
 */

namespace Src\Sea\Server;

class OnServer extends Base
{
    private static $_execute = null;

    public function __construct()
    {
        parent::__construct();
        self::$_execute != null ?: self::$_execute = new Execute();
    }

    public function onConnect(\Swoole\Server $server, $fd, $reactorId)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onReceive(\Swoole\Server $server, $fd, $reactor_id, $data)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onClose(\swoole_server $server, $fd)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onWorkerStart(\swoole_server $server, $worker_id)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onWorkerStop(\swoole_server $server, $worker_id)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onWorkerExit(\swoole_server $server, $worker_id)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onTask(\swoole_server $serv, $task_id, $src_worker_id, $data)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onFinish(\swoole_server $serv, $task_id, $data)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onPipeMessage(\swoole_server $server, $src_worker_id, $message)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onWorkerError(\swoole_server $serv, $worker_id, $worker_pid, $exit_code, $signal)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onManagerStart(\swoole_server $serv)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onManagerStop(\swoole_server $serv)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onStart(\Swoole\Server $server)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onBufferFull(\Swoole\Server $serv, $fd)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onBufferEmpty(\Swoole\Server $serv, $fd)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onShutdown(\swoole_server $server)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

}