<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\ApplicationRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ScholarshipRepository;
use App\Repositories\SavedItemRepository;

class DashboardController extends Controller
{
    public function index(): string
    {
        $auth = AuthService::getInstance();
        $userId = $auth->id();

        $appRepo = new ApplicationRepository();
        $notifRepo = new NotificationRepository();
        $scholarRepo = new ScholarshipRepository();
        $savedRepo = new SavedItemRepository();

        $stats = [
            'active_applications' => $appRepo->countByUserAndStatus($userId),
            'upcoming_deadlines' => count($appRepo->getUpcomingDeadlines($userId)),
            'scholarships_found' => $scholarRepo->count(),
        ];

        $applications = $appRepo->getUserApplications($userId);
        $notifications = $notifRepo->getUserNotifications($userId, 10);
        $upcomingDeadlines = $appRepo->getUpcomingDeadlines($userId, 5);

        return $this->view('dashboard.index', [
            'title' => 'Dashboard',
            'user' => $auth->user(),
            'stats' => $stats,
            'applications' => $applications,
            'notifications' => $notifications,
            'upcomingDeadlines' => $upcomingDeadlines,
        ]);
    }

    public function notifications(): string
    {
        $auth = AuthService::getInstance();
        $repo = new NotificationRepository();
        $notifications = $repo->getUserNotifications($auth->id(), 50);
        return $this->view('dashboard.notifications', [
            'title' => 'Notifications',
            'notifications' => $notifications,
        ]);
    }

    public function markNotificationRead(string $id): string
    {
        $repo = new NotificationRepository();
        $repo->markAsRead((int)$id);
        return $this->json(['success' => true]);
    }

    public function markAllNotificationsRead(): string
    {
        $auth = AuthService::getInstance();
        $repo = new NotificationRepository();
        $repo->markAllAsRead($auth->id());
        return $this->back();
    }
}
