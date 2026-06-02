<?php

namespace Nece\Framework\Adapter\DbAdapter;

use Nece\Framework\Adapter\Contract\DbAdapter\ModelRelationQuery as DbAdapterModelRelationQuery;
use think\db\Query as ThinkQuery;

class ModelRelationQuery extends Query implements DbAdapterModelRelationQuery
{
    /**
     * @inheritDoc
     */
    public function with($relation, $callback = null): DbAdapterModelRelationQuery
    {
        $this->query->with($relation, $callback);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withJoin($relation, $callback = null, bool $joinType = false): DbAdapterModelRelationQuery
    {
        $this->query->withJoin($relation, $callback, $joinType ? 'LEFT' : '');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withCount($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        $this->query->withCount($relation, $field ?: 'id');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withSum($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        if ($field) {
            $this->query->withSum($relation, $field);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withAvg($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        if ($field) {
            $this->query->withAvg($relation, $field);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withMin($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        if ($field) {
            $this->query->withMin($relation, $field);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withMax($relation, string $field = null, string $name = null): DbAdapterModelRelationQuery
    {
        if ($field) {
            $this->query->withMax($relation, $field);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function load($relation, $callback = null): DbAdapterModelRelationQuery
    {
        // ThinkPHP 没有直接的 load 方法，但模型有 lazyLoad 方法
        // 这里我们保持接口一致性，实际使用时通过模型调用
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function scope(string $scope, array $args = []): DbAdapterModelRelationQuery
    {
        call_user_func_array([$this->query, 'scope'], array_merge([$scope], $args));
        return $this;
    }
}