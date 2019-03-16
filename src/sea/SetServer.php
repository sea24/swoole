<?php
/**
 * 设置服务
 */

namespace Src\Sea;

class SetServer
{

    /**
     * 重启worker进程
     * @param $port {主进程PID}
     * @return string
     */
    public function reloadWorker($pid)
    {
        go(function () use ($pid) {
            return \Co::exec("kill -USR1 $pid");
        });

    }

    /**
     * 重启task_worker
     * @param $pid {主进程PID}
     * @return string
     */
    public function reloadTaskWorker($pid)
    {
        go(function () use ($pid) {
            return \CO::exec("kill -USR2 $pid");
        });
    }

}