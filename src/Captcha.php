<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Captcha as ContractCaptcha;
use Nece\Framework\Adapter\Request;
use Webman\Captcha\CaptchaBuilder;

class Captcha implements ContractCaptcha
{
    private $phrase;

    /**
     * @inheritDoc
     */
    public function image(): string
    {
        // 初始化验证码类
        $builder = new CaptchaBuilder();
        // 生成验证码
        $builder->build();
        // 将验证码的值存储到session中
        $this->phrase = strtolower($builder->getPhrase());
        // 输出验证码二进制数据
        return $builder->get();
    }

    /**
     * @inheritDoc
     */
    public function getPhrase(): string
    {
        return $this->phrase;
    }
}
