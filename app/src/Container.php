<?php

namespace App;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;

class Container
{
    private static ?self $instance = null;
    
    private array $objects;
    
    private function __construct()
    {
        $this->objects = [
            Connection::class => fn() => new Connection(),
            UserRepository::class => fn() => new UserRepository($this->get(Connection::class)),
            ArticleRepository::class => fn() => new ArticleRepository($this->get(Connection::class)),
            CommentRepository::class => fn() => new CommentRepository($this->get(Connection::class)),
            MainController::class => fn() => new MainController(
                $this->get(UserRepository::class),
                $this->get(ArticleRepository::class),
                $this->get(CommentRepository::class),
            ),
        ];
    }
    
    public static function app(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }
    
    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }
    
    public function get(string $id): mixed
    {
        return $this->objects[$id]();
    }
}
