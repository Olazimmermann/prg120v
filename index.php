<<<<<<< HEAD
-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+deb12u1
-- https://www.phpmyadmin.net/
--
-- Host: b-studentsql-1.usn.no
-- Generation Time: 22. Okt, 2025 14:22 PM
-- Tjener-versjon: 10.11.14-MariaDB-deb12
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olbor4025`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `klasse`
--

CREATE TABLE `klasse` (
  `klassekode` char(5) NOT NULL,
  `klassenavn` varchar(50) NOT NULL,
  `studiumkode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dataark for tabell `klasse`
--

INSERT INTO `klasse` (`klassekode`, `klassenavn`, `studiumkode`) VALUES
('IT1', 'IT og ledelse 1. år', 'ITLED'),
('IT2', 'IT og ledelse 2. år', 'ITLED'),
('IT3', 'IT og ledelse 3. år', 'ITLED');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `student`
--

CREATE TABLE `student` (
  `brukernavn` char(7) NOT NULL,
  `fornavn` varchar(50) NOT NULL,
  `etternavn` varchar(50) NOT NULL,
  `klassekode` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dataark for tabell `student`
--

INSERT INTO `student` (`brukernavn`, `fornavn`, `etternavn`, `klassekode`) VALUES
('gb', 'Geir', 'Bjarvin', 'IT1'),
('mrj', 'Marius R.', 'Johannessen', 'IT1'),
('tb', 'Tove', 'Bøe', 'IT2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klasse`
--
ALTER TABLE `klasse`
  ADD PRIMARY KEY (`klassekode`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`brukernavn`),
  ADD KEY `klassekode` (`klassekode`);

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`klassekode`) REFERENCES `klasse` (`klassekode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
=======

>>>>>>> 30b4e56ad7b7e304255cb97edc5ab97f21590ef4
