<!doctype html>
<?php
session_start();


require_once('class.dao.php');

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
        <script src="script.js"></script>
    </head>
    <body>
        <header>
            <?php
            include_once('inc.navbar.php'); 
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
                        DisplayListCleanUser();
                        ?>
                    </td>
                    <td>
                        <?php
                        DisplayListBannedUser();
                        ?>
                    </td>
                </tr>
            </table>
        </section>
    </body>
</html>
<?php
    function DisplayListCleanUser(){
        $clean_users = OcDao::SelectCleanUsersNoAdmin(); // retourne les utilisateur non bannis (sans les admins)
        $display = '';

        $display .= '<ul style="height:100%; width:300px; overflow:hidden; overflow-y:auto;">';
        foreach ($clean_users as $clean_user) { // on affiche les utilisateur non bannis
            $display .= '<li>' . $clean_user['username'] . ' / ' . $clean_user['email'];
            $display .= '&nbsp<a href="admin.php?action=ban&id=' . $clean_user['id_user'] . '"><img style="width:15px; height:15px;" src="img/icon_ban.png" alt="Delete"></a>';
            $display .= '</li>';
        }
        $display .= '</ul>';

        echo $display;
    }

    function DisplayListBannedUser(){
        $banned_users = OcDao::SelectBannedUsers(); // retourne les utilisateurs bannis (sans les admins)
        $display = '';

        $display .= '<ul style="height:100%; width:300px; overflow:hidden; overflow-y:auto;">';
        foreach ($banned_users as $banned_user) { // on affiche les utilisateur bannis
            $display .= '<li>' . $banned_user['username'] . ' / ' . $banned_user['email'];
            $display .= '&nbsp<a href="admin.php?action=unban&id=' . $banned_user['id_user'] . '"><img style="width:15px; height:15px;" src="img/icon_ban.png" alt="Unban"></a>';
            $display .= '&nbsp<a href="admin.php?action=delete&id=' . $banned_user['id_user'] . '"><img style="width:15px; height:15px;" src="img/icon_delete.png" alt="Delete"></a>';
            $display .= '</li>';
        }
        $display .= '</ul>';

        echo $display;
    }
?>