<?php
/////////////////////
function print_rr($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}
/////////////////////
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
        $req = "UPDATE users SET username='$username', email='$email' WHERE id_user=:id";
        $sql = MyPdo::GetMyPdo()->prepare($req);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    }

    // recupere tous les heros et les range par role dans un tableau
    static function SelectHeroesInArrayOfRole() { 
        $req = 'SELECT id_hero, name, id_role FROM heroes WHERE id_role = :id';
        $sql = MyPdo::GetMyPdo()->prepare($req);

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
        $req = 'SELECT users_rewards.id_user, users_rewards.id_reward FROM users_rewards WHERE id_user = :id_user AND id_reward = :id_reward';
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
                JOIN events ON events.id_event = rewards.id_event
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

        foreach (OcDao::SelectRewardTypes() as $rewardType) {
            foreach (OcDao::SelectQualities() as $quality) {
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

        foreach (OcDao::SelectRewardTypes() as $rewardType) {
            foreach (OcDao::SelectQualities() as $quality) {
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

        foreach (OcDao::SelectRewardTypes() as $rewardType) {
            foreach (OcDao::SelectQualities() as $quality) {
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