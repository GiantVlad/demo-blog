<?php

namespace App\Repositories;

use App\Connection;

class UserRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }
    
    public function getAll(): array
    {
        $sql = "
            SELECT * FROM `users` LIMIT 100;
        ";
        return $this->connection->query($sql);
    }
    
    public function auth($email, $password): ?\stdClass
    {
        $sql = "SELECT * FROM `users` WHERE email = ? LIMIT 1;";
        $users = $this->connection->query($sql, [$email]);
        if (empty($users)) {
            return null;
        }
        
        return password_verify($password, $users[0]->password) ? $users[0] : null;
    }
    
    public function hashPwd(): void
    {
        $sql = "SELECT * FROM `users` WHERE user_name = 'admin' LIMIT 1;";
        $users = $this->connection->query($sql);
        
        if ($users[0]->password !== '1111') {
            return;
        }
        
        $sql = "SELECT * FROM `users` LIMIT 10;";
        $users = $this->connection->query($sql);
        
        foreach ($users as $user) {
            $password = password_hash($user->password, PASSWORD_DEFAULT);
            $userId = (int) $user->id;
            $sql = "
                UPDATE `users` SET password=? WHERE id=? LIMIT 1;
            ";
            $this->connection->query($sql, [$password, $userId]);
        }
    }
}
