<!-- if there are global vars use phpDoc (search) -->
 <?php
     require_once __DIR__ . "/../../helpers/helpers.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="<?php echo asset("CSS/plugins/all.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo asset("CSS/plugins/bootstrap.css"); ?>">
    <link rel="stylesheet" href="<?php echo asset("CSS/style.css"); ?>">
</head>
<body id="HomeBody">
<?php
    require_once __DIR__ . "/../components/nav.php";
    require_once __DIR__ . "/../components/header.php";

?>
<script src="<?php echo asset("js/bootstrap.js"); ?>"></script>
<script src="<?php echo asset("js/index.js"); ?>"></script>
</body>
</html>