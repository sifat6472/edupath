<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\ScholarshipRepository;
use App\Services\AuthService;
use App\Services\ApplicationService;

class ScholarshipController extends Controller
{
    private ScholarshipRepository $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new ScholarshipRepository();
    }

    public function index(): string
{
    $filters = [
        'q' => Request::input('q', ''),
        'country' => Request::input('country', ''),
        'study_level' => Request::input('study_level', ''),
    ];

    $scholarships = $this->repo->search($filters);

    $appliedIds = [];
    $auth = \App\Services\AuthService::getInstance();
    if ($auth->check()) {
        $db = \App\Core\Database::getInstance();
        $rows = $db->fetchAll(
            "SELECT scholarship_id FROM applications WHERE user_id = ? AND type = 'scholarship' AND scholarship_id IS NOT NULL",
            [$auth->id()]
        );
        $appliedIds = array_column($rows, 'scholarship_id');
    }

    return $this->view('scholarships.index', [
        'title' => 'Scholarships',
        'scholarships' => $scholarships,
        'filters' => $filters,
        'appliedIds' => $appliedIds,
    ]);
}

    public function show(string $id): string
    {
        $scholarship = $this->repo->find((int)$id);
        if (!$scholarship) {
            http_response_code(404);
            return $this->view('errors.404', ['title' => '404']);
        }

        return $this->view('scholarships.show', [
            'title' => $scholarship['name'],
            'scholarship' => $scholarship,
        ]);
    }

    public function apply(string $id): string
    {
        $scholarship = $this->repo->find((int)$id);
        if (!$scholarship) {
            http_response_code(404);
            return $this->view('errors.404', ['title' => '404']);
        }

        return $this->view('scholarships.apply', [
            'title' => 'Apply: ' . $scholarship['name'],
            'scholarship' => $scholarship,
        ]);
    }

    public function submitApplication(string $id): string
    {
        $this->validateCsrf();
        $auth = AuthService::getInstance();

        $data = $this->validate([
            'full_name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'phone' => 'required|max:30',
            'current_education' => 'required|max:255',
            'gpa' => 'required|max:10',
        ]);

        $scholarship = $this->repo->find((int)$id);
        $service = new ApplicationService();

        // Eligibility check
        $eligibility = $service->checkEligibility($scholarship, $data);
        if (!$eligibility['eligible']) {
            Response::flash('error', 'Eligibility check failed: ' . implode(', ', $eligibility['reasons']));
            return $this->back();
        }

        try {
            $service->submitScholarshipApplication($auth->id(), (int)$id, $data);
            Response::flash('success', 'Scholarship application submitted!');
            Response::flash('show_success_popup', true);
            return $this->redirect('/applications?submitted=1');
        } catch (\Exception $e) {
            Response::flash('error', $e->getMessage());
            return $this->back();
        }
    }
}
