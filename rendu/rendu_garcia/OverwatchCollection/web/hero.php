<!--
    Auteur: Sven Wikberg
    Date: 19/06/2017
    Description: Page d'un heros
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
        <section id="hero_info">
            <?php
            OcDisplay::DisplayHeroInfo($_GET['id']);
            ?>
        </section>
        <section id="hero_abilities">
            <?php
            OcDisplay::DisplayHeroAbilities($_GET['id']);
            ?>
        </section>
        <section id="rewards">
            <?php
            OcDisplay::DisplayHeroRewards($_GET['id']);
            ?>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>