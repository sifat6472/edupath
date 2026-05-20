<?php
namespace App\Repositories;

class ProgramRepository extends BaseRepository
{
    protected string $table = 'programs';

    public function allWithUniversity(): array
    {
        return $this->db->fetchAll("
            SELECT p.*, u.name AS university_name, u.country, u.city
            FROM programs p
            JOIN universities u ON u.id = p.university_id
            ORDER BY u.ranking ASC
        ");
    }

    public function search(array $filters): array
    {
        $sql = "
            SELECT p.*, u.name AS university_name, u.country, u.city
            FROM programs p
            JOIN universities u ON u.id = p.university_id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= " AND (p.title LIKE :q OR u.name LIKE :q OR p.field LIKE :q)";
            $params['q'] = '%' . $filters['q'] . '%';
        }
        if (!empty($filters['country'])) {
            $sql .= " AND u.country = :country";
            $params['country'] = $filters['country'];
        }
        if (!empty($filters['field'])) {
            $sql .= " AND p.field LIKE :field";
            $params['field'] = '%' . $filters['field'] . '%';
        }
        if (!empty($filters['degree_level'])) {
            $sql .= " AND p.degree_level = :degree_level";
            $params['degree_level'] = $filters['degree_level'];
        }

        $sql .= " ORDER BY u.ranking ASC";
        return $this->db->fetchAll($sql, $params);
    }

    public function findWithUniversity(int $id): ?array
    {
        return $this->db->fetchOne("
            SELECT p.*, u.name AS university_name, u.country, u.city, u.ranking
            FROM programs p
            JOIN universities u ON u.id = p.university_id
            WHERE p.id = ?
        ", [$id]);
    }
}
