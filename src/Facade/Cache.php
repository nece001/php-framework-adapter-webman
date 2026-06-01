<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Cache as ContractCache;
use support\Container;

class Cache implements ContractCache
{
    /**
     * 获取缓存实例
     *
     * @return \Psr\SimpleCache\CacheInterface
     */
    protected static function getCache()
    {
        return Container::get('cache');
    }

    /**
     * 获取缓存
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return static::getCache()->get($key, $default);
    }

    /**
     * 设置缓存
     *
     * @param string $key
     * @param mixed $value
     * @param null|integer|\DateInterval|null $ttl
     * @return boolean
     */
    public static function set(string $key, mixed $value, $ttl = null): bool
    {
        return static::getCache()->set($key, $value, $ttl);
    }

    /**
     * 删除缓存
     *
     * @param string $key
     * @return boolean
     */
    public static function delete(string $key): bool
    {
        return static::getCache()->delete($key);
    }

    /**
     * 清空缓存
     *
     * @return boolean
     */
    public static function clear(): bool
    {
        return static::getCache()->clear();
    }

    /**
     * 获取多个缓存
     *
     * @param iterable $keys
     * @param mixed $default
     * @return iterable
     */
    public static function getMultiple(iterable $keys, $default = null): iterable
    {
        return static::getCache()->getMultiple($keys, $default);
    }

    /**
     * 设置多个缓存
     *
     * @param iterable $values
     * @param null|integer|\DateInterval|null $ttl
     * @return boolean
     */
    public static function setMultiple(iterable $values, $ttl = null): bool
    {
        return static::getCache()->setMultiple($values, $ttl);
    }

    /**
     * 删除多个缓存
     *
     * @param iterable $keys
     * @return boolean
     */
    public static function deleteMultiple(iterable $keys): bool
    {
        return static::getCache()->deleteMultiple($keys);
    }

    /**
     * 判断缓存是否存在
     *
     * @param string $key
     * @return boolean
     */
    public static function has(string $key): bool
    {
        return static::getCache()->has($key);
    }
}