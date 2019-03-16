<?php

namespace Src\Sea\HttpServer;

class HttpServer extends Base
{
    public $config; //配置信息
    private static $_server; //当前服务


    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
        /*执行*/
        $this->run();
    }


    private function run()
    {
        $this->config = (object)config(sprintf("seaswoole.Http.%s", $this->config));
        self::$_server = new \Swoole\Http\Server($this->config->host, $this->config->port);
        self::$_server->set($this->config->set);
        //浏览器连接服务器后, 页面上的每个请求均会执行一次,
        self::$_server->on('request', [$this, 'onRequest']);
        //每个浏览器第一次打开页面时
        //self::$_server->on('connect', [$this, 'onConnect']);
        //self::$_server->on('start', [$this, 'onStart']);
        self::$_server->start();
    }

    /*请求*/
    public function onRequest($request, $response)
    {
        /*屏蔽谷歌浏览器访问两次*/
        if ($request->server['request_uri'] != '/favicon.ico') {
            try {
                $notice = new $this->config->notice_url;
                //请求信息
                $theRequest = $this->config->request;
                method_exists($notice, $theRequest) !== true ?: $notice->$theRequest($request, $response);
            } catch (\Exception $e) {
                $error['file'] = $e->getFile();
                $error['line'] = $e->getLine();
                $error['code'] = $e->getCode();
                $error['message'] = $e->getMessage();
                self::$_log->error($this->config->log, $error);
            }
        }
    }

}