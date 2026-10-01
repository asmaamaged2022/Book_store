    <?php
    /**
     * @var array $books
     */
    ?>


    <div class="row">

        <?php
        if (!empty($books['data'])) {
            foreach ($books['data'] as $book) {
                $shortDisc = $book['description'];
                if ($shortDisc == "") {
                    $shortDisc = "...";
                }
                $userImage = $book['image'] == null ? asset('images/book.png') : asset('upload/' . $book['image']);
                $quantityInput = isAuth('customer') ?
                    "<div class='input-group mb-3  position-absolute start-50 ' style='width: 90%; bottom:10px; transform:translateX(-50%);'>
                        <input type='number' min='1' class='form-control' placeholder='Quantity' id='AddToCartInput-{$book['id']}'>
                        <button class='btn IdentityButton' type='button' onclick='addToCart({$book['id']},this)'>Add To Cart</button>
                        </div>" :
                    "";
                    $role=isAuth('customer')?'customer':'admin';
                echo " 
                <div class='col-xl-4 col-md-6 show {$role}' data-book-id='{$book["id"]}'> 
                    <div class='box mb-3'>
                        <div class='item infoCard bookCard mainBg text-dark px-4 py-4 rounded-3 position-relative' data-book-id='{$book['id']}'>

                            <div class='head text-center'>
                                <div class='image mb-3 mx-auto'>
                                    <img
                                        src='{$userImage}'
                                        alt=''
                                        class='img-fluid rounded-circle' />
                                </div>

                                <p class=' fw-bold name' title='{$book['title']}'><i class='fa-solid fa-book me-1' ></i>{$book['title']}</p>
                            </div>
                            <div class='boxData'>
                                <div class='item mb-3 '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap head w-100'><i class='fa-solid fa-feather me-1'></i>Author</h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1'>
                                        {$book['author_name']}
                                    </p>

                                </div>
                                <div class='item mb-3  '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap head w-100'>Description </h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1 px-1 disc' title=' {$shortDisc}'>
                                    {$shortDisc}
                                    </p>

                                </div>
                               <div class='additionalInfo d-flex w-100'>
                                    <div class='item pb-1  w-100 borderline'>
                                        <div class='info  flex-nowrap head'>
                                            <h6 class='mb-0 fw-bold text-nowrap'> <i class='fa-solid fa-tag me-1'></i>Price </h6>
                                        </div>
                                        <p class='content fw-bold mb-0 '>
                                            {$book['price']}
                                        </p>

                                    </div>
                                    <div class='item pb-1 w-100'>
                                        <div class='info  flex-nowrap head'>
                                            <h6 class='mb-0 fw-bold text-nowrap'><i class='fa-brands fa-codepen me-1'></i>Stoke  </h6>
                                        </div>
                                        <p class='content stock fw-bold mb-0 ' id='BookStock-{$book['id']}'>
                                                                        {$book['stock']}

                                        </p>
                                    </div>
                                </div>
                            </div>
                           $quantityInput
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
    preparePagination($books, "books");
    ?>