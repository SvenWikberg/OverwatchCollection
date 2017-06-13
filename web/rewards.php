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
            <?php
            include_once('inc.navbar.php'); 
            ?>
        </header>
        <section id="others_rewards_info">
            <h1>Others Rewards</h1>
            <p>Certains des objets cosmetiques dans Overwatch n'ont pas d'héros associé, par exemple les icones d'utilisateurs, étant donnée qu'elle 
            sont faites pour le compte et pas un héro spécifique. C'est sur cette page qu'elle seront répértoriées, triées par catégories et par raretés.</p>
        </section>
        <section id="rewards">
        <?php
            DisplayOtherRewards();
        ?>
        </section>
    </body>
</html>
<?php
    function DisplayOtherRewards(){
        $rewards_array = SelectRewardsInArrayOfQualityAndTypeByNoIdHero(); // retourne un tableau de rewards

        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si l'utilisateur est connecter on va chercher l'id des rewards qu'il a
            $rewards_owned = SelectIdRewardsByNoIdHeroAndIdUser($_SESSION['id_connected']);
        else
            $rewards_owned = false;

        $display = '';

        foreach ($rewards_array as $key => $type) {
            $quality_count = count($type); // on compte le nombre de boite il y par catégorie afin de definir la taille de celle-ci
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

                    // le lien envoie 2 variables en GET:
                            // action, qui signifie qu'il faut faire une action en l'occurrence ajouter un "user_reward"
                            // id_reward, qui est l'id de l'objet sur lequel on a cliqué
                    $display .= '<li>';
                    if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si un utilisateur est connecté on affiche le liens pour ajouter/enlever un "user_reward" 
                        $display .= '<a ' .$css_string. ' href="rewards.php?action=add_user_reward&id_reward=' .$reward['id_reward']. '">';
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
    }
?>