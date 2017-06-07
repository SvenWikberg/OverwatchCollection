<!doctype html>
<?php
session_start();

require_once('inc.dao.php');

if (isset($_GET['action'])) { // selon l'action, la page recupere ou teste des données differentes
    if($_GET['action'] == 'login'){ // l'action login teste les données entrées par l'utilisateur afin de le connecter ou pas
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_ENCODED);
            $password = sha1(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED));

            $user = SelectUserByUsername($username); // on récupere les données de l'utilisateur grace a son nom d'utilisateur

            if($user == null) // si l'on ne récupère rien, ca veut dire que ce nom d'utilisateur n'existe pas, donc on informe l'utilisateurgrace a l'erreur en GET
                $myGet = '?msg=wrongUn';
            else
                if ($user['password'] == $password) { // si tout est juste on connecte l'utilisateur
                    $_SESSION['id_connected'] = $user['id_user'];
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
            $_SESSION['id_connected'] = null;
            $myGet = '';
        }
    header('Location: user.php' . $myGet);
}

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>user</title>
        <link rel="stylesheet" href="css/style-main.css">
        <script src="script.js"></script>
    </head>
    <body>
        <header>
            <?php include_once('inc.navbar.php'); ?>
        </header>
        <?php
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){ // si l'utilisateur est connecter il peut se deconnecter
            $user = SelectUserById($_SESSION['id_connected']);

            echo '<h1>Hello ' . $user['username'] . '</h1>';
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
        $display = '<form action="user.php?action=login" method="post">
                        <fieldset>
                        <legend><h2>Login</h2></legend>
                        Username :<br>
                        <input required type="text" name="username" value="">';
                        
        if(isset($_GET['msg']))
            if($_GET['msg'] == 'wrongUn') // le nom d'utilisateur n'est pas valide
                $display .= 'Username not valid';
                        
        $display .=    '<br>
                        Password:<br>
                        <input required type="password" name="password" value="">';

        if(isset($_GET['msg']))
            if($_GET['msg'] == 'wrongPw') // le mot de passe n'est pas valide
                $display .= 'Password not valid';
                        
        $display .=    '<br><br>
                        <input type="submit" value="Submit">
                        </fieldset>
                    </form>';
        echo $display;
    }

    function DisplaySignin(){ // affichage du formulaire de création de compte avec les message d'erreurs, en GET, s'il y en a
        $display = '<form action="user.php?action=signin" method="post">
                        <fieldset>
                            <legend><h2>Sign in</h2></legend>
                            Username* :<br>
                            <input required type="text" name="username" value="">';

        if(isset($_GET['msg']))
            if($_GET['msg'] == 'duplicate') // nom d'utilisateur ou email deja utilisé
                $display .= 'Username or email already used';

        $display .=         '<br>Email* :<br>
                            <input required type="mail" name="email" value=""><br>
                            Password* :<br>
                            <input required type="password" name="password" value=""><br><br>
                            <input type="submit" value="Submit">
                        </fieldset>
                    </form>';
        echo $display;
    }
?>