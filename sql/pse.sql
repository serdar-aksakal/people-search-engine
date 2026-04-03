SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `pse` (
  `id` int(11) NOT NULL,
  `idx` varchar(8) DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `signature` varchar(300) DEFAULT NULL,
  `family_name` varchar(50) DEFAULT NULL,
  `prev_surname` varchar(100) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(80) DEFAULT NULL,
  `cob` varchar(3) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `father` varchar(150) DEFAULT NULL,
  `mother` varchar(150) DEFAULT NULL,
  `siblings` varchar(300) DEFAULT NULL,
  `spouse` varchar(300) DEFAULT NULL,
  `children` varchar(300) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `social_media` varchar(1000) DEFAULT NULL,
  `occupation` varchar(1000) DEFAULT NULL,
  `justification` varchar(3000) DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `pse`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;