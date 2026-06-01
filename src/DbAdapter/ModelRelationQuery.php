<?php

namespace Nece\Framework\Adapter\DbAdapter;

use Nece\Framework\Adapter\Contract\DbAdapter\ModelRelationQuery as DbAdapterModelRelationQuery;
use think\db\Query as ThinkQuery;

class ModelRelationQuery extends Query implements DbAdapterModelRelationQuery
{
    /**
     * 预加载关联数据.
     *
     * @param mixed $relation 关联方法名（支持字符串、数组、闭包）
     * @param mixed $callback 回调函数
     *
     * @return $this
     */
    public function with($relation, $callback = null): DbAdapterModelRelationQuery
    {
        $this->query->with($relation, $callback);
        return $this;
    }

    /**
     * 预加载关联数据（JOIN方式）.
     *
     * @param mixed $relation 关联方法名
     * @param mixed $callback 回调函数
     * @param bool  $joinType 是否使用LEFT JOIN
     *
     * @return $this
     */
    public function withJoin($relation, $callback = null, bool $joinType = false): DbAdapterModelRelationQuery
    {
        $this->query->withJoin($relation, $callback, $joinType ? 'LEFT' : '');
        return $this;
    }

    /**
     * 预加载关联统计.
     *
     * @param mixed       $relation 关联方法名（支持字符串、数组）
     * @param string|null $field    统计字段
     * @param string|null $name     统计别名
     *
     * @return $this
     */
    public function withCount($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        $this->query->withCount($relation, $field ?: 'id');
        return $this;
    }

    /**
     * 预加载关联求和.
     *
     * @param mixed       $relation 关联方法名（支持字符串、数组）
     * @param string|null $field    求和字段
     * @param string|null $name     求和别名
     *
     * @return $this
     */
    public function withSum($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        if ($field) {
            $this->query->withSum($relation, $field);
        }
        return $this;
    }

    /**
     * 预加载关联求平均值.
     *
     * @param mixed       $relation 关联方法名（支持字符串、数组）
     * @param string|null $field    字段名
     * @param string|null $name     别名
     *
     * @return $this
     */
    public function withAvg($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        if ($field) {
            $this->query->withAvg($relation, $field);
        }
        return $this;
    }

    /**
     * 预加载关联求最小值.
     *
     * @param mixed       $relation 关联方法名（支持字符串、数组）
     * @param string|null $field    字段名
     * @param string|null $name     别名
     *
     * @return $this
     */
    public function withMin($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        if ($field) {
            $this->query->withMin($relation, $field);
        }
        return $this;
    }

    /**
     * 预加载关联求最大值.
     *
     * @param mixed       $relation 关联方法名（支持字符串、数组）
     * @param string|null $field    字段名
     * @param string|null $name     别名
     *
     * @return $this
     */
    public function withMax($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        if ($field) {
            $this->query->withMax($relation, $field);
        }
        return $this;
    }

    /**
     * 延迟预加载关联数据.
     *
     * @param mixed $relation 关联方法名（支持字符串、数组、闭包）
     * @param mixed $callback 回调函数
     *
     * @return $this
     */
    public function load($relation, $callback = null): DbAdapterModelRelationQuery
    {
        // ThinkPHP 没有直接的 load 方法，但模型有 lazyLoad 方法
        // 这里我们保持接口一致性，实际使用时通过模型调用
        return $this;
    }

    /**
     * 查询单条记录.
     *
     * @param mixed $data 主键值或查询条件
     *
     * @return mixed
     */
    public static function find($data = null)
    {
        // 静态方法需要特殊处理，这里返回null或抛出异常
        // 实际应用中应通过模型调用
        return null;
    }

    /**
     * 查询多条记录.
     *
     * @param mixed $data 查询条件
     *
     * @return array
     */
    public static function select($data = null): array
    {
        // 静态方法需要特殊处理，这里返回空数组或抛出异常
        // 实际应用中应通过模型调用
        return [];
    }

    /**
     * 获取或创建记录.
     *
     * @param array $where 查询条件
     * @param array $data  创建数据
     *
     * @return mixed
     */
    public static function firstOrCreate(array $where, array $data = [])
    {
        // 静态方法需要特殊处理
        return null;
    }

    /**
     * 更新或创建记录.
     *
     * @param array $where 查询条件
     * @param array $data  更新/创建数据
     *
     * @return mixed
     */
    public static function updateOrCreate(array $where, array $data = [])
    {
        // 静态方法需要特殊处理
        return null;
    }

    /**
     * 设置查询范围.
     *
     * @param string $scope 范围名称
     * @param array  $args  参数
     *
     * @return $this
     */
    public function scope(string $scope, array $args = []): DbAdapterModelRelationQuery
    {
        call_user_func_array([$this->query, 'scope'], array_merge([$scope], $args));
        return $this;
    }
}