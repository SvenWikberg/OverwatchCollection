<!--
    Auteur: Sven Wikberg
    Date: 19/06/2017
    Description: Page d'accueil
-->    
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
    </head>
    <body>
        <header>
            <?php
            OcDisplay::DisplayNavbar();
            ?>
        </header>
        <section id="index">
            <h1>Overwatch Collection</h1>
            <div class="flex_row">
                <div style="width: 70%;">
                    <p>Bienvenue sur Overwatch Collection! Le site qui vous permet enfin d'avoir un suivi de vos objets dans Overwatch™.
                    Vous n'avez pas besoins de créer compte si vous voulez seulement naviguer parmis les héros et les objets, par contre
                    si vous voulez pouvoir sélectionner des objets et avoir un suivis ainsi que des statistiques, vous êtes obligé d'avoir 
                    compte.</p>
                    <p>Ce site est divisé en plusieurs parties, d'abords il y a la partie "Heroes", cette partie contient les héros du jeu, pour chaque 
                    héro il y a un résumé, quelques informations et évidemment la liste, triée pas rareté, des objets du héros en question.
                    <br>Ensuite, il y a la partie "Events" qui contient les événements du jeu, comme par exemple Halloween ou Noël, et de la même manière
                    que pour les héros, il y a la liste des objets de l'événement.
                    <br>Après ça il y a la partie "Rewards" qui contients les objets qui ne sont relié à aucun héros, comme les icons de joueurs par 
                    exemple.
                    <br>Et finalement il y a la partie "My Account" qui est accessible uniquement pour les utilisateurs connecté, qui affiche  
                    entre autre des statistiques sur les objets sélectionné et un classement des utilisateurs.</p>
                </div>
                <div style="width: 25%;">
                    <h2>Users list</h2>
                    <?php
                    OcDisplay::DisplayListUsers();
                    ?>
                </div>
            </div>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>