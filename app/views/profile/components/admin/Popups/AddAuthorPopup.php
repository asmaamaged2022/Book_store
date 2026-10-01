

<div class="modal fade" id="AddAuthorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Author</h1>
                <button type="button " class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddAuthorForm">
                    <input type="text" class="form-control mb-3" name="authorName" placeholder="Enter Name">
                    <p class="alert alert-danger mb-3 d-none" data-error-name="authorName"></p>
                    <textarea class="form-control " name="authorBio" placeholder="Enter Bio"></textarea>
                    <p class="alert alert-danger mt-3 d-none" data-error-name="authorBio"></p>
                    <button class=" mt-3 btn IdentityButton w-100">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>