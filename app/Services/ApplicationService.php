<?php
namespace App\Services;

use App\Repositories\ApplicationRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\ScholarshipRepository;
use App\Repositories\NotificationRepository;

/**
 * Application Service - Business Logic Layer
 */
class ApplicationService
{
    private ApplicationRepository $appRepo;
    private ProgramRepository $programRepo;
    private ScholarshipRepository $scholarRepo;
    private NotificationRepository $notifRepo;

    public function __construct()
    {
        $this->appRepo = new ApplicationRepository();
        $this->programRepo = new ProgramRepository();
        $this->scholarRepo = new ScholarshipRepository();
        $this->notifRepo = new NotificationRepository();
    }

    public function submitProgramApplication(int $userId, int $programId, array $data): int
    {
        $program = $this->programRepo->find($programId);
        if (!$program) {
            throw new \Exception('Program not found');
        }

        $appData = [
            'user_id' => $userId,
            'program_id' => $programId,
            'type' => 'program',
            'status' => 'submitted',
            'progress' => 100,
            'full_name' => $data['full_name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'current_education' => $data['current_education'] ?? '',
            'gpa' => $data['gpa'] ?? '',
            'test_score' => $data['test_score'] ?? '',
            'work_experience' => $data['work_experience'] ?? '',
            'statement_of_purpose' => $data['statement_of_purpose'] ?? '',
            'submitted_at' => date('Y-m-d H:i:s'),
            'deadline' => $program['application_deadline'],
        ];

        $appId = $this->appRepo->create($appData);

        // Create notification
        $this->notifRepo->create([
            'user_id' => $userId,
            'title' => 'Application Submitted',
            'message' => "Your application for {$program['title']} has been submitted successfully.",
            'type' => 'success',
            'link' => '/applications',
        ]);

        return $appId;
    }

    public function submitScholarshipApplication(int $userId, int $scholarshipId, array $data): int
    {
        $scholarship = $this->scholarRepo->find($scholarshipId);
        if (!$scholarship) {
            throw new \Exception('Scholarship not found');
        }

        $appData = [
            'user_id' => $userId,
            'scholarship_id' => $scholarshipId,
            'type' => 'scholarship',
            'status' => 'submitted',
            'progress' => 100,
            'full_name' => $data['full_name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'current_education' => $data['current_education'] ?? '',
            'gpa' => $data['gpa'] ?? '',
            'test_score' => $data['test_score'] ?? '',
            'submitted_at' => date('Y-m-d H:i:s'),
            'deadline' => $scholarship['deadline'],
        ];

        $appId = $this->appRepo->create($appData);

        $this->notifRepo->create([
            'user_id' => $userId,
            'title' => 'Scholarship Application Submitted',
            'message' => "Your application for {$scholarship['name']} has been submitted.",
            'type' => 'success',
            'link' => '/applications',
        ]);

        return $appId;
    }

    public function checkEligibility(array $scholarship, array $userData): array
    {
        $eligible = true;
        $reasons = [];

        // Sample eligibility logic
        if (!empty($userData['gpa']) && (float)$userData['gpa'] < 3.0) {
            $eligible = false;
            $reasons[] = 'Minimum GPA of 3.0 required';
        }

        if (empty($userData['current_education'])) {
            $eligible = false;
            $reasons[] = "Education background required";
        }

        return [
            'eligible' => $eligible,
            'reasons' => $reasons,
        ];
    }
}
