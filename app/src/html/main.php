<?php

$page = $page ?? 'home';
$userId = $_SESSION['userId'] ?? false;
$error = $_SESSION['error'] ?? false;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>demo</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div id="app" class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Demo Blog</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Articles</a>
                    </li>
                    <?php if ($userId): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/?page=add-article">Add a new article</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/?page=info">Info</a>
                    </li>
                    <li class="nav-item">
                    <?php if ($userId): ?>
                        <a class="nav-link" href="/?page=logout">Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="/?page=login">Login</a>
                    <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php if ($error):
        include (APP_DIR . 'html/error.php');
    endif;
    if ($page === 'articles'):
        include (APP_DIR . 'html/articles.php');
    elseif ($page === 'login'):
        include (APP_DIR . 'html/login.php');
    elseif ($page === 'add-article'):
        include (APP_DIR . 'html/article_new.php');
    elseif ($page === 'article'):
        include (APP_DIR . 'html/article_details.php');
        include (APP_DIR . 'html/comments.php');
        if ($userId):
            include (APP_DIR . 'html/comment_new.php');
        endif;
    elseif ($page === 'info'):
        include (APP_DIR . 'html/info.php');
    endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
