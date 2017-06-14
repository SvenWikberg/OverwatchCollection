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
        <script src="script.js"></script>
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
    </body>
</html>