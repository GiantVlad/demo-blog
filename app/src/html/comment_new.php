<div class="row">
    <form class="row g-3" action="/?page=comment" METHOD="post">
        <div class="mb-3">
            <label for="comment" class="form-label">Add a comment:</label>
            <textarea name="comment" class="form-control" id="comment"></textarea>
        </div>
        <input name="article_id" type="hidden" value="<?= $article->id ?>">
        <input name="user_id" type="hidden" value="<?= $userId ?>">
        <div class="mb-3">
            <button type="submit" class="btn btn-primary mb-3" name="submit-comment">Save</button>
        </div>
    </form>
</div>
