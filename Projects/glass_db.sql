-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2026 at 09:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
CREATE DATABASE IF NOT EXISTS glass_db;

USE glass_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Database: `glass_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
    `id` int(11) NOT NULL,
    `user_id` int(11) DEFAULT NULL,
    `title` varchar(100) DEFAULT NULL,
    `content` text DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO
    `notes` (
        `id`,
        `user_id`,
        `title`,
        `content`
    )
VALUES (
        1,
        1,
        'secret',
        'i hate the CEO '
    ),
    (
        2,
        2,
        'groceries',
        'buy some milk and eggs'
    ),
    (
        3,
        1,
        'system info',
        'the system is glitchy'
    ),
    (
        4,
        1,
        'Meeting Notes',
        'Fire the intern next week.'
    ),
    (
        5,
        2,
        'Shopping List',
        'Milk, Eggs, Bread'
    ),
    (
        6,
        3,
        'My Diary',
        'I hate my boss, he is so mean.'
    ),
    (8, 1, 'hi', 'hi');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
    `id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `filename` varchar(255) NOT NULL,
    `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO
    `uploads` (
        `id`,
        `user_id`,
        `filename`,
        `uploaded_at`
    )
VALUES (
        7,
        1,
        'Goal.txt',
        '2026-02-17 18:55:51'
    );

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
    `id` int(11) NOT NULL,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `bio` text DEFAULT NULL,
    `avatar` varchar(255) DEFAULT 'default.jpg',
    `role` enum('user', 'admin') DEFAULT 'user',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO
    `users` (
        `id`,
        `username`,
        `password`,
        `bio`,
        `avatar`,
        `role`,
        `created_at`
    )
VALUES (
        1,
        'admin',
        '0192023a7bbd73250516f069df18b500',
        'I cheated in the interview lol',
        'default.jpg',
        'admin',
        '2026-02-13 19:15:23'
    ),
    (
        2,
        'hacker',
        '5f4dcc3b5aa765d61d8327deb882cf99',
        'im just a normal user >:) \r\n<ScriPt>prompt(\"HAHAHA 😈  I GOT YOurs 🍪 <br> \" + document.cookie)</ScriPt>',
        'default.jpg',
        'user',
        '2026-02-13 19:15:23'
    ),
    (
        3,
        'john',
        '6f7f9432d35dea629c8384dab312259a',
        'hi',
        'default.jpg',
        'user',
        '2026-02-14 20:22:56'
    );

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
ADD PRIMARY KEY (`id`),
ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
ADD PRIMARY KEY (`id`),
ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 20;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;