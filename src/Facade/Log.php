<?php
namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Log as ContractLog;
use support\Log as WebmanLog;
use Psr\Log\LoggerInterface;

class Log implements ContractLog
{
    /**
     * 获取日志记录器
     *
     * @return LoggerInterface
     */
    public static function getLogger(): LoggerInterface
    {
        return WebmanLog::channel();
    }

    /**
     * 紧急情况
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function emergency(string $message, array $context = []): void
    {
        WebmanLog::emergency($message, $context);
    }

    /**
     * 警告
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function alert(string $message, array $context = []): void
    {
        WebmanLog::alert($message, $context);
    }

    /**
     * 关键错误
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function critical(string $message, array $context = []): void
    {
        WebmanLog::critical($message, $context);
    }

    /**
     * 错误
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function error(string $message, array $context = []): void
    {
        WebmanLog::error($message, $context);
    }

    /**
     * 警告
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function warning(string $message, array $context = []): void
    {
        WebmanLog::warning($message, $context);
    }

    /**
     * 通知
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function notice(string $message, array $context = []): void
    {
        WebmanLog::notice($message, $context);
    }

    /**
     * 信息
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function info(string $message, array $context = []): void
    {
        WebmanLog::info($message, $context);
    }

    /**
     * 调试
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function debug(string $message, array $context = []): void
    {
        WebmanLog::debug($message, $context);
    }

    /**
     * 日志
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function log($level, string $message, array $context = []): void
    {
        WebmanLog::log($level, $message, $context);
    }
}