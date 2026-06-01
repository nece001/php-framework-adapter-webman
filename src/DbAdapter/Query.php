<?php

namespace Nece\Framework\Adapter\DbAdapter;

use Nece\Framework\Adapter\Contract\DbAdapter\Query as DbAdapterQuery;
use Nece\Framework\Adapter\Paginator;
use think\db\Query as ThinkQuery;

class Query implements DbAdapterQuery
{
    /**
     * 数据库查询
     *
     * @var ThinkQuery
     */
    private ThinkQuery $query;

    public function __construct(ThinkQuery $query)
    {
        $this->query = $query;
    }

    /**
     * 指定当前数据表名（不含前缀）.
     *
     * @param string $name 不含前缀的数据表名字
     *
     * @return $this
     */
    public function name(string $name): DbAdapterQuery
    {
        $this->query->name($name);
        return $this;
    }

    /**
     * 指定当前操作的数据表.
     *
     * @param string $table 表名（支持完整表名，可包含前缀）
     *
     * @return $this
     */
    public function table(string $table): DbAdapterQuery
    {
        $this->query->table($table);
        return $this;
    }

    /**
     * 指定数据表别名.
     *
     * @param string $alias 数据表别名
     *
     * @return $this
     */
    public function alias(string $alias): DbAdapterQuery
    {
        $this->query->alias($alias);
        return $this;
    }

    /**
     * 获取数据表别名.
     *
     * @param string $table 数据表（留空取当前表）
     *
     * @return string
     */
    public function getAlias(string $table = ''): string
    {
        return $this->query->getAlias($table);
    }

    /**
     * 指定查询字段.
     *
     * @param array $field 字段信息（支持字段名数组或键值对数组）
     *
     * @return $this
     */
    public function field(array $field): DbAdapterQuery
    {
        $this->query->field($field);
        return $this;
    }

    /**
     * 表达式方式指定查询字段.
     *
     * @param string $field 字段名（支持SQL表达式）
     *
     * @return $this
     */
    public function fieldRaw(string $field): DbAdapterQuery
    {
        $this->query->fieldRaw($field);
        return $this;
    }

    /**
     * 指定要排除的查询字段.
     *
     * @param array $field 要排除的字段（字段名数组）
     *
     * @return $this
     */
    public function withoutField(array $field): DbAdapterQuery
    {
        $this->query->withoutField($field);
        return $this;
    }

    /**
     * 指定其它数据表的查询字段.
     *
     * @param array  $field     字段信息（字段名数组）
     * @param string $tableName 数据表名
     * @param string $prefix    字段前缀
     * @param string $alias     别名前缀
     *
     * @return $this
     */
    public function tableField(array $field, string $tableName, string $prefix = '', string $alias = ''): DbAdapterQuery
    {
        $this->query->tableField($field, $tableName, $prefix, $alias);
        return $this;
    }

    /**
     * COUNT查询.
     *
     * @param string $field 字段名
     *
     * @return int
     */
    public function count(string $field = '*'): int
    {
        return $this->query->count($field);
    }

    /**
     * SUM查询.
     *
     * @param string $field 字段名
     *
     * @return float
     */
    public function sum(string $field): float
    {
        return $this->query->sum($field);
    }

    /**
     * MIN查询.
     *
     * @param string $field 字段名
     * @param bool   $force 是否强制转为数字类型
     *
     * @return float
     */
    public function min(string $field, bool $force = true): float
    {
        return $this->query->min($field, $force);
    }

    /**
     * MAX查询.
     *
     * @param string $field 字段名
     * @param bool   $force 是否强制转为数字类型
     *
     * @return float
     */
    public function max(string $field, bool $force = true): float
    {
        return $this->query->max($field, $force);
    }

    /**
     * AVG查询.
     *
     * @param string $field 字段名
     *
     * @return float
     */
    public function avg(string $field): float
    {
        return $this->query->avg($field);
    }

    /**
     * 查询SQL组装 join.
     *
     * @param string $join      关联的表名
     * @param string $condition 条件
     * @param string $type      JOIN类型（支持 INNER, LEFT, RIGHT, FULL）
     * @param array  $bind      参数绑定
     *
     * @return $this
     */
    public function join(string $join, string $condition = null, string $type = 'INNER', array $bind = []): DbAdapterQuery
    {
        $this->query->join($join, $condition, $type, $bind);
        return $this;
    }

