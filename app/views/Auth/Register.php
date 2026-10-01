<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="<?php echo asset("CSS/plugins/all.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo asset("CSS/plugins/bootstrap.css"); ?>">
  <link rel="stylesheet" href="<?php echo asset("CSS/style.css"); ?>">
</head>

<body class="min-vh-100">
  <?php
  require_once __DIR__ . "/../components/nav.php"
  ?>
  <div class="container min-vh-100 ">


    <div class="registerContent  d-flex justify-content-center align-items-center">

      <form action="<?= route("/auth/register") ?>" method="POST" class="registerForm py-4 px-3 mt-5">
        <h2 class="text-center mainColor mb-3">Register</h2>
        <?= getSessionMsg('correct', false); ?>
        <?= getSessionMsg('invalid'); ?>
        <div class="input-group mb-3">
          <span class="input-group-text">
            <i class="fa-solid fa-user-shield"></i>
          </span>

          <select class="form-select" name="role" aria-label="Role">

            <option hidden <?= oldSelect('role', "") ?>>Choose Role</option>
            <?php
            if (isAuth('admin')) {
              $oldSelected = oldSelect('role', 'admin', true);
              echo "       
                   <option value='admin'{$oldSelected}>Admin</option>
                  ";
            } else {
              $oldSelected = oldSelect('role', "customer", true);
              echo "       
                   <option value='customer' {$oldSelected}>Customer</option>
                  ";
            }
            ?>
          </select>
        </div>
        <?= getError('role'); ?>
        <div class="input-group mb-3">
          <span class="input-group-text">
            <i class="fa-solid fa-user"></i>
          </span>
          <input type="text" class="form-control" name="name" placeholder="Name" aria-label="Name" value="<?= old('name') ?>" />
        </div>
        <?= getError('name'); ?>

        <div class="input-group mb-3">
          <span class="input-group-text">
            <i class="fa-solid fa-envelope"></i>
          </span>
          <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" value="<?= old('email') ?>" />
        </div>
        <?= getError('email'); ?>

        <div class="input-group mb-3">
          <span class="input-group-text">
            <i class="fa-solid fa-lock"></i>
          </span>
          <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" value="<?= old('password') ?>" />
        </div>
        <?= getError('password'); ?>

        <div class="input-group mb-3">
          <span class="input-group-text">
            <i class="fa-solid fa-phone"></i>
          </span>
          <input type="text" class="form-control" name="phone" placeholder="Phone" aria-label="Phone" value="<?= old('phone') ?>" />
        </div>
        <?= getError('phone'); ?>

        <div class="input-group mb-3">
          <span class="input-group-text">
            <i class="fa-solid fa-venus-mars"></i>
          </span>

          <select class="form-select" name="gender" aria-label="gender">
            <option hidden <?= oldSelect('gender', "") ?>>Choose Gender</option>
            <option value="male" <?= oldSelect('gender', "male") ?>>Male</option>
            <option value="female" <?= oldSelect('gender', "female", true) ?>>female</option>
          </select>
        </div>
        <?= getError('gender'); ?>
        <button type="submit" class="mainBtn w-100">Register</button>
      </form>

    </div>
  </div>
  <script src="<?php echo asset("js/bootstrap.js"); ?>"></script>
  <script src="<?php echo asset("js/index.js"); ?>"></script>
</body>

</html>