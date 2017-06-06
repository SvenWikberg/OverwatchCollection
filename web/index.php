<!doctype html>
<?php
session_start();

require_once('overwatchcollection_dao.php');
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>index</title>
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
    <?php
    print_rr(GetUserByUsername('sven'));
    ?>
    </body>
</html>