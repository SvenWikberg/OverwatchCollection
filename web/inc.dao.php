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

    $tmpReturn = $sql->fetch(PDO::FETCH_ASSOC);

    if(count($tmpReturn) > 0){
        return $tmpReturn;
    } else {
        return false;
    }
}

// récupere les capacités d'un hero grace a son id
function SelectAbilitiesByIdHero($id){
    $req = 'SELECT abilities.* 
            FROM abilities 
            JOIN heroes ON heroes.id_hero = abilities.id_hero
            WHERE heroes.id_hero = :id
            ORDER BY abilities.is_ultimate';
    $sql = MyPdo()->prepare($req);
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

// récupère tous les événements dans l'ordre chronologique de la date de debut
function SelectEvents() {
    $req = 'SELECT * FROM events ORDER BY events.start_date ASC';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// récupère un evenement grace a son id
function SelectEventById($id) {
    $req = 'SELECT * FROM events WHERE id_event = :id';
    $sql = MyPdo()->prepare($req);
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
function SelectUsers() {
    $req = 'SELECT * FROM users ORDER BY username ASC';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// récupère tous les utilisateurs non-bannis dans l'ordre alphabetique (avec les admin en premier)
function SelectCleanUsers() {
    $req = 'SELECT * FROM users WHERE is_banned = 0 ORDER BY is_admin DESC, username ASC';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// récupère tous les utilisateurs non-bannis dans l'ordre alphabetique (qui ne sont pas admin)
function SelectCleanUsersNoAdmin() {
    $req = 'SELECT * FROM users WHERE is_banned = 0 AND is_admin = 0 ORDER BY username ASC';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}


// récupère tous les utilisateurs bannis dans l'ordre alphabetique (qui ne sont pas admin)
function SelectBannedUsers() {
    $req = 'SELECT * FROM users WHERE is_banned = 1 AND is_admin = 0 ORDER BY username ASC';
    $sql = MyPdo()->prepare($req);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// modifie le champ is_banned de l'utilisateur selectionné, en le passant a 1 (pour bannir l'utilisateur)
function BanUserById($id) {
    $req = 'UPDATE users SET is_banned=1 WHERE id_user = :id';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
}

// modifie le champ is_banned de l'utilisateur selectionné, en le passant a 0 (pour débannir l'utilisateur)
function UnbanUserById($id) {
    $req = 'UPDATE users SET is_banned=0 WHERE id_user = :id';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
}

// supprime l'utilisateur selectionné
function DeleteUserById($id) {
    $req = 'DELETE FROM users WHERE id_user = :id';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
}

// modifie l'enregistrement d'un utilisateur en les replacant par les parametres de la fonction
function UpdateUserByIdNoPwd($id, $username, $email){
    $req = "UPDATE users SET username='$username', email='$email' WHERE id_user=:id";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
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

// ajoute un enregistrement a la table de liaison "users_rewards"
function InsertUserReward($id_user, $id_reward){
    $req = 'INSERT INTO users_rewards(id_user, id_reward) VALUES (:id_user,:id_reward)';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $sql->bindParam(':id_reward', $id_reward, PDO::PARAM_INT);
    $sql->execute();
}

// supprime un enregistrement a la table de liaison "users_rewards"
function DeleteUserReward($id_user, $id_reward){
    $req = 'DELETE FROM users_rewards WHERE id_user = :id_user AND id_reward = :id_reward';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $sql->bindParam(':id_reward', $id_reward, PDO::PARAM_INT);
    $sql->execute();
}

// test si un enregistrement de la table de liaison "users_rewards" existe, oui -> true / non -> false
function IsCreatedUserReward($id_user, $id_reward){
    $req = 'SELECT * FROM users_rewards WHERE id_user = :id_user AND id_reward = :id_reward';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $sql->bindParam(':id_reward', $id_reward, PDO::PARAM_INT);
    $sql->execute();

    if($sql->fetchAll(PDO::FETCH_ASSOC) == NULL){
        return false;
    } else {
        return true;
    }
}

// les id des objets d'un hero qu'un utilisateur a selectionné
function SelectIdRewardsByIdHeroAndIdUser($id_hero, $id_user){
    $req = 'SELECT rewards.id_reward
            FROM rewards 
            JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
            JOIN heroes ON heroes.id_hero = rewards.id_hero
            WHERE heroes.id_hero = :id_hero
            AND users_rewards.id_user = :id_user';
    $sql = MyPdo()->prepare($req);
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

// les id des objets d'un evenement qu'un utilisateur a selectionné
function SelectIdRewardsByIdEventAndIdUser($id_event, $id_user){
    $req = 'SELECT rewards.id_reward
            FROM rewards 
            JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
            JOIN events ON events.id_event = rewards.id_event
            WHERE rewards.id_event = :id_event
            AND users_rewards.id_user = :id_user';
    $sql = MyPdo()->prepare($req);
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

// les id des objets d'aucun hero qu'un utilisateur a selectionné
function SelectIdRewardsByNoIdHeroAndIdUser($id_user){
    $req = 'SELECT rewards.id_reward
            FROM rewards 
            JOIN users_rewards ON users_rewards.id_reward = rewards.id_reward
            JOIN events ON events.id_event = rewards.id_event
            WHERE (rewards.id_hero = 0 OR rewards.id_hero = NULL)
            AND users_rewards.id_user = :id_user';
    $sql = MyPdo()->prepare($req);
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

    if(count($tmpReturn) > 0){
        return $tmpReturn;
    } else {
        return false;
    }
}

// recupère tous les objets qui ne sont pas associé a un hero et les range d'abord par catégorie et ensuite par rareté
function SelectRewardsInArrayOfQualityAndTypeByNoIdHero(){
    $req = 'SELECT rewards.id_reward, rewards.name, rewards.cost, rewards.id_currency, rewards.id_event
            FROM rewards 
            JOIN qualities ON qualities.id_quality = rewards.id_quality
            JOIN reward_types ON reward_types.id_reward_type = rewards.id_reward_type
            WHERE qualities.id_quality = :id_quality
            AND reward_types.id_reward_type = :id_reward_type
            AND (rewards.id_hero = 0 OR rewards.id_hero = NULL)
            ORDER BY rewards.name';
    $sql = MyPdo()->prepare($req);

    foreach (SelectRewardTypes() as $rewardType) {
        foreach (SelectQualities() as $quality) {
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
function SelectRewardsInArrayOfQualityAndTypeByIdEvent($id){ 
    // il y a une jointure externe (LEFT JOIN) dans la requête car pas tous les objet qu'on veut récupérer on un hero qui leur est associé
    $req = 'SELECT rewards.id_reward, rewards.name as r_name, rewards.cost, rewards.id_currency, rewards.id_hero, heroes.name as h_name
            FROM rewards 
            JOIN qualities ON qualities.id_quality = rewards.id_quality
            JOIN reward_types ON reward_types.id_reward_type = rewards.id_reward_type
            JOIN events ON events.id_event = rewards.id_event
            LEFT JOIN heroes ON heroes.id_hero = rewards.id_hero
            WHERE qualities.id_quality = :id_quality
            AND reward_types.id_reward_type = :id_reward_type
            AND events.id_event = :id_event
            ORDER BY rewards.name';
    $sql = MyPdo()->prepare($req);

    foreach (SelectRewardTypes() as $rewardType) {
        foreach (SelectQualities() as $quality) {
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