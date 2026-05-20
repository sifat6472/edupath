<?php
namespace App\Repositories;

class SavedItemRepository extends BaseRepository
{
    protected string $table = 'saved_programs';

    public function getUserSaved(int $userId): array
    {
        return $this->db->fetchAll("SELECT * FROM saved_programs WHERE user_id = ? ORDER BY created_at DESC", [$userId]);
    }

    public function isSaved(int $userId, string $type, int $itemId): bool
    {
        $result = $this->db->fetchOne(
            "SELECT id FROM saved_programs WHERE user_id = ? AND item_type = ? AND item_id = ?",
            [$userId, $type, $itemId]
        );
        return $result !== null;
    }

    public function toggle(int $userId, string $type, int $itemId): bool
    {
        if ($this->isSaved($userId, $type, $itemId)) {
            $this->db->delete('saved_programs', 'user_id = ? AND item_type = ? AND item_id = ?', [$userId, $type, $itemId]);
            return false;
        }
        $this->create([
            'user_id' => $userId,
            'item_type' => $type,
            'item_id' => $itemId,
        ]);
        return true;
    }
}
