<?php

namespace App\Models;

use App\Core\DB;
class Property
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = DB::getInstance()->getConnection();
    }


    public function getFiltered(array $filters = [], ?string $cursor = null, int $limit = 6): array
    {
        $sql = "SELECT * FROM properties WHERE 1=1";
        $params = [];

        if (isset($filters['type'])) {
            $sql .= " AND type = ?";
            $params[] = $filters['type'];
        }
        if (isset($filters['country_code'])) {
            $sql .= " AND country_code = ?";
            $params[] = $filters['country_code'];
        }
        if (isset($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        if (isset($filters['city']) && !empty($filters['city'])) {
            $sql .= " AND city LIKE ?";
            $params[] = '%' . $filters['city'] . '%';
        }
        if (isset($filters['bedrooms']) && $filters['bedrooms'] > 0) {
            $sql .= " AND bedrooms >= ?";
            $params[] = $filters['bedrooms'];
        }
        if (isset($filters['price_min']) && $filters['price_min'] > 0) {
            $sql .= " AND price >= ?";
            $params[] = $filters['price_min'];
        }
        if (isset($filters['price_max']) && $filters['price_max'] > 0) {
            $sql .= " AND price <= ?";
            $params[] = $filters['price_max'];
        }

        if ($cursor) {
            $cursorData = base64_decode($cursor);
            if (strpos($cursorData, 'id:') === 0) {
                $cursorId = (int) substr($cursorData, 3);
                $sql .= " AND id > ?";
                $params[] = $cursorId;
            }
        }

        $sql .= " ORDER BY featured DESC, created_at DESC LIMIT ?";
        $params[] = $limit;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM properties WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM properties WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function getFeatured(string $country = 'MX', int $limit = 6): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM properties 
             WHERE country_code = ? AND featured = 1 AND status = 'available' 
             ORDER BY created_at DESC LIMIT ?"
        );
        $stmt->execute([$country, $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByCountry(string $country = 'MX', int $limit = 50): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM properties
             WHERE country_code = ? AND status = 'available'
             ORDER BY featured DESC, created_at DESC
             LIMIT ?"
        );
        $stmt->execute([$country, $limit]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function search(string $query, string $country = 'MX', int $limit = 10): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM properties 
             WHERE country_code = ? AND MATCH(city, meta_title, meta_desc) AGAINST(? IN BOOLEAN MODE)
             ORDER BY created_at DESC LIMIT ?"
        );
        $stmt->execute([$country, $query, $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSitemapEntries(int $limit = 500): array
    {
        $stmt = $this->db->prepare(
            "SELECT slug, updated_at
             FROM properties
             WHERE status = 'available' AND slug IS NOT NULL AND slug <> ''
             ORDER BY updated_at DESC
             LIMIT ?"
        );
        $stmt->execute([$limit]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
