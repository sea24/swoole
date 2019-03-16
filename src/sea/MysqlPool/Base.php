<?php
/*初始化*/

namespace Src\Sea\MysqlPool;

use Src\Sea\Base as superiorBase;
use Src\Sea\Log;

class Base extends superiorBase
{


    //日志
    public static $_log = null;

    public function __construct()
    {
        parent::__construct();
        self::$_log != null ?: self::$_log = new Log();
    }

}