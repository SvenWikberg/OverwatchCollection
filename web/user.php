<!doctype html>
<?php
session_start();

require_once('inc.dao.php');
require_once('inc.func.display.php');

if (isset($_GET['action'])) { // selon l'action, la page recupere, teste ou process des données differentes
    $myget = '';
    if($_GET['action'] == 'login'){ // l'action login teste les données entrées par l'utilisateur afin de le connecter ou pas
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_ENCODED);
            $password = sha1(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED));

            $user = SelectUserByUsername($username); // on récupere les données de l'utilisateur grace a son nom d'utilisateur

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

            $tmp = InsertUser($username, $password, $email);
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
    } elseif ($_GET['action'] == 'update') { // 
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){ // si l'utilisateur est connecter
            UpdateUserByIdNoPwd($_SESSION['id_connected'], $_POST['username'], $_POST['email']);
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
        <script src="script.js"></script>
    </head>
    <body>
        <header>
            <?php include_once('inc.navbar.php'); ?>
        </header>
        <?php
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){ // si l'utilisateur est connecter il peut se deconnecter
            if(isset($_GET['goto'])){
                if($_GET['goto'] == 'updating'){
                    DisplayAccountInfoUpdating($_SESSION['id_connected']);
                }
            } else {
                DisplayAccountInfo($_SESSION['id_connected']);

                DisplayAccountStats($_SESSION['id_connected']);
            }
        } else {
            if(isset($_GET['msg']))
                if($_GET['msg'] == 'signOk') // l'utilisateur a bien ete ajouté a la base de donnees'
                    echo '<h2>Account created</h2>';
                DisplayLogin();
                DisplaySignin();
        }
        ?>
    </body>
</html>
<?php
    function DisplayLogin(){ // affichage du formulaire de connection avec les message d'erreurs, en GET, s'il y en a
        $display = '<section id="login"><form action="user.php?action=login" method="post">
                        <fieldset>
                        <legend><h2>Login</h2></legend>
                        Username :<br>
                        <input maxlength="25" required type="text" name="username" value="">';
                        
        if(isset($_GET['msg']))
            if($_GET['msg'] == 'wrongUn') // le nom d'utilisateur n'est pas valide
                $display .= 'Username not valid';
            elseif($_GET['msg'] == 'banned') // l'utilisateur est banni
                $display .= 'Your account has been banned';
                        
        $display .=    '<br>
                        Password:<br>
                        <input required type="password" name="password" value="">';

        if(isset($_GET['msg']))
            if($_GET['msg'] == 'wrongPw') // le mot de passe n'est pas valide
                $display .= 'Wrong password';
                        
        $display .=    '<br><br>
                        <input type="submit" value="Submit">
                        </fieldset>
                    </form></section>';
        echo $display;
    }

    function DisplaySignin(){ // affichage du formulaire de création de compte avec les message d'erreurs, en GET, s'il y en a
        $display = '<section id="sign_in">
                        <form action="user.php?action=signin" method="post">
                            <fieldset>
                                <legend><h2>Sign in</h2></legend>
                                Username* :<br>
                                <input maxlength="25" required type="text" name="username" value="">';

        if(isset($_GET['msg']))
            if($_GET['msg'] == 'duplicate') // nom d'utilisateur ou email deja utilisé
                $display .= 'Username or email already used';

        $display .=             '<br>Email* :<br>
                                <input maxlength="100" required type="mail" name="email" value=""><br>
                                Password* :<br>
                                <input minlength="8" required type="password" name="password" value=""><br><br>
                                <input type="submit" value="Submit">
                            </fieldset>
                        </form>
                    </section>';
        echo $display;
    }

    function DisplayAccountInfo($id_user){ // affiche les informations du compte de l'utilisateur connecté
            $user = SelectUserById($id_user);

            $display = '';
            $display .= '<section id="account_info">';
            $display .= '<div id="title">';
            $display .= '<h1>My Account&nbsp</h1>'; // '&nbsp' sert a forcer un espace en html
            $display .= '<a href="user.php?goto=updating"><img style="width:20px; height:20px;" src="img/icon_edit.png" alt="Edit"></a>';
            $display .= '</div>';

            $display .= '<div class="flex_row">';
            $display .= '<div style="width:70%;">';
            $display .= '<p>Username: ' . $user['username'] . '</p>';
            $display .= '<p>Email: ' . $user['email'] . '</p>';
            $display .= '</div>';

            if($user['is_admin']){
                $display .= '<div>';
                $display .= '<a href="admin.php">Admin page</a>';
                $display .= '</div>';
            }

            $display .= '</div>';
            $display .= '</section>';
            
            echo $display;
    }

    function DisplayAccountInfoUpdating($id_user){ // affiche le formulaire qui permet de modifier les infos de l'utilisateur
        $user = SelectUserById($id_user);

        $display = '';
        $display .= '<section id="account_info_updating">';
        $display .= '<div id="title">';
        $display .= '<h1>My Account</h1>';
        $display .= '</div>';

        $display .= '<form action="user.php?action=update" method="post">';
        $display .= 'Username: ';
        $display .= '<input maxlength="25" required type="text" name="username" value="' . $user['username'] . '"><br>';
        $display .= 'Email: ';
        $display .= '<input maxlength="100" required type="email" name="email" value="' . $user['email'] . '"><br><br>';
        $display .= '<input type="submit" value="Submit">';
        $display .= '</form>';
        
        echo $display;
    }

    function DisplayAccountStats($id_user){ // affiche la section des statistiques d'un utilisateur'
        echo '<section id="account_stats">';
        DisplayMainProgressBar($id_user);
        DisplayEventsProgressBar($id_user);
        echo '</section>';
    }

    function DisplayMainProgressBar($id_user){ // affiche la barre de progression principale
        $all_count = SelectCountReward();  // retourne le nombre d'objet en tout
        $user_count = SelectCountRewardByIdUser($id_user); // retourne le nombre d'objet d'un utilisateur
        $display = '';

        $display .= '<div>';
        $display .= '<div class="flex_row">';
        $display .= '<h3>All rewards</h3>';
        $display .= '<h3>' . $user_count . '/' . $all_count . '</h3>';
        $display .= '</div>';
        $display .= GetProgressBar($all_count, $user_count, 100, 30);
        $display .= '</div>';
        echo $display;
    }

    function DisplayEventsProgressBar($id_user){ // affiche les barre de progression des evenements
        $array_events_count = SelectCountRewardEvents(); // retourne le nombre d'objets de chaque evenement
        $array_events_user_count = SelectCountRewardEventsByIdUser($id_user); // retourne le nombre d'objets de l'utilisateur pour chaque evenement
        $display = '';

        $display .= '<div>';
        $display .= '<h3>Events</h3>';
        $display .= '<div class="flex_row">';
        for ($i=0; $i < count($array_events_count); $i++) { 
            $display .= '<div style="width:48%;">';
            $display .= '<div class="flex_row">';
            $display .= '<h4>' . $array_events_count[$i]['name'] . '</h4>';
            $display .= '<h4>' . $array_events_user_count[$i]['c'] . '/' . $array_events_count[$i]['c'] . '</h4>';
            $display .= '</div>';
            $display .= GetProgressBar($array_events_count[$i]['c'], $array_events_user_count[$i]['c'], 100, 25);
            $display .= '</div>';
        }
        $display .= '</div>';
        $display .= '</div>';
        echo $display;
    }
?>