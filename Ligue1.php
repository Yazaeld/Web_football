<?php
    
	//require_once($_SERVER['DOCUMENT_ROOT'].'../../private/mysql_config.php');
    require_once('/users/21403532/private/mysql_config.php');
    set_include_path("./src");
    require_once("Router.php");
    require_once("model/Ligue1StorageMySQL.php");
   
    $bd=new PDO("mysql:host=".$MYSQL_HOST.";port=".$MYSQL_PORT.";dbname=".$MYSQL_DB.";charset=utf8mb4",$MYSQL_USER,$MYSQL_PASSWORD);
    $Store=new Ligue1StorageMySQL($bd);
    $router = new Router();
    
    $router->main($Store);

?>
