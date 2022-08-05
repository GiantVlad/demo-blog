<div class="row">
    <div class="col-12">
        <h5><?= $article->title ?></h5>
    </div>
    <div class="col-12">
        <img src="<?= $article->img_url ?>" class="rounded mx-auto d-block" alt="<?= $article->title ?>">
    </div>
    <div class="col-12">
        <?= $article->content ?>
    </div>
    <div class="col-12">
        <strong><?= $article->author ?></strong>
    </div>
</div>
