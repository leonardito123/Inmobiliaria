<?php

namespace App\Models;

use App\Core\DB;

/**
 * Lead Model
 *
 * Registro de prospectos desde formularios de contacto/interés.
 */
class Lead
{
    /**
     * Insertar un nuevo lead.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): int
    {
        $db = DB::getInstance();

        $stmt = $db->prepare(
            'INSERT INTO `leads`
             (`property_id`, `name`, `email`, `phone`, `country_code`,
              `source_page`, `score`, `ip_hash`)
             VALUES
             (:property_id, :name, :email, :phone, :country_code,
              :source_page, :score, :ip_hash)'
        );

        $stmt->execute([
            ':property_id'  => $data['property_id'] ?? null,
            ':name'         => substr($data['name']  ?? '', 0, 100),
            ':email'        => substr($data['email'] ?? '', 0, 254),
            ':phone'        => substr($data['phone'] ?? '', 0, 20),
            ':country_code' => $data['country_code'] ?? 'MX',
            ':source_page'  => $data['source_page']  ?? 'unknown',
            ':score'        => (int) ($data['score'] ?? 0),
            ':ip_hash'      => hash('sha256', $data['ip'] ?? ''),
        ]);

        return (int) $db->lastInsertId();
    }

    /**
     * Calcula lead score según campos completados y página de origen.
     *
     * @param array<string, mixed> $data
     */
    public static function calcScore(array $data): int
    {
        $score = 0;

        if (!empty($data['name']))         $score += 10;
        if (!empty($data['email']))        $score += 20;
        if (!empty($data['phone']))        $score += 30;
        if (!empty($data['property_id'])) $score += 20;

        $pageScores = [
            'desarrollos' => 20,
            'venta'       => 15,
            'renta'       => 10,
            'home'        => 5,
        ];

        $score += $pageScores[$data['source_page'] ?? ''] ?? 0;

        return min($score, 100);
    }
}
