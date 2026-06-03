<?php

namespace Nece\Framework\Adapter\DbAdapter;

use think\model\concern\SoftDelete as SoftDeleteConcern;

trait SoftDelete
{
    use SoftDeleteConcern;
}
