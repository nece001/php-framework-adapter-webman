<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Request as ContractRequest;

class Request implements ContractRequest
{
    /**
     * 请求实例
     *
     * @var \Webman\Http\Request|null
     */
    private $request;

    /**
     * 动态属性存储
     *
     * @var array
     */
    private $attributes = [];

    /**
     * 设置动态属性
     *
     * @param string $name  属性名
     * @param mixed  $value 属性值
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * 获取动态属性
     *
     * @param string $name 属性名
     * @return mixed
     */
    public function __get(string $name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return $this->request->$name;
    }

    /**
     * 检查动态属性是否存在
     *
     * @param string $name 属性名
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]) || isset($this->request->$name);
    }

    /**
     * 取消设置动态属性
     *
     * @param string $name 属性名
     * @return void
     */
    public function __unset(string $name): void
    {
        unset($this->attributes[$name]);
    }

    public function __construct()
    {
        $this->request = \request();
    }

    /**
     * 获取当前请求的参数（合并GET、POST、路由参数）
     *
     * @param string|array $name    变量名，支持数组批量获取
     * @param mixed        $default 默认值
     * @param string|array $filter  过滤方法
     * @return mixed
     */
    public function param($name = '', $default = null, $filter = '')
    {
        $params = $this->request->get() + $this->request->post();
        if ($this->request->route) {
            $params = $this->request->route->param() + $params;
        }
        return $this->getValue($params, $name, $default, $filter);
    }

    /**
     * 获取包含文件在内的所有请求参数
     *
     * @param string|array $name   变量名
     * @param string|array $filter 过滤方法
     * @return mixed
     */
    public function all($name = '', $filter = '')
    {
        $params = $this->request->all();
        $files = $this->request->file();
        if (!empty($files)) {
            $params = array_merge($params, $files);
        }
        return $this->getValue($params, $name, [], $filter);
    }

    /**
     * 获取GET参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function get($name = '', $default = null, $filter = '')
    {
        $params = $this->request->get();
        return $this->getValue($params, $name, $default, $filter);
    }

    /**
     * 获取POST参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function post($name = '', $default = null, $filter = '')
    {
        $params = $this->request->post();
        return $this->getValue($params, $name, $default, $filter);
    }

    /**
     * 获取PUT参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function put($name = '', $default = null, $filter = '')
    {
        $params = [];
        if ($this->request->method() === 'PUT') {
            $contentType = $this->request->header('content-type', '');
            if (str_contains($contentType, 'json')) {
                $params = (array)json_decode($this->request->rawBody(), true);
            } else {
                parse_str($this->request->rawBody(), $params);
            }
        }
        return $this->getValue($params, $name, $default, $filter);
    }

    /**
     * 获取DELETE参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function delete($name = '', $default = null, $filter = '')
    {
        $params = $this->request->get();
        $contentType = $this->request->header('content-type', '');
        if (str_contains($contentType, 'json')) {
            $params = array_merge($params, (array)json_decode($this->request->rawBody(), true));
        } else {
            parse_str($this->request->rawBody(), $postData);
            $params = array_merge($params, $postData);
        }
        return $this->getValue($params, $name, $default, $filter);
    }

    /**
     * 获取变量（底层方法，支持过滤和默认值）
     *
     * @param string|bool  $name    字段名
     * @param mixed        $default 默认值
     * @param string|array $filter  过滤函数
     * @return mixed
     */
    public function input($name = '', $default = null, $filter = '')
    {
        if ($name === '') {
            return $this->param();
        }
        return $this->param($name, $default, $filter);
    }

    /**
     * 获取路由参数
     *
     * @param string|array|bool $name    变量名
     * @param mixed             $default 默认值
     * @param string|array      $filter  过滤方法
     * @return mixed
     */
    public function route($name = '', $default = null, $filter = '')
    {
        $params = [];
        if ($this->request->route) {
            $params = $this->request->route->param();
        }
        return $this->getValue($params, $name, $default, $filter);
    }

    /**
     * 获取Cookie参数
     *
     * @param string       $name    变量名
     * @param mixed        $default 默认值
     * @param string|array $filter  过滤方法
     * @return mixed
     */
    public function cookie(string $name = '', $default = null, $filter = '')
    {
        if ($name === '') {
            return $this->request->cookie();
        }
        return $this->filterValue($this->request->cookie($name, $default), $filter);
    }

