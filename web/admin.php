<!--
    Auteur: Sven Wikberg
    Date: 19/06/2017
    Description: Page des evenements
-->    
<!doctype html>
<?php
session_start();


require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');

if(isset($_SESSION['id_connected'])){ // si pas admin, on ne peut pas acceder a cette page
    $user = OcDao::SelectUserById($_SESSION['id_connected']);
    if($user['is_admin'] == 0){
        header('Location: index.php');
    }    
} else {
    header('Location: index.php');
}

if (isset($_GET['action'])) { // selon l'action, la page recupere, teste ou process des données differentes
    if($_GET['action'] == 'ban'){ // on banni l'utilisateur selectionné
        if(isset($_GET['id'])){
            OcDao::BanUserById($_GET['id']);
        }
    } elseif($_GET['action'] == 'unban'){ // on debanni l'utilisateur selectionné
        if(isset($_GET['id'])){
            OcDao::UnbanUserById($_GET['id']);
        }
    } elseif($_GET['action'] == 'delete'){ // on supprime l'utilisateur selectionné'
        if(isset($_GET['id'])){
            OcDao::DeleteUserById($_GET['id']);
        }
    }
    header('Location: admin.php');
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
        <section id="admin">
            <h1>Admin Page</h1>
            <table border="1"style="width:100%;">
                <tr>
                    <td><h2>Clean Users</h2></td>
                    <td><h2>Banned Users</h2></td>
                </tr>
                <tr>
                    <td>
                        <?php
                        OcDisplay::DisplayListCleanUserWithBan();
                        ?>
                    </td>
                    <td>
                        <?php
                        OcDisplay::DisplayListBannedUserWithUnbanDelete();
                        ?>
                    </td>
                </tr>
            </table>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>