    /**
     * LEFT JOIN.
     *
     * @param string $join      关联的表名
     * @param string $condition 条件
     * @param array  $bind      参数绑定
     *
     * @return $this
     */
    public function leftJoin(string $join, string $condition = null, array $bind = []): DbAdapterQuery
    {
        $this->query->leftJoin($join, $condition, $bind);
        return $this;
    }

    /**
     * RIGHT JOIN.
     *
     * @param string $join      关联的表名
     * @param string $condition 条件
     * @param array  $bind      参数绑定
     *
     * @return $this
     */
    public function rightJoin(string $join, string $condition = null, array $bind = []): DbAdapterQuery
    {
        $this->query->rightJoin($join, $condition, $bind);
        return $this;
    }

    /**
     * FULL JOIN.
     *
     * @param string $join      关联的表名
     * @param string $condition 条件
     * @param array  $bind      参数绑定
     *
     * @return $this
     */
    public function fullJoin(string $join, string $condition = null, array $bind = []): DbAdapterQuery
    {
        $this->query->fullJoin($join, $condition, $bind);
        return $this;
    }

    /**
     * 指定AND查询条件.
     *
     * @param mixed $field     查询字段（支持字符串字段名、数组条件、闭包、Query对象）
     * @param mixed $op        查询表达式（=, <, >, <=, >=, <>, !=, LIKE等）
     * @param mixed $condition 查询条件（支持字符串、数字、数组、闭包）
     *
     * @return $this
     */
    public function where($field, $op = null, $condition = null): DbAdapterQuery
    {
        $this->query->where($field, $op, $condition);
        return $this;
    }

    /**
     * 指定OR查询条件.
     *
     * @param mixed $field     查询字段（支持字符串字段名、数组条件、闭包）
     * @param mixed $op        查询表达式（=, <, >, <=, >=, <>, !=, LIKE等）
     * @param mixed $condition 查询条件（支持字符串、数字、数组、闭包）
     *
     * @return $this
     */
    public function whereOr($field, $op = null, $condition = null): DbAdapterQuery
    {
        $this->query->whereOr($field, $op, $condition);
        return $this;
    }

    /**
     * 指定XOR查询条件.
     *
     * @param mixed $field     查询字段（支持字符串字段名、数组条件、闭包）
     * @param mixed $op        查询表达式（=, <, >, <=, >=, <>, !=, LIKE等）
     * @param mixed $condition 查询条件（支持字符串、数字、数组、闭包）
     *
     * @return $this
     */
    public function whereXor($field, $op = null, $condition = null): DbAdapterQuery
    {
        $this->query->whereXor($field, $op, $condition);
        return $this;
    }

