<?php

//очистка данных
function reset_data(){
    global $query_data;
    $query_data = '';
}
//наличие наддых выборки
function have_data(){
    global $query_data;
    if (mysql_num_rows($query_data))
        return true;
    return false;
}
//получаем данные с БД
function put_data(){
    global $data;
    global $query_data;
    $data = mysql_fetch_object($query_data);
    return $data;
}


//получение списка сообщений
function get_messages($id, $check = 0, $to_id = 0){
    global $db;
    global $query_data;   
    switch ($check){
        case 0:
            $query = sprintf('SELECT * FROM '.DB_PREFIX.'Messages WHERE from_user_mess="%d" OR to_user_mess="%d"', $id, $id);
            $query_data = mysql_query($query, $db);        
        break;
        case 1:
            $query = sprintf('
                SELECT * FROM '.DB_PREFIX.'Messages 
                WHERE (from_user_mess="%d" OR from_user_mess="%d") AND (to_user_mess="%d" OR to_user_mess="%d") 
                ORDER BY ID_message ASC', $id, $to_id, $id, $to_id);
            $query_data = mysql_query($query, $db);            
        break;
    } 
}

//получение списка юзеров
function get_users_list(){
    global $db;
    global $query_data;
    $query = sprintf('SELECT * FROM '.DB_PREFIX.'Users');
    $query_data = mysql_query($query, $db);
}
//юзеры онлайн 
function get_users_online($param){
    global $db;
    global $query_data;
    $query = sprintf('SELECT * FROM '.DB_PREFIX.'Users WHERE user_status="%s"', $param);
    $query_data = mysql_query($query, $db);    
}
//получение инфо юзера
function get_users_info($id){
    global $db;
    $query = sprintf('SELECT * FROM '.DB_PREFIX.'Users WHERE ID_user="%d"', $id);
    $send_query = mysql_query($query, $db);
    $result = mysql_fetch_object($send_query);
    return $result;
}

//получение инфо подарка
function get_present_info ($id) {
    global $db;
    $query = sprintf('SELECT * FROM "%s" WHERE ID_present="%d"', DB_PREFIX.'Presents', $id);
    $send_query = mysql_query($query, $db);
    $result = mysql_fetch_object($send_query);
    return $result;    
}

//получание первого предлагаемого сообщения
function get_first_sys_message ($id){
    global $db;
    $query = sprintf('SELECT text_offer FROM '.DB_PREFIX.'Message_offers WHERE ID_offers="%d"', $id);
    $send_query = mysql_query($query, $db);
    $result = mysql_fetch_object($send_query); 
    return $result;
}
//получание количеств новых сообщений
function get_count_new_message ($from_id, $to_id){
    global $db;
	$query = sprintf('SELECT COUNT(ID_message) FROM '.DB_PREFIX.'Messages WHERE from_user_mess="%d" AND to_user_mess="%d" AND message_status_to=1', $from_id, $to_id);
	$send_query = mysql_query($query, $db);
	$result2 = mysql_fetch_array($send_query); 
	return $result2[0];
}
?>