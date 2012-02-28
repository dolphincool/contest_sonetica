<?php
/*
* —ообщени€
*/
require_once '../../config/config.php';
$action = $_REQUEST['action'];
$db = start_db();
switch ($action){
    case 'addMess':
        //емул€ци€ ошибки 
        $error = rand(1,10);
        if ($error == 2){
            echo 'error';
        }
        else{
            $message = array();
            foreach ($_POST['message'] as $mess){
                $message[] = $mess;  
            }      
            $query = sprintf('INSERT INTO '.DB_PREFIX.'Messages 
                (from_user_mess, to_user_mess, message_text, message_read_status, message_time)
                VALUES ("%d", "%d", "%s", "%d", "%d")',
                mysql_escape_string($message[1]['from_user']), mysql_escape_string($message[2]['to_user']), 
                mysql_escape_string($message[0]['text']),
                mysql_escape_string($message[3]['knowInfoMessage']), time() 
            );
            mysql_query($query, $db);
            
        }
    break;
    //отправить оценку
    case 'addRating':
        $rating = $_POST['rating'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $query = sprintf('INSERT INTO '.DB_PREFIX.'Messages (from_user_mess, to_user_mess, rating, message_time) 
        VALUES ("%d", "%d", "%d", "%d")
        ', $from, $to, $rating, time());
        mysql_query($query, $db);       
    break;
	//отправить симпатию
    case 'addRating_Sympathy':
        $id = $_POST['id'];
        $rating = $_POST['rating'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $query = sprintf('INSERT INTO '.DB_PREFIX.'Messages (from_user_mess, to_user_mess, rating, rating_sympathy, message_status_from, message_status_to, message_time) 
                    VALUES ("%d", "%d", "%d", "%d", "%d", "%d", "%d")
                ', $from, $to, $rating, 1, 1, 1, time());
        mysql_query($query, $db);
        mysql_query(sprintf('DELETE FROM '.DB_PREFIX.'Messages WHERE ID_message="%d"', $id), $db);      
    break;    
    //отправить подарок
    case 'addPresent':
        $present = $_POST['id_present'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $query = sprintf('INSERT INTO '.DB_PREFIX.'Messages (from_user_mess, to_user_mess, ID_present, message_time) 
        VALUES ("%d", "%d", "%d", "%d")
        ', $from, $to, $present, time());
        mysql_query($query, $db);          
    break;
    //получаем список сообщений дл€ юзеров
    case 'get_listMess':
        
        $from = $_REQUEST['from'];
        $to = $_REQUEST['to'];
        get_messages($from, 1, $to);
        while (put_data()) :
            $messages[] =  array (
                'id' => $data -> ID_message, 
                'text' => $data -> message_text,
                'time' => date('H:i' ,$data -> message_time),
                'from' => $data -> from_user_mess,
                'del_status' => $data -> del_status,
                'message_status' => $data -> message_status_to,
                'rating' => $data -> rating,
                'rating_sympathy' => $data -> rating_sympathy,
                'present' => $data -> ID_present
            );
            if ($data -> from_user_mess == $from) {
                mysql_query(sprintf('UPDATE '.DB_PREFIX.'Messages SET message_status_from="%d" WHERE ID_message="%d"', 0, $data -> ID_message), $db);   
            }
            else {
                mysql_query(sprintf('UPDATE '.DB_PREFIX.'Messages SET message_status_to="%d" WHERE ID_message="%d"', 0, $data -> ID_message), $db);
            }
        endwhile;
        reset_data();
        echo json_encode($messages);
    break;
    //получение новых сообщений не учитыва€ тех, что уже получены
    case 'get_newMessages':
        $from = $_REQUEST['from'];
        $to = $_REQUEST['to'];
        $last_ID = $_REQUEST['last_ID'];
        $query = sprintf('
            SELECT * FROM '.DB_PREFIX.'Messages 
            WHERE ((from_user_mess="%d" OR from_user_mess="%d") AND (to_user_mess="%d" OR to_user_mess="%d")) 
                     AND ID_message>"%d"
            ORDER BY ID_message ASC', $from , $to, $from , $to, $last_ID);
        $send_query = mysql_query($query, $db);
        while ($result = mysql_fetch_object($send_query)) :
            if ($result -> from_user_mess == $from){
                mysql_query(sprintf('UPDATE '.DB_PREFIX.'Messages SET message_status_from="%d" WHERE ID_message="%d"', 0, $result ->ID_message),$db);   
                $mes_stat = $result -> message_status_to;
            }
            else{
                mysql_query(sprintf('UPDATE '.DB_PREFIX.'Messages SET message_status_to="%d" WHERE ID_message="%d"', 0, $result ->ID_message),$db);
                $mes_stat = 0;
            }
            $messages[] = array (
                'id' => $result -> ID_message, 
                'text' => $result -> message_text,
                'time' => date('H:i' ,$result -> message_time),
                'from' => $result -> from_user_mess,
                'del_status' => $result -> del_status,
                'message_status' => $mes_stat,
                'rating' => $result -> rating,
                'rating_sympathy' => $result -> rating_sympathy,
                'present' => $result -> ID_present
            );
        endwhile;
        echo json_encode($messages);           
    break;
    //удаление сообщений
    case 'deleteMess':
        $id = $_POST['id'];
        $query = sprintf('UPDATE '.DB_PREFIX.'Messages SET del_status=1 WHERE ID_message="%d"', mysql_escape_string($id));
        mysql_query($query, $db);
    break;
    //эмул€ци€ удалени€ сообщений
    case 'new_Deleted':
        $from = $_REQUEST['from'];
        $to = $_REQUEST['to'];        
        $query = sprintf('
            SELECT ID_message FROM '.DB_PREFIX.'Messages 
            WHERE ((from_user_mess="%d" OR from_user_mess="%d") AND (to_user_mess="%d" OR to_user_mess="%d")) 
                    AND del_status="%d"
            ORDER BY ID_message ASC', $from , $to, $from , $to, 1);
        $send_query = mysql_query($query, $db);        
        while ($result = mysql_fetch_object($send_query)) :
            $del_messages[] = array (
                'id' => $result -> ID_message, 
            );            
        endwhile;   
       echo json_encode($del_messages);
    break;
    //проверка на наличее новых сообщений
    case 'haveMess':
        $id = $_POST['id'];
        get_messages($id);
        echo ( (have_data()) ?  1 : 0 );
        reset_data();
    break;
}
close_db($db);
?>