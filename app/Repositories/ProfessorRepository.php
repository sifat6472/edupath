<?php
namespace App\Repositories;

class ProfessorRepository extends BaseRepository
{
    protected string $table = 'professors';

    public function allWithUniversity(): array
    {
        return $this->db->fetchAll("
            SELECT p.*, u.name AS university_name, u.country, u.city
            FROM professors p
            JOIN universities u ON u.id = p.university_id
            ORDER BY p.publications DESC
        ");
    }

    public function search(array $filters): array
    {
        $sql = "
            SELECT p.*, u.name AS university_name, u.country, u.city
            FROM professors p
            JOIN universities u ON u.id = p.university_id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= " AND (p.name LIKE :q OR p.research_area LIKE :q OR u.name LIKE :q)";
            $params['q'] = '%' . $filters['q'] . '%';
        }
        if (!empty($filters['accepting'])) {
            $sql .= " AND p.accepting_students = 1";
        }
        if (!empty($filters['research_area'])) {
            $sql .= " AND p.research_area LIKE :research_area";
            $params['research_area'] = '%' . $filters['research_area'] . '%';
        }

        $sql .= " ORDER BY p.publications DESC";
        return $this->db->fetchAll($sql, $params);
    }

    public function findWithDetails(int $id): ?array
    {
        return $this->db->fetchOne("
            SELECT p.*, u.name AS university_name, u.country, u.city
            FROM professors p
            JOIN universities u ON u.id = p.university_id
            WHERE p.id = ?
        ", [$id]);
    }

    public function getLabs(int $professorId): array
    {
        return $this->db->fetchAll("SELECT * FROM laboratories WHERE professor_id = ?", [$professorId]);
    }
}
