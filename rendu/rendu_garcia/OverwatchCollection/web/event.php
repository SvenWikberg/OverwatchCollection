<!--
    Auteur: Sven Wikberg
    Date: 19/06/2017
    Description: Page d'un evenement
-->    
<!doctype html>
<?php
session_start();

require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');
require_once('function/func.user_reward.php'); 

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>OverwatchCollection</title>
        <link rel="stylesheet" href="css/style-main.css">
    </head>
    <body>
        <header>
            <?php
            OcDisplay::DisplayNavbar();
            ?>
        </header>
        <section id="event_info">
            <?php
            OcDisplay::DisplayEventInfo($_GET['id']);
            ?>
        </section>
        <section id="rewards">
            <?php
            OcDisplay::DisplayEventRewards($_GET['id']);
            ?>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>