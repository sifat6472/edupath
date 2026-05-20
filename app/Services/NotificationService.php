<?php
namespace App\Services;

use App\Repositories\NotificationRepository;

class NotificationService
{
    private NotificationRepository $repo;

    public function __construct()
    {
        $this->repo = new NotificationRepository();
    }

    public function send(int $userId, string $title, string $message, string $type = 'info', ?string $link = null): int
    {
        return $this->repo->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'link' => $link,
        ]);
    }

    public function getForUser(int $userId): array
    {
        return $this->repo->getUserNotifications($userId);
    }

    public function getUnreadCount(int $userId): int
    {
        return $this->repo->countUnread($userId);
    }

    public function markRead(int $notifId): bool
    {
        return $this->repo->markAsRead($notifId) > 0;
    }

    public function markAllRead(int $userId): int
    {
        return $this->repo->markAllAsRead($userId);
    }
}
