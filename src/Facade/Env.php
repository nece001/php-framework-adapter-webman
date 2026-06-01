<?php
namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Env as ContractEnv;

class Env implements ContractEnv
{
    /**
     * 获取环境变量
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return \env($key, $default);
    }

    /**
     * 设置环境变量
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }

    /**
     * 判断环境变量是否存在
     *
     * @param string $key
     * @return boolean
     */
    public static function has($key): bool
    {
        return isset($_ENV[$key]) || isset($_SERVER[$key]);
    }
}