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

    public function onConnect(\Swoole\Server $server, int $fd, int $reactorId)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onReceive(\Swoole\Server $server, int $fd, int $reactor_id, string $data)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onClose(\swoole_server $server, int $fd)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onWorkerStart(\swoole_server $server, int $worker_id)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onWorkerStop(\swoole_server $server, int $worker_id)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onWorkerExit(\swoole_server $server, int $worker_id)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onTask(\swoole_server $serv, int $task_id, int $src_worker_id, mixed $data)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onFinish(\swoole_server $serv, int $task_id, string $data)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onPipeMessage(\swoole_server $server, int $src_worker_id, mixed $message)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onWorkerError(\swoole_server $serv, int $worker_id, int $worker_pid, int $exit_code, int $signal)
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

    public function onBufferFull(\Swoole\Server $serv, int $fd)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onBufferEmpty(\Swoole\Server $serv, int $fd)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

    public function onShutdown(\swoole_server $server)
    {
        self::$_execute->assign(__FUNCTION__, func_get_args());
    }

}