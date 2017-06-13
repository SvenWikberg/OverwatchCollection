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
        <section id="event_info">
            <?php
            DisplayEventInfo($_GET['id']);
            ?>
        </section>
        <section id="rewards">
            <?php
            DisplayEventRewards($_GET['id']);
            ?>
        </section>
    </body>
</html>
<?php
    function DisplayEventRewards($id){
        $rewards_array = SelectRewardsInArrayOfQualityAndTypeByIdEvent($id); // retourne un tableau de rewards
        
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si l'utilisateur est connecter on va chercher l'id des rewards qu'il a
            $rewards_owned = SelectIdRewardsByIdEventAndIdUser($id, $_SESSION['id_connected']);
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

                        // si un hero est associer a l'objet on l'affiche sinon, on affiche juste le nom de l'objet
                        // le lien envoie 3 variables en GET:
                            // id, qui est l'id de l'evenement, qui sert a revenir sur la bonne page
                            // action, qui signifie qu'il faut faire une action en l'occurrence ajouter un "user_reward"
                            // id_reward, qui est l'id de l'objet sur lequel on a cliqué
                        $display .= '<li>'; 
                        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si un utilisateur est connecté on affiche le liens pour ajouter/enlever un "user_reward" 
                            $display .= '<a ' .$css_string. ' href="event.php?id=' .$id. '&action=add_user_reward&id_reward=' .$reward['id_reward']. '">';
                        $display .= $reward['r_name'] . ($reward['h_name'] != NULL ? ' / ' . $reward['h_name'] : '');
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
            header('Location: events.php');
        }
    }

    function DisplayEventInfo($id){
        $event = SelectEventById($id); // retourne l'enregistrement de l'événement depuis la base

        if($event){
            $display = '<h1>' .$event['name']. '</h1>';
            $display .= '<div><p>Beginning Date: ' .$event['start_date']. '</p><p>Ending Date: ' .$event['end_date']. '</p></div>';

            echo $display;
        } else {
            header('Location: events.php');
        }
    }
?>