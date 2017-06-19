<!--
Table des matières:
	Page d'accueil
	Page des héros
	Page d'un héros
	Page des événements
	Page d'un événement
	Page utilisateur
	Page administrateur
	Fonction d'ajout ou de suppression d'objets pour un utilisateur
	Classe MyPdo
	Classe Oc_Dao
	Classe Oc_Display
	Config base de données
	CSS : Style du site web
-->

<!--
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Page d'accueil           // 
//////////////////////////////////////////////
--> 
<!doctype html>
<?php
session_start();

require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');
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
        <section id="index">
            <h1>Overwatch Collection</h1>
            <div class="flex_row">
                <div style="width: 70%;">
                    <p>Bienvenue sur Overwatch Collection! Le site qui vous permet enfin d'avoir un suivi de vos objets dans Overwatch™.
                    Vous n'avez pas besoins de créer compte si vous voulez seulement naviguer parmis les héros et les objets, par contre
                    si vous voulez pouvoir sélectionner des objets et avoir un suivis ainsi que des statistiques, vous êtes obligé d'avoir 
                    compte.</p>
                    <p>Ce site est divisé en plusieurs parties, d'abords il y a la partie "Heroes", cette partie contient les héros du jeu, pour chaque 
                    héro il y a un résumé, quelques informations et évidemment la liste, triée pas rareté, des objets du héros en question.
                    <br>Ensuite, il y a la partie "Events" qui contient les événements du jeu, comme par exemple Halloween ou Noël, et de la même manière
                    que pour les héros, il y a la liste des objets de l'événement.
                    <br>Après ça il y a la partie "Rewards" qui contients les objets qui ne sont relié à aucun héros, comme les icons de joueurs par 
                    exemple.
                    <br>Et finalement il y a la partie "My Account" qui est accessible uniquement pour les utilisateurs connecté, qui affiche  
                    entre autre des statistiques sur les objets sélectionné et un classement des utilisateurs.</p>
                </div>
                <div style="width: 25%;">
                    <h2>Users list</h2>
                    <?php
                    OcDisplay::DisplayListUsers();
                    ?>
                </div>
            </div>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>

<!--
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Page des héros           //
//////////////////////////////////////////////
-->    
<!doctype html>
<?php
session_start();

require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');
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
        <section id="heroes">
            <?php
            OcDisplay::DisplayHeroesByRole(4);
            ?>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>

<!--
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Page d'un héros          //
//////////////////////////////////////////////
-->    
<!doctype html>
<?php
session_start();

require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');
require_once('function/func.user_reward.php'); 
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
        <section id="hero_info">
            <?php
            OcDisplay::DisplayHeroInfo($_GET['id']);
            ?>
        </section>
        <section id="hero_abilities">
            <?php
            OcDisplay::DisplayHeroAbilities($_GET['id']);
            ?>
        </section>
        <section id="rewards">
            <?php
            OcDisplay::DisplayHeroRewards($_GET['id']);
            ?>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>

<!--
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Page des événements		//
//////////////////////////////////////////////
-->    
<!doctype html>
<?php
session_start();

require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');
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
        <section id="events">
            <?php
            OcDisplay::DisplayEvents(2);
            ?>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>

<!--
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Page d'un evenement		//
//////////////////////////////////////////////
-->    
<!doctype html>
<?php
session_start();

require_once('class/class.oc_dao.php');
require_once('class/class.oc_display.php');
require_once('function/func.user_reward.php'); 

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
        <section id="event_info">
            <?php
            OcDisplay::DisplayEventInfo($_GET['id']);
            ?>
        </section>
        <section id="rewards">
            <?php
            OcDisplay::DisplayEventRewards($_GET['id']);
            ?>
        </section>
        <footer>
            <p>This site is not affiliated with Blizzard Entertainement. ®2016 Blizzard Entertainment, Inc. All rights reserved /
            Author : Sven Wikberg </p>
        </footer>
    </body>
</html>

<!--
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                     	//
//    Description: Page utilisateur,		//
//	  c'est la page de connexion et la 		//
//	  age "mon compe" selon si on est 		//
//	  connecté ou pas						//
//////////////////////////////////////////////
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

<!--
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Page administrateur		//
//////////////////////////////////////////////
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

<?php
/*
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Fonction de ajout ou de	//
//	  suppression d'objets pour un			// 
//	  utilisateur							//
//////////////////////////////////////////////
*/
if (isset($_GET['action'])) {
    if($_GET['action'] == 'add_user_reward' && isset($_GET['id_reward'])){
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){ // si l'utilisateur est connecter
            $id_user = $_SESSION['id_connected'];
            $id_reward = $_GET['id_reward'];

           if(OcDao::IsCreatedUserReward($id_user, $id_reward)){ // test si l'enregistrement est deja créé
               OcDao::DeleteUserReward($id_user, $id_reward); // si c'est le cas on l'enelève
           } else {
               OcDao::InsertUserReward($id_user, $id_reward); // si ce n'est pas le cas on l'ajoute
           }
        }
    }

    header('Location: '. $_SERVER['PHP_SELF'] . (isset($_GET['id']) ? '?id=' . $_GET['id'] : '') . '#rewards');
}
?>

<?php
/*
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: classe de connexion a la	//
//	  base de données						//
//////////////////////////////////////////////
*/
require_once('config/config_db.php');

class MyPdo{
    private static $_myPdo;

