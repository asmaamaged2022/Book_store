    <?php
    /**
     * @var array $customers
     */
    ?>


    <div class="row">

        <?php
        if (!empty($customers['data'])) {
            foreach ($customers['data'] as $customer) {
                $customerId = $customer['id'];
                $userImage = asset('images/customer.png');
                $isBanned = ($customer['is_banned']) ? '' : 'd-none';
                $isButtonBanned = ($customer['is_banned'])
                    ? '<button class="btn  IdentityButton banBtn position-absolute" " onclick="banUser(' . $customerId . ', \'UnBan\')">UnBan</button>'
                    : '<button class="btn btn-danger banBtn position-absolute" " onclick="banUser(' . $customerId . ', \'Ban\')">Ban</button>';

                echo " 
                <div class='col-xl-4 col-md-6  '>
           <div class='box mb-3'>
               <div class='item infoCard mainBg customerCard text-dark px-4 py-4 rounded-3 position-relative' data-user-id='$customerId'>
                               <span class='badge badgeBan text-bg-danger position-absolute {$isBanned}' style='top:10px;right:10px;' '>Banned</span>

                   <div class='head text-center'>
                       <div class='image mb-3 mx-auto'>
                           <img
                               src='{$userImage}'
                               alt=''
                               class='img-fluid' />
                       </div>

                       <p class=' fw-bold name'>{$customer['name']}</p>
                   </div>

                   <div class='item mb-3 d-flex justify-content-start align-items-center '>
                       <div class='info d-flex  align-items-center flex-nowrap'>
                           <h6 class='mb-0 fw-bold text-nowrap'>Email : </h6>
                       </div>
                       <p class='content fw-bold mb-0 ms-1 text' title='{$customer['email']}'>
                           {$customer['email']}
                       </p>

                   </div>
                   <div class='item mb-3 d-flex justify-content-start align-items-center '>
                       <div class='info d-flex  align-items-center flex-nowrap'>
                           <h6 class='mb-0 fw-bold text-nowrap'>Gender : </h6>
                       </div>
                       <p class='content fw-bold mb-0 ms-1'>
                          {$customer['gender']}
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
    preparePagination($customers, "customers");
    ?>