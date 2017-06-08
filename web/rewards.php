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
        <section id="others_rewards_info">
            <h1>Others Rewards</h1>
            <p>Certains des objets cosmetiques dans Overwatch n'ont pas d'héros associé, par exemple les icones d'utilisateurs, étant donnée qu'elle 
            sont faites pour le compte et pas un héro spécifique. C'est sur cette page qu'elle seront répértoriées, par catégorie et par rareté.</p>
        </section>
        <section class="rewards">
        <?php
        $rewards_array = SelectRewardsInArrayOfQualityAndTypeByNoIdHero(); // retourne un tableau de rewards

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
                    $display .= '<li>' .$reward['name']. '</li>';
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