<?php
namespace Sea;
class httpServer
{
    public $get = [];
    static $post = [];
    private $request = '';
    private $response = '';

    public $host = '';
    public $port = '';

    public $end = '';

    public function __construct($host, $port)
    {
        echo 66666;exit;
        $server = new Swoole\Http\Server($host, $port);
        $server->set([
            'worker_num' => 1, //woker进程
            'reactor_num' => 1, //线程数量，异步IO充分利用多化
            'open_cpu_affinity' => 1,
            'open_eof_check' => true,
            'package_eof' => '\r\n\r\n',
            'dispatch_mode' => 2,
        ]);

        $server->on('request', [$this, 'onRequest']);
        $server->start();
    }

    /*连接成功*/
    public function onRequest($request, $response)
    {
        /*屏蔽谷歌浏览器访问两次*/
        if ($request->server['request_uri'] == '/favicon.ico') {
        } else {
            $this->get = $request->get;
            print_r($request);
        }
    }

}

//$httpServer = new httpServer('127.0.0.1', 8501);
