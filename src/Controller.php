<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Controller as ContractController;
use Nece\Framework\Adapter\Request;
use support\Response;

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
        $response = new Response($status, $headers, $body);
        return $this->addCookiesToResponse($response);
    }

    /**
     * @inheritDoc
     */
    public function render(string $view, $data)
    {
        return $this->addCookiesToResponse(\view($view, $data));
    }

    /**
     * @inheritDoc
     */
    public function redirect(string $url, int $code = 302)
    {
        return $this->addCookiesToResponse(\redirect($url, $code));
    }

    /**
     * @inheritDoc
     */
    public function json($data, int $code = 200, array $headers = [])
    {
        return $this->addCookiesToResponse(\json($data, $code, $headers));
    }

    /**
     * @inheritDoc
     */
    public function xml($data, int $code = 200, array $headers = [])
    {
        return $this->addCookiesToResponse(\xml($data, $code, $headers));
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function stream($stream, int $code = 200, array $headers = [])
    {
        return $this->addCookiesToResponse(new Response($code, $headers, $stream));
    }

    /**
     * @inheritDoc
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
