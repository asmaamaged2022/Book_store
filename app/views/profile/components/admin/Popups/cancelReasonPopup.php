<div class="modal fade" id="cancelReasonModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Cancel Reason</h1>
                <button type="button " class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cancelReasonForm">
                    <div class="form-group">
                        <label for="desc" class="mb-3 fw-bold">Enter Cancel Reason:</label>
                        <textarea class="form-control mb-3" id=" cancelReason" name="cancelReason" placeholder="Enter Cancel Reason"></textarea>
                        <p class="alert alert-danger mb-3 d-none" data-error-name="cancelReason"></p>
                    </div>

                    <button class=" mt-3 btn btn-danger w-100">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>