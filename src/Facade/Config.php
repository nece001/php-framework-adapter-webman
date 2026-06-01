<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Config as ContractConfig;

class Config implements ContractConfig
{
    /**
     * 获取配置变量值
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function config(string $key, $default = null)
    {
        return \config($key, $default);
    }

    /**
     * 获取环境变量值
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function env(string $key, $default = null)
    {
        return \env($key, $default);
    }
}