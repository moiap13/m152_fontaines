-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Dec 11, 2014 at 02:45 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `M152_Fontaines`
--

-- --------------------------------------------------------

--
-- Table structure for table `fontaines`
--

CREATE TABLE `fontaines` (
`id_fontaine` int(4) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `lng` varchar(10) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fontaines`
--

INSERT INTO `fontaines` (`id_fontaine`, `lat`, `lng`, `active`, `id_user`) VALUES
(1, '46.194755', '6.104491', 0, 1),
(2, '46.188338', '6.114083', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id_user` int(4) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `mdp`, `email`, `admin`) VALUES
(1, 'admin', 'admin', 'admin@admin.ch', 1),
(2, 'RobinP', '1234', '', 0),
(3, 'AntonioP', '1234', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fontaines`
--
ALTER TABLE `fontaines`
 ADD PRIMARY KEY (`id_fontaine`), ADD KEY `id_user` (`id_user`), ADD KEY `id_user_2` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fontaines`
--
ALTER TABLE `fontaines`
MODIFY `id_fontaine` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `fontaines`
--
ALTER TABLE `fontaines`
ADD CONSTRAINT `fontaines_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
