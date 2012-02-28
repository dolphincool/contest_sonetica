-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 28 2012 г., 23:16
-- Версия сервера: 5.5.20
-- Версия PHP: 5.3.10-1~dotdeb.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `chat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chat_HWnd_Messages`
--

CREATE TABLE IF NOT EXISTS `chat_HWnd_Messages` (
  `ID_message` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_mess` int(11) NOT NULL,
  `to_user_mess` int(11) NOT NULL,
  `rating` tinyint(2) NOT NULL DEFAULT '0',
  `rating_sympathy` tinyint(1) NOT NULL DEFAULT '0',
  `ID_present` int(11) NOT NULL DEFAULT '0',
  `message_status_from` tinyint(1) NOT NULL DEFAULT '1',
  `message_status_to` tinyint(1) NOT NULL DEFAULT '1',
  `message_text` text NOT NULL,
  `message_read_status` tinyint(1) NOT NULL DEFAULT '0',
  `message_time` varchar(30) NOT NULL,
  `del_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_message`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2687 ;

--
-- Дамп данных таблицы `chat_HWnd_Messages`
--


-- --------------------------------------------------------

--
-- Структура таблицы `chat_HWnd_Message_offers`
--

CREATE TABLE IF NOT EXISTS `chat_HWnd_Message_offers` (
  `ID_offers` int(11) NOT NULL AUTO_INCREMENT,
  `text_offer` text NOT NULL,
  PRIMARY KEY (`ID_offers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `chat_HWnd_Message_offers`
--

INSERT INTO `chat_HWnd_Message_offers` (`ID_offers`, `text_offer`) VALUES
(1, '«У тебя приятная улыбка»'),
(2, '«Чистое и доброе существо!»'),
(3, '«То ли девочка, а то ли виденье»'),
(4, '«Чувственные губы»'),
(5, '«Платье великолепно!»'),
(6, '«Девушка-мечта»'),
(7, '«Великосветская дама»'),
(8, 'С такой фигурой можно быть и дурой'),
(9, 'Для такой красавицы десятки мало'),
(10, 'Ты почти такая же красавица, как Меган Фокс ');

-- --------------------------------------------------------

--
-- Структура таблицы `chat_HWnd_Presents`
--

CREATE TABLE IF NOT EXISTS `chat_HWnd_Presents` (
  `ID_present` int(11) NOT NULL AUTO_INCREMENT,
  `name_present` varchar(255) NOT NULL,
  `present_price` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_present`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `chat_HWnd_Presents`
--

INSERT INTO `chat_HWnd_Presents` (`ID_present`, `name_present`, `present_price`, `logo`) VALUES
(1, 'Шар', 2, 'presents/1.jpg'),
(2, 'Коробка', 2, 'presents/2.jpg'),
(3, 'Цветы', 2, 'presents/3.jpg'),
(4, 'Шапка', 2, 'presents/4.jpg'),
(5, 'Цветы', 2, 'presents/5.jpg'),
(6, 'Коффе', 2, 'presents/6.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `chat_HWnd_Users`
--

CREATE TABLE IF NOT EXISTS `chat_HWnd_Users` (
  `ID_user` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Age` int(3) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Avatar` varchar(255) NOT NULL,
  `user_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `chat_HWnd_Users`
--

INSERT INTO `chat_HWnd_Users` (`ID_user`, `Name`, `Age`, `Country`, `City`, `Avatar`, `user_status`) VALUES
(1, 'Сергей', 21, 'Украина', 'Черкассы', 'avatars/dolphin.jpg', 1),
(2, 'Игорь', 23, 'Украина', 'Черкассы', 'avatars/rion.jpg', 1),
(3, 'Bot1', 54, 'Росссия', 'Москва', 'avatars/avatar2963_1.gif', 0),
(4, 'Bot2', 30, 'Росссия', 'Смоленск', 'avatars/images.jpg', 0),
(5, 'Anecdot', 88, 'USA', 'Washington', 'avatars/768345.gif', 1);
