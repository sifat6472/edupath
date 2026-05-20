<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\ProgramRepository;
use App\Repositories\SavedItemRepository;
use App\Services\AuthService;
use App\Services\ApplicationService;

class ProgramController extends Controller
{
    private ProgramRepository $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new ProgramRepository();
    }

    public function index(): string
    {
        $filters = [
            'q' => Request::input('q', ''),
            'country' => Request::input('country', ''),
            'field' => Request::input('field', ''),
            'degree_level' => Request::input('degree_level', ''),
        ];

        $programs = $this->repo->search($filters);

        return $this->view('programs.index', [
            'title' => 'Explore Programs',
            'programs' => $programs,
            'filters' => $filters,
        ]);
    }

    public function show(string $id): string
    {
        $program = $this->repo->findWithUniversity((int) $id);
        if (!$program) {
            http_response_code(404);
            return $this->view('errors.404', ['title' => '404']);
        }

        $auth = AuthService::getInstance();
        $isSaved = false;
        if ($auth->check()) {
            $isSaved = (new SavedItemRepository())->isSaved($auth->id(), 'program', (int)$id);
        }

        return $this->view('programs.show', [
            'title' => $program['title'],
            'program' => $program,
            'isSaved' => $isSaved,
        ]);
    }

    public function apply(string $id): string
    {
        $program = $this->repo->findWithUniversity((int) $id);
        if (!$program) {
            http_response_code(404);
            return $this->view('errors.404', ['title' => '404']);
        }

        return $this->view('programs.apply', [
            'title' => 'Apply to ' . $program['title'],
            'program' => $program,
        ]);
    }

    public function submitApplication(string $id): string
    {
        $this->validateCsrf();
        $auth = AuthService::getInstance();
        if (!$auth->check()) return $this->redirect('/login');

        $data = $this->validate([
            'full_name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'phone' => 'required|max:30',
            'current_education' => 'required|max:255',
            'gpa' => 'required|max:10',
            'work_experience' => 'max:1000',
            'statement_of_purpose' => 'required|min:20|max:5000',
        ]);
        $data['test_score'] = trim($_POST['test_score'] ?? '');

        $service = new ApplicationService();
        try {
            $service->submitProgramApplication($auth->id(), (int)$id, $data);
            Response::flash('success', 'Application submitted successfully!');
            Response::flash('show_success_popup', true);
            return $this->redirect('/applications?submitted=1');
        } catch (\Exception $e) {
            Response::flash('error', $e->getMessage());
            return $this->back();
        }
    }

    public function toggleSave(string $id): string
    {
        $auth = AuthService::getInstance();
        if (!$auth->check()) return $this->redirect('/login');
        $this->validateCsrf();

        $saved = (new SavedItemRepository())->toggle($auth->id(), 'program', (int)$id);
        return $this->json(['saved' => $saved]);
    }
}
