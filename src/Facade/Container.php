<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Container as ContractContainer;
use support\Container as WebmanContainer;

class Container implements ContractContainer
{
    /**
     * 初始化应用
     *
     * @return void
     */
    public static function initApp(): void
    {
        // webman的应用在启动时已自动初始化
    }

    /**
     * 获取应用实例
     *
     * @return Object
     */
    public static function getApp()
    {
        // webman没有直接的应用实例，返回容器实例
        return WebmanContainer::instance();
    }

    /**
     * 依赖注入创建实例
     *
     * @param string $abstract
     * @param array $vars
     * @param boolean $newInstance
     * @return Object
     */
    public static function make(string $abstract, array $vars = [], bool $newInstance = false)
    {
        if ($newInstance) {
            return WebmanContainer::make($abstract, $vars);
        }
        return WebmanContainer::get($abstract);
    }
}