<?php

namespace App\Models;

use App\Core\DB;

/**
 * Agent Model
 *
 * Acceso PDO a la tabla agents (agentes inmobiliarios).
 */
class Agent
{
    /**
     * Obtener agentes activos, opcionalmente filtrados por país.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getActive(?string $countryCode = null): array
    {
        $db = DB::getInstance();

        if ($countryCode !== null) {
            $stmt = $db->prepare(
                'SELECT * FROM `agents` WHERE `active` = 1 AND `country_code` = :country ORDER BY `id` ASC'
            );
            $stmt->execute([':country' => $countryCode]);
        } else {
            $stmt = $db->prepare(
                'SELECT * FROM `agents` WHERE `active` = 1 ORDER BY `id` ASC'
            );
            $stmt->execute();
        }

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Decode JSON fields
        foreach ($rows as &$row) {
            $row['languages']   = json_decode($row['languages']   ?? '[]', true) ?? [];
            $row['specialties'] = json_decode($row['specialties'] ?? '[]', true) ?? [];
        }
        unset($row);

        return $rows;
    }

    /**
     * Obtener un agente por ID.
     *
     * @return array<string, mixed>|null
     */
    public function getById(int $id): ?array
    {
        $db   = DB::getInstance();
        $stmt = $db->prepare('SELECT * FROM `agents` WHERE `id` = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $row['languages']   = json_decode($row['languages']   ?? '[]', true) ?? [];
        $row['specialties'] = json_decode($row['specialties'] ?? '[]', true) ?? [];

        return $row;
    }
}
