/*
*   Управление ботами для эмуляции
*/
$(function () {

var botsTimer = null;

function bots_ajax(){
    $.ajax({
        url: '/engine/ajax/bots.php',
        cache: false
    }); 
    botsTimer = setTimeout(bots_ajax, 3000);     
}

    $('#addBot').toggle(function(){
        $(this).val('Выключить эмуляцию');
        bots_ajax();            
    },
    function (){
        $(this).val('Включить эмуляцию');
        clearTimeout(botsTimer);
    });     
});