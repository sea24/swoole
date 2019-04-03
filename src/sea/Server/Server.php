<?php
/**
 * 创建TCP服务
 */

namespace Src\Sea\Server;

class Server extends Base
{
    //base模式
    public $swooleBase = SWOOLE_BASE;

    //TCP服务
    public $swooleSockTcp = SWOOLE_SOCK_TCP;

    private static $_onServer = null;

    public function __construct($config)
    {
        parent::__construct();
        self::$_config = (object)config(sprintf("seaswoole.Server.%s", $config));
        self::$_server = new \Swoole\Server(self::$_config->host, self::$_config->port, $this->swooleBase,
            $this->swooleSockTcp);
        self::$_onServer != null ?: self::$_onServer = new OnServer();
        $this->start();
    }

    private function start()
    {
        /**
         * 初始化设置
         */
        self::$_server->set(
            self::$_config->set
        );

        $onServer = self::$_onServer;
        //worker进程回调
        self::$_server->on('connect', [$onServer, 'onConnect']);            //连接进入
        self::$_server->on('receive', [$onServer, 'onReceive']);            //接收数据
        self::$_server->on('workerStart', [$onServer, 'onWorkerStart']);    //Worker进程/Task进程启动时
        self::$_server->on('workerStop', [$onServer, 'onWorkerStop']);      //worker进程终止时
        self::$_server->on('workerExit', [$onServer, 'onWorkerExit']);      //仅在开启reload_async特性后有效
        self::$_server->on('task', [$onServer, 'onTask']);                  //投递任务
        self::$_server->on('finish', [$onServer, 'onFinish']);              //投递任务完成
        self::$_server->on('pipeMessage', [$onServer, 'onPipeMessage']);    //工作进程收到由 sendMessage 发送的管道消息时会触发

        //Manager进程
        self::$_server->on('workerError', [$onServer, 'onWorkerError']);    //Worker/Task进程发生异常后会在Manager进程内回调此函数
        self::$_server->on('managerStart', [$onServer, 'onManagerStart']);  //进程启动时
        self::$_server->on('managerStop', [$onServer, 'onManagerStop']);    //进程结束时

        //master进程
        self::$_server->on('start', [$onServer, 'onStart']);                //主进程启动
        self::$_server->on('bufferFull', [$onServer, 'onBufferFull']);      //缓存区达到最高水位时触发此事件
        self::$_server->on('bufferEmpty', [$onServer, 'onBufferEmpty']);    //当缓存区低于最低水位线时触发此事件。
        self::$_server->on('close', [$onServer, 'onClose']);                //连接关闭
        self::$_server->on('shutdown', [$onServer, 'onShutdown']);          //Server正常结束时

        //启动
        self::$_server->start();
    }

}