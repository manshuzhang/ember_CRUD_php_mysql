-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: May 17, 2016 at 06:56 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ember`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
`id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `p_id` int(11) DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `firstName`, `lastName`, `p_id`, `active`) VALUES
(1, 'Andy', 'Crum', 1, 1),
(2, 'Hello ', 'Kitty', 1, 1),
(4, 'Harry', 'Potter', 1, 1),
(5, 'Pika', 'Chu', 1, 1),
(8, 'squirtle', 'squad', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
`id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` varchar(300) NOT NULL,
  `aid` int(11) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `body`, `aid`, `active`) VALUES
(1, 'An Awesome Blog Post', 'Best content', 4, 1),
(55, 'good day', 'you don''t say', 2, 1),
(56, 'an apple a day', 'keep the doctor away', 5, 1),
(58, 'sun glasses', 'are cool', 8, 1),
(59, 'hello', 'hello', 1, 1),
(60, 'hello', 'hello', 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE `rental` (
  `id` int(11) NOT NULL,
  `title` varchar(25) NOT NULL,
  `owner` varchar(25) NOT NULL,
  `city` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental`
--

INSERT INTO `rental` (`id`, `title`, `owner`, `city`, `type`, `bedrooms`, `image`) VALUES
(1, 'Grand Old Mansion', 'Veruca Salt', 'San Francisco', 'Estate', 15, 'https://upload.wikimedia.org/wikipedia/commons/c/cb/Crane_estate_(5).jpg'),
(2, 'Urban Living', 'Mike Teavee', 'Seattle', 'Condo', 1, 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Alfonso_13_Highrise_Tegucigalpa.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;