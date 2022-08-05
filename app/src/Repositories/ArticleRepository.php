<?php

namespace App\Repositories;

use App\Connection;

class ArticleRepository
{
    private const LIST_LIMIT = 3;
    private const LIST_CONTENT_LENGTH = 1000;
    
    public function __construct(
        private Connection $connection
    ) {
    }
    
    public function getList(int $offset = 0): array
    {
        $sql = "SELECT articles.*, u.user_name author, COUNT(c.id) comments_count FROM `articles`
         JOIN users u ON articles.user_id = u.id
         LEFT JOIN comments c ON articles.id = c.article_id
         GROUP BY articles.id
         LIMIT " . self::LIST_LIMIT . " OFFSET $offset";
        
        $articles = $this->connection->query($sql);
        
        return array_map(
            function ($item) {
                $item->content = strlen($item->content) > self::LIST_CONTENT_LENGTH
                    ? (substr($item->content, 0, self::LIST_CONTENT_LENGTH) . ' ...') : $item->content;
                
                return $item;
            },
            $articles
        );
    }
    
    public function findOne(int $id): ?\stdClass
    {
        $sql = "
            SELECT articles.*, u.user_name author FROM `articles`
            JOIN users u ON articles.user_id = u.id
            WHERE articles.id = ?
        ";
        
        $records = $this->connection->query($sql, [$id]);
        
        if (empty($records)) {
            return null;
        }
        
        return $records[0];
    }
    
    public function add(string $title, string $imgUrl, string $content, int $userId): void
    {
        $sql = "
            INSERT INTO `articles` (title, img_url, content, user_id)
            VALUES (?,?,?,?)
        ";
        
        $this->connection->query($sql, [$title, $imgUrl, $content, $userId]);
    }
}
