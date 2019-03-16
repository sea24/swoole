<?php

namespace Src\Sea;

class Base
{
    //日志
    public static $_log = null;

    public function __construct()
    {
        self::$_log != null ?: self::$_log = $_log = new Log();
    }
}