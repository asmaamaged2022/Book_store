   <?php
    /**
     * @var array $total
     */
    ?>


   <div class="row">
       <div class="col-xl-3 col-md-4 col-sm-6 ">
           <div class="box mb-3">
               <div class="item infoCard mainBg text-dark px-4 py-4 rounded-3">

                   <div class="head text-center">
                       <i class="fa-solid fa-book  text-info fs-3"></i>
                       <h6 class=" fw-bold my-2 text-nowrap">Total Books</h6>
                   </div>
                   <div class="text-center text-success fw-bold"><?= $total['books'] ?></div>

               </div>
           </div>
       </div>
       <?php
        if (isAuth("admin")) {
            echo "
             <div class='col-xl-3 col-md-4 col-sm-6 '>
           <div class='box mb-3'>
               <div class='item infoCard mainBg text-dark px-4 py-4 rounded-3'>

                   <div class='head text-center'>
                       <i class='fa-solid fa-user-group  text-info fs-3'></i>
                       <h6 class='  fw-bold my-2 text-nowrap'>Total Authors</h6>
                   </div>
                   <div class='text-center text-success fw-bold'>{$total['authors']}</div>

               </div>
           </div>
       </div>
       <div class='col-xl-3 col-md-4 col-sm-6 '>
           <div class='box mb-3'>
               <div class='item infoCard mainBg text-dark px-4 py-4 rounded-3'>

                   <div class='head text-center'>
                       <i class='fa-solid fa-users  text-info fs-3'></i>
                       <h6 class='  fw-bold my-2 text-nowrap'>Total Customers</h6>
                   </div>
                   <div class='text-center text-success fw-bold'>{$total['customers']}</div>

               </div>
           </div>
       </div>
       <div class='col-xl-3 col-md-4 col-sm-6 '>
           <div class='box mb-3'>
               <div class='item infoCard mainBg text-dark px-4 py-4 rounded-3'>

                   <div class='head text-center'>
                       <i class='fa-solid fa-users-gear  text-info fs-3'></i>
                       <h6 class='  fw-bold my-2 text-nowrap'>Total Admins</h6>
                   </div>
                   <div class='text-center text-success fw-bold'>{$total['admins']}</div>

               </div>
           </div>
       </div>
            ";
        } else {
            echo "
            <div class='col-xl-3 col-md-4 col-sm-6 '>
           <div class='box mb-3'>
               <div class='item infoCard mainBg text-dark px-4 py-4 rounded-3'>

                   <div class='head text-center'>
                       <i class='fa-solid fa-book  text-info fs-3'></i>
                       <h6 class='  fw-bold my-2 text-nowrap'>Total Bought Books</h6>
                   </div>
                   <div class='text-center text-success fw-bold'>{$total['boughtBooks']}</div>

               </div>
           </div>
       </div>";
        }
        ?>

       <div class="col-xl-3 col-md-4 col-sm-6 ">
           <div class="box mb-3">
               <div class="item infoCard mainBg text-dark px-4 py-4 rounded-3">

                   <div class="head text-center">
                       <i class="fa-regular fa-circle-pause  text-info fs-3"></i>
                       <h6 class="  fw-bold my-2 text-nowrap">Total Ordered orders</h6>
                   </div>
                   <div class="text-center text-success fw-bold"><?= $total['orders']['ordered'] ?></div>

               </div>
           </div>
       </div>
       <div class="col-xl-3 col-md-4 col-sm-6 ">
           <div class="box mb-3">
               <div class="item infoCard mainBg text-dark px-4 py-4 rounded-3">

                   <div class="head text-center">
                       <i class="fa-solid fa-ban  text-info fs-3"></i>
                       <h6 class="  fw-bold my-2 text-nowrap">Total Canceled orders</h6>
                   </div>
                   <div class="text-center text-success fw-bold"><?= $total['orders']['canceled'] ?></div>

               </div>
           </div>
       </div>
       <div class="col-xl-3 col-md-4 col-sm-6 ">
           <div class="box mb-3">
               <div class="item infoCard mainBg text-dark px-4 py-4 rounded-3">

                   <div class="head text-center">
                       <i class="fa-solid fa-circle-check  text-info fs-3"></i>
                       <h6 class="  fw-bold my-2 text-nowrap">Total Done orders</h6>
                   </div>
                   <div class="text-center text-success fw-bold"><?= $total['orders']['done'] ?></div>

               </div>
           </div>
       </div>

   </div>