<?php

namespace Src\Sea\WebSocket;

use Src\Sea\Base as superiorBase;
use Src\Sea\Log;

class Base extends superiorBase
{
    //WebSocket服务
    public static $_server = null;

    //配置信息
    public static $_config = null;

    public function __construct()
    {
        parent::__construct();
    }

}