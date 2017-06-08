<ul>
    <li><a href="index.php">Index</a></li>
    <li><a href="heroes.php">Heroes</a></li>
    <li><a href="events.php">Events</a></li>
    <li><a href="rewards.php">Others Rewards</a></li>
    <?php 
        if(isset($_SESSION['id_connected']) && $_SESSION['id_connected'] != null){
            if($_SERVER['PHP_SELF'] == '/OverwatchCollection/user.php'){
                $display = '<li><a href="user.php?action=deco">Log Out</a></li>';
            } else {
                $display =  '<li><a href="user.php">My Account</a></li>';
            }
        } else {
            $display =  '<li><a href="user.php">Login/Sign In</a></li>';
        }

        echo $display;
    ?>
</ul>