    /**
     * 获取Session对象
     *
     * @param string $name    变量名（空字符串返回Session对象）
     * @param mixed  $default 默认值
     * @return mixed
     */
    public function session(string $name = '', $default = null)
    {
        $session = $this->request->session();
        if ($name === '') {
            return $session;
        }
        return $session->get($name, $default);
    }

    /**
     * 获取SERVER参数
     *
     * @param string $name    变量名
     * @param string $default 默认值
     * @return mixed
     */
    public function server(string $name = '', string $default = '')
    {
        if ($name === '') {
            return $_SERVER;
        }
        $name = strtoupper($name);
        return $_SERVER[$name] ?? $default;
    }

    /**
     * 获取Header信息
     *
     * @param string     $name    header名称
     * @param string     $default 默认值
     * @return mixed
     */
    public function header(string $name = '', string $default = null)
    {
        if ($name === '') {
            return $this->request->header();
        }
        return $this->request->header($name, $default);
    }

    /**
     * 获取上传文件
     *
     * @param string $name 文件字段名
     * @return mixed
     */
    public function file(string $name = '')
    {
        return $this->request->file($name);
    }

    /**
     * 判断请求类型
     *
     * @param bool $origin 是否获取原始请求类型
     * @return string
     */
    public function method(bool $origin = false): string
    {
        if ($origin) {
            return $this->request->method();
        }
        $method = $this->request->post('_method', '');
        if (!empty($method)) {
            return strtoupper($method);
        }
        return $this->request->method();
    }

    /**
     * 是否为GET请求
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->request->isGet();
    }

    /**
     * 是否为POST请求
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->request->isPost();
    }

    /**
     * 是否为PUT请求
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->method() === 'PUT';
    }

    /**
     * 是否为DELETE请求
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->method() === 'DELETE';
    }

    /**
     * 是否为AJAX请求
     *
     * @param bool $ajax true时只检测X-Requested-With头
     * @return bool
     */
    public function isAjax(bool $ajax = false): bool
    {
        if ($ajax) {
            return $this->request->isAjax();
        }
        return $this->request->isAjax() || $this->request->expectsJson();
    }

    /**
     * 是否为JSON请求
     * @return bool
     */
    public function isJson(): bool
    {
        $contentType = $this->request->header('content-type', '');
        return str_contains($contentType, 'application/json');
    }

