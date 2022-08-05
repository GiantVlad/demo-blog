<?php

namespace App;

use App\Exceptions\ValidationException;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;

class MainController
{
    private array $query;
    private string $httpRequestMethod;
    
    public function __construct(
        private UserRepository $userRepository,
        private ArticleRepository $articleRepository,
        private CommentRepository $commentRepository,
    ) {
        $this->query = [];
    }
    
    public function handle()
    {
        $this->hashPwd();
        $_SESSION['error'] = null;
        parse_str($_SERVER['QUERY_STRING'], $this->query);
        $this->httpRequestMethod = strtolower($this->validateHttpRequestMethod($_SERVER['REQUEST_METHOD']));
        
        $method = match(($this->query['page'] ?? '')) {
            'login' => 'Login',
            'logout' => 'Logout',
            'article' => 'Article',
            'comment' => 'Comment',
            'add-article' => 'AddArticle',
            'info' => 'Info',
            'delete-comment' => 'DeleteComment',
            default => 'Articles',
        };
        $method = $this->httpRequestMethod . $method;
        return $this->{$method}();
    }
    
    public function getLogin()
    {
        return ['page' => 'login'];
    }
    
    public function postLogin()
    {
        $password = $_POST['password'] ?? '';
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        
        if (! $email || ! $password) {
            throw new ValidationException('Invalid Email or Password fields');
        }
        
        if ($user = $this->userRepository->auth($email, $password)) {
            $_SESSION['userId'] = $user->id;
            header("Location: /");
        }
        
        return ['page' => 'login', 'error' => 'Auth error.'];
    }
    
    public function getLogout()
    {
        $_SESSION['userId'] = false;
        header("Location: /");
    }
    
    public function getArticles()
    {
        $offset = $this->query['offset'] ?? 0;
        
        $articles = $this->articleRepository->getList($offset);
        
        return ['page' => 'articles', 'articles' => $articles];
    }
    
    public function getArticle()
    {
        $id = $this->query['id'] ?? false;
        if (!$id) {
            return ['page' => 'home', 'error' => 'Article not found.'];
        }
        $article = $this->articleRepository->findOne($id);
    
        $comments = $this->commentRepository->getListByArticleId($article->id);
        
        return ['page' => 'article', 'article' => $article, 'comments' => $comments];
    }
    
    public function getAddArticle()
    {
        return ['page' => 'add-article'];
    }
    
    public function postArticle()
    {
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
        $imgUrl = filter_input(INPUT_POST, "img_url", FILTER_SANITIZE_URL);
        $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_STRING);
        $userId = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
        
        if (! $title || ! $imgUrl || ! $content || ! $userId) {
            throw new ValidationException('All fields are required');
        }
        
        $this->articleRepository->add($title, $imgUrl, $content, $userId);
    
        header("Location: /");
    }
    
    public function postComment()
    {
        $text = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);
        $userId = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
        $articleId = filter_input(INPUT_POST, "article_id", FILTER_VALIDATE_INT);
    
        if (! $text) {
            throw new ValidationException('The Comment field is required');
        }
    
        if (! $userId || ! $articleId) {
            throw new ValidationException('Invalid user or article');
        }
        
        $this->commentRepository->add($text, $userId, $articleId);
        
        header("Location: /?page=article&id=" . $articleId);
    }
    
    public function postDeleteComment()
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $articleId = filter_input(INPUT_POST, "article_id", FILTER_VALIDATE_INT);
        $this->commentRepository->delete($id);
        
        header("Location: /?page=article&id=" . $articleId);
    }
    
    public function getInfo()
    {
        return ['page' => 'info'];
    }
    
    private function validateHttpRequestMethod(string $method)
    {
        if(empty($method)) {
            throw new \Exception('Empty value');
        }

        return match ($method) {
            'GET', 'POST', 'PUT', 'DELETE', 'HEAD' => $method,
            default => throw new \Exception('Unexpected value.'),
        };
    }
    
    private function hashPwd(): void
    {
        $this->userRepository->hashPwd();
    }
}
