<?php
require_once('config/config_db.php');

/////////////////////
function print_rr($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}
/////////////////////

function &MyPdo() {
    static $dbc = NULL;
    try {
        if ($dbc == NULL) {
            $dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PWD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
    } catch (PDOException $e) {
        print 'Erreur !: ' . $e->getMessage() . '<br/>';
        die();
    }
    return $dbc;
}

// récupère tous les heros dans l'ordre de base/de l'id
function SelectHeroes() {
    $req = 'SELECT * FROM heroes';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// récupère un heros grace a son id
function SelectHeroById($id) {
    $req = 'SELECT * FROM heroes WHERE id_hero = :id';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();

    return $sql->fetch(PDO::FETCH_ASSOC);
}

// récupere les capacités d'un hero garce a son id
function SelectAbilitiesByIdHero($id){
    $req = 'SELECT abilities.* 
            FROM abilities 
            JOIN heroes ON heroes.id_hero = abilities.id_hero
            WHERE heroes.id_hero = :id
            ORDER BY abilities.is_ultimate';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// récupère tous les roles dans l'ordre de base/de l'id
function SelectRoles() {
    $req = 'SELECT * FROM roles';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// récupère toutes les qualitiés/raretés des objets dans l'ordre de base/de l'id
function SelectQualities() {
    $req = 'SELECT * FROM qualities';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// récupère tous les type d'objets dans l'ordre de base/de l'id
function SelectRewardTypes() {
    $req = 'SELECT * FROM reward_types';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// recupere tous les heros et les range par role dans un tableau
function SelectHeroesInArrayOfRole() { 
    $req = 'SELECT * FROM heroes WHERE id_role = :id';
    $sql = MyPdo()->prepare($req);

    foreach (SelectRoles() as $role) {
        $sql->bindParam(':id', $role['id_role'], PDO::PARAM_INT);
        $sql->execute();
        $tmpReturn[$role['name']] = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    return $tmpReturn;
}

// recupère tous les objets d'un heros et les range d'abord par catégorie et ensuite par rareté
function SelectRewardsInArrayOfQualityAndTypeByIdHero($id){
    $req = 'SELECT rewards.id_reward, rewards.name, rewards.cost, rewards.id_currency, rewards.id_event
            FROM rewards 
            JOIN qualities ON qualities.id_quality = rewards.id_quality
            JOIN reward_types ON reward_types.id_reward_type = rewards.id_reward_type
            JOIN heroes ON heroes.id_hero = rewards.id_hero
            WHERE qualities.id_quality = :id_quality
            AND reward_types.id_reward_type = :id_reward_type
            AND heroes.id_hero = :id_hero
            ORDER BY rewards.name';
    $sql = MyPdo()->prepare($req);

    foreach (SelectRewardTypes() as $rewardType) {
        foreach (SelectQualities() as $quality) {
            $sql->bindParam(':id_reward_type', $rewardType['id_reward_type'], PDO::PARAM_INT);
            $sql->bindParam(':id_quality', $quality['id_quality'], PDO::PARAM_INT);
            $sql->bindParam(':id_hero', $id, PDO::PARAM_INT);
            $sql->execute();

            $tmp = $sql->fetchAll(PDO::FETCH_ASSOC); // afin de ne pas mettre du vide dans le tableau
            if(isset($tmp[0]))
                $tmpReturn[$rewardType['name']][$quality['name']] = $tmp;
        }
    }

    return $tmpReturn;
}

// récupère les infos d'un utilisateur en fonction de son 'username' (utilisé pour la connection)
function SelectUserByUsername($username) {
    $req = 'SELECT * FROM users WHERE username = :username';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':username', $username, PDO::PARAM_STR);
    $sql->execute();

    return $sql->fetch(PDO::FETCH_ASSOC);
}

// récupère les infos d'un utilisateur en fonction de son id
function SelectUserById($id) {
    $req = 'SELECT * FROM users WHERE id_user = :id';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();

    return $sql->fetch(PDO::FETCH_ASSOC);
}

// insère un nouvel enregistrement dans la table "users"
// retourne le code de l'erreur s'il y en a une, ou null s'il n'y en a pas 
function InsertUser($username, $email, $password) {
    try{
        $req = 'INSERT INTO users (username, password, email, is_banned) VALUES (:username, :email, :password, 0)';
        $sql = MyPdo()->prepare($req); 
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
?>