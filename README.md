#ОПИСАНИЕ СКРИПТА "ЧАТ"

##Файловая структура

index.php - стартовый файл
/sctipts - папка с javascript
/engine/ajax - серверное управление
/css - стили
/config - конфигурация и функции
/images - картинки

##Работа скрипта

var my_NAME = 'Игорь'; //имя пользователя авторизоровано в чате (емуляция) 

При первом использовании скрипта в БД занесены только несколько ботов(юзеров), несколько подарков и первые фразы.

Для эмуляции работы чата нужно нажать на кнопку "Включить эмуляцию", 
после чего боты начнут активно общатся в чате эмулируя все имеющиеся функции чата.

##Доступные функции

-- отправка и удаление сообщений;
-- оценки, симпатии (9, 10);
-- отправка подарков (добавлены только подарки за 2зол.);
-- емуляция ошибки отправки сообщения;
-- мониторинг онлайн пользователей;
-- мониторинг количества новых сообщений;
-- ожидание доставки сообщения в виде прелоадера, когда пользователь в офлайне (как в skype);
-- прелоад аватарок;


