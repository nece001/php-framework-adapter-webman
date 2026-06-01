<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Request as ContractRequest;

class Request implements ContractRequest
{
    private $request;

    public function __construct()
    {
        $this->request = \request();
    }
}