    /**
     * 指定Null查询条件.
     *
     * @param string $field 查询字段
     * @param string $logic 查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereNull(string $field, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNull($field, $logic);
        return $this;
    }

    /**
     * 指定NotNull查询条件.
     *
     * @param string $field 查询字段
     * @param string $logic 查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereNotNull(string $field, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotNull($field, $logic);
        return $this;
    }

    /**
     * 指定In查询条件.
     *
     * @param string $field     查询字段
     * @param mixed  $condition 查询条件（支持数组或闭包子查询）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereIn(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereIn($field, $condition, $logic);
        return $this;
    }

    /**
     * 指定NotIn查询条件.
     *
     * @param string $field     查询字段
     * @param mixed  $condition 查询条件（支持数组或闭包子查询）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereNotIn(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotIn($field, $condition, $logic);
        return $this;
    }

    /**
     * 指定Like查询条件.
     *
     * @param string $field     查询字段
     * @param mixed  $condition 查询条件（支持字符串或数组）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereLike(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereLike($field, $condition, $logic);
        return $this;
    }

    /**
     * 指定NotLike查询条件.
     *
     * @param string $field     查询字段
     * @param mixed  $condition 查询条件（支持字符串或数组）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereNotLike(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotLike($field, $condition, $logic);
        return $this;
    }

    /**
     * 指定Between查询条件.
     *
     * @param string $field     查询字段
     * @param mixed  $condition 查询条件（支持数组或字符串）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereBetween(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereBetween($field, $condition, $logic);
        return $this;
    }

    /**
     * 指定NotBetween查询条件.
     *
     * @param string $field     查询字段
     * @param mixed  $condition 查询条件（支持数组或字符串）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereNotBetween(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotBetween($field, $condition, $logic);
        return $this;
    }

    /**
     * 指定Exists查询条件.
     *
     * @param mixed  $condition 查询条件（支持闭包子查询或SQL字符串）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereExists($condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereExists($condition, $logic);
        return $this;
    }

    /**
     * 指定NotExists查询条件.
     *
     * @param mixed  $condition 查询条件（支持闭包子查询或SQL字符串）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereNotExists($condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereNotExists($condition, $logic);
        return $this;
    }

    /**
     * 指定FIND_IN_SET查询条件.
     *
     * @param string $field     查询字段
     * @param mixed  $condition 查询条件（支持字符串或数组）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereFindInSet(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereFindInSet($field, $condition, $logic);
        return $this;
    }

    /**
     * 指定json_contains查询条件.
     *
     * @param string $field     查询字段
     * @param mixed  $condition 查询条件（支持数组、对象、字符串）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereJsonContains(string $field, $condition, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereJsonContains($field, $condition, $logic);
        return $this;
    }

    /**
     * 比较两个字段.
     *
     * @param string $field1   查询字段
     * @param string $operator 比较操作符（支持=, <, >, <=, >=, <>, !=）
     * @param string $field2   比较字段
     * @param string $logic    查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereColumn(string $field1, string $operator, string $field2 = null, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereColumn($field1, $operator, $field2, $logic);
        return $this;
    }

    /**
     * 指定表达式查询条件.
     *
     * @param string $where 查询条件（支持SQL表达式）
     * @param array  $bind  参数绑定
     * @param string $logic 查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereRaw(string $where, array $bind = [], string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereRaw($where, $bind, $logic);
        return $this;
    }

    /**
     * 指定表达式查询条件 OR.
     *
     * @param string $where 查询条件（支持SQL表达式）
     * @param array  $bind  参数绑定
     *
     * @return $this
     */
    public function whereOrRaw(string $where, array $bind = []): DbAdapterQuery
    {
        $this->query->whereOrRaw($where, $bind);
        return $this;
    }

    /**
     * 指定Exp查询条件.
     *
     * @param string $field 查询字段
     * @param string $where 查询条件（支持SQL表达式）
     * @param array  $bind  参数绑定
     * @param string $logic 查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereExp(string $field, string $where, array $bind = [], string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereExp($field, $where, $bind, $logic);
        return $this;
    }

    /**
     * 指定字段Raw查询.
     *
     * @param string $field     查询字段表达式（支持SQL表达式）
     * @param mixed  $op        查询表达式（支持=, <, >等操作符或作为条件值）
     * @param mixed  $condition 查询条件（支持字符串、数字，若为null则$op作为条件值）
     * @param string $logic     查询逻辑（支持 and, or, xor）
     *
     * @return $this
     */
    public function whereFieldRaw(string $field, $op, $condition = null, string $logic = 'AND'): DbAdapterQuery
    {
        $this->query->whereFieldRaw($field, $op, $condition, $logic);
        return $this;
    }

    /**
     * 指定group查询.
     *
     * @param mixed $group GROUP字段（支持字符串或数组）
     *
     * @return $this
     */
    public function group($group): DbAdapterQuery
    {
        $this->query->group($group);
        return $this;
    }

    /**
     * 指定排序 order('id','desc').
     *
     * @param string $field 排序字段
     * @param string $order 排序方向（支持 desc, asc，默认为空表示asc）
     *
     * @return $this
     */
    public function order(string $field, string $order = ''): DbAdapterQuery
    {
        $this->query->order($field, $order);
        return $this;
    }

    /**
     * 表达式方式指定Field排序.
     *
     * @param string $field 排序字段（支持SQL表达式）
     * @param array  $bind  参数绑定
     *
     * @return $this
     */
    public function orderRaw(string $field, array $bind = []): DbAdapterQuery
    {
        $this->query->orderRaw($field, $bind);
        return $this;
    }

