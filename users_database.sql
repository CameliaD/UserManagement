-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2016 at 10:33 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `users_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `first name` varchar(30) NOT NULL,
  `last name` varchar(15) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=527 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `phone`, `first name`, `last name`, `password`) VALUES
(2, 'CameliaD', 'cami@yahoo.com', '+40768268463', 'Camelia', 'Bobaru', 'passCamelia'),
(4, 'Mihai', 'mihai@yahoo.com', '+40768268463', 'Mihai', 'Pintilie', 'passMihai'),
(511, 'Harry Potter', 'dana.popescu@gmail.com', '0789456789', 'Dana', 'Popescu', 'pass'),
(512, '@na', 'ana.ionescu@yahoo.com', '0768157220', 'Ana', 'Ionescu', 'pass'),
(513, 'sterne', 'heidi.walter@yahoo.de', '0785679267', 'Heidi', 'Walter', 'pass'),
(514, 'Ionut7', 'ionut.gheorghe@gmail.com', '0768456824', 'Ionut', 'Gheorghe', 'pass'),
(515, 'myrelik', 'mirela@yahoo.com', '0785672838', 'Mirela', 'Popescu', 'pass'),
(516, 'Alyn', 'alin@yahoo.com', '0789457265', 'Alin', 'Ungureanu', 'pass'),
(517, 'Dana', 'dana.p@gmail.com', '0768456798', 'Dana', 'Pintilie', 'pass'),
(519, 'aliii', 'ali@yahoo.com', '0897456723', 'Ali', 'Peter', 'pass'),
(525, 'lyca', 'lyca@gmail.com', '0978567864', 'Laurentiu', 'Nastase', 'pass'),
(526, 'Alyna', 'alyna@gmail.com', '0236430659', 'Alina', 'Cojocaru', 'pass');

-- --------------------------------------------------------

--
-- Table structure for table `user_optional_attributes`
--

CREATE TABLE IF NOT EXISTS `user_optional_attributes` (
  `Description` varchar(200) NOT NULL,
  `Avatar` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  UNIQUE KEY `userid_2` (`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_optional_attributes`
--

INSERT INTO `user_optional_attributes` (`Description`, `Avatar`, `userid`) VALUES
('desc', 'images/avatars/11831859_10207348580891980_40513376_o.jpg', 2),
('this is an account', 'images/avatars/11779776_10207341956046363_5081223343740424445_o.jpg', 4),
('', 'images/avatars/20150706_214842_LLS.jpg', 511),
('mydesc', 'images/avatars/standard.jpg', 512),
('  my account', 'images/avatars/20150706_214340.jpg', 516),
('mydesc', 'images/avatars/DSC_1047.JPG', 526);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_optional_attributes`
--
ALTER TABLE `user_optional_attributes`
  ADD CONSTRAINT `user_optional_attributes_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
