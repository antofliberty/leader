<?php

namespace Leader\Services;

use Leader\Traits\PdoTrait;

class AuthService
{
    use PdoTrait;

    public static function createUser($email, $password): string|bool
    {
        $stmt = self::$pdo->prepare("SELECT email FROM users WHERE email=?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();

        if ($result) {
            $result = $result["email"];
            return "User with this e-mail already exists!";
        }

        $stmt = self::$pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->execute([$email, password_hash($password, PASSWORD_BCRYPT)]);

        return true;
    }

    public static function authenticate($email, $password): bool
    {
        $stmt = self::$pdo->prepare("SELECT password FROM users WHERE email=?");
        $stmt->execute([$email]);
        if ($hash = $stmt->fetch()) {
            $hash = $hash['password'];
            if (password_verify($password, $hash)) {
                $_SESSION['auth'] = true;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