    /**
     * 指定Field排序 orderField('id',[1,2,3],'desc').
     *
     * @param string $field  排序字段
     * @param array  $values 排序值数组
     * @param string $order  排序方向（支持 desc, asc）
     *
     * @return $this
     */
    public function orderField(string $field, array $values, string $order = ''): DbAdapterQuery
    {
        $this->query->orderField($field, $values, $order);
        return $this;
    }

    /**
     * 随机排序.
     *
     * @return $this
     */
    public function orderRand(): DbAdapterQuery
    {
        $this->query->orderRand();
        return $this;
    }

    /**
     * 指定查询数量.
     *
     * @param int $offset 起始位置
     * @param int $length 查询数量
     *
     * @return $this
     */
    public function limit(int $offset, int $length = null): DbAdapterQuery
    {
        $this->query->limit($offset, $length);
        return $this;
    }

    /**
     * 指定分页.
     *
     * @param int $page     页数
     * @param int $listRows 每页数量
     *
     * @return $this
     */
    public function page(int $page, int $listRows = null): DbAdapterQuery
    {
        $this->query->page($page, $listRows);
        return $this;
    }

    /**
     * 查询单条记录.
     *
     * @param mixed $data 主键值或查询条件
     *
     * @return Model|null
     */
    public function find($data = null): ?Model
    {
        $result = $this->query->find($data);
        if ($result instanceof \support\think\Model) {
            return new Model($result);
        }
        return null;
    }

    /**
     * 获取单个字段值.
     *
     * @param string $field   字段名
     * @param mixed  $default 默认值
     *
     * @return mixed
     */
    public function value(string $field, $default = null)
    {
        return $this->query->value($field, $default);
    }

    /**
     * 获取一列值.
     *
     * @param string $field 字段名
     * @param string $key   索引字段名
     *
     * @return array
     */
    public function column(string $field, string $key = ''): array
    {
        return $this->query->column($field, $key);
    }

    /**
     * 查询多条记录.
     *
     * @param mixed $data 查询条件
     *
     * @return Model[]
     */
    public function select($data = null): array
    {
        $result = $this->query->select($data);

        // 如果是 \think\Collection，转换为 Model 实例
        if ($result instanceof \think\Collection) {
            $models = [];
            foreach ($result as $item) {
                if ($item instanceof \support\think\Model) {
                    $models[] = new Model($item);
                }
            }
            return $models;
        }

        // 如果是数组，直接返回
        return (array) $result;
    }

    /**
     * 分块查询数据.
     *
     * @param int     $size        每块的数量
     * @param Closure $closure     处理每块数据的回调函数
     * @param string  $column      排序字段
     * @param string  $direction   排序方向
     *
     * @return bool
     */
    public function chunk(int $size, Closure $closure, string $column = 'id', string $direction = 'asc'): bool
    {
        return $this->query->chunk($size, function ($items) use ($closure) {
            // 将每块数据转换为 Model 实例
            $models = [];
            foreach ($items as $item) {
                if ($item instanceof \support\think\Model) {
                    $models[] = new Model($item);
                }
            }
            // 调用回调函数
            return $closure($models);
        }, $column, $direction);
    }

    /**
     * 分页查询.
     *
     * @param int   $page     当前页码
     * @param int   $listRows 每页数量
     * @param array $options  额外选项
     *
     * @return Paginator
     */
    public function paginate(int $page = 1, int $listRows = 15, array $options = []): Paginator
    {
        // 设置分页参数
        $this->query->page($page, $listRows);
        // 获取总记录数
        $total = $this->query->count();
        // 执行查询
        $result = $this->query->select();

        // 如果是 \think\Collection，转换为 Model 实例
        if ($result instanceof \think\Collection) {
            $items = [];
            foreach ($result as $item) {
                if ($item instanceof \support\think\Model) {
                    $items[] = new Model($item);
                }
            }
        } else {
            // 如果是数组，直接使用
            $items = (array) $result;
        }

        // 创建通用分页器
        return new Paginator($items, $total, $page, $listRows);
    }

    /**
     * 指定having查询.
     *
     * @param string $having HAVING条件（支持SQL表达式）
     *
     * @return $this
     */
    public function having(string $having): DbAdapterQuery
    {
        $this->query->having($having);
        return $this;
    }

