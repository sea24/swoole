# seaswoole
## 接入流程
### 安装
环境要求：PHP >= 7.0.0

swoole编译安装请参考以下地址：
https://wiki.swoole.com/wiki/page/6.html


使用 `composer`

在composer.json的require文件加入以下内容:

```php
待定改
```


加载源码(终端执行):
```php
composer update jialeo/swoole-distributed
```


## HttpServer配置
在config/seaswoole.php文件的数组追加以下内容:

**通知路径请填写当前项目的根命名空间路径

请求信息及相应信息就是回调对应方法
```php
<?php
/*swoole服务配置*/
return [
    /*HttpServer服务配置*/
    'Http' => [
        /*服务器1配置*/
        'one' => [
            'host' => '127.0.0.1', //服务器地址
            'port' => 8501, //端口
            'set' => [
                'worker_num' => 1, //woker进程
                'reactor_num' => 1, //线程数量，异步IO充分利用多化
                'open_cpu_affinity' => 1,
                'open_eof_check' => true,
                'package_eof' => '\r\n\r\n',
                'dispatch_mode' => 2,
                'package_max_length' => 1024 * 1024, //1M字节数
            ], //设置httpServer
            'notice_url' => '\App\Http\Controllers\Api\Terminal\V1\Receive\HttpServer', //通知路径
            'request' => 'request', //请求信息
            'log' => '/wwwroot/swoole.log', //代码异常报错日志
        ]
    ]
];
```
说明：事件回调均在回调路径类里面创建相对应的方法，方法命名规则参照：https://wiki.swoole.com/wiki/page/327.html
在cli模式执行脚本：
```php
use Sea\Test\YangHaiLong\httpServer 

public function handle()
    {
        //这里one是上面seaswoole.php配置文件key,如果多个服务那么多增加一个配置
        $swooleHttpServer = new httpServerSwoole('one');
    }
```

## Server配置
```php
return [
    /*Server服务器配置*/
    'Server' => [
        'one' => [
            'host' => '127.0.0.1', //服务器地址
            'port' => 9501, //端口
            'set' => [
                'reactor_num' => swoole_cpu_num() * 2,
                'worker_num' => swoole_cpu_num() * 2,
                'max_request' => 2000,
                'open_cpu_affinity' => 1,
                'log_file' => '/wwwroot/swoole.log',
                'open_eof_check' => true, //检测数据完整性
                'package_eof' => "\r\n\r\n", //设置EOF（结束符EOF C语言）
                'max_coroutine' => 200, //当前工作最大协程数量
            ], //这是server
            'notice_url' => '\App\Http\Controllers\Api\Terminal\V1\Receive\HttpServer', //协程回调路径
            'log' => '/wwwroot/swoole.log', //日志路径
        ]
    ]
];
```

说明：事件回调均在回调路径类里面创建相对应的方法，方法命名规则参照：https://wiki.swoole.com/wiki/page/41.html

在cli模式执行脚本：
```php
use Sea\Test\YangHaiLong\Server\Server as swooleServer;

public function handle()
    {
        //这里one是上面seaswoole.php配置文件key,如果多个服务那么多增加一个配置
        $swooleHttpServer = new swooleServer('one');
    }
```

## WebSocket配置

```php
<?php
return [
    /*WebSocket*/
    'WebSocket' => [
        'one' => [
            'host' => '127.0.0.1', //服务器地址
            'port' => 6501, //端口
            'set' => [
                'open_websocket_close_frame' => false,
            ], //这是server
            'notice_url' => '\App\Http\Controllers\Api\Terminal\V1\Receive\WebSocket', //协程回调路径
            'log' => '/wwwroot/swoole.log',
        ]
    ]
];
```

说明：事件回调均在回调路径类里面创建相对应的方法，方法命名规则参照：https://wiki.swoole.com/wiki/page/400.html
在cli模式执行脚本：
```php
use Sea\Test\YangHaiLong\WebSocket\WebServer as swooleWebServer;

public function handle()
    {
        //这里one是上面seaswoole.php配置文件key,如果多个服务那么多增加一个配置
        $swooleHttpServer = new swooleWebServer('one');
    }
```


## Mysql数据库连接池
配置文件
```php
return [
    /*Mysql连接池*/
    'Mysql' => [
        'one' => [
            'dbConfig' => [
                'host' => '127.0.0.1', //dns
                'port' => 3306, //端口
                'user' => 'root', //用户名
                'password' => 'root', //密码
                'database' => 'test', //数据库
                'charset' => 'utf8', //字符集
                'timeout' => 2,
            ],
            'min' => 10, //最少连接数
            'max' => 100, //最大连接数
            'balance' => 50,//空闲时均衡连接数
            'timeOut' => 3,//等待出队列等待时间（单位秒）
        ],
        'channel' => 1024 * 1024, //mysql缓存区容量（单位字节）
    ]
];
```
使用方法，（底层实现协程mysql，连接池组，等待连接池。）仅在当前进程中使用

```php
namespace App\Http\Controllers\Api\Terminal\V1\Receive;

use Sea\Test\YangHaiLong\MysqlPool\DB as seaDB;


class Server
{
    public static $db = null;

    public function __construct()
    {
        self::$db = new  seaDB('one');
    }

    public function onWorkerStart($server)
    {
        //初始化数据库连接池
        self::$db->init();
    }

    public function onReceive($server)
    {
        //执行sql语句
        print_r(json_encode(self::$db->query("select * from shop_goods limit 1")));
    }

}
```