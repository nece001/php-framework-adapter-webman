<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Cache as ContractCache;
use support\Cache as WebmanCache;

class Cache implements ContractCache
{
    /**
     * 获取缓存
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return WebmanCache::get($key, $default);
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
        return WebmanCache::set($key, $value, $ttl);
    }

    /**
     * 删除缓存
     *
     * @param string $key
     * @return boolean
     */
    public static function delete(string $key): bool
    {
        return WebmanCache::delete($key);
    }

    /**
     * 清空缓存
     *
     * @return boolean
     */
    public static function clear(): bool
    {
        return WebmanCache::clear();
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
        return WebmanCache::getMultiple($keys, $default);
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
        return WebmanCache::setMultiple($values, $ttl);
    }

    /**
     * 删除多个缓存
     *
     * @param iterable $keys
     * @return boolean
     */
    public static function deleteMultiple(iterable $keys): bool
    {
        return WebmanCache::deleteMultiple($keys);
    }

    /**
     * 判断缓存是否存在
     *
     * @param string $key
     * @return boolean
     */
    public static function has(string $key): bool
    {
        return WebmanCache::has($key);
    }
}