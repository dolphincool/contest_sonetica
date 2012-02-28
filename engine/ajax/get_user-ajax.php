<?php
/*
* Получение информации о пользователе
*/
require_once '../../config/config.php';
$db = start_db();
$id = $_REQUEST['id'];
$user = get_users_info($id);
$mass = array('user_name' => $user->Name, 
                'age' => $user->Age, 
                'country' => $user-> Country, 
                'city' => $user-> City, 
                'avatar' => $user-> Avatar);
echo json_encode($mass);
close_db($db);
?>