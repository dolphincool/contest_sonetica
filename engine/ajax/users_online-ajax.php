<?php
require_once '../../config/config.php';
$db = start_db();

get_users_online(1);

while (put_data()) : 
    $users[] = array(
		"id" => $data -> ID_user,
		"count_new_msg" => get_count_new_message($data->ID_user,MY_ID)
	);
endwhile;
reset_data(); 

echo json_encode($users);
close_db($db);
?>