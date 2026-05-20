<?php
namespace App\Repositories;

class ScholarshipRepository extends BaseRepository
{
    protected string $table = 'scholarships';

    public function search(array $filters): array
    {
        $sql = "SELECT * FROM scholarships WHERE 1=1";
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= " AND (name LIKE :q OR provider LIKE :q OR description LIKE :q)";
            $params['q'] = '%' . $filters['q'] . '%';
        }
        if (!empty($filters['country'])) {
            $sql .= " AND country = :country";
            $params['country'] = $filters['country'];
        }
        if (!empty($filters['study_level'])) {
            $sql .= " AND study_level = :study_level";
            $params['study_level'] = $filters['study_level'];
        }

        $sql .= " ORDER BY deadline ASC";
        return $this->db->fetchAll($sql, $params);
    }
}
