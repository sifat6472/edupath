<?php
namespace App\Repositories;

class NotificationRepository extends BaseRepository
{
    protected string $table = 'notifications';

    public function getUserNotifications(int $userId, int $limit = 20): array
    {
        return $this->db->fetchAll("
            SELECT * FROM notifications
            WHERE user_id = ?
            ORDER BY created_at DESC
            LIMIT $limit
        ", [$userId]);
    }

    public function countUnread(int $userId): int
    {
        return $this->count('user_id = ? AND is_read = 0', [$userId]);
    }

    public function markAsRead(int $id): int
    {
        return $this->update($id, ['is_read' => 1]);
    }

    public function markAllAsRead(int $userId): int
    {
        return $this->db->update('notifications', ['is_read' => 1], 'user_id = :user_id', ['user_id' => $userId]);
    }
}
