<?php
namespace Classes;

use Config\Database;

class Score {
    public static function save(int $userId, int $pairs, int $moves, int $duration): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO scores (user_id, pairs, moves, duration) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $pairs, $moves, $duration]);
    }

    public static function top10(): array {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT u.username, MIN(s.moves) as best_moves
            FROM scores s
            JOIN users u ON u.id = s.user_id
            GROUP BY s.user_id
            ORDER BY best_moves ASC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    public static function userScores(int $userId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM scores WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}