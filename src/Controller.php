<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Controller as ContractController;
use Nece\Framework\Adapter\Request;
use Nece\Framework\Adapter\Facade\Response;
use support\Response as WebmanResponse;
use Workerman\Protocols\Http\Session;

class Controller implements ContractController
{
    private  $request;

    private $cookies = [];

    /**
     * 获取当前请求
     * 
     * @return Request
     */
    public function request(): Request
    {
        if (!$this->request) {
            $this->request = new Request();
        }
        return $this->request;
    }

    /**
     * @inheritDoc
     */
    public function response(string $body = '', int $status = 200, array $headers = [])
    {
        $response = Response::response($body, $status, $headers);
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function render(string $view, $data)
    {
        return $this->addCookiesToResponse(Response::view($view, $data));
    }

    /**
     * @inheritDoc
     */
    public function redirect(string $url, int $code = 302)
    {
        return $this->addCookiesToResponse(Response::redirect($url, $code));
    }

    /**
     * @inheritDoc
     */
    public function json($data, int $code = 200, array $headers = [])
    {
        $response = Response::json($data);
        foreach ($headers as $key => $value) {
            $response->withHeader($key, $value);
        }
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function xml($data, int $code = 200, array $headers = [])
    {
        $response = Response::xml($data);
        foreach ($headers as $key => $value) {
            $response->withHeader($key, $value);
        }
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function download(string $file, string $name = null, array $headers = [])
    {
        $response = Response::download($file, $name);
        foreach ($headers as $key => $value) {
            $response->withHeader($key, $value);
        }
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function stream($stream, int $code = 200, array $headers = [])
    {
        return $this->addCookiesToResponse(new WebmanResponse($code, $headers, $stream));
    }

    /**
     * @inheritDoc
     */
    protected function addCookiesToResponse(WebmanResponse $response): WebmanResponse
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
     * @inheritDoc
     */
    public function session(string $name = '', $default = null)
    {
        $session = $this->request()->session();
        if ($name === '') {
            return $session;
        }
        return $session->get($name, $default);
    }

    /**
     * @inheritDoc
     */
    public function pullSession(string $name, $default = null)
    {
        $value = $this->request()->session()->pull($name);
        return $value ? $value : $default;
    }

    /**
     * @inheritDoc
     */
    public function setSession(string $name, $value)
    {
        $this->request()->session()->put($name, $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function deleteSession(string $name)
    {
        $this->request()->session()->delete($name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSessionLifeTime(int $life_time)
    {
        Session::$lifetime = $life_time;
        Session::$cookieLifetime = $life_time;
    }

    /**
     * @inheritDoc
     */
    public function setCookie(string $name, string $value = '', int $expire = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httpOnly = true)
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
     * @inheritDoc
     */
    public function deleteCookie(string $name, string $path = '/', string $domain = '')
    {
        unset($this->cookies[$name]);
        return $this;
    }
}
