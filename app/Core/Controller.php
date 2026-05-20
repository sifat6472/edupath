<?php
namespace App\Core;

/**
 * Base Controller
 */
abstract class Controller
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    protected function view(string $template, array $data = []): string
    {
        return $this->view->render($template, $data);
    }

    protected function redirect(string $url): string
    {
        return Response::redirect($url);
    }

    protected function back(): string
    {
        return Response::back();
    }

    protected function json($data, int $status = 200): string
    {
        return Response::json($data, $status);
    }

    protected function validateCsrf(): void
    {
        $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!hash_equals($_SESSION['_csrf_token'] ?? '', $token)) {
            http_response_code(419);
            die('CSRF token mismatch. Please refresh and try again.');
        }
    }

    protected function validate(array $rules): array
    {
        $errors = [];
        $data = [];
        foreach ($rules as $field => $ruleStr) {
            $value = trim($_POST[$field] ?? '');
            $data[$field] = $value;
            $ruleList = explode('|', $ruleStr);
            foreach ($ruleList as $rule) {
                if ($rule === 'required' && $value === '') {
                    $errors[$field] = ucfirst($field) . ' is required';
                    break;
                }
                if ($rule === 'email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = 'Invalid email address';
                    break;
                }
                if (strpos($rule, 'min:') === 0) {
                    $min = (int) substr($rule, 4);
                    if (strlen($value) < $min) {
                        $errors[$field] = ucfirst($field) . " must be at least $min characters";
                        break;
                    }
                }
                if (strpos($rule, 'max:') === 0) {
                    $max = (int) substr($rule, 4);
                    if (strlen($value) > $max) {
                        $errors[$field] = ucfirst($field) . " may not exceed $max characters";
                        break;
                    }
                }
            }
        }
        if (!empty($errors)) {
            Response::flash('errors', $errors);
            Response::flash('old', $data);
            Response::back();
        }
        return $data;
    }
}
