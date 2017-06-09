<!doctype html>
<?php
session_start();


require_once('inc.dao.php');

if(isset($_SESSION['id_connected'])){ // si pas admin, on ne peut pas acceder a cette page
    $user = SelectUserById($_SESSION['id_connected']);
    if($user['is_admin'] == 0){
        header('Location: index.php');
    }    
} else {
    header('Location: index.php');
}

if (isset($_GET['action'])) { // selon l'action, la page recupere, teste ou process des données differentes
    if($_GET['action'] == 'ban'){
        if(isset($_GET['id'])){
            BanUserById($_GET['id']);
        }
    } elseif($_GET['action'] == 'unban'){
        if(isset($_GET['id'])){
            UnbanUserById($_GET['id']);
        }
    } elseif($_GET['action'] == 'delete'){
        if(isset($_GET['id'])){
            
        }
    }
    header('Location: admin.php');
}
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
        <section id="admin">
            <?php
            $clean_users = SelectCleanUsersNoAdmin();
            $banned_users = SelectBannedUsers();
            ?>
            <h1>Admin Page</h1>
            <table border="1">
                <tr>
                    <td><h2>Clean Users</h2></td>
                    <td><h2>Banned Users</h2></td>
                </tr>
                <tr>
                    <td>
                        <ul style="height:100%; width:300px; overflow:hidden; overflow-y:auto;">
                            <?php
                            $display = '';

                            foreach ($clean_users as $clean_user) {
                                $display .= '<li>' . $clean_user['username'] . ' / ' . $clean_user['email'];
                                $display .= '&nbsp<a href="admin.php?action=ban&id=' . $clean_user['id_user'] . '"><img style="width:15px; height:15px;" src="img/icon_ban.png" alt="Delete"></a>';
                                $display .= '</li>';
                            }

                            echo $display;
                            ?>
                        </ul>
                    </td>
                    <td>
                        <ul style="height:100%; width:300px; overflow:hidden; overflow-y:auto;">
                            <?php
                            $display = '';

                            foreach ($banned_users as $banned_user) {
                                $display .= '<li>' . $banned_user['username'] . ' / ' . $banned_user['email'];
                                $display .= '&nbsp<a href="admin.php?action=unban&id=' . $banned_user['id_user'] . '"><img style="width:15px; height:15px;" src="img/icon_ban.png" alt="Unban"></a>';
                                $display .= '&nbsp<a href="admin.php?action=delete&id=' . $banned_user['id_user'] . '"><img style="width:15px; height:15px;" src="img/icon_delete.png" alt="Delete"></a>';
                                $display .= '</li>';
                            }

                            echo $display;
                            ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </section>
    </body>
</html>