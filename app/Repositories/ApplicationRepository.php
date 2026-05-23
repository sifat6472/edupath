<?php
namespace App\Repositories;

class ApplicationRepository extends BaseRepository
{
    protected string $table = 'applications';

    public function getUserApplications(int $userId): array
{
    return $this->db->fetchAll("
        SELECT a.*,
               p.title AS program_title,
               u.name AS university_name,
               s.name AS scholarship_name,
               prof.name AS professor_name,
               prof.research_area AS professor_research,
               prof.department AS professor_department,
               profuni.name AS professor_university
        FROM applications a
        LEFT JOIN programs p ON p.id = a.program_id
        LEFT JOIN universities u ON u.id = p.university_id
        LEFT JOIN scholarships s ON s.id = a.scholarship_id
        LEFT JOIN professors prof ON prof.id = a.professor_id
        LEFT JOIN universities profuni ON profuni.id = prof.university_id
        WHERE a.user_id = ?
        ORDER BY a.created_at DESC
    ", [$userId]);
}

    public function countByUserAndStatus(int $userId, ?string $status = null): int
    {
        if ($status) {
            return $this->count('user_id = ? AND status = ?', [$userId, $status]);
        }
        return $this->count('user_id = ?', [$userId]);
    }

    public function getUpcomingDeadlines(int $userId, int $limit = 5): array
{
    return $this->db->fetchAll("
        SELECT a.*, p.title AS program_title, u.name AS university_name
        FROM applications a
        LEFT JOIN programs p ON p.id = a.program_id
        LEFT JOIN universities u ON u.id = p.university_id
        WHERE a.user_id = ?
          AND a.deadline >= date('now')
          AND a.status != 'submitted'
          AND a.status != 'accepted'
        ORDER BY a.deadline ASC
        LIMIT $limit
    ", [$userId]);
}
}
