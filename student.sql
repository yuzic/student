-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 01 2014 г., 14:36
-- Версия сервера: 5.5.31-0+wheezy1
-- Версия PHP: 5.6.0RC4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `student`
--

-- --------------------------------------------------------

--
-- Структура таблицы `semester`
--

CREATE TABLE IF NOT EXISTS `semester` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `semester`
--

INSERT INTO `semester` (`id`, `name`) VALUES
(1, 'I'),
(2, 'II');

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `description` text NOT NULL COMMENT 'Характеристика',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`id`, `firstName`, `surname`, `description`) VALUES
(2, 'Ирина', 'Волкова', 'Прекрасный учитель математики');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `created`) VALUES
(16, 'yuzic@land.ru', '25d55ad283aa400af464c76d713c07ad', '0000-00-00 00:00:00'),
(17, 'durov@mail.ru', '25d55ad283aa400af464c76d713c07ad', '0000-00-00 00:00:00'),
(19, 'antipov@maio.ru', '25d55ad283aa400af464c76d713c07ad', '2014-08-31 19:04:25'),
(20, 'chiparev@mail.ru', '25d55ad283aa400af464c76d713c07ad', '2014-09-01 08:14:34'),
(21, 'jdksd@dsds.ru', '25f9e794323b453885f5181f1b624d0b', '2014-09-01 10:04:14'),
(22, 'petro@mail.ru', '25d55ad283aa400af464c76d713c07ad', '2014-09-01 10:04:45');

-- --------------------------------------------------------

--
-- Структура таблицы `userGroup`
--

CREATE TABLE IF NOT EXISTS `userGroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `userGroup`
--

INSERT INTO `userGroup` (`id`, `name`) VALUES
(1, 'Ису-34'),
(2, 'ЮС5-08');

-- --------------------------------------------------------

--
-- Структура таблицы `userProfile`
--

CREATE TABLE IF NOT EXISTS `userProfile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `groupId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `dob` date NOT NULL COMMENT 'дата рождения',
  `ip` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_user_fk_constraint` (`userId`),
  KEY `group_user_fk_constraint` (`groupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `userProfile`
--

INSERT INTO `userProfile` (`id`, `firstName`, `surname`, `groupId`, `userId`, `dob`, `ip`) VALUES
(8, 'Юрий', 'Жигадло', 1, 16, '2016-01-02', 2130706433),
(9, 'Серегей', 'Довлыдов', 1, 17, '2011-01-02', 2130706433),
(11, 'Юрий', 'Свиридов', 1, 19, '2015-02-02', 2130706433),
(12, 'Юрий', 'Ноземов', 1, 20, '2015-01-01', 2130706433),
(13, 'Валетин', 'Юдашкин', 1, 21, '2011-02-02', 2130706433),
(14, 'Юрий', 'Стекольников', 1, 22, '2014-01-01', 2130706434);

-- --------------------------------------------------------

--
-- Структура таблицы `userRating`
--

CREATE TABLE IF NOT EXISTS `userRating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `userSubjectId` int(11) NOT NULL,
  `userProfileId` int(11) NOT NULL,
  `semestrerId` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `schoolyear` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rating_user_fk_constraint` (`userId`),
  KEY `rating_subject_fk_constraint` (`userSubjectId`),
  KEY `rating_profile_fk_constraint` (`userProfileId`),
  KEY `rating_semester_fk_constraint` (`semestrerId`),
  KEY `rating_teacher_fk_constraint` (`teacherId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Оценки студентов' AUTO_INCREMENT=40 ;

--
-- Дамп данных таблицы `userRating`
--

INSERT INTO `userRating` (`id`, `userId`, `userSubjectId`, `userProfileId`, `semestrerId`, `teacherId`, `rating`, `schoolyear`) VALUES
(3, 16, 1, 8, 1, 2, 5, 2014),
(4, 17, 2, 9, 1, 2, 4, 2014),
(16, 19, 1, 11, 1, 2, 5, 2014),
(17, 19, 2, 11, 1, 2, 4, 2014),
(18, 19, 3, 11, 1, 2, 3, 2014),
(19, 19, 4, 11, 1, 2, 2, 2014),
(20, 19, 5, 11, 1, 2, 4, 2014),
(21, 19, 6, 11, 1, 2, 5, 2014),
(22, 20, 1, 12, 1, 2, 4, 2014),
(23, 20, 2, 12, 1, 2, 3, 2014),
(24, 20, 3, 12, 1, 2, 1, 2014),
(25, 20, 4, 12, 1, 2, 2, 2014),
(26, 20, 5, 12, 1, 2, 5, 2014),
(27, 20, 6, 12, 1, 2, 5, 2014),
(28, 22, 1, 14, 1, 2, 3, 2014),
(29, 22, 2, 14, 1, 2, 1, 2014),
(30, 22, 3, 14, 1, 2, 2, 2014),
(31, 22, 4, 14, 1, 2, 4, 2014),
(32, 22, 5, 14, 1, 2, 5, 2014),
(33, 22, 6, 14, 1, 2, 2, 2014),
(34, 21, 1, 13, 1, 2, 5, 2014),
(35, 21, 2, 13, 1, 2, 3, 2014),
(36, 21, 3, 13, 1, 2, 2, 2014),
(37, 21, 4, 13, 1, 2, 4, 2014),
(38, 21, 5, 13, 1, 2, 1, 2014),
(39, 21, 6, 13, 1, 2, 5, 2014);

-- --------------------------------------------------------

--
-- Структура таблицы `userRatingAverage`
--

CREATE TABLE IF NOT EXISTS `userRatingAverage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `ratingAvg` float(11,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `userRatingAverage`
--

INSERT INTO `userRatingAverage` (`id`, `userId`, `ratingAvg`) VALUES
(1, 16, 5),
(2, 17, 4),
(3, 19, 4),
(4, 20, 3),
(5, 21, 3),
(6, 22, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `userSubject`
--

CREATE TABLE IF NOT EXISTS `userSubject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Предметы студентов' AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `userSubject`
--

INSERT INTO `userSubject` (`id`, `name`) VALUES
(1, 'математика'),
(2, 'Русский язык'),
(3, 'История'),
(4, 'Физика'),
(5, 'Физкультура'),
(6, 'Информатика');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `userProfile`
--
ALTER TABLE `userProfile`
  ADD CONSTRAINT `group_user_fk_constraint` FOREIGN KEY (`groupId`) REFERENCES `userGroup` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_user_fk_constraint` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `userRating`
--
ALTER TABLE `userRating`
  ADD CONSTRAINT `rating_profile_fk_constraint` FOREIGN KEY (`userProfileId`) REFERENCES `userProfile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_semester_fk_constraint` FOREIGN KEY (`semestrerId`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `rating_subject_fk_constraint` FOREIGN KEY (`userSubjectId`) REFERENCES `userSubject` (`id`),
  ADD CONSTRAINT `rating_teacher_fk_constraint` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`id`),
  ADD CONSTRAINT `rating_user_fk_constraint` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
