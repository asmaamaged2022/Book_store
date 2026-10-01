<div class="modal fade" id="AddBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Book</h1>
                <button type="button " class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddBookForm">
                    <input type="hidden" name="bookAuthorId" id="authorIdHidden">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="mb-3 fw-bold">Author:</label>
                            <select name="authorId" id="authorId" disabled class="mb-3 form-control">
                                <option value="" selected hidden></option>
                            </select>
                            <p class="alert alert-danger mb-3 d-none" data-error-name="authorId"></p>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="name" class="mb-3 fw-bold">Enter Book Title:</label>
                            <input type="text" id="name" class="form-control mb-3" name="bookTitle" placeholder="Enter Title">
                            <p class="alert alert-danger mb-3 d-none" data-error-name="bookTitle"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="mb-3 fw-bold">Enter Image:</label>
                        <input type="file" id="image" class="form-control mb-3" name="bookImage">
                        <p class="alert alert-danger mb-3 d-none" data-error-name="bookTitle"></p>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="mb-3 fw-bold">Enter Description:</label>

                        <textarea class="form-control mb-3" id="desc" name="bookDescription" placeholder="Enter description"></textarea>
                        <p class="alert alert-danger mb-3 d-none" data-error-name="bookDescription"></p>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="price" class="mb-3 fw-bold">Enter Book Price:</label>

                            <input type="text" id="price" class="form-control mb-3" name="bookPrice" placeholder="Enter Price">
                            <p class="alert alert-danger mb-3 d-none" data-error-name="bookPrice"></p>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="stock" class="mb-3 fw-bold">Enter Book Stock:</label>

                            <input type="text" id="stock" class="form-control mb-3" name="bookStock" placeholder="Enter Stock">
                            <p class="alert alert-danger mb-3 d-none" data-error-name="bookStock"></p>
                        </div>

                    </div>
                    <button class=" mt-3 btn IdentityButton w-100">Add</button>
                </form> 
            </div>
        </div>
    </div>
</div>