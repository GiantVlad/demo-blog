<?php
echo "<h6>Comments:</h6>";
foreach ($comments as $comment) : ?>
    <div class="row">
        <div class="col-8">
            <?= $comment->comment ?>
        </div>
        <div class="col-4">
        <?php if($userId): ?>
            <form action="">
                <input name="article_id" type="hidden">
                <input name="article_id" type="hidden">
                <button class="btn btn-sm btn-default" type="button">Remove</button>
            </form>
        <?php endif; ?>
        </div>
    </div>
<?php
endforeach;
