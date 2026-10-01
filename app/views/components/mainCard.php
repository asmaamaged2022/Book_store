        <div class="col-xl-3 mx-auto part1  mb-3">
            <div class="item bg-body rounded-5 py-3 px-4">
                <div class="head">
                    <div class="image mx-auto ">
                        <img src="<?=asset("images/default.png")?>" alt="" class=" img-fluid">
                    </div>
                    <div class="name d-flex justify-content-center align-items-center my-3">
                        <i class="fa-solid fa-pen-to-square me-2 text-info" data-bs-toggle="modal"  data-bs-target="#editNameModal"></i>
                        <h5 class="mb-0 fw-bold" title='<?=$_SESSION['user']['name']?>'><?=$_SESSION['user']['name']?></h5>
                    </div>
                </div>
                <div class="body">
                    <div class="item mb-3 d-flex justify-content-start align-items-center flex-nowrap">
                        <div class="info d-flex  align-items-center flex-nowrap">
                            <i class="fa-solid fa-pen-to-square me-2 text-info" data-bs-toggle="modal" data-bs-target="#editEmailModal"></i>
                            <h6 class="mb-0 fw-bold text-nowrap" >Email : </h6>
                        </div>
                        <p class="content fw-bold mb-0 ms-1 text" title='<?=$_SESSION['user']['email']?>'>
                            <?=$_SESSION['user']['email']?>
                        </p>

                    </div>
                      <div class="item mb-3 d-flex justify-content-start align-items-center flex-wrap">
                        <div class="info d-flex  align-items-center flex-nowrap" data-bs-toggle="modal" data-bs-target="#editPhoneModal">
                            <i class="fa-solid fa-pen-to-square me-2 text-info"></i>
                            <h6 class="mb-0 fw-bold text-nowrap">Phone : </h6>
                        </div>
                        <p class="content fw-bold mb-0 ms-1">
                            <?=$_SESSION['user']['phone']?>
                        </p>

                    </div>
                     <div class="item mb-3 d-flex justify-content-start align-items-center flex-wrap">
                        <div class="info d-flex  align-items-center flex-nowrap">
                            <i class="fa-solid fa-pen-to-square me-2 text-info" data-bs-toggle="modal" data-bs-target="#editGenderModal"></i>
                            <h6 class="mb-0 fw-bold text-nowrap">Gender : </h6>
                        </div>
                        <p class="content fw-bold mb-0 ms-1">
                             <?=$_SESSION['user']['gender']?>
                        </p>

                    </div>
                     <div class="item mb-3 d-flex justify-content-start align-items-center flex-nowrap">
                        <div class="info d-flex  align-items-center flex-nowrap">
                            <i class="fa-solid fa-pen-to-square me-2 text-info" data-bs-toggle="modal" data-bs-target="#editPasswordModal"></i>
                            <h6 class="mb-0 fw-bold text-nowrap">Password </h6>
                        </div>

                    </div>
                </div>
            </div>
        </div>