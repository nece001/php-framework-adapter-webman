<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Captcha as ContractCaptcha;
use Nece\Framework\Adapter\Facade\Session;
use Nece\Framework\Adapter\Request;
use Webman\Captcha\CaptchaBuilder;

class Captcha implements ContractCaptcha
{
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
        $phrase = strtolower($builder->getPhrase());

        Session::set('captcha', $phrase);

        // 输出验证码二进制数据
        return $builder->get();
    }

    /**
     * @inheritDoc
     */
    public function check(string $phrase): bool
    {
        $value = Session::get('captcha');
        Session::delete('captcha');

        return strtolower($phrase) === $value;
    }
}
