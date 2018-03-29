

-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Mar 26, 2018 at 06:27 AM
-- Server version: 5.7.21
-- PHP Version: 7.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camagru-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `date`, `photo_id`, `text`) VALUES
(1, 1, 1521234297, 8, 'hello my friend!!!'),
(2, 2, 1521744037, 10, 'add'),
(3, 2, 1521744091, 10, 'come'),
(4, 2, 1521744163, 10, 'ttt'),
(5, 2, 1521744451, 10, 'xxx'),
(6, 2, 1521744687, 10, 'yes'),
(7, 2, 1521745297, 10, 'text'),
(8, 2, 1521746112, 10, 'comment last'),
(11, 1, 1521756424, 7, 'text'),
(12, 1, 1521756475, 7, 'tex'),
(13, 1, 1521756493, 7, 'comment'),
(14, 1, 1521756514, 7, 'all'),
(15, 1, 1521756634, 7, '+++'),
(16, 1, 1521756701, 7, '---'),
(18, 1, 1521992879, 16, 'nice'),
(19, 3, 1522006246, 16, 'Hey'),
(20, 3, 1522006696, 17, 'фотка заебись'),
(21, 3, 1522006739, 17, 'орлорвіо'),
(22, 3, 1522006739, 17, 'орлорвіо'),
(23, 3, 1522006741, 17, 'орлорвіо'),
(24, 3, 1522006743, 17, 'орлорвіо'),
(25, 3, 1522006791, 17, 'воіровр'),
(26, 3, 1522007147, 5, 'хто тут бухал'),
(27, 3, 1522007310, 19, 'заебись фото');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `photo_id`, `user_id`) VALUES
(33, 10, 1),
(35, 16, 3),
(36, 10, 3),
(37, 4, 3),
(38, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `path`, `user_id`, `date`) VALUES
(4, 'img/sergio/4.jpg', 1, 1521234297),
(5, 'img/sergio/5.jpg', 1, 1521234311),
(6, 'img/sergio/6.jpg', 1, 1521234321),
(7, 'img/sergio/7.jpg', 1, 1521234333),
(8, 'img/sergio/8.jpg', 1, 1521287635),
(9, 'img/sergio/9.gif', 1, 1521393340),
(10, 'img/slavik/10.jpg', 2, 1521728402),
(16, 'img/sergio/11.jpg', 1, 1521992782),
(17, 'img/Liubomyr/17.jpg', 3, 1522006673),
(18, 'img/Liubomyr/18.jpg', 3, 1522006870),
(19, 'img/Liubomyr/19.jpg', 3, 1522007292);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `confirm` int(11) DEFAULT NULL,
  `notify_me` int(11) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `confirm`, `notify_me`, `activation_code`, `avatar`) VALUES
(1, 'sergio', '550e1bafe077ff0b0b67f4e32f29d751', 'sholodnuk@gmail.com', 1, 1, '6e3757a9c6ced0901e8ee5eb518ce2f6', 'img/sergio/avatar.jpg'),
(2, 'slavik', '4062e1fc046d77ba16ca9ccabb5539dc', 'khomslava@gmail.com', 1, 1, '8d9aebf8b2c075829791b22d8ef531ee', 'img/slavik/avatar.jpg'),
(3, 'Liubomyr', '36d1059d89bbfaeb927943ce07265a88', 'lm.klymenko@gmail.com', 1, 1, '4a6760af33267e0be4aef2a16b5d4e7c', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `photo_id` (`photo_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `photo_id_2` (`photo_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
