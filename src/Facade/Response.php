<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Response as ResponseContract;
use Webman\Http\Response as HttpResponse;

class Response implements ResponseContract
{
    public static function response(string $body = '', int $status = 200, array $headers = [])
    {
        return response($body, $status, $headers);
    }

    public static function json($data, int $status = 200, array $headers = [], array $options = [])
    {
        $options = empty($options) ? JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR : $options;
        $response = new HttpResponse($status, array_merge(['Content-Type' => 'application/json'], $headers), json_encode($data, $options));
        return $response;
    }

    public static function xml($xml, int $status = 200, array $headers = [], array $options = [])
    {
        if ($xml instanceof \SimpleXMLElement) {
            $xml = $xml->asXML();
        }
        $response = new HttpResponse($status, array_merge(['Content-Type' => 'text/xml'], $headers), $xml);
        return $response;
    }

    public static function jsonp($data, int $status = 200, array $headers = [], array $options = [])
    {
        $callbackName = isset($options['callback']) ? $options['callback'] : 'callback';
        if (!is_scalar($data) && null !== $data) {
            $data = json_encode($data);
        }
        $response = new HttpResponse($status, $headers, "$callbackName($data)");
        return $response;
    }

    public static function redirect(string $location, int $status = 302)
    {
        return redirect($location, $status);
    }

    public static function view(mixed $template = null, array $vars = [], int $status = 200)
    {
        $viewResponse = view($template, $vars);
        if ($status !== 200) {
            $viewResponse->withStatus($status);
        }
        return $viewResponse;
    }

    public static function download(string $filename, string $name = '', bool $content = false, int $expire = 180)
    {
        $response = new HttpResponse();
        if ($content) {
            $response->header('Content-Type', 'application/octet-stream');
            if ($name) {
                $name = str_replace(['"', "\r", "\n", "\0"], '', $name);
                $response->header('Content-Disposition', "attachment; filename=\"$name\"");
            }
            $response->header('Content-Length', strlen($filename));
            $response->header('Cache-Control', "max-age=$expire");
            $response->withBody($filename);
        } else {
            $response->download($filename, $name);
        }
        return $response;
    }

    public static function notFound()
    {
        return not_found();
    }

    public static function buildData($code, $status, $message, $data = [])
    {
        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}