    /**
     * 指定查询lock.
     *
     * @param mixed $lock 是否lock（支持bool或lock表达式字符串）
     *
     * @return $this
     */
    public function lock($lock = false): DbAdapterQuery
    {
        $this->query->lock($lock);
        return $this;
    }

    /**
     * 查询缓存 数据为空不缓存.
     *
     * @param mixed $key    缓存key（true自动生成，string指定key，false关闭缓存）
     * @param mixed $expire 缓存有效期（秒数或DateTime对象）
     * @param mixed $tag    缓存标签（支持字符串或数组）
     *
     * @return $this
     */
    public function cache($key = true, $expire = null, $tag = null): DbAdapterQuery
    {
        $this->query->cache($key, $expire, $tag);
        return $this;
    }

    /**
     * 查询缓存 允许缓存空数据.
     *
     * @param mixed $key    缓存key（true自动生成，string指定key）
     * @param mixed $expire 缓存有效期（秒数或DateTime对象）
     * @param mixed $tag    缓存标签（支持字符串或数组）
     *
     * @return $this
     */
    public function cacheAlways($key = true, $expire = null, $tag = null): DbAdapterQuery
    {
        $this->query->cache($key, $expire, $tag, true);
        return $this;
    }

    /**
     * 强制更新缓存
     *
     * @param mixed $key    缓存key（true自动生成，string指定key）
     * @param mixed $expire 缓存有效期（秒数或DateTime对象）
     * @param mixed $tag    缓存标签（支持字符串或数组）
     *
     * @return $this
     */
    public function cacheForce($key = true, $expire = null, $tag = null): DbAdapterQuery
    {
        $this->query->cache($key, $expire, $tag, false, true);
        return $this;
    }

    /**
     * 指定查询SQL组装 union.
     *
     * @param string $union UNION查询（支持SQL字符串或Query对象）
     * @param bool   $all   是否使用UNION ALL
     *
     * @return $this
     */
    public function union(string $union, bool $all = false): DbAdapterQuery
    {
        $this->query->union($union, $all);
        return $this;
    }

    /**
     * 查询SQL组装 union all.
     *
     * @param string $union UNION查询（支持SQL字符串或Query对象）
     *
     * @return $this
     */
    public function unionAll(string $union): DbAdapterQuery
    {
        $this->query->unionAll($union);
        return $this;
    }

    /**
     * 指定distinct查询.
     *
     * @param bool $distinct 是否唯一
     *
     * @return $this
     */
    public function distinct(bool $distinct = true): DbAdapterQuery
    {
        $this->query->distinct($distinct);
        return $this;
    }

    /**
     * 指定强制索引.
     *
     * @param string $force 索引名称
     *
     * @return $this
     */
    public function force(string $force): DbAdapterQuery
    {
        $this->query->force($force);
        return $this;
    }

    /**
     * 查询注释.
     *
     * @param string $comment 注释内容
     *
     * @return $this
     */
    public function comment(string $comment): DbAdapterQuery
    {
        $this->query->comment($comment);
        return $this;
    }

    /**
     * 设置从主服务器读取数据.
     *
     * @param bool $readMaster 是否从主服务器读取
     *
     * @return $this
     */
    public function master(bool $readMaster = true): DbAdapterQuery
    {
        $this->query->master($readMaster);
        return $this;
    }

    /**
     * 设置是否严格检查字段名.
     *
     * @param bool $strict 是否严格检查字段
     *
     * @return $this
     */
    public function strict(bool $strict = true): DbAdapterQuery
    {
        $this->query->strict($strict);
        return $this;
    }

    /**
     * 条件查询.
     *
     * @param mixed $condition 满足条件（支持闭包、布尔值、非空值）
     * @param mixed $query     满足条件后执行的查询表达式（闭包或数组）
     * @param mixed $otherwise 不满足条件后执行（支持闭包或数组）
     *
     * @return $this
     */
    public function when($condition, $query, $otherwise = null): DbAdapterQuery
    {
        $this->query->when($condition, $query, $otherwise);
        return $this;
    }

    /**
     * 转换为字符串（SQL语句）
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->query;
    }
}