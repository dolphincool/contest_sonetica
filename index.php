<?php 
require_once 'config/config.php';
$db = start_db();
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
    
    <script type="text/javascript" src="sctipts/jquery.js"></script>
    <script type="text/javascript" src="sctipts/scripts.js"></script>
    <script type="text/javascript" src="sctipts/bots.js"></script>
    
</head>
<body>
<!-- Блок отправки подарков -->	
<div id="presents"></div>
<!-- Блок удалений сообщений -->	
<div id="blockRemoveMsgText">
	<div class="closeBlockPopup"></div>
	Вы действительно хотите удалить сообщение?
	<p></p>
	<ul id="blockRemoveMsg">
		<li><input type="button" id="exceptDell" value="Удалить" /></li>
		<li id="exceptDellNone">Нет, не надо удалять</li>
	</ul>
</div>
<!-- Блок отправки оценки -->	
<div id="blockAddStar">
	<div class="closeBlockPopup"></div>
	Отправьте <span></span> оценку
	<ul id="selectStar">
		<li id="star_1">1</li>
		<li id="star_2">2</li>
		<li id="star_3">3</li>
		<li id="star_4">4</li>
		<li id="star_5">5</li>
		<li id="star_6">6</li>
		<li id="star_7">7</li>
		<li id="star_8">8</li>
		<li id="star_9">9</li>
		<li id="star_10">10</li>
	</ul>
</div>
<div id="blockPopup"></div>
	<div id="mainStyle">
		<ul id="blockTable">
			<li id="placePeople">
				<!-- список контактов -->
				<ul id="listPeople">
                    <?php    
                        get_users_list();
                        while (put_data()) :
                        if ($data->ID_user != MY_ID) :
                        ?>
                        
    					<li id="<?php echo $data->ID_user?>">
    						<ul>
    							<li class="<?php if ($data-> user_status) {echo 'online';}else {echo 'offline';} ?>"></li>
    							<li class="nameList"><?php echo $data->Name?>, <?php echo $data->Age?></li>
								<li class="countMsg">
									<?php $count_new_msg = get_count_new_message($data->ID_user,MY_ID);
										if($count_new_msg){ ?>
											<div class="blockCount"><span><?php echo $count_new_msg; ?></span></div>
										<?php }else {?>
											<div class="removeUser">&nbsp;</div>
										<?php };?>
								</li>
								<li id="ava_<?php echo $data->ID_user ?>" class="getAvatar">
                                    <img class="preloader" src="images/ajax-loader.gif" width="20" height="20"/>
                                    <div id="images/<?php echo $data->Avatar?>" class="avatarka"></div>
									
                                </li>
    						</ul>
    					</li>                        
                        <?php 
                        endif;
                        endwhile;
                        reset_data();
                    ?>
				</ul>
				<ul id="bonus">
					<li><input id="addBot" type="button" value="Включить эмуляцию" /> </li>
				</ul>
			</li>
			<li id="shadowLi">
			</li>
			<li id="placeText">
				<!-- Информация о пользователе-->
				<ul id="infoPeople">
					<li id="peoplePhoto"><img class="preloader" src="images/ajax-loader.gif"/></li>
					<li id="peopleName">
						<a href="#"></a>
						<div id="peopleCountry"></div>
					</li>
					<li id="peopleAction">
						<span class="selectText">Добавить в контакты</span>
						<p><span class="selectText">Пожаловаться</span></p>
					</li>
				</ul>
					
				
					<!-- Блок первой фразы -->
					<div id="selectWord">
						<div class="sizeText">Начни с интересной фразы</div>
						<p>Произведи хорошее впечатление!</p>
						<div id="updateWord"><span class="selectText">Другой комплимент</span></div>
						<p><span id="randomWord" class="selectText">«Чертовски привлекательный!»</span></p>
						<div id="bootomSelectWord">Напиши первое сообщение</div>
					</div>
					<!-- Блок отправки сообщений -->
					<div id="blockSend">
						<div id="infoMessage">Хотите узнать о прочтении вашего сообщения? <span class="selectText" id="knowInfoMessage">Узнать</span></div>
                        <div id="errorMsg">Ваше сообщение не доставлено. <span class="selectText" id="repeatMsg">Повторить попытку</span></div>
						<form>
							<textarea id="styleTextarea"></textarea>
							<ul id="btnSend">
								<li>
									<input id="sendMessage" type="button" value="Отправить" />
								</li>
								<li class="sendPresent"><span class="selectText">Отправить подарок</span></li>
								<li class="sendRation"><span class="selectText">Отправить оценку</span></li>
							</ul>
						</form>
					</div>
				
			</li>
		</ul>
	</div>
	
	
</body>
</html>
<?php close_db($db);?>