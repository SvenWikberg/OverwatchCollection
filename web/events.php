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
            <?php
            include_once('inc.navbar.php'); 
            ?>
        </header>
        <section>
            <?php
            $events = SelectEvents();
            $display = '';
            $nb_col_max = 2; // nombre de colonnes maximum pour les tableaux de heros
            $nb_col_current = 0; // nombre de colonnes actuelle

            $display .= '<table border="1">';
            foreach ($events as $event) {
                $nb_col_current++;

                if($nb_col_current == 1) // si le nombre de colonne actuelle vaut 1, c'est qu'on est au debut d'une nouvelle ligne donc on ouvre une balise <tr>
                    $display .= '<tr>';
                $display .= '<td><a href="event.php?id=' .$event['id_event']. '"><div>' .$event['name']. '</div><img style="width: 100%;" src="img/icon_event.jpg" alt="' .$event['name']. '"><div>From: ' .$event['start_date']. ' To: ' .$event['start_date']. '</div></a></td>';
                if($nb_col_current == $nb_col_max){ // si le nombre de colonne actuelle vaut le nombre de colonne max, c'est qu'on est a la fin de la ligne donc on ferme une balise <tr>
                    $display .= '</tr>';
                    $nb_col_current = 0;
                }
            }
            $display .= '</table>';

            echo $display;
            ?>
        </section>
    </body>
</html>