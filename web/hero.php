<!doctype html>
<?php
session_start();

require_once('inc.dao.php');

include_once('inc.func.user_reward.php'); 
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
            <?php include_once('inc.navbar.php'); ?>
        </header>
        <section id="hero_info">
            <?php
            DisplayHeroInfo($_GET['id']);
            ?>
        </section>
        <section id="hero_abilities">
            <?php
            DisplayHeroAbilities($_GET['id']);
            ?>
        </section>
        <section id="rewards">
            <?php
            DisplayHeroRewards($_GET['id']);
            ?>
        </section>
    </body>
</html>
<?php
    function DisplayHeroRewards($id){
        $rewards_array = SelectRewardsInArrayOfQualityAndTypeByIdHero($id); // retourne un tableau de rewards

        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si l'utilisateur est connecter on va chercher l'id des rewards qu'il a
            $rewards_owned = SelectIdRewardsByIdHeroAndIdUser($id, $_SESSION['id_connected']);
        else
            $rewards_owned = false;

        if($rewards_array){
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

                        // si l'id reward correspond a un element du tableau alors l'utilisateur a la reward, donc on l'affiche vert
                        if($rewards_owned && in_array($reward['id_reward'], $rewards_owned)){
                            $css_string = 'style="color: #00c600;"';
                        } else{
                            $css_string = '';
                        }

                        // le lien envoie 3 variables en GET:
                            // id, qui est l'id de l'heros, qui sert a revenir sur la bonne page
                            // action, qui signifie qu'il faut faire une action en l'occurrence ajouter un "user_reward"
                            // id_reward, qui est l'id de l'objet sur lequel on a cliqué
                        $display .= '<li>';
                        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si un utilisateur est connecté on affiche le liens pour ajouter/enlever un "user_reward" 
                            $display .= '<a ' .$css_string. ' href="hero.php?id=' .$id. '&action=add_user_reward&id_reward=' .$reward['id_reward']. '">';
                        $display .= $reward['name'];
                        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null)
                            $display .= '</a>';    
                        $display .= '</li>';
                    }
                    $display .= '</ul>';
                    $display .= '</div>';
                }
                $display .= '</div>';
                $display .= '</div>';
            }

            echo $display;
            } else {
                header('Location: heroes.php');
            }
    }

    function DisplayHeroAbilities($id){
        $abilities = SelectAbilitiesByIdHero($id); // retourne les capacité du heros
        $nb_col_max = 2; // nombre de colonnes maximum pour les tableaux de heros
        $nb_col_current = 0; // nombre de colonnes actuelle

        if($abilities){
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
        } else {
            header('Location: heroes.php');
        }
    }

    function DisplayHeroInfo($id){
        $hero = SelectHeroById($id); // retourne l'enregistrement du heros depuis la base

        if($hero){
            $display = '<h1>' .$hero['name']. '</h1>';
            $display .= '<p>' .$hero['description']. '</p>';
            $display .= '<div><p>Real Name: ' .$hero['real_name']. '</p><p>Base Of Operations: ' .$hero['base_of_operations']. '</p></div>';
            $display .= '<div><p>Health: ' .$hero['health']. '</p><p>Armour: ' .$hero['armour']. '</p><p>Shield: ' .$hero['shield']. '</p></div>';
            $display .= '<div><p>Affiliation: ' .$hero['affiliation']. '</p><p>Difficulty: ' .$hero['difficulty']. '</p></div>';

            echo $display;
        } else {
            header('Location: heroes.php');
        }
    }
?>