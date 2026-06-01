<?php

namespace Nece\Framework\Adapter\DbAdapter;

use Nece\Framework\Adapter\Contract\DbAdapter\Model as DbAdapterModel;
use Nece\Framework\Adapter\Contract\DbAdapter\ModelRelationQuery;
use support\think\Model as ThinkModel;

class Model implements DbAdapterModel
{
    /**
     * 数据库模型
     *
     * @var ThinkModel
     */
    private ThinkModel $model;

    public function __construct(ThinkModel $model)
    {
        $this->model = $model;
    }

    /**
     * 创建模型实例.
     *
     * @param mixed $dbModel 底层模型实例
     *
     * @return Model
     */
    public static function instance($dbModel): DbAdapterModel
    {
        return new self($dbModel);
    }

    /**
     * 设置单个属性值.
     *
     * @param string $name  属性名
     * @param mixed  $value 属性值
     *
     * @return $this
     */
    public function setAttr(string $name, $value): DbAdapterModel
    {
        $this->model->setAttr($name, $value);
        return $this;
    }

    /**
     * 获取单个属性值.
     *
     * @param string $name 属性名
     *
     * @return mixed
     */
    public function getAttr(string $name)
    {
        return $this->model->getAttr($name);
    }

    /**
     * 设置多个属性值.
     *
     * @param array $data 属性数据
     *
     * @return $this
     */
    public function data(array $data): DbAdapterModel
    {
        $this->model->data($data);
        return $this;
    }

    /**
     * 获取全部属性数据.
     *
     * @param bool $withRelation 是否包含关联数据
     *
     * @return array
     */
    public function getData(bool $withRelation = false): array
    {
        $data = $this->model->getData();
        if ($withRelation) {
            // 获取关联数据
            $relationData = $this->model->getRelation();
            $data = array_merge($data, $relationData);
        }
        return $data;
    }

    /**
     * 判断属性是否存在.
     *
     * @param string $name 属性名
     *
     * @return bool
     */
    public function hasAttr(string $name): bool
    {
        return $this->model->hasAttr($name);
    }

    /**
     * 保存数据.
     *
     * @param array $data 数据
     *
     * @return bool
     */
    public function save(array $data = []): bool
    {
        if (!empty($data)) {
            $this->model->data($data);
        }
        return $this->model->save();
    }

    /**
     * 强制更新数据.
     *
     * @param array $data 数据
     *
     * @return bool
     */
    public function forceUpdate(array $data = []): bool
    {
        if (!empty($data)) {
            $this->model->data($data);
        }
        return $this->model->forceUpdate();
    }

    /**
     * 删除数据.
     *
     * @param mixed $data 主键值或删除条件
     *
     * @return bool
     */
    public function delete($data = null): bool
    {
        if ($data !== null) {
            return $this->model::destroy($data);
        }
        return $this->model->delete();
    }

    /**
     * 创建新记录.
     *
     * @param array $data 数据
     *
     * @return Model
     */
    public static function create(array $data): DbAdapterModel
    {
        // 获取模型类名
        $modelClass = get_called_class();
        // 创建底层模型实例
        $thinkModel = ThinkModel::create($data);
        return new self($thinkModel);
    }

    /**
     * 更新记录.
     *
     * @param array $data      更新数据
     * @param mixed $condition 更新条件
     *
     * @return int
     */
    public static function update(array $data, $condition = null): int
    {
        $result = ThinkModel::update($data, $condition);
        return $result ? 1 : 0;
    }

    /**
     * 获取原始数据.
     *
     * @param string $name 属性名（留空返回全部原始数据）
     *
     * @return mixed
     */
    public function getOriginal(string $name = null)
    {
        return $this->model->getOriginal($name);
    }

    /**
     * 判断是否为新增数据.
     *
     * @return bool
     */
    public function isNewRecord(): bool
    {
        return $this->model->isNewRecord();
    }

    /**
     * 设置主键值.
     *
     * @param mixed $value 主键值
     *
     * @return $this
     */
    public function setKey($value): DbAdapterModel
    {
        $this->model->setKey($value);
        return $this;
    }

    /**
     * 获取主键值.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->model->getKey();
    }

    /**
     * 获取主键名.
     *
     * @return string
     */
    public function getKeyName(): string
    {
        return $this->model->getKeyName();
    }

    /**
     * 获取数据表名.
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->model->getTable();
    }

    /**
     * 获取模型名称.
     *
     * @return string
     */
    public function getModelName(): string
    {
        return $this->model->getName();
    }

    /**
     * 获取错误信息.
     *
     * @param bool $all 是否获取全部错误
     *
     * @return mixed
     */
    public function getError(bool $all = false)
    {
        return $this->model->getError($all);
    }

    /**
     * 设置错误信息.
     *
     * @param mixed $error 错误信息（支持字符串或数组）
     *
     * @return $this
     */
    public function setError($error): DbAdapterModel
    {
        $this->model->setError($error);
        return $this;
    }

    /**
     * 数据验证.
     *
     * @param array  $data  数据
     * @param mixed  $rules 验证规则（支持数组或字符串场景名）
     * @param array  $msg   错误信息
     * @param string $scene 验证场景
     *
     * @return bool
     */
    public function validate(array $data = [], $rules = [], array $msg = [], string $scene = ''): bool
    {
        return $this->model->validate($data, $rules, $msg, $scene);
    }

    /**
     * 开启自动写入时间戳.
     *
     * @param bool $auto 是否自动写入
     *
     * @return $this
     */
    public function autoWriteTimestamp(bool $auto = true): DbAdapterModel
    {
        $this->model->autoWriteTimestamp($auto);
        return $this;
    }

    /**
     * 获取查询对象.
     *
     * @return ModelRelationQuery
     */
    public static function query(): ModelRelationQuery
    {
        $query = ThinkModel::query();
        return new ModelRelationQuery($query);
    }
}