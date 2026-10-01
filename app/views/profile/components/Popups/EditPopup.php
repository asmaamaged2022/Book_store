<div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Name</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route("/Profile/editName") ?>" method="POST">
                    <input type="text" pattern="[A-Za-z\s]+" require class="form-control" name="name" placeholder="Enter new Name" value="<?= auth('name') ?>">
                    <button class=" mt-3 ms-auto d-block btn btn-info text-light">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Email</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route("/Profile/editEmail") ?>" method="POST">
                    <input type="text" class="form-control" name="email" placeholder="Enter new Email" value="<?= auth('email') ?>">

                    <button class=" mt-3 ms-auto d-block btn btn-info text-light">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editPhoneModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Phone</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route("/Profile/editPhone") ?>" method="POST">
                    <input type="text" class="form-control" name="phone" placeholder="Enter new Phone" value="<?= auth('phone') ?>">

                    <button class=" mt-3 ms-auto d-block btn btn-info text-light">Edit</button>
                </form>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="editGenderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Gender</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route("/Profile/editGender") ?>" method="POST">
                    <select class="form-select" name="gender" aria-label="gender">
                        <option hidden <?= isSelected(auth('gender'), "")    ?>>Choose Gender</option>
                        <option value='male' <?= isSelected(auth('gender'), "male")    ?>>Male</option>
                        <option value='female' <?= isSelected(auth('gender'), "female")    ?>>Female</option>
                    </select>
                    <button class=" mt-3 ms-auto d-block btn btn-info text-light">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route("/Profile/editPassword") ?>" method="POST">
                    <input type="password " class="form-control" name="password" placeholder="Enter new Password">

                    <button class=" mt-3 ms-auto d-block btn btn-info text-light">Edit</button>
                </form>

            </div>
        </div>
    </div>
</div>