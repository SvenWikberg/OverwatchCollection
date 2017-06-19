<!--
    Auteur: Sven Wikberg
    Date: 19/06/2017
    Description: Classe pdo
-->    
<?php
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