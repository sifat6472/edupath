<?php
namespace App\Core;

/**
 * View Renderer
 * Simple Blade-inspired template engine
 */
class View
{
    private string $viewsPath;
    private array $sections = [];
    private ?string $extends = null;
    private ?string $currentSection = null;
    private static ?array $cachedFlash = null;

    public function __construct()
    {
        $this->viewsPath = BASE_PATH . '/resources/views';
    }

    public function render(string $view, array $data = []): string
    {
        $viewPath = $this->viewsPath . '/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: $view ($viewPath)");
        }

        // Make data available to view
        extract($data);

        // Helper methods available in views
        $view_instance = $this;
        $auth = \App\Services\AuthService::getInstance();
        $csrf_token = $_SESSION['_csrf_token'] ?? '';
        $flash = $this->getFlash();

        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        if ($this->extends) {
            $layoutView = $this->extends;
            $this->extends = null;
            $sections = $this->sections;
            $this->sections = [];
            // When a view extends a layout, the 'content' section becomes the main content.
            // Fallback to outer buffer if 'content' section wasn't defined.
            $mainContent = $sections['content'] ?? $content;
            return $this->renderLayout($layoutView, array_merge($data, ['sections' => $sections, 'content' => $mainContent]));
        }

        return $content;
    }

    private function renderLayout(string $layout, array $data): string
    {
        $viewPath = $this->viewsPath . '/' . str_replace('.', '/', $layout) . '.php';
        extract($data);
        $view_instance = $this;
        $auth = \App\Services\AuthService::getInstance();
        $csrf_token = $_SESSION['_csrf_token'] ?? '';
        $flash = $this->getFlash();
        
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }

    public function extend(string $layout): void
    {
        $this->extends = $layout;
    }

    public function startSection(string $name): void
    {
        $this->currentSection = $name;
        ob_start();
    }

    public function endSection(): void
    {
        if ($this->currentSection) {
            $this->sections[$this->currentSection] = ob_get_clean();
            $this->currentSection = null;
        }
    }

    public function section(string $name, array $sections = [], string $default = ''): string
    {
        return $sections[$name] ?? $default;
    }

    public function include(string $view, array $data = []): string
    {
        return (new View())->render($view, $data);
    }

    private function getFlash(): array
    {
        if (self::$cachedFlash === null) {
            self::$cachedFlash = $_SESSION['_flash'] ?? [];
            unset($_SESSION['_flash']);
        }
        return self::$cachedFlash;
    }

    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
