-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 03:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `checkmate`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_att` (IN `aid` INT)   BEGIN 
        DELETE FROM attendance where id = aid; 
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_sub` (IN `sid` INT)   BEGIN 
        DELETE FROM subjects where id = sid; 
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_attendance_data` (IN `input_subject_id` INT)   BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE cur_id INT;
    DECLARE cur_subject_id INT;
    DECLARE cur_hours INT;
    DECLARE cur_date DATE;

    -- Declare the cursor to fetch data for the specified subject_id
    DECLARE cur CURSOR FOR 
        SELECT id, subject_id, hours, date 
        FROM attendance
        WHERE subject_id = input_subject_id;

    -- Declare a handler to set the done variable to 1 when the cursor reaches the end of the result set
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    -- Open the cursor
    OPEN cur;

    -- Loop to fetch each row from the cursor
    read_loop: LOOP
        FETCH cur INTO cur_id, cur_subject_id, cur_hours, cur_date;
        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Directly select the fetched data
        SELECT cur_id AS id, cur_subject_id AS subject_id, cur_hours AS hours, cur_date AS date;
    END LOOP;

    -- Close the cursor
    CLOSE cur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_att` (IN `sid` INT, IN `d` DATE, IN `hrs` INT)   BEGIN
        	INSERT INTO attendance(subject_id,date,hours) VALUES (sid,d,hrs);
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_sub` (IN `roll` VARCHAR(50), IN `sname` VARCHAR(50), IN `tot` INT)   BEGIN
    	INSERT INTO subjects(roll_no,subject_name,total_hours) VALUES (roll,sname,tot);
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reset_sub` (IN `roll` INT)   BEGIN
        	DELETE FROM subjects where roll_no = roll;
        END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `subject_id`, `hours`, `date`) VALUES
(133, 69, 2, '2024-05-04'),
(135, 69, 2, '2024-05-21'),
(138, 71, 2, '2024-05-07'),
(139, 71, 2, '2024-05-11'),
(140, 71, 1, '2024-05-19'),
(143, 69, 2, '2024-05-22'),
(160, 40, 1, '2024-08-13'),
(161, 40, 1, '2024-08-15'),
(163, 40, 1, '2024-08-18'),
(164, 40, 2, '2024-08-14'),
(165, 40, 2, '2024-08-06'),
(167, 40, 2, '2024-08-24'),
(168, 40, 2, '2024-08-28'),
(169, 40, 2, '2024-08-26'),
(170, 40, 2, '2024-08-05'),
(171, 40, 1, '2024-08-31'),
(172, 40, 2, '2024-08-17'),
(173, 38, 2, '2024-08-14'),
(175, 38, 2, '2024-08-20'),
(176, 38, 2, '2024-08-12'),
(177, 38, 3, '2024-08-10'),
(178, 38, 2, '2024-08-08'),
(179, 38, 2, '2024-08-06'),
(180, 38, 2, '2024-08-17');

