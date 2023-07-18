-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iul. 18, 2023 la 09:37 AM
-- Versiune server: 10.4.28-MariaDB
-- Versiune PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `calendarapp`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `app_date` varchar(15) NOT NULL,
  `id_app1` int(11) DEFAULT NULL,
  `id_app2` int(11) DEFAULT NULL,
  `id_app3` int(11) DEFAULT NULL,
  `id_app4` int(11) DEFAULT NULL,
  `id_app5` int(11) DEFAULT NULL,
  `id_app6` int(11) DEFAULT NULL,
  `id_app7` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `appointments`
--

INSERT INTO `appointments` (`id`, `app_date`, `id_app1`, `id_app2`, `id_app3`, `id_app4`, `id_app5`, `id_app6`, `id_app7`) VALUES
(12, '27.7.2023', 0, 18, 0, 0, 0, 0, 18),
(13, '19.7.2023', 0, 0, 0, 0, 18, 0, 0),
(19, '18.7.2023', 0, 5, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `userip`
--

CREATE TABLE `userip` (
  `id` int(11) NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `acc_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `userip`
--

INSERT INTO `userip` (`id`, `ip`, `acc_count`) VALUES
(2, 0x3132372e302e302e31, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `verified`) VALUES
(5, 'admin', 'admin@gmail.com', '$2y$10$TGIwjanVJHpByxlXCePzBObbZU3og2m76Rp3pb2mPBsMOvRN4PUuO', 1, 1),
(18, 'Test', 'andrei.socoteala14@gmail.com', '$2y$10$NhCMVyEsVjSk4iE0pD19UuEPguIsv08ULsqsO9/FM0NEP0.gOR/V.', 0, 1),
(19, 'test2', 'test@gmail.com', '$2y$10$UQloopz/UhjZ6i2mBOUoD.wcYd6nYrv.3Y6r5lZRq5xX1bJao8L9e', 0, 0);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `verify`
--

CREATE TABLE `verify` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `userip`
--
ALTER TABLE `userip`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pentru tabele `userip`
--
ALTER TABLE `userip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pentru tabele `verify`
--
ALTER TABLE `verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

DELIMITER $$
--
-- Evenimente
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_old_rows` ON SCHEDULE EVERY 2 MINUTE STARTS '2023-07-18 09:49:58' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM verify
    WHERE created_at < NOW() - INTERVAL 10 MINUTE$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
