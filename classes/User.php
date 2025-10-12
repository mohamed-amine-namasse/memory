<?php
namespace Classes;

use Config\Database;
use PDO;

class User {
    public int $id;
    public string $email;

    public static function findById(int $id): ?User {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);

        if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->id = $data['id'];
            $user->email = $data['email'];
            return $user;
        }

        return null;
    }

    public static function authenticate(string $email, string $password): ?User {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                $u = new User();
                $u->id = $user['id'];
                $u->email = $user['email'];
                return $u;
            }
        }

        return null;
    }
}