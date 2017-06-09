<?php
if (isset($_GET['action'])) {
    if($_GET['action'] == 'add_user_reward' && isset($_GET['id'])){
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){ // si l'utilisateur est connecter
            $id_user = $_SESSION['id_connected'];
            $id_reward = $_GET['id'];

           if(IsCreatedUserReward($id_user, $id_reward)){ // test si l'enregistrement est deja créé
               DeleteUserReward($id_user, $id_reward); // si c'est le cas on l'enelève
           } else {
               InsertUserReward($id_user, $id_reward); // si ce n'est pas le cas on l'ajoute
           }
        }
    }
    header('Location: '. $_SERVER['PHP_SELF']);
}
?>