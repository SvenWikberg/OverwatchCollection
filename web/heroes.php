<!doctype html>
<?php
session_start();

require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>OverwatchCollection</title>
        <link rel="stylesheet" href="css/style-main.css">
        <script src="script.js"></script>
    </head>
    <body>
        <header>
            <?php 
            OcDisplay::DisplayNavbar();
            ?>
        </header>
        <section id="heroes">
            <?php
            OcDisplay::DisplayHeroesByRole(4);
            ?>
        </section>
    </body>
</html>