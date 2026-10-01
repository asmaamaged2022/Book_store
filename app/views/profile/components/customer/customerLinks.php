   <?php
    /**
     * @var array $total
     */
    ?>

   <li type="button" class="btn mainBg position-absolute" style="top: 15px; right: 25px;border: 1px solid #A882FF;" onclick='getItemsInCart()'>
       <i class="fa-solid fa-cart-shopping text-info cartIcon fs-5"></i>
       <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
           <span id="TotalOrders"><?= $total['totalItemsIntoOrder'] ?></span>
           <span class="visually-hidden">unread messages</span>
       </span>
   </li>


   <li class="nav-item" role="presentation">
       <button
           class="nav-link active "
           id="statistics-tab"
           data-bs-toggle="tab"
           data-bs-target="#statistics-tab-pane"
           type="button"
           role="tab"
           aria-controls="statistics-tab-pane"
           aria-selected="true">
           Statistics
       </button>
   </li>

   <li class="nav-item" role="presentation">
       <button
           class="nav-link"
           id="books-tab"
           data-bs-toggle="tab"
           data-bs-target="#books-tab-pane"
           type="button"
           role="tab"
           aria-controls="books-tab-pane"
           aria-selected="false">
           Books
       </button>
   </li>
   <li class="nav-item dropdown">
       <button
           class="nav-link dropdown-toggle"
           data-bs-toggle="dropdown"
           role="button"
           aria-expanded="false">
           Orders
       </button>

       <ul class="dropdown-menu">

           <li>
               <a
                   class="dropdown-item pointer"
                   id="ordered-tab"
                   data-bs-toggle="tab"
                   data-bs-target="#ordered-tab-pane"
                   role="tab"
                   aria-controls="ordered-tab-pane"
                   aria-selected="false">
                   Ordered
               </a>
           </li>

           <li>
               <a
                   class="dropdown-item pointer"
                   id="canceled-tab"
                   data-bs-toggle="tab"
                   data-bs-target="#canceled-tab-pane"
                   role="tab"
                   aria-controls="canceled-tab-pane"
                   aria-selected="false">
                   Canceled
               </a>
           </li>

           <li>
               <a
                   class="dropdown-item pointer"
                   id="done-tab"
                   data-bs-toggle="tab"
                   data-bs-target="#done-tab-pane"
                   role="tab"
                   aria-controls="done-tab-pane"
                   aria-selected="false">
                   Done
               </a>
           </li>

       </ul>
   </li>