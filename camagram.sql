-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июл 10 2017 г., 06:39
-- Версия сервера: 5.6.35
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `camagram`
--
CREATE DATABASE IF NOT EXISTS `camagram` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `camagram`;

-- --------------------------------------------------------

--
-- Структура таблицы `confirm`
--

CREATE TABLE `confirm` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `confirm`
--

INSERT INTO `confirm` (`id`, `user_id`, `hash`) VALUES
(1, 1, '9f77f864b10c07cb12cda9a02dd28cee'),
(2, 2, '80293bbc34c94c67bfc8c3f63ae862c2'),
(3, 3, 'a03d402afc8606b2e8e6c4258ed95c21'),
(4, 4, '488419bc098d383dd0120a55efdb1dd2');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `photo_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `user_id`, `file_name`, `photo_date`) VALUES
(1, 2, 'd71d4c2f5884e59f440ef9090d909e56.png', '2017-07-10 11:10:48'),
(2, 2, '460ade0f39ac7501db3b0912b829efdb.png', '2017-07-10 11:11:39'),
(3, 2, '21e4ed58a5d8c137017db2bbfd34c1d4.png', '2017-07-10 15:53:14'),
(4, 2, '7b80d0d5524ce5d1abce81225ca03bf1.png', '2017-07-10 15:53:44'),
(5, 2, '9b7e9da5652f7af214cd48561dffc9b7.png', '2017-07-10 15:55:16'),
(6, 2, '96206d2698a33ba84f3fea0c2082617e.png', '2017-07-10 15:56:19'),
(7, 2, '259296262c5d3b33dae1160000d67870.png', '2017-07-10 16:00:20'),
(8, 4, 'c46449b30aae5f6203576239769afe54.png', '2017-07-10 16:31:57'),
(9, 4, '554d75542ecbfb84058f7141958a3e62.png', '2017-07-10 16:32:02'),
(10, 4, '9d16b9531db3ee13fe678bbba82d61bd.png', '2017-07-10 16:32:35'),
(11, 4, '29dae24720761260f2156c12cd4927c1.png', '2017-07-10 16:32:40');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `email`, `confirmed`) VALUES
(2, 'kos', '1bbd886460827015e5d605ed44252251', 'kostya bovt', 'kostya.bovt@gmail.com', 1),
(4, 'test', 'e16b2ab8d12314bf4efbd6203906ea6c', 'test test', 'test@test.test', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `confirm`
--
ALTER TABLE `confirm`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `confirm`
--
ALTER TABLE `confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
