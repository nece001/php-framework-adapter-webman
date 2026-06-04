<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Response as ResponseContract;

class Response implements ResponseContract
{
    /**
     * @inheritDoc
     */
    public static function response(string $body = '', int $status = 200, array $headers = [])
    {
        return \response($body, $status, $headers);
    }

    /**
     * @inheritDoc
     */
    public static function json($data, int $options = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)
    {
        return \json($data, $options);
    }

    /**
     * @inheritDoc
     */
    public static function xml($xml)
    {
        return \xml($xml);
    }

    /**
     * @inheritDoc
     */
    public static function jsonp($data, string $callback_name = 'callback')
    {
        return \jsonp($data, $callback_name);
    }

    /**
     * @inheritDoc
     */
    public static function redirect(string $location, int $status = 302, array $headers = [])
    {
        return \redirect($location, $status, $headers);
    }

    /**
     * @inheritDoc
     */
    public static function view(mixed $template = null, array $vars = [], ?string $app = null, ?string $plugin = null)
    {
        return \view($template, $vars, $app, $plugin);
    }

    /**
     * @inheritDoc
     */
    public static function download(string $file_path, ?string $filename = null)
    {
        $response = new \support\Response();
        return $response->download($file_path, $filename ?? '');
    }

    /**
     * @inheritDoc
     */
    public static function notFound()
    {
        return \not_found();
    }
}