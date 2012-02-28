<?php
/*
* Первое предлагаемое сообщение
*/
require_once '../../config/config.php';
$rand = rand(1, 10);
$db = start_db();
$mess = get_first_sys_message($rand);
echo $mess->text_offer; 
close_db($db);
?>