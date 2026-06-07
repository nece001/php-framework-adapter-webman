<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Exception\ValidateException;
use Nece\Framework\Adapter\Contract\Facade\Validate as ContractValidate;
use support\validation\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        try {
            // 将 Webman UploadFile 自动转换为 Symfony UploadedFile 用于验证
            $adaptedData = self::adaptWebmanFiles($data);
            Validator::make($adaptedData, $validate, $message, $attributes)->validate();
        } catch (\Exception $e) {
            echo $e->getFile() . ':' . $e->getLine() . $e->getMessage();
            throw new ValidateException($e->getMessage());
        }
    }

    /**
     * 将 Webman UploadFile 适配为 Symfony UploadedFile (因为webman没有实现这个转换)
     *
     * @param array $data
     * @return array
     */
    private static function adaptWebmanFiles(array $data): array
    {
        foreach ($data as $key => $value) {
            // 通过方法签名检测是否为 Webman UploadFile
            if (is_object($value)
                && method_exists($value, 'getRealPath')
                && method_exists($value, 'getUploadName')
                && method_exists($value, 'getUploadMimeType')
                && method_exists($value, 'getUploadErrorCode')
            ) {
                // 创建 Symfony UploadedFile 用于验证
                $data[$key] = new UploadedFile(
                    $value->getRealPath(),
                    $value->getUploadName(),
                    $value->getUploadMimeType(),
                    $value->getUploadErrorCode(),
                    true // keepOriginalName
                );
            }
        }
        return $data;
    }
}