--
-- Triggers `attendance`
--
DELIMITER $$
CREATE TRIGGER `after_attendance_delete` AFTER DELETE ON `attendance` FOR EACH ROW BEGIN
    DECLARE cont DECIMAL; 
    DECLARE abs DECIMAL;
    DECLARE per DECIMAL(10,2);
    
    SELECT SUM(hours) INTO abs FROM attendance where subject_id = OLD.subject_id;
    IF abs is not null THEN
    SELECT total_hours INTO cont FROM subjects where id = OLD.subject_id;
    
    SET per = ((cont - abs)/cont)*100;
    
    UPDATE stats
    SET absent_hours = abs,
        attendance_percentage = per WHERE subject_id = OLD.subject_id;
    ELSE
    update stats set absent_hours = 0,attendance_percentage = 100 where subject_id = OLD.subject_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_attendance_insert` AFTER INSERT ON `attendance` FOR EACH ROW BEGIN
    DECLARE cont DECIMAL;
    DECLARE abs DECIMAL;
    DECLARE per DECIMAL(10,2);

    SELECT SUM(hours) INTO abs FROM attendance where subject_id = NEW.subject_id;

    SELECT total_hours INTO cont FROM subjects where id = NEW.subject_id;

    SET per = ((cont - abs)/cont)*100;
    UPDATE stats
    SET absent_hours = abs,
        attendance_percentage = per WHERE subject_id = NEW.subject_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `uname` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `roll_no` varchar(50) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `contact_hours` int(11) DEFAULT NULL,
  `absent_hours` int(11) NOT NULL DEFAULT 0,
  `attendance_percentage` decimal(10,2) NOT NULL DEFAULT 100.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`roll_no`, `subject_id`, `contact_hours`, `absent_hours`, `attendance_percentage`) VALUES
('2022103046', 38, 60, 15, 75.00),
('2022103046', 40, 48, 18, 62.50),
('2022103556', 69, 80, 6, 92.50),
('2022103556', 73, 35, 0, 100.00),
('2022103556', 74, 105, 0, 100.00),
('2022103556', 75, 56, 0, 100.00),
('2022103556', 76, 3, 0, 100.00),
('2022103557', 71, 50, 5, 90.00),
('2022103557', 72, 35, 0, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `roll_no` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`roll_no`, `name`, `phone_no`, `email`, `department`, `semester`, `password`) VALUES
('2022103032', 'Summa', '9887899878', 'summa@gmail.com', 'Electrical Engineering', 3, '$2y$10$BuGoQl8Fe1rAnX4wwFkk..2MM2ywc0aI7z6cd0lxmLd2J035qwc4C'),
('2022103033', 'Irfan', '7878745678', 'irfanvlogs@gmail.com', 'Electrical Engineering', 3, '$2y$10$o6PFZ5uExKffuXYNBI.iUu0NK677GgUjfY.le6HMvy0ZQ7Yvj9xr2'),
('2022103046', 'Hariprasath', '8072727935', 'harihacksofficial@gmail.com', 'Computer Engineering', 4, '$2y$10$Y9tD2RWh2JWB07ZKPB91HuGEGlWGQB8sHe92p90yCgQncu/xeWIU.'),
('2022103550', 'Nandhakumaran', '7094035755', 'lnandhakumaran@gmail.com', 'Electrical Engineering', 6, '$2y$10$JHeCIAuBg0RnmkR8ATXJ..NFFYEiOkBDGSop6FJZy7gkRbaJzDA.6'),
('2022103556', 'Ganeshkanna', '9894146703', 'gkmusic@gmail.com', 'Civil Engineering', 6, '$2y$10$hY7QdHmRenva4euYb0w6uuv7ZKr/A7bWJ8YCNIDcMT6zpGoJL4Vua'),
('2022103557', 'Sushmitha', '9876543210', 'blacky123@gmail.com', 'Mechanical Engineering', 3, '$2y$10$wLiPtNhQ2.chzHsNjJD15Ojlg0Ly8OUvAqidAUqVoEJgdSIKKxaxu'),
('2022103563', 'Sakthi', '6385241136', 'sycho@gmail.com', 'Electrical Engineering', 3, '$2y$10$tcqvyx.fAzTjotbhpDbZxuRjkl24vAAFMHq.khirgrJYDOEBdtvja'),
('2022103564', 'Vairaperumal', '2348968936', 'diamondhead@gmail.com', 'Civil Engineering', 2, '$2y$10$N8DiNsZLa7EyQ8UAsvs0suTfQY6B2BdmfWdFCC.KU4gppkEnhBfWq'),
('2022103569', 'Ps', '8273625321', 'ps@gmail.com', 'Computer Engineering', 4, '$2y$10$rt5zEl6CD3vsnYfBW9aeZONpWi4hJ5w/6OT6TYbrEiUPbMCaHR8Na'),
('2022103577', 'Balasrini', '9791628012', 'bala12@gmail.com', 'Computer Engineering', 3, '$2y$10$aPb4L2/2BSyHuUp8dOpluO0dRJkW7K0wkYxIr1Sphceofufvuqqxm');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `roll_no` varchar(50) DEFAULT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `total_hours` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `roll_no`, `subject_name`, `total_hours`) VALUES
(38, '2022103046', 'Computer network', 60),
(40, '2022103046', 'LA', 48),
(69, '2022103556', 'DBMS', 80),
(71, '2022103557', 'DBMS', 50),
(72, '2022103557', 'TOC', 35),
(73, '2022103556', 'TOC', 35),
(74, '2022103556', 'CA', 105),
(75, '2022103556', 'EEE', 56),
(76, '2022103556', 'EEE', 3);

--
-- Triggers `subjects`
--
DELIMITER $$
CREATE TRIGGER `after_subject_insert` AFTER INSERT ON `subjects` FOR EACH ROW BEGIN
    INSERT INTO stats (roll_no, subject_id, contact_hours, absent_hours, attendance_percentage)
    VALUES (NEW.roll_no, NEW.id, NEW.total_hours, 0, 100);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_subject_update` AFTER UPDATE ON `subjects` FOR EACH ROW BEGIN
    DECLARE abs INT;
    DECLARE cont INT;
    DECLARE per DECIMAL(10,2);
    IF OLD.total_hours != NEW.total_hours THEN  
    SET cont = NEW.total_hours;
    SELECT absent_hours INTO abs FROM stats where subject_id = NEW.id;
    SET per = ((cont - abs)/cont)*100;
    UPDATE stats SET contact_hours = cont,attendance_percentage = per where subject_id = NEW.id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_subject_delete` BEFORE DELETE ON `subjects` FOR EACH ROW BEGIN
    -- Delete associated attendance records
    DELETE FROM attendance WHERE subject_id = OLD.id;

    -- Delete corresponding stats entry
    DELETE FROM stats WHERE subject_id = OLD.id AND roll_no = OLD.roll_no;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_id` (`subject_id`,`date`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`roll_no`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roll_no` (`roll_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stats`
--
ALTER TABLE `stats`
  ADD CONSTRAINT `stats_ibfk_1` FOREIGN KEY (`roll_no`) REFERENCES `students` (`roll_no`),
  ADD CONSTRAINT `stats_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`roll_no`) REFERENCES `students` (`roll_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
