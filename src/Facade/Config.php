<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Config as ContractConfig;

class Config implements ContractConfig
{
    /**
     * 获取配置变量值
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return \config($key, $default);
    }
}