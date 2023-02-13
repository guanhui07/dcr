<?php
declare(strict_types = 1);

namespace Dcr\Process;

class ProcessManager
{
    public function run(string $className,int $processNum = 1): void
    {
        umask(0);
        for ($i = 1; $i <= $processNum; $i++) {
            $pid = pcntl_fork();
            if ($pid > 0) {    // 在父进程中
                cli_set_process_title($className);
//                pcntl_waitpid($pid, $status, WNOHANG);
                // 给父进程安装一个SIGCHLD信号处理器
                // 想在子进程中执行任务，这种写法子进程如果不报错就会是固定数量定时运行，如果报错一个子进程就少一个 需要处理
                pcntl_signal(SIGCHLD, static function () use ($pid) {
                    pcntl_waitpid($pid, $status, WNOHANG);
                });
                // 父进程不断while循环，去反复执行pcntl_waitpid()，从而试图解决已经退出的子进程
                while (true) {
                    pcntl_signal_dispatch();
                }
            } elseif (0 === $pid) {
                (new $className())->hook();
            }
        }
    }
}