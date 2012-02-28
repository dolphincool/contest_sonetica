<?php

/*
* Соеденение с базой данных
*/

define('HOST', 'localhost');
define('DB_NAME', 'empty');
define('DB_USER', 'empty');
define('DB_PASS', 'empty');
define('MY_ID', 2);

function start_db (){
    $db = mysql_connect(HOST, DB_USER, DB_PASS) OR die(mysql_error());
    mysql_query("SET NAMES `utf8`", $db);
    mysql_query("COLLATE `utf8`", $db);    
    mysql_select_db(DB_NAME, $db);    
    return $db;
}

function close_db($db){
    mysql_close($db);
}
?>