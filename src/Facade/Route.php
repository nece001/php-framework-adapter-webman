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
                    $method = $method['method'] ?? 'get';
                    $name = $method['name'] ?? '';
                    $match = $method['match'] ?? false;

                    $rounte = WebmanRoute::add($method, $path, [$controller_class, $action]);
                    if ($name) {
                        $rounte->name($name);
                    }
                    if ($match) {
                        $rounte->completeMatch();
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
        return route($name, $params);
    }
}
