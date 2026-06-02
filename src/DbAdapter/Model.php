<?php

namespace Nece\Framework\Adapter\DbAdapter;

use Nece\Framework\Adapter\BaseModel;
use Nece\Framework\Adapter\Contract\DbAdapter\Model as DbAdapterModel;

class Model implements DbAdapterModel, \JsonSerializable, \ArrayAccess
{
    /**
     * 数据库模型
     *
     * @var BaseModel
     */
    private BaseModel $model;

    public function __construct(BaseModel $model)
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
        $value = $this->model->getAttr($name);
        return $this->convertModel($value);
    }

    /**
     * 递归转换模型实例为适配器的 Model 类型.
     *
     * @param mixed $value 要转换的值
     *
     * @return mixed
     */
    private function convertModel($value)
    {
        // 如果返回的是模型实例，转换为适配器的 Model 类型
        if ($value instanceof \support\think\Model) {
            return new Model($value);
        }

        // 如果返回的是数组或集合，遍历并递归转换其中的模型实例
        if (is_array($value) || $value instanceof \think\Collection) {
            $result = [];
            foreach ($value as $item) {
                $result[] = $this->convertModel($item);
            }
            return $result;
        }

        return $value;
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
     * 获取属性数据.
     *
     * @param string|null $name 属性名（留空返回全部数据）
     *
     * @return array|mixed
     */
    public function getData(?string $name = null)
    {
        $value = $this->model->getData($name);
        return $this->convertModel($value);
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
        // 如果存在 forceUpdate 方法则调用，否则使用普通 save
        if (method_exists($this->model, 'forceUpdate')) {
            return $this->model->forceUpdate();
        }
        return $this->model->save();
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
     * 获取原始数据.
     *
     * @param string $name 属性名（留空返回全部原始数据）
     *
     * @return mixed
     */
    public function getOriginal(string $name = null)
    {
        // 使用 getData 作为替代，因为 think\Model 没有 getOriginal 方法
        $data = $this->model->getData();
        if ($name !== null) {
            return $data[$name] ?? null;
        }
        return $data;
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
        // 尝试多种方式获取模型名称
        if (method_exists($this->model, 'getName')) {
            return $this->model->getName();
        }
        // 通过类名推断
        $className = get_class($this->model);
        return basename(str_replace('\\', '/', $className));
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
        if (method_exists($this->model, 'getError')) {
            return $this->model->getError($all);
        }
        return null;
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
        if (method_exists($this->model, 'setError')) {
            $this->model->setError($error);
        }
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
        if (method_exists($this->model, 'validate')) {
            return $this->model->validate($data, $rules, $msg, $scene);
        }
        return true;
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
        if (method_exists($this->model, 'autoWriteTimestamp')) {
            $this->model->autoWriteTimestamp($auto);
        }
        return $this;
    }

    /**
     * 获取查询对象.
     *
     * @return ModelRelationQuery
     */
    public function query(): ModelRelationQuery
    {
        // 使用 db() 方法获取查询对象
        $query = $this->model->db();
        return new ModelRelationQuery($query);
    }

    public function toArray(): array
    {
        return $this->model->toArray();
    }

    public function __get(string $name)
    {
        return $this->getAttr($name);
    }

    public function __set(string $name, $value)
    {
        $this->setAttr($name, $value);
    }

    /**
     * JsonSerializable 接口实现
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * ArrayAccess 接口实现 - 检查偏移量是否存在
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->model->getData());
    }

    /**
     * ArrayAccess 接口实现 - 获取偏移量对应的值
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->getAttr($offset);
    }

    /**
     * ArrayAccess 接口实现 - 设置偏移量对应的值
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setAttr($offset, $value);
    }

    /**
     * ArrayAccess 接口实现 - 删除偏移量对应的值
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        $data = $this->model->getData();
        unset($data[$offset]);
        $this->model->data($data);
    }
}