<?php
require_once __DIR__ . "/components/functions.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | <?= ucfirst(Auth('role')) ?></title>
    <link rel="stylesheet" href="<?php echo asset("CSS/plugins/all.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo asset("CSS/plugins/bootstrap.css"); ?>">
    <link rel="stylesheet" href="<?php echo asset("CSS/style.css"); ?>">
</head>

<body class="min-vh-100 border border-0">

    <?php
    require_once __DIR__ . "/../components/nav.php";
    ?>
    <div class="container profile mb-5">
        <div class="row">

            <?php
            require_once __DIR__ . "/../components/mainCard.php";
            ?>
            <div class="col-xl-9 part2" data-role='<?= isAuth("customer") ? "customer" : "admin" ?>'>
                <div class="item bg-body overflow-hidden rounded-4 position-relative ">

                    <ul class="nav nav-tabs <?= isAuth("customer") ? "pt-3" : "" ?> " id="myTab" role="tablist">
                        <?php
                        if (isAuth("admin")) {
                            require_once __DIR__ . "/components/admin/adminLinks.php";
                        } else {
                            require_once __DIR__ . "/components/customer/customerLinks.php";
                        }
                        ?>
                    </ul>
                    <div class="tab-content p-3" id="myTabContent">
                        <?php
                        if (isAuth("admin")) {
                            require_once __DIR__ . "/components/admin/adminTabs.php";
                        } else {
                            require_once __DIR__ . "/components/customer/customerTabs.php";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once __DIR__ . "/components/Popups/EditPopup.php";
    require_once __DIR__ . "/components/Popups/CartPopup.php";
    require_once __DIR__ . "/components/admin/Popups/AddAuthorPopup.php";
    require_once __DIR__ . "/components/admin/Popups/AddBookPopup.php";
    require_once __DIR__ . "/components/admin/Popups/cancelReasonPopup.php";

    ?>
    <script src="<?php echo asset("js/bootstrap.js"); ?>"></script>
    <script src="<?php echo asset("js/plugins/sweetAlert.js"); ?>"></script>
    <script src="<?php echo asset("js/profile/functions.js"); ?>"></script>
    <script src="<?php echo asset("js/profile/profile.js"); ?>"></script>
    <?php
    if (isAuth("customer")) {
        echo "<script src='" . asset("js/profile/customer.js") . "'></script>";
    }
    ?>

    <script>
        isError(<?= json_encode($_SESSION['editAlert'] ?? null) ?>)
    </script>
    <?php
    unset($_SESSION['editAlert']);
    ?>
</body>

</html>