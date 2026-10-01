    
    <div
        class="tab-pane fade show active"
        id="statistics-tab-pane"
        role="tabpanel"
        aria-labelledby="statistics-tab"
        tabindex="0">
        <?php
        require_once __DIR__ . "/../statistics_card.php";        ?>
    </div>
    <div
        class="tab-pane fade"
        id="admins-tab-pane"
        role="tabpanel"
        aria-labelledby="admins-tab"
        tabindex="1">
        <?php
        require_once __DIR__ . "/../admins_card.php";
        ?>
    </div>
    <div
        class="tab-pane fade"
        id="clients-tab-pane"
        role="tabpanel"
        aria-labelledby="clients-tab"
        tabindex="2">
        <?php
        require_once __DIR__ . "/../customers_card.php";
        ?> 
    </div>
    <div
        class="tab-pane fade"
        id="authors-tab-pane"
        role="tabpanel"
        aria-labelledby="authors-tab"
        tabindex="3">
        <button class="btn addAuthor w-100 mb-4" data-bs-toggle="modal" data-bs-target="#AddAuthorModal"> Add Author</button>
        <?php
        require_once __DIR__ . "/../authors_card.php";
        ?>
    </div>
    <div
        class="tab-pane fade"
        id="books-tab-pane"
        role="tabpanel"
        aria-labelledby="books-tab"
        tabindex="4">

        <div id="BooksFilter">
            <form class="mb-3" id="BooksFilterForm">
                <div class="container mb-3">
                    <div class="row g-3">
                        <input type="hidden" name="page" value="1" id="paginationPage">
                        <!-- Title -->
                        <div class="col-lg-6">
                            <div class="input-group item">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-book"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Title..."
                                    name="title" />
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="col-lg-6">
                            <div class="input-group item">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-user"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Author..."
                                    name="author" />
                            </div>
                        </div>


                        <!-- Min Price -->
                        <div class="col-lg-6">
                            <div class="input-group item">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </span>

                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Min Price..."
                                    name="minPrice" />
                            </div>
                        </div>

                        <!-- Max Price -->
                        <div class="col-lg-6">
                            <div class="input-group item">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </span>

                                <input
                                    type="number"
                                    class="form-control"

                                    placeholder="Max Price..."
                                    name="maxPrice" />
                            </div>
                        </div>


                        <!-- Stock -->
                        <div class="col-lg-6">
                            <div class="input-group item">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-hashtag"></i>
                                </span>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="stock"
                                    placeholder="Stock..." />
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="col-lg-6">
                            <div class="input-group item">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-arrow-up-wide-short"></i>
                                </span>

                                <select class="form-select" name="sort">
                                    <option value="desc">↑ DESC</option>
                                    <option value="asc">↑ ASC</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <button class="btn IdentityButton w-100 submitBtn">Filter</button>

            </form>
        </div>
        <?php
        require_once __DIR__ . "/../books_card.php";
        ?>
    </div>
    <div
        class="tab-pane fade"
        id="ordered-tab-pane"
        role="tabpanel"
        aria-labelledby="ordered-tab"
        tabindex="5">
        <?php
        require_once __DIR__ . "/../ordered_orders.php";
        ?>
    </div>
    <div
        class="tab-pane fade"
        id="canceled-tab-pane"
        role="tabpanel"
        aria-labelledby="canceled-tab"
        tabindex="6">
        <?php
        require_once __DIR__ . "/../canceled_orders.php";
        ?>
    </div>
    <div
        class="tab-pane fade"
        id="done-tab-pane"
        role="tabpanel"
        aria-labelledby="done-tab"
        tabindex="7">
        <?php
        require_once __DIR__ . "/../Done_orders.php";
        ?>
    </div>

   