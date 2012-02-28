/*
* Основной javascript  
*/
var my_ID = 2; //индефикатор пользоователя, которым в данный момент являюсь Я (емуляция)
var my_NAME = 'Игорь'; //имя моего пользователя (емуляция)


var users_Info = new Object(); //глобальный обьект для инфо юзеров 
var messages = new Object(); // глобальный массив сообщений


//---------------------------------------функции 

//выбор пользователя в чате
function get_user(u_id){
    //если впервые на странице за сесию - будет использоваться БД
    if (users_Info[u_id+'_id']){
        $('#peopleName > a').text(users_Info[u_id+'_userName']+', '+users_Info[u_id+'_age']);
        $('#peopleCountry').text(users_Info[u_id+'_country']+', '+users_Info[u_id+'_city']);
        $('#peoplePhoto > img').attr('src','images/'+users_Info[u_id+'_avatar']);           
    }
    else{
        $.getJSON(
            '/engine/ajax/get_user-ajax.php',
            {
                id: u_id
            },
            function (data){
                users_Info[u_id+'_id'] = u_id;
                users_Info[u_id+'_userName'] = data.user_name;
                users_Info[u_id+'_age'] = data.age;
                users_Info[u_id+'_country'] = data.country;
                users_Info[u_id+'_city'] = data.city;
                users_Info[u_id+'_avatar'] = data.avatar;  
                $('#peopleName > a').text(data.user_name+', '+data.age);
                $('#peopleCountry').text(data.country+', '+data.city);
                $('#peoplePhoto > img').attr('src','images/'+data.avatar);
            }
        ); 
    }   
    
} 
// проверка на наличие сообщений 
function haveUserMess (u_id, my_ID){
    $.ajax({
        url: '/engine/ajax/messages-ajax.php',
        type: 'post',
        data: {
            action: 'haveMess',
            id: u_id
        },
        cache: false,
        success: function (data){
            if (data == 1){
                $('#selectWord').hide();
                $('#placeText').css('background', 'white');
                $('#textMsg_'+u_id).show();
                $('ul.textMsg').hide().filter('[id="textMsg_'+u_id+'"]').show();
                //одноразовая выгрузка сообщений при новой сесии
                if ( !$('#textMsg_'+u_id+' > li').size() ){
                    get_user_Msg(my_ID, u_id, 'get_listMess');       
                }  
                $('ul.textMsg').scrollTop($('#textMsg_'+u_id).height()+10000/*емуляция*/);   // в конец списка сообщений             
            }
            else{
                $('#selectWord').show();
                $('#placeText').css('background', '#F1F5FB');
                $('ul.textMsg').hide();
            }
        }
    });
}