    /**
     * 是否为HTTPS请求
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->request->header('x-forwarded-proto') === 'https' ||
            $this->request->header('x-scheme') === 'https';
    }

    /**
     * 是否为CLI模式
     * @return bool
     */
    public function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }

    /**
     * 是否存在指定请求参数
     *
     * @param string $name       参数名
     * @param string $type       参数类型
     * @param bool   $checkEmpty 是否检查空值
     * @return bool
     */
    public function has(string $name, string $type = 'param', bool $checkEmpty = false): bool
    {
        switch ($type) {
            case 'get':
                $params = $this->request->get();
                break;
            case 'post':
                $params = $this->request->post();
                break;
            case 'put':
                $params = $this->put();
                break;
            case 'route':
                $params = $this->route();
                break;
            case 'cookie':
                $params = $this->request->cookie();
                break;
            case 'session':
                $params = $this->session();
                break;
            default:
                $params = $this->param();
        }
        if (!isset($params[$name])) {
            return false;
        }
        if ($checkEmpty) {
            return !empty($params[$name]);
        }
        return true;
    }

    /**
     * 只获取指定的参数
     *
     * @param array        $name   要获取的参数名数组
     * @param string|array $data   数据源类型或数组
     * @param string|array $filter 过滤方法
     * @return array
     */
    public function only(array $name, $data = 'param', $filter = ''): array
    {
        if (is_array($data)) {
            $params = $data;
        } else {
            switch ($data) {
                case 'get':
                    $params = $this->request->get();
                    break;
                case 'post':
                    $params = $this->request->post();
                    break;
                case 'put':
                    $params = $this->put();
                    break;
                case 'route':
                    $params = $this->route();
                    break;
                case 'cookie':
                    $params = $this->request->cookie();
                    break;
                case 'session':
                    $params = $this->session();
                    break;
                default:
                    return $this->request->only($name);
            }
        }
        $result = [];
        foreach ($name as $key) {
            if (isset($params[$key])) {
                $result[$key] = $this->filterValue($params[$key], $filter);
            }
        }
        return $result;
    }

    /**
     * 排除指定参数后获取
     *
     * @param array  $name 要排除的参数名数组
     * @param string $type 参数类型
     * @return array
     */
    public function except(array $name, string $type = 'param'): array
    {
        switch ($type) {
            case 'get':
                $params = $this->request->get();
                break;
            case 'post':
                $params = $this->request->post();
                break;
            case 'put':
                $params = $this->put();
                break;
            case 'route':
                $params = $this->route();
                break;
            case 'cookie':
                $params = $this->request->cookie();
                break;
            case 'session':
                $params = $this->session();
                break;
            default:
                return $this->request->except($name);
        }
        foreach ($name as $key) {
            unset($params[$key]);
        }
        return $params;
    }

    /**
     * 获取客户端IP地址
     * @return string
     */
    public function ip(): string
    {
        return $this->request->getRealIp();
    }

    /**
     * 获取当前URL
     *
     * @param bool $complete 是否包含完整域名
     * @return string
     */
    public function url(bool $complete = false): string
    {
        if ($complete) {
            $scheme = $this->isSsl() ? 'https' : 'http';
            return $scheme . ':' . $this->request->fullUrl();
        }
        return $this->request->url();
    }

    /**
     * 获取当前域名
     *
     * @param bool $port 是否包含端口号
     * @return string
     */
    public function domain(bool $port = false): string
    {
        return $this->request->host(!$port);
    }

    /**
     * 获取当前请求的pathinfo
     * @return string
     */
    public function pathinfo(): string
    {
        return $this->request->path();
    }

    /**
     * @inheritDoc
     */
    public function path(): string
    {
        return $this->request->path();
    }

    /**
     * 获取当前URL的后缀
     * @return string
     */
    public function ext(): string
    {
        $path = $this->request->path();
        $pos = strrpos($path, '.');
        if ($pos !== false) {
            return substr($path, $pos + 1);
        }
        return '';
    }

    /**
     * 获取当前请求的Content-Type
     * @return string
     */
    public function contentType(): string
    {
        return $this->request->header('content-type', '');
    }

    /**
     * 获取当前请求的完整内容
     * @return string
     */
    public function getContent(): string
    {
        return $this->request->rawBody();
    }

    /**
     * 获取请求时间
     *
     * @param bool $float 是否返回浮点类型
     * @return int
     */
    public function time(bool $float = false): int
    {
        if ($float) {
            return (int)(microtime(true) * 1000000);
        }
        return (int)time();
    }

    /**
     * 获取值
     *
     * @param array         $params  参数数组
     * @param string|array  $name    变量名
     * @param mixed         $default 默认值
     * @param string|array  $filter  过滤方法
     * @return mixed
     */
    protected function getValue(array $params, $name = '', $default = null, $filter = '')
    {
        if ($name === '' || $name === true) {
            if ($filter) {
                return $this->filterValues($params, $filter);
            }
            return $params;
        }

        if (is_array($name)) {
            $result = [];
            foreach ($name as $key) {
                $value = $params[$key] ?? $default;
                $result[$key] = $this->filterValue($value, $filter);
            }
            return $result;
        }

        $value = $params[$name] ?? $default;
        return $this->filterValue($value, $filter);
    }

    /**
     * 过滤单个值
     *
     * @param mixed        $value  值
     * @param string|array $filter 过滤方法
     * @return mixed
     */
    protected function filterValue($value, $filter = '')
    {
        if (!$filter || empty($value)) {
            return $value;
        }

        if (is_callable($filter)) {
            return call_user_func($filter, $value);
        }

        if (is_string($filter)) {
            $filters = explode(',', $filter);
            foreach ($filters as $f) {
                $f = trim($f);
                if (function_exists($f)) {
                    $value = $f($value);
                }
            }
        }

        return $value;
    }

    /**
     * 过滤数组值
     *
     * @param array         $values 值数组
     * @param string|array  $filter 过滤方法
     * @return array
     */
    protected function filterValues(array $values, $filter = '')
    {
        foreach ($values as &$value) {
            if (is_array($value)) {
                $value = $this->filterValues($value, $filter);
            } else {
                $value = $this->filterValue($value, $filter);
            }
        }
        return $values;
    }
}
