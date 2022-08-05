<div class="row">
    <form class="row g-3" action="/?page=article" METHOD="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input name="title" class="form-control" id="comment" placeholder="Title">
        </div>
        <div class="mb-3">
            <label for="img-url" class="form-label">Image url:</label>
            <input name="img_url" class="form-control" id="img-url" placeholder="Image">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Add an article:</label>
            <textarea name="content" class="form-control" id="content"></textarea>
        </div>
        <input name="user_id" type="hidden" value="<?= $userId ?>">
        <div class="mb-3">
            <button type="submit" class="btn btn-primary mb-3" name="submit-article">Save</button>
        </div>
    </form>
</div>
