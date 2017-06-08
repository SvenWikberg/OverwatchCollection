<!doctype html>
<?php
session_start();

require_once('inc.dao.php');
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>index</title>
        <link rel="stylesheet" href="css/style-main.css">
        <script src="script.js"></script>
    </head>
    <body>
        <header>
            <?php include_once('inc.navbar.php'); ?>
        </header>
        <section id="heroes">
            <?php
            $heroes_array = SelectHeroesInArrayOfRole(); // retourne un tableau, trié par role, de tableau de héros
            $display = '';
            $nb_col_max = 4; // nombre de colonnes maximum pour les tableaux de heros
            $nb_col_current = 0; // nombre de colonnes actuelle

            foreach ($heroes_array as $key => $role) { // pour chaque role on fait un tableau afin d'ordonner et de regrouper les heros
                $display .= '<div>';
                $display .= '<h1>' . $key . '</h1>';
                $display .= '<table>';
                foreach ($role as $hero) {
                    $nb_col_current++;

                    if($nb_col_current == 1) // si le nombre de colonne actuelle vaut 1, c'est qu'on est au debut d'une nouvelle ligne donc on ouvre une balise <tr>
                        $display .= '<tr>';
                    $display .= '<td><a href="hero.php?id=' .$hero['id_hero']. '"><img src="img/icon_hero.png" alt="' .$hero['name']. '"><div>' .$hero['name']. '</div></a></td>';
                    if($nb_col_current == $nb_col_max){ // si le nombre de colonne actuelle vaut le nombre de colonne max, c'est qu'on est a la fin de la ligne donc on ferme une balise <tr>
                        $display .= '</tr>';
                        $nb_col_current = 0;
                    }
                }
                $nb_col_current = 0; // on remet a 0 pour le prochain role
                $display .= '</table>';
                $display .= '</div>';
            }
            echo $display;
            ?>
        </section>
    </body>
</html>