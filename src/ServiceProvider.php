<?php

namespace Nece\Framework\Adapter;

use Closure;
use Nece\Framework\Adapter\Contract\ServiceProvider as ContractServiceProvider;
use support\Container;
use Webman\Route;

class ServiceProvider implements ContractServiceProvider
{
    /**
     * 服务注册
     *
     * @return void
     */
    public function register()
    {
        // 默认空实现
    }

    /**
     * 服务启动
     *
     * @return void
     */
    public function boot()
    {
        // 默认空实现
    }

    /**
     * 绑定服务
     *
     * @param string|array $abstract
     * @param string|array $concrete
     * @return void
     */
    public function bind($abstract, $concrete = null): void
    {
        if (is_array($abstract)) {
            foreach ($abstract as $key => $value) {
                Container::set($key, $value);
            }
        } else {
            Container::set($abstract, $concrete ?? $abstract);
        }
    }

    /**
     * 添加视图命名空间
     *
     * @param string $namespace
     * @param string $path
     * @return void
     */
    public function addViewNamespaces(string $namespace, string $path): void
    {
        // webman的视图命名空间通过配置实现
        // 这里记录一下，实际需要在配置文件中配置
    }

    /**
     * 加载路由文件
     *
     * @param string $filename 路由文件路径
     * @return void
     */
    public function loadRouteFile(string $filename): void
    {
        if (file_exists($filename)) {
            require $filename;
        }
    }

    /**
     * 注册路由
     *
     * @param Closure $closure
     * @return void
     */
    public function addRoutes(Closure $closure): void
    {
        $closure();
    }

    /**
     * 注册命令
     *
     * @param array $commands
     * @return void
     */
    public function registerCommands(array $commands): void
    {
        // webman的命令注册通过配置文件实现
        // 这里记录一下，实际需要在配置文件中配置
    }
}