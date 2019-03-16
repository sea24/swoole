<?php
/*封装连接池*/

namespace Src\Sea\MysqlPool;

use Src\Sea\Base as superiorBase;
use Swoole\Coroutine\Channel;

abstract class Database extends superiorBase
{
    //连接池
    public static $_channel = null;

    //缓存对象
    public $connections = null;

    //链接数量
    public $count = 0;

    protected abstract function createDb();

    public function __construct()
    {
        parent::__construct();
        self::$_channel != null ?: self::$_channel = new Channel(config('seaswoole.Mysql.channel'));
    }

    /**
     * 初始换最小数量连接池
     * @return $this|null
     */
    protected function open(object $_config)
    {
        for ($i = 0; $i < $_config->min; $i++) {
            $obj = $this->createObject();
            $this->count++;
            self::$_channel->push($obj);
        }
        return $this;
    }

    /*
     * 创建连接
     */
    protected function createObject()
    {
        $obj = null;
        $db = $this->createDb();
        if ($db) {
            $obj = [
                'last_used_time' => time(),
                'db' => $db,
            ];
        }
        return (object)$obj;
    }

    /**
     * 执行sql
     * @param array $_config
     * @param string $sql
     * @return mixed
     */
    protected function dbSql(object $_config, $sql)
    {
        $dispose = $this->dispose($_config);
        $result = $dispose->db->query($sql);
        go(function () use ($dispose) {
            $this->free($dispose);
        });
        return $result;
    }

    /**
     * 连接池分配
     */
    private function dispose(object $_config)
    {
        //当前连接池为空或者当前连接池数量小于配置最大连接数创建连接入池
        if (self::$_channel->isEmpty() && $this->count < $_config->max) {
            $this->count++;
            $db = $this->createObject();
            self::$_channel->push($db);
        } else {
            $db = self::$_channel->pop($_config->timeOut);
        }
        return $db;
    }

    /**
     * 投入连接池
     */
    public function free(object $db)
    {
        self::$_channel->push($db);
        return $this;
    }

}