<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Validate as ContractValidate;
use support\validation\Validator;

class Validate implements ContractValidate
{
    /**
     * 验证数据
     *
     * @param array $data 数据
     * @param array $validate 验证规则
     * @param array $message 错误消息
     * @param array $attributes 自定义属性名
     * @param bool  $batch 是否批量验证
     *
     * @return void
     */
    public static function validate(array $data, array $validate, array $message = [], array $attributes = [], bool $batch = false): void
    {
        Validator::make($data, $validate, $message, $attributes)->validate();
    }
}