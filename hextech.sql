-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2021 at 05:13 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hextech`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `username` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `FName` varchar(25) NOT NULL,
  `LName` varchar(25) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`username`, `password`, `timestamp`, `FName`, `LName`, `user_email`, `user_id`) VALUES
('defaultadmin', '$2y$10$6kIK0f4V/stv9WAG0P.5ZuyhktNhK.9fvjCv2SslgW66fABgfqy26', '2021-12-06 01:07:07', 'Admin', 'User', 'adminuser123@gmail.com', 1),
('testadmin01', '$2y$10$6kIK0f4V/stv9WAG0P.5ZuyhktNhK.9fvjCv2SslgW66fABgfqy26', '2021-12-06 01:06:19', 'Evan', 'John', 'b@g.com', 8);

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `chapter_ID` int(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `chapter_name` varchar(255) NOT NULL,
  `champion_name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `release_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`chapter_ID`, `slug`, `chapter_name`, `champion_name`, `description`, `release_date`, `image_name`) VALUES
(5, 'yasuo-yone', 'Kin of the Stained Blade', 'Yasuo, Yone', 'Not forgiven. Not forgotten. See the story of brothers torn asunder.', '2021-11-11 19:22:59', ''),
(6, 'tf', 'Tales of Runeterra: Bilgewater', 'Twisted Fate, Graves, Miss Fortune', 'Down on the slaughter docks, Miss Fortune springs a trap for wanted criminals Twisted Fate and Graves&hellip; but soon finds the tables turned against her.', '2021-11-11 19:24:15', ''),
(7, 'darius', 'Tales of Runeterra: Noxus', 'Darius', 'Darius and his victorious warhosts demand that the king of Urtis surrender his throne, offering every citizen&mdash;from the highest noble to the lowliest servant&mdash;a place in the Noxian empire.', '2021-11-11 19:27:03', ''),
(8, 'akali', 'Tales of Runeterra: Ionia', 'Akali, Shen', 'Akali learns an important lesson from her former Kinkou master, Shen, when they encounter a young woodcutter upsetting the balance of Ionia.', '2021-11-11 19:27:59', ''),
(9, 'Teemo-Tristana', 'Tales of Runeterra: Don&#039;t Mess With Yordles', 'Teemo, Tristana, Corki, Lulu, Graves, Twisted Fate', '<p>When Teemo goes missing, Tristana finds plenty of volunteers to help bring him home to Bandle City&mdash;in all the ways that only yordles can!</p>', '2021-11-11 19:29:20', '0434180048e47e8d6ed39d844a649758.jpg'),
(10, 'Varus', 'As We Fall', 'Varus', 'The back story of Varus, The Arrow of Retribution', '2021-11-11 19:30:36', ''),
(11, 'xayah', 'Xayah and Rakan: Wild Magic', 'Xayah, Rakan, Zed', '<p>Restoring the wild magic of Ionia won&rsquo;t be easy when a deadly enemy lurks in the shadows.</p>', '2021-11-11 19:31:46', 'xayah.jpg'),
(12, 'ekko', 'Ekko: Seconds', 'Ekko', 'Dive in the backstory of Ekko, The Boy Who Shattered Time', '2021-11-11 19:32:55', ''),
(34, 'teem', 'teemo', 'teemo', '<p>teemo</p>', '2021-11-26 15:45:34', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`chapter_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `chapter_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
