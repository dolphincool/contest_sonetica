<?php

require_once '../../config/config.php';
$db = start_db();
get_users_list();
while (put_data()) :
    $rand = rand(0,1);
    $query = sprintf('UPDATE '.DB_PREFIX.'Users SET user_status="%d" WHERE ID_user="%d"', $rand, $data->ID_user);
	mysql_query($query, $db);
	
	if ($rand && $data->ID_user != MY_ID){
		//прочитать свои сообщения, если онлайн
		$query = sprintf('UPDATE '.DB_PREFIX.'Messages SET message_status_to=0 WHERE to_user_mess="%d"',  $data->ID_user);
		mysql_query($query, $db);
		
		$query = sprintf('UPDATE '.DB_PREFIX.'Messages SET message_status_from=0 WHERE from_user_mess="%d"',  $data->ID_user);
		mysql_query($query, $db);
		
		if ($data->ID_user != 3) {//если бот онлайн
			$rand_type = rand(0,6);

			switch ($rand_type) {
				case 0: //бот ничего не делает, он устал он спит)))
					break;
				case 1: //отправляет ообщение
					//количество сообщений в базе
					$query = sprintf('SELECT COUNT(ID_offers) FROM '.DB_PREFIX.'Message_offers');
					$send_query = mysql_query($query, $db);
					$result_id_msg = mysql_fetch_array($send_query); 
					
					$rand_msg = rand(1, $result_id_msg[0]);
					
					$query = sprintf('SELECT text_offer FROM '.DB_PREFIX.'Message_offers WHERE ID_offers="%d"', $rand_msg);
					$send_query = mysql_query($query, $db);
					$result_msg = mysql_fetch_array($send_query); 
					
					$query = sprintf('INSERT INTO '.DB_PREFIX.'Messages (from_user_mess, to_user_mess, message_text, message_time) VALUES ("%d", "%d", "%s", "%d")', $data->ID_user, 2, $result_msg[0], time());
					mysql_query($query, $db);
					break;
				case 2: //отправляет подарок
					//количество подарков в базе
					$query = sprintf('SELECT COUNT(ID_present) FROM '.DB_PREFIX.'Presents');
					$send_query = mysql_query($query, $db);
					$result_id_pre = mysql_fetch_array($send_query); 
					
					$rand_present = rand(1, $result_id_pre[0]);
					
					$query = sprintf('INSERT INTO '.DB_PREFIX.'Messages (from_user_mess, to_user_mess, ID_present, message_time) VALUES ("%d", "%d", "%s", "%d")', $data->ID_user, 2, $rand_present, time());
					mysql_query($query, $db);
					break;
				case 3: //голосует
					$rand_ration = rand(1, 10);
					
					$query = sprintf('INSERT INTO '.DB_PREFIX.'Messages (from_user_mess, to_user_mess, rating, message_time) VALUES ("%d", "%d", "%s", "%d")', $data->ID_user, 2, $rand_ration, time());
					mysql_query($query, $db);
				
					break;
				case 4: //отправить сипатию
				
					$query = sprintf('SELECT rating, ID_message FROM '.DB_PREFIX.'Messages WHERE to_user_mess="%d" AND rating_sympathy=0 AND rating > 8', $data->ID_user);
					$send_query = mysql_query($query, $db);
					
					if (mysql_num_rows($send_query)) {
					
						while ($result_ration = mysql_fetch_array($send_query)) :
							$arr_ration[] = array(
								"rating" => $result_ration[0],
								"ID_message" => $result_ration[1]
							);
						endwhile;
						
						$count_arr = count($arr_ration);
						
						
						$rand_index = rand(1, $count_arr);
						
						
						$query = sprintf('DELETE FROM '.DB_PREFIX.'Messages WHERE ID_message="%d"',$arr_ration[$rand_index-1]['ID_message']);
						mysql_query($query, $db);
						
						$query = sprintf('INSERT INTO '.DB_PREFIX.'Messages (from_user_mess, to_user_mess, rating, rating_sympathy, message_time) VALUES ("%d", "%d", "%d", "%d", "%d")', $data->ID_user, 2, $arr_ration[$rand_index-1]['rating'], 1, time());
						mysql_query($query, $db);
					}
					break;
				default:
				//отдыхаем)))
			}
			
		}
	}
endwhile;
reset_data();
close_db($db);
?>