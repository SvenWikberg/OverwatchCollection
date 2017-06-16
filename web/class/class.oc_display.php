<?php
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
            if($_SERVER['PHP_SELF'] == '/OverwatchCollection/user.php'){
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
                $display .= '<div class="rewards_type" style="width:' . ($quality_count == 4 ? '100' : $quality_count * 25 - 0.5) . '%">';
                $display .= '<h2>' .$key. '</h2>';
                $display .= '<div>';
                foreach ($type as $key => $quality) {
                    $display .= '<div>';
                    $display .= '<h3>' .$key. '</h3><ul style="height:200px; width:170px; overflow:hidden; overflow-y:auto;">';
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

        $display .= '<table border="1">';
        foreach ($events as $event) {
            $nb_col_current++;

            if($nb_col_current == 1) // si le nombre de colonne actuelle vaut 1, c'est qu'on est au debut d'une nouvelle ligne donc on ouvre une balise <tr>
                $display .= '<tr>';
            $display .= '<td><a href="event.php?id=' .$event['id_event']. '"><div>' .$event['name']. '</div><img style="width: 100%;" src="img/icon_event.jpg" alt="' .$event['name']. '"><div>From: ' .$event['start_date']. ' To: ' .$event['start_date']. '</div></a></td>';
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
                $display .= '<div class="rewards_type" style="width:' . ($quality_count == 4 ? '100' : $quality_count * 25 - 0.5) . '%">';
                $display .= '<h2>' .$key. '</h2>';
                $display .= '<div>';
                foreach ($type as $key => $quality) {
                    $display .= '<div>';
                    $display .= '<h3>' .$key. '</h3><ul style="height:200px; width:170px; overflow:hidden; overflow-y:auto;">';
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
            $display = '<table border="1">';
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
                $display .= '<td><a href="hero.php?id=' .$hero['id_hero']. '"><img src="img/icon_hero.png" alt="' .$hero['name']. '"><div>' .$hero['name']. '</div></a></td>';
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
            $display .= '<div class="rewards_type" style="width:' . ($quality_count == 4 ? '100' : $quality_count * 25 - 0.5) . '%">';
            $display .= '<h2>' .$key. '</h2>';
            $display .= '<div>';
            foreach ($type as $key => $quality) {
                $display .= '<div>';
                $display .= '<h3>' .$key. '</h3><ul style="height:200px; width:170px; overflow:hidden; overflow-y:auto;">';
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

    // affichage du formulaire de création de compte avec les message d'erreurs, en GET, s'il y en a
    static function DisplaySignin(){ 
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
                if($_GET['msg'] = 'updateDuplicate')
                    $display .= '<h3>Username/Email already used</h3>';

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

    // affiche le formulaire qui permet de modifier les infos de l'utilisateur
    static function DisplayAccountInfoUpdating($id_user){ 
        $user = OcDao::SelectUserById($id_user);

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
        $display .= '<h3>All rewards</h3>';
        $display .= '<h3>' . $user_count . '/' . $all_count . '</h3>';
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
        $display .= '<h3>Events</h3>';
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
        $display .= '<h3>Events</h3>';
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
        $display .= '<div style="width: ' . $width_percent . '%; height: ' . $height_px . 'px; border: 1px solid black;">';
        $display .=      '<div style="width: ' . ($current_value / $max_value) * 100 . '%; background-color: black; height: ' . $height_px . 'px;">';
        $display .=      '</div>';
        $display .= '</div>';

        return $display;
    }
}
?>