//генерация сообщений
function generate_MsgList (messages_Data, from, to){
    items = null;
    messages_Data.text = messages_Data.text.replace(/\n/gi, '<br />')
    class_Del = 'styleMsg';
    class_Name = 'styleNameSender';
    class_StatusRemove = 'removeMsg';
    class_Ico = 'removed'
    name = my_NAME;
    if (messages_Data.from != from) {
        class_Name = 'styleName'; 
        class_StatusRemove = 'removeMsgNone'
        name = users_Info[to+'_userName'];   
    } 
    if (messages_Data.del_status == 1){
        messages_Data.text = 'Сообщение было удалено.';
        class_Del = 'styleMsgRemoved';   
        class_StatusRemove = 'removeMsgNone';
        class_Ico = 'removedIco';
    }
    //рейтинг
    if (messages_Data.rating != 0){
            if (messages_Data.rating > 8){
                items =  '<li>'+
                    '<ul id="msg_'+messages_Data.id+'">'+
                        '<li class="styleName">&nbsp;</li>'+
                        '<li class="styleMsg">'+
                            '<ul class="sendLoveUser">'+
                                '<li><img src="images/heart_blue.png" height="53" /></li>'+
                                '<li id="sympathy_ID_'+messages_Data.id+'">';
                                if (messages_Data.from != from){
                                    if (messages_Data.rating_sympathy == 1){
                                        items += 'Ты понравился.';
                                    }
                                    else{
                                        items += 'Ты понравился. <span class="selectText addSympathy" id="sympathy_'+messages_Data.rating+'">Отправить взаимную симпатию</span>';
                                    }
                                    
                                }
                                else{
                                    items += 'Вы отправили симпатию.';
                                }                                            
                            items +=    '</li>'+
                            '</ul>';
                            if (messages_Data.rating_sympathy == 1){
                                items += 
                                '<ul class="sendLoveUser">'+
                                    '<li><img src="images/heart_red.png" height="53" /></li>'+
                                    '<li>У вас взаимная симпатия! <p><span class="selectText sendPresent">Подарок</span> — лучший способ продолжить отношения.</p></li>'+
                                '</ul>';
                            }                                        
                       items +=  '</li>'+
                        '<li class="removeMsgNone">&nbsp;</li>'+
                        '<li class="styleTimeHeight">'+messages_Data.time+'</li>'+
                        '<li class="removed">&nbsp;</li>'+
                        '<div class="clearer"></div>'+
                   '</ul>'+
                '</li>';                            
            }
            else{
                items =  '<li>'+
                    '<ul id="msg_'+messages_Data.id+'">'+
                        '<li class="styleName">&nbsp;</li>'+
                        '<li class="styleMsg">'+
                            '<ul id="sendRationUser">'+
                                '<li>'+messages_Data.rating+'</li>'+
                                '<li>';
                                if (messages_Data.from != from){
                                    items += 'Вас оценили. <span class="selectText sendRation">Оценить в ответ</span>';
                                }
                                else{
                                    items += 'Вы отправили оценку.';
                                }                                        
                                
                                items += '</li>'+
                            '</ul>'+
                        '</li>'+
                        '<li class="removeMsgNone">&nbsp;</li>'+
                        '<li class="styleTimeHeight">'+messages_Data.time+'</li>'+
                        '<li class="removed">&nbsp;</li>'+
                        '<div class="clearer"></div>'+
                   '</ul>'+
                '</li>';
            }
    }
    
    else{
        //подарки
        if (messages_Data.present != 0){
            items =  '<li>'+
                '<ul id="msg_'+messages_Data.id+'">'+
                    '<li class="styleName">&nbsp;</li>'+
                    '<li class="styleMsg">'+
                        '<ul id="sendPresentUser">'+
                            '<li><img src="images/presents/'+messages_Data.present+'.jpg" height="53" /></li>'+
                            '<li>';
                            if (messages_Data.from != from){
                                items += 'Вам отправили подарок. <span class="selectText sendPresent">Отправить подарок в ответ</span>';
                            }
                            else{
                                items += 'Вы отправили подарок.';
                            }
                           items +='</li>'+
                        '</ul>'+
                    '</li>'+
                    '<li class="removeMsgNone">&nbsp;</li>'+
                    '<li class="styleTimeHeight">'+messages_Data.time+'</li>'+
                    '<li class="removed">&nbsp;</li>'+
                    '<div class="clearer"></div>'+
               '</ul>'+
            '</li>';                        
        }
        // текстовые сообщения
        else{
            items =  '<li>'+
                '<ul id="msg_'+messages_Data.id+'">'+
                    '<li class="'+class_Name+'">'+name+'</li>'+
                    '<li class="'+class_Del+'">'+messages_Data.text+'</li>'+
                    '<li class="'+class_StatusRemove+'">&nbsp;</li>';
                    if ( (messages_Data.message_status == 1) && 
                         (messages_Data.from == from) && 
                         ($('#'+to).find('li:first').hasClass('offline'))
                       ){
                            items+= '<li class="preloadMsg"><img src="images/ajax-loader.gif" /></li>';
                            items+= '<li style="display:none;" class="styleTime">'+messages_Data.time+'</li>';
                       }
                       else{
                            items+= '<li class="styleTime">'+messages_Data.time+'</li>';
                       }
                    items+= '<li class="'+class_Ico+'"></li>'+
                    '<div class="clearer"></div>'+
               '</ul>'+
            '</li>';                        
        }   
    }    
    return items;
}

