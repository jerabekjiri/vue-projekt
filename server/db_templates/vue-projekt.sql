-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 15. dub 2018, 18:55
-- Verze serveru: 10.1.16-MariaDB
-- Verze PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `vue-projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_type_id` int(11) NOT NULL,
  `contact` varchar(200) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `contacts`
--

INSERT INTO `contacts` (`contact_id`, `user_id`, `contact_type_id`, `contact`) VALUES
(1, 10, 1, '123 456 789'),
(2, 10, 2, 'test@test.test'),
(3, 10, 3, 'Pekelna Brambora');

-- --------------------------------------------------------

--
-- Struktura tabulky `contact_type`
--

CREATE TABLE `contact_type` (
  `contact_type_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `contact_type`
--

INSERT INTO `contact_type` (`contact_type_id`, `name`, `icon`) VALUES
(1, 'Mobile', 'phone'),
(2, 'Email', 'email'),
(3, 'Skype', 'message'),
(4, 'ICQ', 'message');

-- --------------------------------------------------------

--
-- Struktura tabulky `discussion`
--

CREATE TABLE `discussion` (
  `discussion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meetup_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_czech_ci NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `discussion`
--

INSERT INTO `discussion` (`discussion_id`, `user_id`, `meetup_id`, `comment`, `date`) VALUES
(1, 10, 1, 'lorem ipsum', 0),
(2, 10, 1, 'test 123', 0),
(3, 4, 1, 'Ahoj :) ', 0),
(4, 10, 2, 'dalsi muj meetup', 0),
(5, 2, 1, 'Ahoj ja jsem davidek', 0),
(6, 10, 3, 'lorem ipsum', 1522616150),
(7, 10, 3, 'lorem ipsum', 1522616160),
(8, 10, 3, 'lorem ipsum', 1522616389),
(9, 10, 3, 'test test', 1522616433),
(10, 10, 3, 'lorem ipsum', 1522616788),
(11, 10, 3, 'lorem ipsum', 1522616801),
(12, 10, 3, 'lorem ipsum', 1522616912),
(13, 10, 3, 'novej test halo', 1522616921),
(14, 10, 3, 'test', 1522617179),
(15, 10, 3, 'ahoj mam otazku', 1522617237),
(16, 10, 1, 'Dobrý den, bude na místě i občerstvení? :)', 1522876969),
(17, 10, 1, 'Občerstvení je zajištěno :)', 1522877060),
(18, 11, 1, 'Jsem děcko ? ', 1522879062),
(19, 16, 2, 'Test uzivatele :)', 1522879569),
(20, 11, 3, 'hello, england is my city', 1522881557),
(21, 10, 3, 'Bude na místě i občerstvení? :)', 1522948524);

-- --------------------------------------------------------

--
-- Struktura tabulky `joined_meetups`
--

CREATE TABLE `joined_meetups` (
  `joined_id` int(11) NOT NULL,
  `meetup_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `joined_meetups`
--

INSERT INTO `joined_meetups` (`joined_id`, `meetup_id`, `user_id`) VALUES
(92, 3, 4),
(93, 1, 4),
(94, 2, 4),
(101, 3, 11),
(128, 3, 10),
(129, 1, 10),
(130, 7, 10);

-- --------------------------------------------------------

--
-- Struktura tabulky `meetups`
--

CREATE TABLE `meetups` (
  `meetup_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `location` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `img` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `date` int(11) NOT NULL,
  `information` text COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(120) COLLATE utf8_czech_ci NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `meetups`
--

INSERT INTO `meetups` (`meetup_id`, `title`, `location`, `img`, `date`, `information`, `url`, `published`) VALUES
(1, 'Go Lang Brno', 'Brno, Czech Republic', 'background1.jpg', 1527738900, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse kapvkaquam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 'go-lang-brno', 0),
(2, 'test', 'Slavkov u Brnaěč', 'background2.jpg', 1527738600, 'test', 'test', 0),
(3, 'JS PIVO', 'Brno, Czech Republic', 'background3.jpg', 1527738600, 'lorem ipsum', 'js-pivo', 0),
(17, 'mrdka', 'richard', 'background4.jpg', 1527738600, 'krtka', 'mrdka', 0),
(18, 'b', 'b', '', 1523469600, 'b', 'b', 1),
(19, 'Sraz školáků', 'Slavkov u Brna', 'background5.jpg', 1527789600, 'Všichni jsou zváni', 'sraz-skolaku', 0),
(20, 's', 's', 'background6.jpg', 1523988000, 's', 's', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `avatar` varchar(150) COLLATE utf8_czech_ci NOT NULL,
  `information` text COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_czech_ci NOT NULL,
  `href` varchar(100) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `avatar`, `information`, `password`, `href`) VALUES
(1, 'Jiří Jeřábek', 'jiri-jerabek@mail.cz', '', 'Ahoj, jsem Jirka', '$2y$10$k3DfVT.owhl1QBb/vhhTauyOMLrLBydn1b2tm4QYPSY0k1lLZonZi', ''),
(2, 'David Krček', 'david-krcek@mail.cz', '', 'Ahoj, jsem David', '$2y$10$YanSPyP1SSKOQjB4GSB04.mlJKvDchyicobfCaM3VIdKf2jFLiOcK', ''),
(4, 'Dorotka', 'dorotka@mail.cz', '99problems.jpg', '<3', '$2y$10$Yr1ERWI5RcCTyH8RDLtvUuvBT77ddH3B9CBRBdMTmP/lDir2ssUXu', 'dorotka'),
(5, 'Filip Trotl', 'filip-trotl@mail.cz', '', 'Ahoj jsem trochu trotl', '$2y$10$pI0lknw2qj/MMAIM5PYzcOPOQiYOafwr4YmHEEI9j1MfH0Ra73Wtq', ''),
(9, 'Jirka', 'Jirina@ocas.cz', '', '', '431', ''),
(10, 'test', 'test@test.test', 'vasek_face.png', 'test here', '$2y$10$Yr1ERWI5RcCTyH8RDLtvUuvBT77ddH3B9CBRBdMTmP/lDir2ssUXu', 'test'),
(11, 'Richard Hurda', 'hurda@email.cz', '', '', '$2y$10$A63gZq5MA/KuUQ9b1jPWcuAD7WYSNHXxKSzmBG6LR1yCigQxVFjWi', 'richard-hurda'),
(12, 'Krabí muž', 's', '', '', '$2y$10$FnmybQ4z9LRIv1ZhrwJ4GucEjNmy2Ejei0MpzhpNTsGEy4aWvoDSK', ''),
(13, 'Jakub Kučera', 'kokotko', '', '', '$2y$10$n0xKOQf2UMJjOM3xyx8qG.FM01b6.wzlzefIulF9iiEyBqRnGplbu', 'jakub-kucera');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Klíče pro tabulku `contact_type`
--
ALTER TABLE `contact_type`
  ADD PRIMARY KEY (`contact_type_id`);

--
-- Klíče pro tabulku `discussion`
--
ALTER TABLE `discussion`
  ADD PRIMARY KEY (`discussion_id`);

--
-- Klíče pro tabulku `joined_meetups`
--
ALTER TABLE `joined_meetups`
  ADD PRIMARY KEY (`joined_id`);

--
-- Klíče pro tabulku `meetups`
--
ALTER TABLE `meetups`
  ADD PRIMARY KEY (`meetup_id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `contact_type`
--
ALTER TABLE `contact_type`
  MODIFY `contact_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pro tabulku `discussion`
--
ALTER TABLE `discussion`
  MODIFY `discussion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pro tabulku `joined_meetups`
--
ALTER TABLE `joined_meetups`
  MODIFY `joined_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
--
-- AUTO_INCREMENT pro tabulku `meetups`
--
ALTER TABLE `meetups`
  MODIFY `meetup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
