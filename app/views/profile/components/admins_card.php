  <?php
    /**
     * @var array $admins
     */

    ?>


  <div class="row">

      <?php
        if (!empty($admins['data'])) {
            foreach ($admins['data'] as $admin) {
                $adminId = $admin['id'];
                $userImage = asset('images/admin.png');
                $isBanned = ($admin['is_banned']) ? '' : 'd-none';
                $isButtonBanned = "";
                $badge = "";
                if (Auth('id') < $adminId) {
                    $isButtonBanned = ($admin['is_banned'])
                        ? '<button class="btn w-100 IdentityButton banBtn" onclick="banUser(' . $adminId . ', \'UnBan\')">UnBan</button>'
                        : '<button class="btn w-100 btn-danger banBtn" onclick="banUser(' . $adminId . ', \'Ban\')">Ban</button>';

                    $badge = "<span class='badge badgeBan text-bg-danger position-absolute {$isBanned}' style='top:10px;right:10px;' '>Banned</span>";
                }
                echo " 
                <div class='col-md-4'>
                        <div class='box mb-3 '>
                            <div class='item infoCard  adminCard mainBg text-dark px-4 py-4 rounded-3 position-relative' data-user-id='$adminId'>
                               {$badge}
                                <div class='head text-center'>
                                    <div class='image mb-3 mx-auto'>
                                        <img
                                            src='{$userImage}'
                                            alt=''
                                            class='img-fluid' />
                                    </div>

                                    <p class=' fs-5 fw-bold' title='{$admin['name']}'>{$admin['name']}</p>
                                </div>
                                <div class='item mb-3 d-flex justify-content-start align-items-center '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap'>Email : </h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1 text' title='{$admin['email']}'>
                                        {$admin['email']}
                                    </p>

                                </div>
                                <div class='item mb-3 d-flex justify-content-start align-items-center '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap'>Gender : </h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1'>
                                        {$admin['gender']}
                                    </p>

                                </div>
                                <div class='item mb-3 d-flex justify-content-start align-items-center '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap'>Phone : </h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1'>
                                        {$admin['phone']}
                                    </p>

                                </div>
{$isButtonBanned}
                            </div>
                        </div>
                </div> 
                 ";
            }
        } else {
            echo "<p class='alert alert-warning w-75 text-center mx-auto'>There are no Data</p>";
        }
        ?>

  </div>

  <?php
    preparePagination($admins, "admins")
    ?>