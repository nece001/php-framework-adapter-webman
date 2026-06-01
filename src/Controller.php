<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Controller as ContractController;
use Nece\Framework\Adapter\Contract\Request;
use support\Response;

class Controller implements ContractController
{
    private Request $request;

    private $cookies = [];

    /**
     * 获取当前请求
     * 
     * @return Request
     */
    public function request(): Request
    {
        if ($this->request === null) {
            $this->request = new Request();
        }
        return $this->request;
    }

    /**
     * 渲染视图
     * 
     * @param string $view 视图路径
     * @param array $data 视图数据
     * @return Response
     */
    public function render(string $view, $data)
    {
        return $this->addCookiesToResponse(\view($view, $data));
    }

    /**
     * 重定向
     * 
     * @param string $url 重定向URL
     * @param int $code HTTP状态码
     * @return Response
     */
    public function redirect(string $url, int $code = 302)
    {
        return $this->addCookiesToResponse(\redirect($url, $code));
    }

    /**
     * 返回 JSON 响应
     *
     * @param mixed $data 数据
     * @param int $code HTTP状态码
     * @param array $headers 响应头
     * @return Response
     */
    public function json($data, int $code = 200, array $headers = [])
    {
        return $this->addCookiesToResponse(\json($data, $code, $headers));
    }

    /**
     * 返回 XML 响应
     *
     * @param mixed $data 数据
     * @param int $code HTTP状态码
     * @param array $headers 响应头
     * @return Response
     */
    public function xml($data, int $code = 200, array $headers = [])
    {
        return $this->addCookiesToResponse(\xml($data, $code, $headers));
    }

    /**
     * 文件下载
     *
     * @param string $file 文件路径
     * @param string|null $name 下载文件名
     * @param array $headers 响应头
     * @return Response
     */
    public function download(string $file, string $name = null, array $headers = [])
    {
        $response = new Response(200, $headers, file_get_contents($file));
        if ($name) {
            $response->withHeader('Content-Disposition', 'attachment; filename=' . $name);
        }
        return $this->addCookiesToResponse($response);
    }

    /**
     * 流式响应
     *
     * @param resource $stream 数据流
     * @param int $code HTTP状态码
     * @param array $headers 响应头
     * @return Response
     */
    public function stream($stream, int $code = 200, array $headers = [])
    {
        return $this->addCookiesToResponse(new Response($code, $headers, $stream));
    }

    /**
     * 向响应对象添加所有cookie
     *
     * @param Response $response
     * @return Response
     */
    protected function addCookiesToResponse(Response $response): Response
    {
        foreach ($this->cookies as $cookie) {
            $response->cookie(
                $cookie['name'],
                $cookie['value'],
                $cookie['expire'],
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httpOnly']
            );
        }
        // 清空已添加的cookies
        $this->cookies = [];
        return $response;
    }

    /**
     * 获取 Session
     *
     * @param string $name Session键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function session(string $name = '', $default = null)
    {
        return $this->request()->session()->get($name, $default);
    }

    /**
     * 设置 Session
     *
     * @param string $name Session键名
     * @param mixed $value Session值
     * @return $this
     */
    public function setSession(string $name, $value)
    {
        $this->request()->session()->put($name, $value);
        return $this;
    }

    /**
     * 删除 Session
     *
     * @param string $name Session键名
     * @return $this
     */
    public function deleteSession(string $name)
    {
        $this->request()->session()->delete($name);
        return $this;
    }

    /**
     * 设置 Cookie
     *
     * @param string $name Cookie名称
     * @param string $value Cookie值
     * @param int $expire 过期时间（秒）
     * @param string $path 路径
     * @param string $domain 域名
     * @param bool $secure 是否安全连接
     * @param bool $httpOnly 是否仅HTTP访问
     * @return $this
     */
    public function cookie(string $name, string $value = '', int $expire = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httpOnly = true)
    {
        $this->cookies[$name] = [
            'name' => $name,
            'value' => $value,
            'expire' => $expire,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httpOnly' => $httpOnly,
        ];
        return $this;
    }

    /**
     * 删除 Cookie
     *
     * @param string $name Cookie名称
     * @param string $path 路径
     * @param string $domain 域名
     * @return $this
     */
    public function deleteCookie(string $name, string $path = '/', string $domain = '')
    {
        unset($this->cookies[$name]);
        return $this;
    }
}