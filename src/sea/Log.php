<?php
/**
 * Log系统
 */

namespace Src\Sea;

class Log
{
    public $time;

    public function __construct()
    {
        $time = date("Y-m-d H:i:s", time());
        $this->time = sprintf("%s$time%s", '[', ']');
    }

    public function error($filename, $data)
    {
        file_put_contents($filename, $this->time . json_encode($data) . PHP_EOL, FILE_APPEND);
    }
}