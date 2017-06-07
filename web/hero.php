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
        <section id="hero_info">
            <?php
            $hero = SelectHeroById($_GET['id']); // retourne l'enregistrement du heros dans la base

            $display = '<h1>' .$hero['name']. '</h1>';
            $display .= '<p>' .$hero['description']. '</p>';
            $display .= '<div><p>Real Name: ' .$hero['real_name']. '</p><p>Base Of Operations: ' .$hero['base_of_operations']. '</p></div>';
            $display .= '<div><p>Health: ' .$hero['health']. '</p><p>Armour: ' .$hero['armour']. '</p><p>Shield: ' .$hero['shield']. '</p></div>';
            $display .= '<div><p>Affiliation: ' .$hero['affiliation']. '</p><p>Difficulty: ' .$hero['difficulty']. '</p></div>';
            echo $display;
            ?>
        </section>
        <section id="hero_abilities">
            <?php
            $abilities = SelectAbilitiesByIdHero($_GET['id']); // retourne les capacité du heros
            $nb_col_max = 2; // nombre de colonnes maximum pour les tableaux de heros
            $nb_col_current = 0; // nombre de colonnes actuelle

            $display = '<table border="1">';
            foreach ($abilities as $ability) {
                $nb_col_current++;

                if($nb_col_current == 1) // si le nombre de colonne actuelle vaut 1, c'est qu'on est au debut d'une nouvelle ligne donc on ouvre une balise <tr>
                    $display .= '<tr>';
                $display .= '<td width=' . 100 / $nb_col_max . '%>';
                $display .= '<h2>' .$ability['name']. '</h2><p>' .$ability['description']. '</p>';
                $display .= ($ability['is_ultimate'] == 0 ? '<h3>Ultimate</h3>' : '');
                $display .= '</td>';


                if($nb_col_current == $nb_col_max){ // si le nombre de colonne actuelle vaut le nombre de colonne max, c'est qu'on est a la fin de la ligne donc on ferme une balise <tr>
                    $display .= '</tr>';
                    $nb_col_current = 0;
                }
            }
            $display .= '</table>';

            echo $display;
            ?>
        </section>
        <section id="hero_rewards">
            <?php
            $rewards_array = SelectRewardsInArrayOfQualityAndTypeByIdHero($_GET['id']);
            $display = '';

            foreach ($rewards_array as $key => $type) {
                $quality_count = count($type);
                $display .= '<div class="rewards_type" style="width:' . ($quality_count == 4 ? '100' : $quality_count * 25 - 0.5) . '%">';
                $display .= '<h2>' .$key. '</h2>';
                $display .= '<div>';
                foreach ($type as $key => $quality) {
                    $display .= '<ul style="height:200px; width:170px; overflow:hidden; overflow-y:scroll;">';
                    foreach ($quality as $key => $reward) {
                        $display .= '<li>' .$reward['name']. '</li>';
                    }
                    $display .= '</ul>';
                }
                $display .= '</div>';
                $display .= '</div>';
            }

            echo $display;
            ?>
        </section>
    </body>
</html>