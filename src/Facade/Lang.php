<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Lang as ContractLang;

class Lang implements ContractLang
{
    public static function trans(string $key, array $replace = []): string
    {
        return \trans($key, $replace);
    }
}