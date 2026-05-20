<?php
namespace App\Core;

/**
 * HTTP Response helpers
 */
class Response
{
    public static function redirect(string $url): string
    {
        header("Location: $url");
        exit;
    }

    public static function back(): string
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: $referer");
        exit;
    }

    public static function json($data, int $status = 200): string
    {
        http_response_code($status);
        header('Content-Type: application/json');
        return json_encode($data);
    }

    public static function flash(string $key, $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function withFlash(string $url, string $key, $value): string
    {
        self::flash($key, $value);
        return self::redirect($url);
    }
}
