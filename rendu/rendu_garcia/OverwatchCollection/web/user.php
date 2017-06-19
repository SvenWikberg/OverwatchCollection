<!--
    Auteur: Sven Wikberg
    Date: 19/06/2017
    Description: Page utilisateur
-->    
<!doctype html>
<?php
session_start();

require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');

if (isset($_GET['action'])) { // selon l'action, la page recupere, teste ou process des données differentes
    $myget = '';
    if($_GET['action'] == 'login'){ // l'action login teste les données entrées par l'utilisateur afin de le connecter ou pas
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_ENCODED);
            $password = sha1(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED));

            $user = OcDao::SelectUserByUsername($username); // on récupere les données de l'utilisateur grace a son nom d'utilisateur

            if($user == null) // si l'on ne récupère rien, ca veut dire que ce nom d'utilisateur n'existe pas, donc on informe l'utilisateurgrace a l'erreur en GET
                $myGet = '?msg=wrongUn';
            elseif ($user['password'] == $password) { // si tout est juste 
                    if($user['is_banned'] == 1) { // si l'utilisateur est banni
                        $myGet = '?msg=banned';
                    } else{ // si l'utilisateur n'est pas banni,on le connecte
                        $_SESSION['id_connected'] = $user['id_user'];
                    }
            }
            else { // si le mot de passe est faux on met l'erreur en GET afin d'informer l'utilisateur 
                $myGet = '?msg=wrongPw';
            }
        }
    } elseif ($_GET['action'] == 'signin') { // l'action sign in ajoute un nouvel utilisateur la dans la base avec les données entrées
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_ENCODED);
            $password = sha1(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED));
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            $tmp = OcDao::InsertUser($username, $password, $email);
            if($tmp == null){
                $myGet = '?msg=signOk';
            } else {
                if($tmp == 1062){
                    $myGet = '?msg=duplicate';
                }
            }
        }
    } elseif ($_GET['action'] == 'deco') { // l'action deco met la valeur de l'id_connected a null, id_connected qui donne l'info de l'id de utilisateur connecté
        session_destroy(); 
    } elseif ($_GET['action'] == 'update') { // l'action update met a jour les donnée de l'utilisateur avec les données qu'il a entrées
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){ // si l'utilisateur est connecter
            if (isset($_POST['username']) && isset($_POST['email'])) {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_ENCODED);
                $email = filter_input(INPUT_POST, 'email');

                $tmp = OcDao::UpdateUserByIdNoPwd($_SESSION['id_connected'], $username, $email);
                if($tmp == null){
                    $myGet = '?msg=updateOK';
                } else {
                    if($tmp == 1062){
                        $myGet = '?msg=updateDuplicate';
                    }
                }
            }
        }
    }
    header('Location: user.php' . $myGet);
}

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
        <?php
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){ // si l'utilisateur est connecter il peut se deconnecter
            if(isset($_GET['goto'])){
                if($_GET['goto'] == 'updating'){
                    OcDisplay::DisplayAccountInfoUpdating($_SESSION['id_connected']);
                }
            } else {
                OcDisplay::DisplayAccountInfo($_SESSION['id_connected']);

                OcDisplay::DisplayAccountStats($_SESSION['id_connected']);
            }
        } else {
            if(isset($_GET['msg']))
                if($_GET['msg'] == 'signOk') // l'utilisateur a bien ete ajouté a la base de donnees'
                    echo '<h2>Account created</h2>';
                OcDisplay::DisplayLogin();
                OcDisplay::DisplaySignin();
        }
        ?>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>
