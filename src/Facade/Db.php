<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Db as ContractDb;
use think\facade\Db as ThinkDb;

class Db implements ContractDb
{
    /**
     * 创建原始表达式.
     *
     * @param mixed $value 表达式值
     *
     * @return mixed
     */
    public static function raw($value)
    {
        return ThinkDb::raw($value);
    }

    /**
     * 创建函数表达式.
     *
     * @param string $func  函数名
     * @param string $field 字段名
     * @param string $alias 别名
     *
     * @return mixed
     */
    public static function rawFunc(string $func, string $field, string $alias)
    {
        return ThinkDb::raw($func . '(`' . $field . '`) AS `' . $alias . '`');
    }

    /**
     * 创建计数函数表达式.
     *
     * @param string $field 字段名
     * @param string $alias 别名
     *
     * @return mixed
     */
    public static function rawCount(string $field, string $alias)
    {
        return ThinkDb::raw('COUNT(`' . $field . '`) AS `' . $alias . '`');
    }

    /**
     * 创建求和函数表达式.
     *
     * @param string $field 字段名
     * @param string $alias 别名
     *
     * @return mixed
     */
    public static function rawSum(string $field, string $alias)
    {
        return ThinkDb::raw('SUM(`' . $field . '`) AS `' . $alias . '`');
    }

    /**
     * 创建平均值函数表达式.
     *
     * @param string $field 字段名
     * @param string $alias 别名
     *
     * @return mixed
     */
    public static function rawAvg(string $field, string $alias)
    {
        return ThinkDb::raw('AVG(`' . $field . '`) AS `' . $alias . '`');
    }

    /**
     * 创建最小值函数表达式.
     *
     * @param string $field 字段名
     * @param string $alias 别名
     *
     * @return mixed
     */
    public static function rawMin(string $field, string $alias)
    {
        return ThinkDb::raw('MIN(`' . $field . '`) AS `' . $alias . '`');
    }

    /**
     * 创建最大值函数表达式.
     *
     * @param string $field 字段名
     * @param string $alias 别名
     *
     * @return mixed
     */
    public static function rawMax(string $field, string $alias)
    {
        return ThinkDb::raw('MAX(`' . $field . '`) AS `' . $alias . '`');
    }

    /**
     * 开启事务.
     *
     * @return void
     */
    public static function startTrans(): void
    {
        ThinkDb::startTrans();
    }

    /**
     * 提交事务.
     *
     * @return void
     */
    public static function commit(): void
    {
        ThinkDb::commit();
    }

    /**
     * 回滚事务.
     *
     * @return void
     */
    public static function rollback(): void
    {
        ThinkDb::rollback();
    }

    /**
     * 执行事务回调.
     *
     * @param callable $callback 事务回调函数
     *
     * @return mixed
     */
    public static function transaction(callable $callback)
    {
        return ThinkDb::transaction($callback);
    }

    /**
     * 执行SQL语句.
     *
     * @param string $sql SQL语句
     *
     * @return mixed
     */
    public static function execute(string $sql)
    {
        return ThinkDb::execute($sql);
    }
}