    public static function GetMyPdo(){
        try {
            if (!isset($_myPdo)) {
                $dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PWD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
        return $dbc;
    }
}

<?php
/*
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Classe de récupération	//
//	  des données							//
//////////////////////////////////////////////
*/

require_once('class/class.my_pdo.php');

class OcDao{

    // récupère tous les heros dans l'ordre de base/de l'id
    static function SelectHeroes() {
        $req = 'SELECT id_hero, name, description, id_role, health, armour, shield, real_name, age, height, affiliation, base_of_operations, difficulty 
                FROM heroes';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // récupère un heros grace a son id
    static function SelectHeroById($id) {
        $req = 'SELECT id_hero, name, description, id_role, health, armour, shield, real_name, age, height, affiliation, base_of_operations, difficulty 
                FROM heroes 
                WHERE id_hero = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        $tmpReturn = $sql->fetch(PDO::FETCH_ASSOC);

        if(count($tmpReturn) > 0){
            return $tmpReturn;
        } else {
            return false;
        }
    }

    // récupere les capacités d'un hero grace a son id
    static function SelectAbilitiesByIdHero($id){
        $req = 'SELECT abilities.id_ability, abilities.name, abilities.description, abilities.id_hero, abilities.is_ultimate 
                FROM abilities 
                WHERE abilities.id_hero = :id
                ORDER BY abilities.is_ultimate';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        $tmpReturn = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(count($tmpReturn) > 0){
            return $tmpReturn;
        } else {
            return false;
        }
    }

    // récupère tous les roles dans l'ordre de base/de l'id
    static function SelectRoles() {
        $req = 'SELECT id_role, name FROM roles';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // récupère toutes les qualitiés/raretés des objets dans l'ordre de base/de l'id
    static function SelectQualities() {
        $req = 'SELECT id_quality, name FROM qualities';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // récupère tous les type d'objets dans l'ordre de base/de l'id
    static function SelectRewardTypes() {
        $req = 'SELECT id_reward_type, name FROM reward_types';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // récupère tous les événements dans l'ordre chronologique de la date de debut
    static function SelectEvents() {
        $req = 'SELECT id_event, name, start_date, end_date FROM events ORDER BY events.start_date ASC';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // récupère un evenement grace a son id
    static function SelectEventById($id) {
        $req = 'SELECT id_event, name, start_date, end_date FROM events WHERE id_event = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        $tmpReturn = $sql->fetch(PDO::FETCH_ASSOC);

        if(count($tmpReturn) > 0){
            return $tmpReturn;
        } else {
            return false;
        }
    }

    // récupère tous les utilisateurs dans l'ordre alphabetique 
    static function SelectUsers() {
        $req = 'SELECT id_user, username, email, is_banned, is_admin FROM users ORDER BY username ASC';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // récupère tous les utilisateurs non-bannis dans l'ordre alphabetique (avec les admin en premier)
    static function SelectCleanUsers() {
        $req = 'SELECT id_user, username, email, is_banned, is_admin FROM users WHERE is_banned = 0 ORDER BY is_admin DESC, username ASC';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // récupère tous les utilisateurs non-bannis dans l'ordre alphabetique (qui ne sont pas admin)
    static function SelectCleanUsersNoAdmin() {
        $req = 'SELECT id_user, username, email, is_banned, is_admin FROM users WHERE is_banned = 0 AND is_admin = 0 ORDER BY username ASC';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // récupère tous les utilisateurs bannis dans l'ordre alphabetique (qui ne sont pas admin)
    static function SelectBannedUsers() {
        $req = 'SELECT id_user, username, email, is_banned, is_admin FROM users WHERE is_banned = 1 AND is_admin = 0 ORDER BY username ASC';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // modifie le champ is_banned de l'utilisateur selectionné, en le passant a 1 (pour bannir l'utilisateur)
    static function BanUserById($id) {
        $req = 'UPDATE users SET is_banned=1 WHERE id_user = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    }

    // modifie le champ is_banned de l'utilisateur selectionné, en le passant a 0 (pour débannir l'utilisateur)
    static function UnbanUserById($id) {
        $req = 'UPDATE users SET is_banned=0 WHERE id_user = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    }

    // supprime l'utilisateur selectionné
    static function DeleteUserById($id) {
        $req = 'DELETE FROM users WHERE id_user = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    }

    // modifie l'enregistrement d'un utilisateur en les replacant par les parametres de la fonction
    static function UpdateUserByIdNoPwd($id, $username, $email){
        try{
            $req = "UPDATE users SET username='$username', email='$email' WHERE id_user=:id";
            $sql = MyPdo::GetMyPdo()->prepare($req);
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();
        } catch (PDOException $e) {
            print_rr($e);
            return $e->errorInfo[1];
        }
        return null;
    }

    // recupere tous les heros et les range par role dans un tableau
    static function SelectHeroesInArrayOfRole() { 
        $req = 'SELECT id_hero, name, id_role FROM heroes WHERE id_role = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $tmpReturn = Array();

        foreach (OcDao::SelectRoles() as $role) {
            $sql->bindParam(':id', $role['id_role'], PDO::PARAM_INT);
            $sql->execute();
            $tmpReturn[$role['name']] = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $tmpReturn;
    }

    // ajoute un enregistrement a la table de liaison "users_rewards"
    static function InsertUserReward($id_user, $id_reward){
        $req = 'INSERT INTO users_rewards(id_user, id_reward) VALUES (:id_user,:id_reward)';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->bindParam(':id_reward', $id_reward, PDO::PARAM_INT);
        $sql->execute();
    }

    // supprime un enregistrement a la table de liaison "users_rewards"
    static function DeleteUserReward($id_user, $id_reward){
        $req = 'DELETE FROM users_rewards WHERE id_user = :id_user AND id_reward = :id_reward';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->bindParam(':id_reward', $id_reward, PDO::PARAM_INT);
        $sql->execute();
    }

    // test si un enregistrement de la table de liaison "users_rewards" existe, oui -> true / non -> false
    static function IsCreatedUserReward($id_user, $id_reward){
        $req = 'SELECT users_rewards.id_user, users_rewards.id_reward 
                FROM users_rewards 
                WHERE id_user = :id_user 
                AND id_reward = :id_reward';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->bindParam(':id_reward', $id_reward, PDO::PARAM_INT);
        $sql->execute();

        if($sql->fetchAll(PDO::FETCH_ASSOC) == NULL){
            return false;
        } else {
            return true;
        }
    }

    // recupere les id des objets d'un hero qu'un utilisateur a selectionné
    static function SelectIdRewardsByIdHeroAndIdUser($id_hero, $id_user){
        $req = 'SELECT rewards.id_reward
                FROM rewards 
                JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
                WHERE rewards.id_hero = :id_hero
                AND users_rewards.id_user = :id_user';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id_hero', $id_hero, PDO::PARAM_INT);
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->execute();

        $tmpReturn = NULL;

        $cmpt = 0;
        foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $array){
            $tmpReturn[$cmpt] = $array['id_reward'];

            $cmpt++;
        }

        return $tmpReturn;
    }

    // recupere les id des objets d'un evenement qu'un utilisateur a selectionné
    static function SelectIdRewardsByIdEventAndIdUser($id_event, $id_user){
        $req = 'SELECT rewards.id_reward
                FROM rewards 
                JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
                WHERE rewards.id_event = :id_event
                AND users_rewards.id_user = :id_user';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id_event', $id_event, PDO::PARAM_INT);
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->execute();

        $tmpReturn = NULL;

        $cmpt = 0;
        foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $array){
            $tmpReturn[$cmpt] = $array['id_reward'];

            $cmpt++;
        }

        return $tmpReturn;
    }

    // recupere les id des objets d'aucun hero qu'un utilisateur a selectionné
    static function SelectIdRewardsByNoIdHeroAndIdUser($id_user){
        $req = 'SELECT rewards.id_reward
                FROM rewards 
                JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
                WHERE (rewards.id_hero = 0 OR rewards.id_hero = NULL)
                AND users_rewards.id_user = :id_user';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->execute();

        $tmpReturn = NULL;

        $cmpt = 0;
        foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $array){
            $tmpReturn[$cmpt] = $array['id_reward'];

            $cmpt++;
        }

        return $tmpReturn;
    }

    // recupère tous les objets d'un heros et les range d'abord par catégorie et ensuite par rareté
    static function SelectRewardsInArrayOfQualityAndTypeByIdHero($id){
        $req = 'SELECT rewards.id_reward, rewards.name, rewards.cost, rewards.id_currency, rewards.id_event
                FROM rewards 
                WHERE rewards.id_quality = :id_quality
                AND rewards.id_reward_type = :id_reward_type
                AND rewards.id_hero = :id_hero
                ORDER BY rewards.name';
        $sql = MyPdo::GetMyPdo()->prepare($req);

        $rewardTypes = OcDao::SelectRewardTypes();
        $qualities = OcDao::SelectQualities();
        $tmpReturn = Array();

        foreach ($rewardTypes as $rewardType) {
            foreach ($qualities as $quality) {
                $sql->bindParam(':id_reward_type', $rewardType['id_reward_type'], PDO::PARAM_INT);
                $sql->bindParam(':id_quality', $quality['id_quality'], PDO::PARAM_INT);
                $sql->bindParam(':id_hero', $id, PDO::PARAM_INT);
                $sql->execute();

                $tmp = $sql->fetchAll(PDO::FETCH_ASSOC); // afin de ne pas mettre du vide dans le tableau
                if(isset($tmp[0]))
                    $tmpReturn[$rewardType['name']][$quality['name']] = $tmp;
            }
        }

        if(count($tmpReturn) > 0){
            return $tmpReturn;
        } else {
            return false;
        }
    }

    // recupère tous les objets qui ne sont pas associé a un hero et les range d'abord par catégorie et ensuite par rareté
    static function SelectRewardsInArrayOfQualityAndTypeByNoIdHero(){
        $req = 'SELECT rewards.id_reward, rewards.name, rewards.cost, rewards.id_currency, rewards.id_event
                FROM rewards 
                WHERE rewards.id_quality = :id_quality
                AND rewards.id_reward_type = :id_reward_type
                AND (rewards.id_hero = 0 OR rewards.id_hero = NULL)
                ORDER BY rewards.name';
        $sql = MyPdo::GetMyPdo()->prepare($req);

        $rewardTypes = OcDao::SelectRewardTypes();
        $qualities = OcDao::SelectQualities();

        foreach ($rewardTypes as $rewardType) {
            foreach ($qualities as $quality) {
                $sql->bindParam(':id_reward_type', $rewardType['id_reward_type'], PDO::PARAM_INT);
                $sql->bindParam(':id_quality', $quality['id_quality'], PDO::PARAM_INT);
                $sql->execute();

                $tmp = $sql->fetchAll(PDO::FETCH_ASSOC); // afin de ne pas mettre du vide dans le tableau
                if(isset($tmp[0]))
                    $tmpReturn[$rewardType['name']][$quality['name']] = $tmp;
            }
        }

        return $tmpReturn;
    }

    // recupère tous les objets d'un evenement et les range d'abord par catégorie et ensuite par rareté
    static function SelectRewardsInArrayOfQualityAndTypeByIdEvent($id){ 

        // il y a une jointure externe (LEFT JOIN) dans la requête car pas tous les objet qu'on veut récupérer on un hero qui leur est associé
        $req = 'SELECT rewards.id_reward, rewards.name as r_name, rewards.cost, rewards.id_currency, rewards.id_hero, heroes.name as h_name
                FROM rewards 
                LEFT JOIN heroes ON heroes.id_hero = rewards.id_hero
                WHERE rewards.id_quality = :id_quality
                AND rewards.id_reward_type = :id_reward_type
                AND rewards.id_event = :id_event
                ORDER BY rewards.name';
        $sql = MyPdo::GetMyPdo()->prepare($req);

        $rewardTypes = OcDao::SelectRewardTypes();
        $qualities = OcDao::SelectQualities();

        foreach ($rewardTypes as $rewardType) {
            foreach ($qualities as $quality) {
                $sql->bindParam(':id_reward_type', $rewardType['id_reward_type'], PDO::PARAM_INT);
                $sql->bindParam(':id_quality', $quality['id_quality'], PDO::PARAM_INT);
                $sql->bindParam(':id_event', $id, PDO::PARAM_INT);
                $sql->execute();

                $tmp = $sql->fetchAll(PDO::FETCH_ASSOC); // afin de ne pas mettre du vide dans le tableau
                if(isset($tmp[0]))
                    $tmpReturn[$rewardType['name']][$quality['name']] = $tmp;
            }
        }

        if(count($tmpReturn) > 0){ // s'il n'y a rien, il y a un porbleme, donc on retourne false
            return $tmpReturn;
        } else {
            return false;
        }
    }

    // récupère les infos d'un utilisateur en fonction de son 'username' (utilisé pour la connection)
    static function SelectUserByUsername($username) {
        $req = 'SELECT id_user, username, password, email, is_banned, is_admin FROM users WHERE username = :username';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':username', $username, PDO::PARAM_STR);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    // récupère les infos d'un utilisateur en fonction de son id
    static function SelectUserById($id) {
        $req = 'SELECT id_user, username, password, email, is_banned, is_admin FROM users WHERE id_user = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    // insère un nouvel enregistrement dans la table "users"
    // retourne le code de l'erreur s'il y en a une, ou null s'il n'y en a pas 
    static function InsertUser($username, $email, $password) {
        try{
            $req = 'INSERT INTO users (username, password, email, is_banned) VALUES (:username, :email, :password, 0)';
            $sql = MyPdo::GetMyPdo()->prepare($req); 
            $sql->bindParam(':username', $username);   
            $sql->bindParam(':email', $email);   
            $sql->bindParam(':password', $password);   
            $sql->execute();
        } catch (PDOException $e) {
            print_rr($e);
            return $e->errorInfo[1];
        }
        return null;
    }

    // compte le nombre d'objets en tous
    static function SelectCountReward(){
        $req = 'SELECT COUNT(id_reward) AS c FROM rewards';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC)['c'];
    }

    // compte le nombre d'objets d'un utilisateur
    static function SelectCountRewardByIdUser($id){
        $req = 'SELECT COUNT(id_reward) AS c FROM users_rewards WHERE id_user = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC)['c'];
    }

    // compte le nombre d'objets qu'a chaque evenement
    static function SelectCountRewardEvents(){
        $req = 'SELECT events.name, COUNT(rewards.id_reward) AS c 
                FROM rewards 
                JOIN events ON rewards.id_event = events.id_event 
                GROUP BY events.id_event
                ORDER BY events.start_date';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // compte le nombre d'objets qu'a l'utilisateur pour chaque evenement
    static function SelectCountRewardEventsByIdUser($id){
        // la 1ere partie de la requete recupere les evenements et les nombre d'objet de l'utilisateur pour cet evenement
        // la 2eme partie recupére les evenements pou lesquelle l'utilisateur n'a aucun objet 
        // on fait une union des deux pour avoir tous les evenement
        $req = '(SELECT events.start_date, events.name, COUNT(users_rewards.id_reward) AS c
                FROM events
                JOIN rewards ON rewards.id_event = events.id_event
                JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
                WHERE users_rewards.id_user = :id1
                GROUP BY events.id_event)
            UNION
                (SELECT events.start_date, events.name, 0 AS c
                FROM events
                WHERE events.id_event NOT IN 
                    (SELECT events.id_event
                    FROM events
                    JOIN rewards ON rewards.id_event = events.id_event
                    JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
                    WHERE users_rewards.id_user = :id2
                    GROUP BY events.id_event))  
                ORDER BY start_date ASC';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id1', $id, PDO::PARAM_INT);
        $sql->bindParam(':id2', $id, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // compte le nombre d'objets qu'a chaque hero
    static function SelectCountRewardHeroes(){
        $req = 'SELECT heroes.name, COUNT(rewards.id_reward) AS c 
                FROM rewards 
                JOIN heroes ON rewards.id_hero = heroes.id_hero 
                GROUP BY heroes.id_hero
                ORDER BY heroes.name';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // compte le nombre d'objets qu'a l'utilisateur pour chaque hero
    static function SelectCountRewardHeroesByIdUser($id){
        // la 1ere partie de la requete recupere les evenements et les nombre d'objet de l'utilisateur pour cet evenement
        // la 2eme partie recupére les evenements pou lesquelle l'utilisateur n'a aucun objet 
        // on fait une union des deux pour avoir tous les evenement
        $req = '(SELECT heroes.name, COUNT(users_rewards.id_reward) AS c
                FROM heroes
                JOIN rewards ON rewards.id_hero = heroes.id_hero
                JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
                WHERE users_rewards.id_user = :id1
                GROUP BY heroes.id_hero)
            UNION
                (SELECT heroes.name, 0 AS c
                FROM heroes
                WHERE heroes.id_hero NOT IN 
                    (SELECT heroes.id_hero
                    FROM heroes
                    JOIN rewards ON rewards.id_hero = heroes.id_hero
                    JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
                    WHERE users_rewards.id_user = :id2
                    GROUP BY heroes.id_hero))  
                ORDER BY name ASC';
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id1', $id, PDO::PARAM_INT);
        $sql->bindParam(':id2', $id, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<?php
/*
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: classe d'affichage		//
//    des donnees							//
//////////////////////////////////////////////
*/
class OcDisplay{

    // affiche la barre de navigation, avec des chamgement selon si on est connetcer ou pas
    static function DisplayNavbar(){
        $display = '';

        $display .= '<ul>';
        $display .= '<li><a href="index.php">Index</a></li>';
        $display .= '<li><a href="heroes.php">Heroes</a></li>';
        $display .= '<li><a href="events.php">Events</a></li>';
        $display .= '<li><a href="rewards.php">Others Rewards</a></li>';
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){
            if(fnmatch('*user.php' , $_SERVER['PHP_SELF'])){
                $display .= '<li><a href="user.php?action=deco">Log Out</a></li>';
            } else {
                $display .=  '<li><a href="user.php">My Account</a></li>';
            }
        } else {
            $display .=  '<li><a href="user.php">Login/Sign In</a></li>';
        }

        $display .= '</ul>';

        echo $display;
    }

    // affiche une liste des utilisateeur non bannis avec des botuuon pour bannir les utilisateurs
    static function DisplayListCleanUserWithBan(){
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

    // affiche un liste des utilisateurs bannis avec des boutons pour les dé-bannir ou les supprimer 
    static function DisplayListBannedUserWithUnbanDelete(){
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

    // affiche les objets d'un evenement triés, avec les liens pour les selectionner si l'utilisateur est connecté
    static function DisplayEventRewards($id_event){
        $rewards_array = OcDao::SelectRewardsInArrayOfQualityAndTypeByIdEvent($id_event); // retourne un tableau de rewards
        
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si l'utilisateur est connecter on va chercher l'id des rewards qu'il a
            $rewards_owned = OcDao::SelectIdRewardsByIdEventAndIdUser($id_event, $_SESSION['id_connected']);
        else
            $rewards_owned = false;

        if($rewards_array){
            $display = '';

            foreach ($rewards_array as $key => $type) {
                $quality_count = count($type); // on compte le nombre de boite il y par catégorie afin de definir la taille de cell-ci
                $display .= '<div class="rewards_type" style="width:' . ($quality_count == 4 ? '100' : $quality_count * 24 - 0.5) . '%">';
                $display .= '<h2>' .$key. '</h2>';
                $display .= '<div>';
                foreach ($type as $key => $quality) {
                    $display .= '<div>';
                    $display .= '<h3 class="' .$key. '">' .$key. '</h3><ul>';
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
                            $display .= '<a ' .$css_string. ' href="event.php?id=' .$id_event. '&action=add_user_reward&id_reward=' .$reward['id_reward']. '">';
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

    // affiche les informationde base d'un evenement
    static function DisplayEventInfo($id_event){
        $event = OcDao::SelectEventById($id_event); // retourne l'enregistrement de l'événement depuis la base

        if($event){
            $display = '<h1>' .$event['name']. '</h1>';
            $display .= '<div><p>Beginning Date: ' .$event['start_date']. '</p><p>Ending Date: ' .$event['end_date']. '</p></div>';

            echo $display;
        } else {
            header('Location: events.php');
        }
    }

    // affiche un tableau des evenement avec un parametre pour le nombre de colonne du tableau
    static function DisplayEvents($nb_col_max){ // $nb_col_max = nombre de colonnes maximum pour les tableaux de heros
        $events = OcDao::SelectEvents();
        $display = '';
        $nb_col_current = 0; // nombre de colonnes actuelle

        $display .= '<table>';
        foreach ($events as $event) {
            $nb_col_current++;

            if($nb_col_current == 1) // si le nombre de colonne actuelle vaut 1, c'est qu'on est au debut d'une nouvelle ligne donc on ouvre une balise <tr>
                $display .= '<tr>';
            $display .= '<td><a href="event.php?id=' .$event['id_event']. '"><div>' .$event['name']. '</div><img style="width: 100%;" src="img/icon_event/' .$event['id_event']. '.jpg" alt="' .$event['name']. '"><div>From: ' .$event['start_date']. ' To: ' .$event['start_date']. '</div></a></td>';
            if($nb_col_current == $nb_col_max){ // si le nombre de colonne actuelle vaut le nombre de colonne max, c'est qu'on est a la fin de la ligne donc on ferme une balise <tr>
                $display .= '</tr>';
                $nb_col_current = 0;
            }
        }
        $display .= '</table>';

        echo $display;
    }

     // affiche les objets d'un hero triés, avec les liens pour les selectionner si l'utilisateur est connecté
    static function DisplayHeroRewards($id_hero){
        $rewards_array = OcDao::SelectRewardsInArrayOfQualityAndTypeByIdHero($id_hero); // retourne un tableau de rewards

        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si l'utilisateur est connecter on va chercher l'id des rewards qu'il a
            $rewards_owned = OcDao::SelectIdRewardsByIdHeroAndIdUser($id_hero, $_SESSION['id_connected']);
        else
            $rewards_owned = false;

        if($rewards_array){
            $display = '';

            foreach ($rewards_array as $key => $type) {
                $quality_count = count($type); // on compte le nombre de boite il y par catégorie afin de definir la taille de cell-ci
                $display .= '<div class="rewards_type" style="width:' . ($quality_count == 4 ? '100' : $quality_count * 24 - 0.5) . '%">';
                $display .= '<h2>' .$key. '</h2>';
                $display .= '<div>';
                foreach ($type as $key => $quality) {
                    $display .= '<div>';
                    $display .= '<h3 class="' .$key. '">' .$key. '</h3><ul>';
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
                            $display .= '<a ' .$css_string. ' href="hero.php?id=' .$id_hero. '&action=add_user_reward&id_reward=' .$reward['id_reward']. '">';
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
    
    // affiche un tableau des capacités d'un hero
    static function DisplayHeroAbilities($id_hero){
        $abilities = OcDao::SelectAbilitiesByIdHero($id_hero); // retourne les capacité du heros
        $nb_col_max = 2; // nombre de colonnes maximum pour les tableaux de heros
        $nb_col_current = 0; // nombre de colonnes actuelle

        if($abilities){
            $display = '<table>';
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

    // affiche les informations de base d'un hero
    static function DisplayHeroInfo($id_hero){
        $hero = OcDao::SelectHeroById($id_hero); // retourne l'enregistrement du heros depuis la base

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

    // affiche un tableau de hero pour chaque role, avec un parametre pour le nombre de colonne de ces tableaux
    static function DisplayHeroesByRole($nb_col_max){// $nb_col_max = nombre de colonnes maximum pour les tableaux de heros
        $heroes_array = OcDao::SelectHeroesInArrayOfRole(); // retourne un tableau, trié par role, de tableau de héros
        $display = '';
        $nb_col_current = 0; // nombre de colonnes actuelle

        foreach ($heroes_array as $key => $role) { // pour chaque role on fait un tableau afin d'ordonner et de regrouper les heros
            $display .= '<div>';
            $display .= '<h1>' . $key . '</h1>';
            $display .= '<table>';
            foreach ($role as $hero) {
                $nb_col_current++;

                if($nb_col_current == 1) // si le nombre de colonne actuelle vaut 1, c'est qu'on est au debut d'une nouvelle ligne donc on ouvre une balise <tr>
                    $display .= '<tr>';
                $display .= '<td><a href="hero.php?id=' .$hero['id_hero']. '"><img src="img/icon_hero/' .preg_replace('/[^A-Za-z0-9\-]/', '', $hero['name']). '.png" alt="' .$hero['name']. '"><div>' .$hero['name']. '</div></a></td>';
                if($nb_col_current == $nb_col_max){ // si le nombre de colonne actuelle vaut le nombre de colonne max, c'est qu'on est a la fin de la ligne donc on ferme une balise <tr>
                    $display .= '</tr>';
                    $nb_col_current = 0;
                }
            }
            $nb_col_current = 0; // on remet a 0 pour le prochain role
            $display .= '</table>';
            $display .= '</div>';
        }
        echo $display;
    }

    // affiche une liste des utilisateurs et adnimistrateurs non bannis
    static function DisplayListUsers(){
        $users = OcDao::SelectCleanUsers(); // recupere le utilisateur depuis la base de données

        $display = '';
        $display .= '<ul style="height:100%; width:170px; overflow:hidden; overflow-y:auto;">';
        foreach ($users as $user) {
            $display .= '<li>' .$user['username'] . ($user['is_admin'] == 1 ? ' / Admin' : ''). '</li>';
        }
        $display .= '</ul>';

        echo $display;
    }

    // afiche les objet non lié a un heros de facon trie, avec les liens pour les selectionner si l'utilisateur est connecté
    static function DisplayOtherRewards(){
        $rewards_array = OcDao::SelectRewardsInArrayOfQualityAndTypeByNoIdHero(); // retourne un tableau de rewards

        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null) // si l'utilisateur est connecter on va chercher l'id des rewards qu'il a
            $rewards_owned = OcDao::SelectIdRewardsByNoIdHeroAndIdUser($_SESSION['id_connected']);
        else
            $rewards_owned = false;

        $display = '';

        foreach ($rewards_array as $key => $type) {
            $quality_count = count($type); // on compte le nombre de boite il y par catégorie afin de definir la taille de celle-ci
            $display .= '<div class="rewards_type" style="width:' . ($quality_count == 4 ? '100' : $quality_count * 24 - 0.5) . '%">';
            $display .= '<h2>' .$key. '</h2>';
            $display .= '<div>';
            foreach ($type as $key => $quality) {
                $display .= '<div>';
                $display .= '<h3 class="' .$key. '">' .$key. '</h3><ul>';
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

    // affichage du formulaire de connection avec les message d'erreurs, en GET, s'il y en a
    static function DisplayLogin(){ 
        $display = '<section id="login"><form action="user.php?action=login" method="post">
                        <fieldset>
                        <legend><h2>Login</h2></legend>
                        <p>Username :</p>
                        <input maxlength="25" required type="text" name="username" value="">';
                        
        if(isset($_GET['msg']))
            if($_GET['msg'] == 'wrongUn') // le nom d'utilisateur n'est pas valide
                $display .= 'Username not valid';
            elseif($_GET['msg'] == 'banned') // l'utilisateur est banni
                $display .= 'Your account has been banned';
                        
        $display .=    '<br>
                        <p>Password:</p>
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

    // affichage du formulaire de création de compte avec les message d'erreurs, en GET, s'il y en a
    static function DisplaySignin(){ 
        $display = '<section id="sign_in">
                        <form action="user.php?action=signin" method="post">
                            <fieldset>
                                <legend><h2>Sign in</h2></legend>
                                <p>Username* :</p>
                                <input maxlength="25" required type="text" name="username" value="">';

        if(isset($_GET['msg']))
            if($_GET['msg'] == 'duplicate') // nom d'utilisateur ou email deja utilisé
                $display .= 'Username or email already used';

        $display .=             '<p>Email* :</p>
                                <input maxlength="100" required type="email" name="email" value=""><br>
                                <p>Password* :</p>
                                <input minlength="8" required type="password" name="password" value=""><br><br>
                                <input type="submit" value="Submit">
                            </fieldset>
                        </form>
                    </section>';
        echo $display;
    }

    // affiche les informations du compte de l'utilisateur connecté
    static function DisplayAccountInfo($id_user){ 
            $user = OcDao::SelectUserById($id_user);

            $display = '';
            $display .= '<section id="account_info">';
            $display .= '<div id="title">';
            $display .= '<h1>My Account&nbsp</h1>'; // '&nbsp' sert a forcer un espace en html
            $display .= '<a href="user.php?goto=updating"><img style="width:20px; height:20px;" src="img/icon_edit.png" alt="Edit"></a>';
            $display .= '</div>';

            if(isset($_GET['msg']))
                if($_GET['msg'] == 'updateDuplicate')
                    $display .= '<h3>Username/Email already used</h3>';

            $display .= '<div class="flex_row">';
            $display .= '<div style="width:70%;">';
            $display .= '<p>Username: ' . $user['username'] . '</p>';
            $display .= '<p>Email: ' . $user['email'] . '</p>';
            $display .= '</div>';

            if($user['is_admin']){
                $display .= '<div>';
                $display .= '<a href="admin.php"><p>Admin page</p></a>';
                $display .= '</div>';
            }

            $display .= '</div>';
            $display .= '</section>';
            
            echo $display;
    }

    // affiche le formulaire qui permet de modifier les infos de l'utilisateur
    static function DisplayAccountInfoUpdating($id_user){ 
        $user = OcDao::SelectUserById($id_user);

        $display = '';
        $display .= '<section id="account_info_updating">';
        $display .= '<div id="title">';
        $display .= '<h1>Updating account info</h1>';
        $display .= '</div>';

        $display .= '<form action="user.php?action=update" method="post">';
        $display .= '<p>Username :</p>';
        $display .= '<input maxlength="25" required type="text" name="username" value="' . $user['username'] . '"><br>';
        $display .= '<p>Email: </p>';
        $display .= '<input maxlength="100" required type="email" name="email" value="' . $user['email'] . '"><br><br>';
        $display .= '<input type="submit" value="Submit">';
        $display .= '</form>';
        
        echo $display;
    }

    // affiche la section des statistiques d'un utilisateur
    static function DisplayAccountStats($id_user){ 
        echo '<section id="account_stats">';
        OcDisplay::DisplayMainProgressBar($id_user);
        OcDisplay::DisplayEventsProgressBar($id_user);
        OcDisplay::DisplayHeroesProgressBar($id_user);
        echo '</section>';
    }

    // affiche la barre de progression principale (des tous les objets) d'un utilisateur
    static function DisplayMainProgressBar($id_user){ 
        $all_count = OcDao::SelectCountReward();  // retourne le nombre d'objet en tout
        $user_count = OcDao::SelectCountRewardByIdUser($id_user); // retourne le nombre d'objet d'un utilisateur
        $display = '';

        $display .= '<div>';
        $display .= '<div class="flex_row">';
        $display .= '<h2>All rewards</h2>';
        $display .= '<h2>' . $user_count . '/' . $all_count . '</h2>';
        $display .= '</div>';
        $display .= OcDisplay::GetProgressBar($all_count, $user_count, 100, 30);
        $display .= '</div>';
        echo $display;
    }

    // affiche les barres de progression des evenements d'un utilisateur
    static function DisplayEventsProgressBar($id_user){ 
        $array_events_count = OcDao::SelectCountRewardEvents(); // retourne le nombre d'objets de chaque evenement
        $array_events_user_count = OcDao::SelectCountRewardEventsByIdUser($id_user); // retourne le nombre d'objets de l'utilisateur pour chaque evenement
        $display = '';

        $display .= '<div>';
        $display .= '<h2>Events</h2>';
        $display .= '<div class="flex_row">';
        for ($i=0; $i < count($array_events_count); $i++) { 
            $display .= '<div style="width:48%;">';
            $display .= '<div class="flex_row">';
            $display .= '<h4>' . $array_events_count[$i]['name'] . '</h4>';
            $display .= '<h4>' . $array_events_user_count[$i]['c'] . '/' . $array_events_count[$i]['c'] . '</h4>';
            $display .= '</div>';
            $display .= OcDisplay::GetProgressBar($array_events_count[$i]['c'], $array_events_user_count[$i]['c'], 100, 25);
            $display .= '</div>';
        }
        $display .= '</div>';
        $display .= '</div>';
        echo $display;
    }

    // affiche les barres de progression des heros d'un utilisateur
    static function DisplayHeroesProgressBar($id_user){ 
        $array_heroes_count = OcDao::SelectCountRewardHeroes(); // retourne le nombre d'objets de chaque hero
        $array_heroes_user_count = OcDao::SelectCountRewardHeroesByIdUser($id_user); // retourne le nombre d'objets de l'utilisateur pour chaque hero
        $display = '';

        $display .= '<div>';
        $display .= '<h2>Heroes</h2>';
        $display .= '<div class="flex_row">';
        for ($i=0; $i < count($array_heroes_count); $i++) { 
            $display .= '<div style="width:32%;">';
            $display .= '<div class="flex_row">';
            $display .= '<h4>' . $array_heroes_count[$i]['name'] . '</h4>';
            $display .= '<h4>' . $array_heroes_user_count[$i]['c'] . '/' . $array_heroes_count[$i]['c'] . '</h4>';
            $display .= '</div>';
            $display .= OcDisplay::GetProgressBar($array_heroes_count[$i]['c'], $array_heroes_user_count[$i]['c'], 100, 15);
            $display .= '</div>';
        }
        $display .= '</div>';
        $display .= '</div>';
        echo $display;
    }

    // retourne une chaine pour afficher une barre de progression grace aux parametre de la fonction
        // max_value est la valeur maximum de la progress bar
        // current_value est la valur actuelle de la barre
        // width_percent est la largeur de la barre en pourcentage
        // height_px est la hauteur de la barre en pixel
    static function GetProgressBar($max_value, $current_value, $width_percent, $height_px){
        $display = '';
        $display .= '<div class="bar_ext" style="width: ' . $width_percent . '%; height: ' . $height_px . 'px; border: 1px solid black;">';
        $display .=      '<div style="width: ' . ($current_value / $max_value) * 100 . '%; background-color: black; height: ' . $height_px . 'px;">';
        $display .=      '</div>';
        $display .= '</div>';

        return $display;
    }
}
?>

<?php
/*
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: données pour la 			//
//	  connexion a la base					//
//////////////////////////////////////////////
*/

define('DB_HOST', 'localhost');
define('DB_NAME', 'overwatchcollection');
define('DB_USER', 'oc_admin');
define('DB_PWD', 'overwatch123');
?>

/*
//////////////////////////////////////////////
//    Auteur: Sven Wikberg                  //
//    Date: 19/06/2017                      //
//    Description: Page de style du site 	//
//////////////////////////////////////////////
*/  
@font-face {
    font-family: "BigNoodle";
    src: url('../font/BigNoodleToo.ttf');
}
@font-face {
    font-family: "BigNoodle";
    font-style: italic;
    src: url('../font/BigNoodleTooOblique.ttf');
}
@font-face {
    font-family: "Futura";
    src: url('../font/Futura.ttf');
}

body{
    font-family: "BigNoodle", Helvetica, Arial, sans-serif;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

h1{
    color: #FF9C1E;
    font-size: 40px;
    font-style: italic;
}

h2{
    font-size: 30px;
    font-style: italic;
}

h3{
    font-size: 25px;
    font-style: italic;
}

h4{
    font-size: 25px;
}

p{
    font-family: "Futura", Helvetica, Arial, sans-serif;
    text-align: justify;
    font-style: normal;
    font-weight: normal;
}

footer{
    padding: 5px;
    margin: 0px;
    margin-top: 30px; 
    background-color: #cccccc;
    border-radius: 15px;
}
footer p{
    margin: 0px;
}

header ul{
    padding: 30px 20px;
    margin: 0px;
    list-style-type: none;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
    background-color: #cccccc;
    border-radius: 15px;
}

header ul li{
    font-size: 30px;
}

header ul li a{
    text-decoration: none;
    color: #606060;
    padding: 5px;
}

header ul li a:hover{
    color: #FF9C1E;
    cursor: pointer;
    background-color: #a0a0a0;
    border-radius: 5px;
}

.flex_row{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
}

section#index li{
    font-size: 22px;
}

section#heroes{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
}

section#heroes table a div{
    font-size: 22px;
}

section#heroes table a img{
    border-radius: 5px;
}

section#heroes table td{
    border-radius: 5px;
}

section#heroes table td:hover{
    background-color: #FF9C1E;
}

section#hero_info div{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
}

section#hero_abilities{
    margin-top: 50px;
}

section#hero_abilities table tr td{
    border: 3px solid black;
    border-radius: 10px; 
}

section#rewards{
    margin-top: 50px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
}

section#rewards h2{
    margin: 0;
}

section#rewards h3{
    margin: 10px 0px;
}

section#rewards ul{
    height:200px; 
    width:170px; 
    overflow:hidden; 
    overflow-y:auto;
}

section#rewards div{
    display: flex;
    flex-direction: column;
}

section#rewards div.rewards_type{
    border: 3px solid black;
    border-radius: 10px; 
    margin-top: 10px;
}

section#rewards div div{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
}

section#rewards div div div{
    display: flex;
    flex-direction: column;
}

section#rewards div div div h3.Common{
    color: black;
}

section#rewards div div div h3.Rare{
    color: #01C2FD;
}

section#rewards div div div h3.Epic{
    color: #FE01FE;
}

section#rewards div div div h3.Legendary{
    color: #FF9C1E;
}

section#rewards div div div li{
    font-size: 22px;
    border-radius: 3px;
}

section#events{
    margin-top: 30px;
}

section#events table a div{
    font-size: 25px;
    font-style: italic;
}

section#events table tr td{
    padding: 10px;
    border-radius: 10px;
}

section#events table tr td:hover{
    background-color: #FF9C1E;
}

section#events table tr td img{
    border-radius: 10px;
}

section#event_info div{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
}

section#account_info div#title{
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    flex-wrap: wrap;
}

section#account_stats div.bar_ext{
    border-radius: 5px;
}

section#admin table ul{
    margin: 10px;
}

section#admin table ul li{
    font-family: "Futura", Helvetica, Arial, sans-serif;
    font-size: 18px;
}