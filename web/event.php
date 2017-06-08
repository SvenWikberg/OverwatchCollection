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
        <section id="event_info">
            <?php
            $event = SelectEventById($_GET['id']); // retourne l'enregistrement de l'événement depuis la base

            $display = '<h1>' .$event['name']. '</h1>';
            $display .= '<div><p>Beginning Date: ' .$event['start_date']. '</p><p>Ending Date: ' .$event['end_date']. '</p></div>';

            echo $display;
            ?>
        </section>
        <section class="rewards">
            <?php
            $rewards_array = SelectRewardsInArrayOfQualityAndTypeByIdEvent($_GET['id']); // retourne un tableau de rewards
            $display = '';

            foreach ($rewards_array as $key => $type) {
                $quality_count = count($type); // on compte le nombre de boite il y par catégorie afin de definir la taille de cell-ci
                $display .= '<div class="rewards_type" style="width:' . ($quality_count == 4 ? '100' : $quality_count * 25 - 0.5) . '%">';
                $display .= '<h2>' .$key. '</h2>';
                $display .= '<div>';
                foreach ($type as $key => $quality) {
                    $display .= '<div>';
                    $display .= '<h3>' .$key. '</h3><ul style="height:200px; width:170px; overflow:hidden; overflow-y:auto;">';
                    foreach ($quality as $key => $reward) {
                        // si un hero est associer a l'objet on l'affiche sinon, on affiche juste le nom de l'objet
                        $display .= '<li>' .$reward['r_name'].($reward['h_name'] != NULL ? ' / ' . $reward['h_name'] : ''). '</li>';
                    }
                    $display .= '</ul>';
                    $display .= '</div>';
                }
                $display .= '</div>';
                $display .= '</div>';
            }

            echo $display;
            ?>
        </section>
    </body>
</html>