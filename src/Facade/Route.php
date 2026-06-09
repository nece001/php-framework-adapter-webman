<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Route as ContractRouteFacade;
use webman\Route as WebmanRoute;

class Route implements ContractRouteFacade
{
    public static function addRules(array $rules): void
    {
        foreach ($rules as $rule) {
            $group = $rule['group'];
            $controllers = $rule['controllers'];

            $prefix = rtrim($group['prefix'], '/');

            foreach ($controllers as $controller) {
                $controller_class = $controller['controller'];
                $methods = $controller['methods'];
                foreach ($methods as $method) {
                    $path = $prefix . '/' . ltrim($method['path'], '/');
                    $action = $method['action'];
                    $name = $method['name'] ?? '';
                    $match = $method['match'] ?? false;
                    $mtd = $method['method'] ?? 'get';

                    $rounte = WebmanRoute::add($mtd, $path, [$controller_class, $action]);
                    if ($name) {
                        $rounte->name($name);
                    }
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public static function url(string $name, array $params = []): string
    {
        $url = route($name, $params);

        // 把编码后的{}还原
        return str_replace(['%7B', '%7D'], ['{', '}'], $url);
    }
}
