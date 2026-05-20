<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\ProfessorRepository;
use App\Services\AuthService;
use App\Services\NotificationService;

class ProfessorController extends Controller
{
    private ProfessorRepository $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new ProfessorRepository();
    }

    public function index(): string
    {
        $filters = [
            'q' => Request::input('q', ''),
            'accepting' => Request::input('accepting', ''),
            'research_area' => Request::input('research_area', ''),
        ];

        $professors = $this->repo->search($filters);

        return $this->view('professors.index', [
            'title' => 'Professor & Lab Directory',
            'professors' => $professors,
            'filters' => $filters,
        ]);
    }

    public function show(string $id): string
    {
        $professor = $this->repo->findWithDetails((int)$id);
        if (!$professor) {
            http_response_code(404);
            return $this->view('errors.404', ['title' => '404']);
        }

        $labs = $this->repo->getLabs((int)$id);

        return $this->view('professors.show', [
            'title' => $professor['name'],
            'professor' => $professor,
            'labs' => $labs,
        ]);
    }

    public function contact(string $id): string
    {
        $professor = $this->repo->findWithDetails((int)$id);
        if (!$professor) {
            http_response_code(404);
            return $this->view('errors.404', ['title' => '404']);
        }

        return $this->view('professors.contact', [
            'title' => 'Contact ' . $professor['name'],
            'professor' => $professor,
        ]);
    }

    public function sendContact(string $id): string
    {
        $this->validateCsrf();
        $auth = AuthService::getInstance();
        $professor = $this->repo->findWithDetails((int)$id);

        $data = $this->validate([
            'full_name' => 'required|min:2',
            'email' => 'required|email',
            'phone' => 'required',
            'current_education' => 'required',
        ]);

        $subject = rawurlencode("Prospective Student Inquiry — {$data['full_name']}");
        $body = "Dear {$professor['name']},\n\n"
              . "My name is {$data['full_name']}. I am writing to express my interest in joining your research lab.\n\n"
              . "Current education: {$data['current_education']}\n"
              . "Email: {$data['email']}\n"
              . "Phone: {$data['phone']}\n\n"
              . "I would be honored to learn more about your research in {$professor['research_area']}.\n\n"
              . "Best regards,\n{$data['full_name']}";
        $body = rawurlencode($body);

        $mailto = "mailto:{$professor['email']}?subject={$subject}&body={$body}";

        // Save as application record
        $appRepo = new \App\Repositories\ApplicationRepository();
        $appRepo->create([
            'user_id' => $auth->id(),
            'professor_id' => (int)$id,
            'type' => 'lab',
            'status' => 'submitted',
            'progress' => 100,
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'current_education' => $data['current_education'],
            'submitted_at' => date('Y-m-d H:i:s'),
        ]);

        (new NotificationService())->send(
            $auth->id(),
            'Lab Inquiry Sent',
            "Your inquiry to {$professor['name']} is ready in your email client.",
            'success',
            '/applications'
        );

        return $this->view('professors.sent', [
            'title' => 'Email Ready',
            'professor' => $professor,
            'mailto' => $mailto,
        ]);
    }
}
