<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Middleware as ContractMiddleware;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

abstract class Middleware implements ContractMiddleware, MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        return $this->handle($request, $handler);
    }
}
