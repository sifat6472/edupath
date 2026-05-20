<?php
namespace App\Core;

/**
 * Application Core
 * Implements Singleton Pattern
 */
class Application
{
    private static ?Application $instance = null;
    private Router $router;
    private Database $db;
    private array $config;

    private function __construct()
    {
        $this->config = $GLOBALS['config'];
        $this->db = Database::getInstance();
        $this->router = new Router();
        $this->loadRoutes();
    }

    public static function getInstance(): Application
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadRoutes(): void
    {
        $router = $this->router;
        require BASE_PATH . '/routes/web.php';
    }

    public function run(): void
    {
        try {
            $this->router->dispatch();
        } catch (\Throwable $e) {
            if ($this->config['debug']) {
                http_response_code(500);
                echo "<pre style='padding:20px;font-family:monospace;background:#fee;color:#900'>";
                echo "Error: " . htmlspecialchars($e->getMessage()) . "\n\n";
                echo "File: " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "\n\n";
                echo htmlspecialchars($e->getTraceAsString());
                echo "</pre>";
            } else {
                http_response_code(500);
                echo "Server Error";
            }
        }
    }

    public function getRouter(): Router { return $this->router; }
    public function getDb(): Database { return $this->db; }
    public function getConfig(): array { return $this->config; }
}
