<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Repositories\ProgramRepository;
use App\Repositories\ScholarshipRepository;
use App\Repositories\UserRepository;

class HomeController extends Controller
{
    public function index(): string
    {
        $db = Database::getInstance();
        $programRepo = new ProgramRepository();
        $scholarRepo = new ScholarshipRepository();
        $userRepo = new UserRepository();

        $unisResult = $db->fetchOne("SELECT COUNT(*) AS c FROM universities");

        $stats = [
            'programs' => $programRepo->count(),
            'universities' => (int) ($unisResult['c'] ?? 0),
            'scholarships' => $scholarRepo->count(),
            'students' => $userRepo->count('role = ?', ['student']),
        ];

        return $this->view('home', ['stats' => $stats, 'title' => 'EduPath - Your Path to Global Education']);
    }
}
