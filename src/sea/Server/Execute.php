<?php
/**
 * TCP服务对象指派
 */

namespace Src\Sea\Server;

class Execute extends Base
{
    private static $_app = null;

    public function __construct()
    {
        parent::__construct();
        self::$_app != null ?: self::$_app = new self::$_config->notice_url;
    }

    public function assign($_function, array $_server)
    {
        try {
            method_exists(self::$_app, $_function) !== true ?: self::$_app->$_function($_server);
        } catch (\Exception $e) {
            $error['file'] = $e->getFile();
            $error['line'] = $e->getLine();
            $error['code'] = $e->getCode();
            $error['message'] = $e->getMessage();
            $error['host'] = self::$_server->host;
            $error['port'] = self::$_server->port;
            $error['master_pid'] = self::$_server->master_pid;
            self::$_log->error(self::$_config->log, $error);
        }
    }
}