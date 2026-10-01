       <?php
        /**
         * @var array $authors
         */
        ?>



       <div class="row" id="AuthorTab">
           <?php
            if (!empty($authors['data'])) {

                foreach ($authors['data'] as $author) {
                    $shortBio = "";

                    if ($author['bio'] !== null) {
                        $shortBio = substr($author['bio'], 0, 100);
                    } else {
                        $shortBio = ".....";
                    }
                    $userImage = asset('images/author.png');
                    echo " 
                <div class=' col-xl-4 col-md-6   '>
           <div class='box mb-3'>
               <div class='item infoCard authorCard mainBg text-dark px-4 py-4 rounded-3'>

                   <div class='head text-center'>
                       <div class='image mb-3 mx-auto'>
                           <img
                               src='{$userImage}'
                               alt=''
                               class='img-fluid' />
                       </div>

                       <p class='fw-bold name'><i class='fa-solid fa-feather me-1'></i>{$author['name']}</p>
                   </div>

                 
             <div class='item mb-3  BioBox'>
                       <div class='info d-flex  align-items-center flex-nowrap'>
                           <h6 class='mb-0 headBio fw-bold text-nowrap'>About Author </h6>
                       </div>
                       <p class='content fw-bold mb-0 ms-1 bodyBio' title='{$shortBio}'>
                          {$shortBio}
                            
                       </p>

                   </div> 
                <button class='btn addBook mt-3 ' onclick='openAddBookPopup({$author['id']},\"{$author['name']}\")' >Add New Book</button>

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
        preparePagination($authors, "authors");
        ?>