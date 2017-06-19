<!--
    Auteur: Sven Wikberg
    Date: 19/06/2017
    Description: Page des autres objets cosmetiques
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
        <script src="script.js"></script>
    </head>
    <body>
        <header>
            <?php
            OcDisplay::DisplayNavbar();
            ?>
        </header>
        <section id="others_rewards_info">
            <h1>Others Rewards</h1>
            <p>Certains des objets cosmetiques dans Overwatch n'ont pas d'héros associé, par exemple les icones d'utilisateurs, étant donnée qu'elle 
            sont faites pour le compte et pas un héro spécifique. C'est sur cette page qu'elle seront répértoriées, triées par catégories et par raretés.</p>
        </section>
        <section id="rewards">
        <?php
            OcDisplay::DisplayOtherRewards();
        ?>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved <br>
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>