

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="<?php echo asset("CSS/plugins/all.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo asset("CSS/plugins/bootstrap.css"); ?>">
    <link rel="stylesheet" href="<?php echo asset("CSS/style.css"); ?>">
</head>

<body class="vh-100">
    <?php
    require_once __DIR__ . "/../components/nav.php";
    ?>
    <div class="container vh-100  ">
        <div class="loginContent pt-5 h-100 d-flex justify-content-center align-items-center">
            <form method="POST" action="<?= route("/auth/Login") ?>" class="loginForm py-4 px-3">
                <h2 class=" text-center mainColor mb-3"> LogIn</h2>
                <?= getSessionMsg('invalid'); ?>

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
                <button type="submit" class="mainBtn w-100">Login</button>
            </form>
        </div>
    </div>

    <script src="<?php echo asset("js/bootstrap.js"); ?>"></script>
    <script src="<?php echo asset("js/index.js"); ?>"></script>
</body>

</html>