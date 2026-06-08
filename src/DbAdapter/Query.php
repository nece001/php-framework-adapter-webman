<?php

namespace Nece\Framework\Adapter\DbAdapter;

use Closure;
use Nece\Framework\Adapter\Contract\DbAdapter\Query as DbAdapterQuery;
use Nece\Framework\Adapter\DbAdapter\Paginator;
use think\db\Query as ThinkQuery;
use Nece\Framework\Adapter\Contract\DbAdapter\Model as ModelInterface;

class Query implements DbAdapterQuery
{
    /**
     * 数据库查询
     *
     * @var ThinkQuery
     */
    protected ThinkQuery $query;

    public function __construct(ThinkQuery $query)
    {
        $this->query = $query;
    }

    /**
     * @inheritDoc
     */
    public function name(string $name): DbAdapterQuery
    {
        $this->query->name($name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function table(string $table): DbAdapterQuery
    {
        $this->query->table($table);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function alias(string $alias): DbAdapterQuery
    {
        $this->query->alias($alias);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAlias(string $table = ''): string
    {
        return $this->query->getAlias($table);
    }

    /**
     * @inheritDoc
     */
    public function field(array $field): DbAdapterQuery
    {
        $this->query->field($field);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function fieldRaw(string $field): DbAdapterQuery
    {
        $this->query->fieldRaw($field);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withoutField(array $field): DbAdapterQuery
    {
        $this->query->withoutField($field);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function tableField(array $field, string $tableName, string $prefix = '', string $alias = ''): DbAdapterQuery
    {
        $this->query->tableField($field, $tableName, $prefix, $alias);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function count(string $field = '*'): int
    {
        return $this->query->count($field);
    }

    /**
     * @inheritDoc
     */
    public function sum(string $field): float
    {
        return $this->query->sum($field);
    }

    /**
     * @inheritDoc
     */
    public function min(string $field, bool $force = true): float
    {
        return $this->query->min($field, $force);
    }

    /**
     * @inheritDoc
     */
    public function max(string $field, bool $force = true): float
    {
        return $this->query->max($field, $force);
    }

    /**
     * @inheritDoc
     */
    public function avg(string $field): float
    {
        return $this->query->avg($field);
    }

    /**
     * @inheritDoc
     */
    public function join(ModelInterface $model, string $condition = null, string $type = 'INNER', array $bind = []): DbAdapterQuery
    {
        $this->query->join($model->getTable(), $condition, $type, $bind);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function leftJoin(ModelInterface $model, string $condition = null, array $bind = []): DbAdapterQuery
    {
        $this->query->leftJoin($model->getTable(), $condition, $bind);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function rightJoin(ModelInterface $model, string $condition = null, array $bind = []): DbAdapterQuery
    {
        $this->query->rightJoin($model->getTable(), $condition, $bind);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function fullJoin(string $join, string $condition = null, array $bind = []): DbAdapterQuery
    {
        $this->query->fullJoin($join, $condition, $bind);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function where($field, $op = null, $condition = null): DbAdapterQuery
    {
        $this->query->where($field, $op, $condition);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereOr($field, $op = null, $condition = null): DbAdapterQuery
    {
        $this->query->whereOr($field, $op, $condition);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereXor($field, $op = null, $condition = null): DbAdapterQuery
    {
        $this->query->whereXor($field, $op, $condition);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereNull(string $field, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNull($field, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereNotNull(string $field, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotNull($field, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereIn(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereIn($field, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereNotIn(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotIn($field, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereLike(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereLike($field, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereNotLike(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotLike($field, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereBetween(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereBetween($field, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereNotBetween(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotBetween($field, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereExists($condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereExists($condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereNotExists($condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotExists($condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereFindInSet(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereFindInSet($field, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereJsonContains(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereJsonContains($field, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereColumn(string $field1, string $operator, string $field2 = null, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereColumn($field1, $operator, $field2, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereRaw(string $where, array $bind = [], string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereRaw($where, $bind, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereOrRaw(string $where, array $bind = []): DbAdapterQuery
    {
        $this->query->whereOrRaw($where, $bind);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereExp(string $field, string $where, array $bind = [], string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereExp($field, $where, $bind, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereFieldRaw(string $field, $op, $condition = null, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereFieldRaw($field, $op, $condition, $logic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function group($group): DbAdapterQuery
    {
        $this->query->group($group);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function order(string $field, string $order = ''): DbAdapterQuery
    {
        $this->query->order($field, $order);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function orderRaw(string $field, array $bind = []): DbAdapterQuery
    {
        $this->query->orderRaw($field, $bind);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function orderField(string $field, array $values, string $order = ''): DbAdapterQuery
    {
        $this->query->orderField($field, $values, $order);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function orderRand(): DbAdapterQuery
    {
        $this->query->orderRand();
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function limit(int $offset, int $length = null): DbAdapterQuery
    {
        $this->query->limit($offset, $length);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function page(int $page, int $page_size = null): DbAdapterQuery
    {
        $this->query->page($page, $page_size);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function find($data = null): ?Model
    {
        $result = $this->query->find($data);
        if ($result instanceof \support\think\Model) {
            return new Model($result);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function value(string $field, $default = null)
    {
        return $this->query->value($field, $default);
    }

    /**
     * @inheritDoc
     */
    public function column(string $field, string $key = ''): array
    {
        return $this->query->column($field, $key);
    }

    /**
     * @inheritDoc
     */
    public function select(array $data = []): Collection
    {
        $result = $this->query->select($data);
        $models = [];

        // 如果是 \think\Collection，转换为 Model 实例
        if ($result instanceof \think\Collection) {
            foreach ($result as $item) {
                if ($item instanceof \support\think\Model) {
                    $models[] = new Model($item);
                } else {
                    $models[] = $item;
                }
            }
        }

        return new Collection($models);
    }

    /**
     * @inheritDoc
     */
    public function chunk(int $size, Closure $closure, string $column = 'id', string $direction = 'asc'): bool
    {
        return $this->query->chunk($size, function ($items) use ($closure) {
            // 将每块数据转换为 Model 实例
            $models = [];
            foreach ($items as $item) {
                if ($item instanceof \support\think\Model) {
                    $models[] = new Model($item);
                } else {
                    $models[] = $item;
                }
            }
            // 调用回调函数
            return $closure($models);
        }, $column, $direction);
    }

    /**
     * @inheritDoc
     */
    public function paginate(int $page_size = 15, int $page = 1, array $options = []): Paginator
    {
        // 使用框架提供的分页功能
        $thinkPaginator = $this->query->paginate($page_size, false, ['page' => $page]);

        // 获取分页数据
        $total = $thinkPaginator->total();
        $currentPage = $thinkPaginator->currentPage();
        $items = [];

        // 转换为 Model 实例
        foreach ($thinkPaginator->items() as $item) {
            if ($item instanceof \support\think\Model) {
                $items[] = new Model($item);
            } else {
                $items[] = $item;
            }
        }

        return new Paginator($items, $total, $currentPage, $page_size);
    }

    /**
     * @inheritDoc
     */
    public function having(string $having): DbAdapterQuery
    {
        $this->query->having($having);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function lock($lock = false): DbAdapterQuery
    {
        $this->query->lock($lock);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function cache($key = true, $expire = null, $tag = null): DbAdapterQuery
    {
        $this->query->cache($key, $expire, $tag);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function cacheAlways($key = true, $expire = null, $tag = null): DbAdapterQuery
    {
        $this->query->cache($key, $expire, $tag, true);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function cacheForce($key = true, $expire = null, $tag = null): DbAdapterQuery
    {
        $this->query->cache($key, $expire, $tag, false, true);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function union(string $union, bool $all = false): DbAdapterQuery
    {
        $this->query->union($union, $all);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function unionAll(string $union): DbAdapterQuery
    {
        $this->query->unionAll($union);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function distinct(bool $distinct = true): DbAdapterQuery
    {
        $this->query->distinct($distinct);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function force(string $force): DbAdapterQuery
    {
        $this->query->force($force);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function comment(string $comment): DbAdapterQuery
    {
        $this->query->comment($comment);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function master(bool $readMaster = true): DbAdapterQuery
    {
        $this->query->master($readMaster);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function strict(bool $strict = true): DbAdapterQuery
    {
        $this->query->strict($strict);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function when($condition, $query, $otherwise = null): DbAdapterQuery
    {
        $this->query->when($condition, $query, $otherwise);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLastSql(): string
    {
        return $this->query->getLastSql();
    }

    public function startTrans(): void
    {
        $this->query->startTrans();
    }

    public function commit(): void
    {
        $this->query->commit();
    }

    public function rollback(): void
    {
        $this->query->rollback();
    }

    public function transaction(callable $callback)
    {
        return $this->query->transaction($callback);
    }

    public function update(array $data): int
    {
        return $this->query->update($data);
    }

    public function delete($data = null): int
    {
        return $this->query->delete($data);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->query->buildSql();
    }
}