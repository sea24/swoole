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
        $path = $filename['log_path'] . '/' . $filename['log_file'] . '-' . date("Y-m-d", time()) . '.log';
        if (!file_exists($path)) {
            fopen($path, 'w+');
        }
        file_put_contents($path, $this->time . json_encode($data) . PHP_EOL, FILE_APPEND);
    }
}