//получание списка сообщений
function get_user_Msg (from, to, action){
    $.ajax({
       url: '/engine/ajax/messages-ajax.php',
       dataType: 'json',
       cache: false,
       data: {
            action: action,
            from: from,
            to: to
       },
       success: function (data){
             items = null;
             $.each(data, function (ind, messages_Data){
                items = generate_MsgList(messages_Data, from, to);
                $('#textMsg_'+to).append(items);
             });
             $('ul.textMsg').scrollTop($('#textMsg_'+to).height()+10000/*емуляция*/);   // в конец списка сообщений 
       } 
    });
}


//отправка сообщения на сервер
function send_Msg(msg){
    $.post(
        '/engine/ajax/messages-ajax.php',
        {
            action: 'addMess',
            'message[]': msg
        },
        function (data){
            if (data == 'error'){
                $('#errorMsg').show();
                $('#infoMessage').hide();
                
            }
            else{
                
                $('#infoMessage').show();
                $('#errorMsg').hide();
                $('#selectWord').hide();
            }
        }
    );   
}



//удалить сообщение
function del_Msg(id){
    $.ajax({
        url: '/engine/ajax/messages-ajax.php',
        type: 'post',
        cache: false,
        data:
        {
            action: 'deleteMess',
            id: id
        },
        success: function (){
            $('#msg_'+id).find('li.styleMsg').html('<img src="images/ajax-loader.gif" />');
        }       
    });
}

//анимация подарков
function slideErrowsLeft(elem, count, width, speed){
    slide = (count-1)*width;
    elem.animate({marginLeft: '-'+slide+'px'}, speed);
}
function slideErrowsRight(elem, count, width, speed){
    slide = (count+1)*width;
    elem.animate({marginLeft: '-'+slide+'px'}, speed);
} 

//контроль попап окнами 
function controlling_Popup (elem1, elem2, action){
    switch (action){
        case 'show':
            elem1.show();
            elem2.show();
        break;
        case 'hide':
            elem1.hide();
            elem2.hide();
        break;
    }
}

