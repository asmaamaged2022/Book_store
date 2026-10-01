<nav class='navbar navbar-expand-lg  position-absolute top-0  w-100'>
  <div class='container position-relative  px-md-5'>
    <a class='navbar-brand' href='#'>
      <div class='image'>
        <img src='<?php echo asset('images/logo.png'); ?>' alt='' class='img-fluid'>
      </div>
    </a>
    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
      <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
      <ul class='navbar-nav ms-auto mb-2 mb-lg-0'>
        <li class='nav-item'>
          <a class='nav-link active' aria-current='page' href='<?php echo route(''); ?>'>Home</a>
        </li>
        <?php
        if (isAuth('admin')) {
          $userName = Auth('name');
          $profilePath = route('/Profile');
          $registerPath = route('/auth/register');
          $LogoutPath = route('/auth/logout');


          echo "
        <li class='nav-item dropdown'>
          <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
          {$userName}
          </a>
          <ul class='dropdown-menu'>
            <li><a class='dropdown-item' href='$profilePath '>profile</a></li>
            <li><a class='dropdown-item' href='$registerPath '>Create New Admin</a></li>
            <li><a class='dropdown-item' href='$LogoutPath '>LogOut</a></li>
          </ul>
        </li>
              
              ";
        } else if (isAuth('customer')) {
          $userName = Auth('name');
          $profilePath = route('/Profile');
          $LogoutPath = route('/auth/logout');


          echo "
        <li class='nav-item dropdown'>
          <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
          {$userName}
          </a>
          <ul class='dropdown-menu'>
            <li><a class='dropdown-item' href='$profilePath '>profile</a></li>
            <li><a class='dropdown-item' href=' $LogoutPath  '>LogOut</a></li>
          </ul>
        </li>";
        } else {
          $registerPath = route('/auth/register');
          $loginPath = route('/auth/Login');

          echo "
        <li class='nav-item dropdown'>
          <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            Account
          </a>
          <ul class='dropdown-menu'>
            <li><a class='dropdown-item' href='$loginPath'>Login</a></li>
            <li><a class='dropdown-item'  href='$registerPath'>Register</a></li>
          </ul>
        </li>
              
              ";
        }

        ?>

      </ul>

    </div>
  </div>
</nav>