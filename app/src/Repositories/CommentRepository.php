<?php

namespace App\Repositories;

use App\Connection;

class CommentRepository
{
    private const LIST_LIMIT = 500;
    
    public function __construct(
        private Connection $connection
    ) {
    }
    
    public function getListByArticleId(int $articleId): array
    {
        $sql = "SELECT * FROM `comments` WHERE article_id = ? LIMIT " . self::LIST_LIMIT;
        
        return $this->connection->query($sql, [$articleId]);
    }
    
    public function add(string $comment, int $articleId, int $userId): void
    {
        $sql = "
            INSERT INTO `comments` (comment, article_id, user_id)
            VALUES (?,?,?)
        ";
        
        $this->connection->query($sql, [$comment, $articleId, $userId]);
    }
    
    public function delete(int $id): void
    {
        $sql = "DELETE FROM `comments` WHERE id = ?";
        
        $this->connection->query($sql, [$id]);
    }
}