$(function (){

    
/*основные настройки скрипта ----------------------------------------- */
    //переменные
    var listPeople = $('#listPeople > li'); // список юзеров
    var active_UserID = null; // айди юзера
    var randomWord = $('#randomWord');
    var textarea = $('#styleTextarea');
    var block_Popup = $('#blockPopup'); //окно затемнения    
    var active_user_block = null; //активное окно юзера
    //настройка полей вывода сообщений для каждого из юзеров
    listPeople.each(function (){
        $('#infoPeople').after('<ul class="textMsg" id="textMsg_'+$(this).attr('id')+'">');
    }); 
       
    listPeople.filter(':first').addClass('active'); // первый пользователь активный
    active_UserID = listPeople.filter('.active').attr('id');
    get_user(active_UserID);  
    haveUserMess(active_UserID, my_ID);
    active_user_block = $('#textMsg_'+active_UserID);
    //выбор пользователя в чате 
    listPeople.click(function (){
        listPeople.removeClass('active');
        $(this).addClass('active');
        active_UserID = listPeople.filter('.active').attr('id');
        get_user(active_UserID);
        haveUserMess(active_UserID, my_ID);
        active_user_block = $('#textMsg_'+active_UserID);
    });
    
    //мониторинг пользователей  -- количество новых сообщений
    setInterval(function (){
        $.ajax({
            url: '/engine/ajax/users_online-ajax.php',
            dataType: 'json',
            cache: false,
            success: function (data){
                if (data != null){
                    listPeople.find('li.online').removeClass('online').addClass('offline');
                    $.each(data, function (ind, u_Info) {
                        user = listPeople.filter('[id="'+u_Info.id+'"]');
                        user.find('li:first').removeAttr('class').addClass('online');
                        user.find('li.countMsg').html('<div class="removeUser">&nbsp;</div>');
                        if (u_Info.count_new_msg != 0){
                            user.find('li.countMsg').html('<div class="blockCount"><span>'+u_Info.count_new_msg+'</span></div>');
                        }
                        $('#textMsg_'+u_Info.id).find('li.preloadMsg').hide().next().show();
                    });
                }
            }
        });
    }, 2000); 
    
    //первое сообщение
    $('#updateWord').click(function (){
        $.ajax({
            url: '/engine/ajax/get_offers-ajax.php',
            dataType: 'text',
            cache: false,
            success: function(data){
                randomWord.text(data);
            }
        });
    });    
    randomWord.click(function (){
       textarea.val($(this).text()); 
    });
    
    //подгрузка аватара (прелоад)
    var img_mass = [];
    var id_mass = [];
    i = 0;
    $('li.getAvatar').each(function (){
        id_mass[i] = $(this).attr('id');
        img_mass[i] = $(this).find('div.avatarka').attr('id');
        
        i++;
    });
    function preloading(id, img){
        var user_img = new Image();
        $(user_img).load(function (){
            $(this).hide();
            $('#'+id).append(this);
            $('#'+id).find('img.preloader').remove();
            $(this).show();
        }).attr({'src':img, 'width':30, 'height':30});         
    }
    
    len = id_mass.length;
    for (i = 0; i < len; i++){
       preloading(id_mass[i], img_mass[i]);
    }
    
//------------- сообщения ---------------------------------------------------------------------------------------//
    
    
    
    $('#knowInfoMessage').click(function (){
        messages.knowInfoMessage = 1;
    });
    $('#sendMessage').click(function (){
        if (textarea.val() == ''){
            alert('Введите сообщение в поле');
            return false;
        }
        messages.text = $.trim(textarea.val());
        messages.from_user = my_ID;
        messages.to_user = listPeople.filter('.active').attr('id');
        if (!messages.knowInfoMessage)
            messages.knowInfoMessage = 0;
        
        send_Msg(messages); //отправка сообщения
        textarea.val('');
    });
    //если error
    $('#repeatMsg').click(function (){
        send_Msg(messages);
    });
    
    
    //удаление сообщений
    var blockRemoveMsg_Text = $('#blockRemoveMsgText');
    $('li.removeMsg').live('click',function (){
        id = $(this).parent().attr('id').replace('msg_', '');
        text = $(this).prev().html();
        block_Popup.show();
        blockRemoveMsg_Text.show().find('p').html(text);
        $('body').animate({scrollTop:0}, 300); // для маленьких мониторов
        $('#exceptDell').click(function (){
            del_Msg(id);  
            controlling_Popup(block_Popup, blockRemoveMsg_Text, 'hide');                  
        });
        $('#exceptDellNone').click(function (){    
            controlling_Popup(block_Popup, blockRemoveMsg_Text, 'hide');        
        });
    });
    
    //подгрузка новых сообщений
    setInterval(function (){
        last_ID = ($('#textMsg_'+active_UserID+' > li:last').find('> ul:first').size()) ? $('#textMsg_'+active_UserID+' > li:last').find('> ul:first').attr('id').replace('msg_', '') : 1;
        $.ajax({
           url: '/engine/ajax/messages-ajax.php',
           type: 'post',
           dataType: 'json',
           cache: false,
           data: {
                action: 'get_newMessages',
                from: my_ID,
                to: active_UserID,
                last_ID: last_ID
           },
           success: function (data){
                 items = null;
                 if (data){
                     active_user_block.animate({scrollTop:active_user_block.height()+5000/*емуляция*/}, 500);   // прокрутка к новым сообщениям                 
                     $.each(data, function (ind, messages_Data){
                        items = generate_MsgList(messages_Data, my_ID, active_UserID);
                        $('#textMsg_'+active_UserID).append(items);
                        if (last_ID == 1){
                            $('#placeText').css('background', 'white');
                            active_user_block.show();
                            $('#selectWord').hide();
                        }
                     });
                 }            
           }
        });    
        $.ajax({
           url: '/engine/ajax/messages-ajax.php',
           type: 'post',
           dataType: 'json',
           cache: false,
           data: {
                action: 'new_Deleted',
                from: my_ID,
                to: active_UserID
           },
           success: function (data){
                 items = null;
                 if (data){
                     $.each(data, function (ind, messages_Data){
                        $('#msg_'+messages_Data.id+' > li:eq(1)')
                        .removeClass('styleMsg').text('Сообщение было удалено.').addClass('styleMsgRemoved')
                        .next().removeClass('removeMsg').addClass('removeMsgNone');
                        $('#msg_'+messages_Data.id+' > li.removed').removeClass('removed').addClass('removedIco');
                     });
                 }            
           }
        });              
    }, 2000);
    
    
//-------------- подарки --------------------//
    
    var presentsBlock = $('#presents');
    $('.sendPresent').live('click', function (){
       presentsBlock.load(
            '/engine/ajax/presents-ajax.php',
            function (){
                
                 var chekList = [];
                $('ul.presentsPictures').each(function (){
                   if ($(this).find('li').size() < 9){
                        $(this).prev().hide();
                        $(this).next().hide();   
                   } 
                   else{
                        chekList[$(this).index()] = 0; 
                   }
                });   
                
                $('div.presentErrow_left').click(function (){
                    $elem = $(this).next();
                    ind = $elem.index();
                    if (chekList[ind] != 0){
                        slideErrowsLeft($elem, chekList[ind], 615, 1000);
                        chekList[ind]--;
                    }
                });
                $('div.presentErrow_right').click(function (){
                    $elem = $(this).prev();
                    ind = $elem.index();
                    count = $elem.find('> li').size()/8;
                    if (count%1 == 0){
                        count-=1;
                    }
                    else{
                        count =  count - (count%1);   
                    }
                    if (chekList[ind] < count){        
                        slideErrowsRight($elem, chekList[ind], 615, 1000);
                        chekList[ind]++;
                    }
                });  
                $('#closePresent').click(function (){
                    presentsBlock.hide();
                }); 
                $('ul.presentsPictures > li').click(function (){
                    id_Present = $(this).attr('id').replace('present_', '');
                    $.post(
                        '/engine/ajax/messages-ajax.php',
                        {
                            action: 'addPresent',
                            id_present: id_Present,
                            from: my_ID,
                            to: active_UserID    
                        }
                    );
                    presentsBlock.hide();
                });                               
            }
       ).show(); 
       $('body').animate({scrollTop:0}, 300); // для маленьких мониторов
    });
    
//------------------------ Оценки --------------------------- //

    var blockAdd_Star = $('#blockAddStar');
    $('.sendRation').live('click', function (){
        block_Popup.show();
        blockAdd_Star.show().find('span').text(users_Info[active_UserID+'_userName']);
        $('body').animate({scrollTop:0}, 300); // для маленьких мониторов
    });
    
    $('#selectStar > li').click(function (){
        rating = $(this).attr('id').replace('star_', '');
        $.post(
            '/engine/ajax/messages-ajax.php',
            {
                action: 'addRating',
                rating: rating,
                from: my_ID,
                to: active_UserID    
            }           
        );      
        controlling_Popup(block_Popup, blockAdd_Star, 'hide');      
    });
    
    $('span.addSympathy').live('click', function (){
        $(this).hide();
        id = $(this).parent().attr('id').replace('sympathy_ID_', '');
        $.post(
            '/engine/ajax/messages-ajax.php',
            {
                action: 'addRating_Sympathy',
                rating: $(this).attr('id').replace('sympathy_', ''),
                id: $(this).parent().attr('id').replace('sympathy_ID_', ''),
                from: my_ID,
                to: active_UserID    
            },
            function (){
                $('#msg_'+id).parent().remove();
            }
        );        
    });
  
//-------------------------------------------------------------------------------------------  
//закрыть все попап окна    
    $('div.closeBlockPopup').click(function (){
        block_Popup.hide();
        blockRemoveMsg_Text.hide();
        blockAdd_Star.hide();
        
    });
  
});
