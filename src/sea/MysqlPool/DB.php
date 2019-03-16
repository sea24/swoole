<?php
/*数据库操作*/

namespace Src\Sea\MysqlPool;

use Src\Sea\Base as superiorBase;
use Src\Sea\MysqlPool\Database;

class DB extends Database
{
    //配置信息
    public static $_config = null;

    public function __construct($config)
    {
        parent::__construct();
        self::$_config = self::$_config = (object)config(sprintf("seaswoole.Mysql.%s", $config));
    }

    /**
     * 初始化方法
     */
    public function init()
    {
        $this->open(self::$_config);
    }

    /**
     * 查询方法
     */
    public function query(string $sql)
    {
        return $this->dbSql(self::$_config, $sql);
    }

    public function createDb()
    {
        $db = new \Swoole\Coroutine\Mysql();
        $db->connect(
            self::$_config->dbConfig
        );
        return $db;
    }

}