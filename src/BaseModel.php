<?php

namespace Nece\Framework\Adapter;

use support\think\Model;

class BaseModel extends Model
{
    protected function init()
    {
        if (isset($this->casts)) {
            $this->type = $this->casts;
        }
    }
}
