<?php
namespace App\Core;

/**
 * HTTP Request wrapper
 */
class Request
{
    public static function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public static function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public static function only(array $keys): array
    {
        return array_intersect_key(self::all(), array_flip($keys));
    }

    public static function method(): string
    {
        return $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public static function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
    }

    public static function file(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }

    public static function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    }

    public static function isAjax(): bool
    {
        return ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
    }
}
