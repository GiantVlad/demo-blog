<?php
    foreach ($articles as $article) : ?>
        <div class="row">
            <div class="col-8">
                <p><?= $article->created_at . ' - ' . $article->title ?></p>
                <p><?= $article->content ?></p>
                <a href="/?page=article&id=<?= $article->id ?>">Details</a>
            </div>
            <div class="col-4">
                <img src="<?= $article->img_url ?>" class="rounded mx-auto d-block" alt="<?= $article->title ?>">
            </div>
        </div>
        <div class="row">
        <div class="col-6">
            Author: <?= $article->author ?>
        </div>
        <div class="col-6">
            Comments: <?= $article->comments_count ?>
        </div>
<?php
    endforeach;
