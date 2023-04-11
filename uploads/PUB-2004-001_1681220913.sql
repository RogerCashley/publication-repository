-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 03:33 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `publication_repo`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_publications` (IN `user_id` VARCHAR(50))   BEGIN
    SELECT p.publication_id, p.publication_title, p.publication_date, p.publication_abstract,
           pt.type_name, at.area_name, p.publication_owner
    FROM publication p
    INNER JOIN publication_authors pa ON p.publication_id = pa.publication_id
    INNER JOIN app_user au ON pa.user_id = au.user_id
    INNER JOIN app_user_role aur ON aur.user_id = au.user_id
    INNER JOIN app_role ar ON ar.role_id = aur.role_id
    INNER JOIN study_program sp ON au.program_id = sp.program_id
    INNER JOIN faculty f ON sp.faculty_id = f.faculty_id
    INNER JOIN publication_type pt ON p.type_id = pt.type_id
    INNER JOIN area_type at ON p.area_id = at.area_id
    WHERE (ar.role_id > (SELECT aur.role_id FROM app_user_role aur WHERE aur.user_id = user_id LIMIT 1)
           AND f.faculty_id = (SELECT sp.faculty_id FROM app_user WHERE user_id = user_id LIMIT 1))
          OR pa.user_id = user_id
    GROUP BY p.publication_id, p.publication_title, p.publication_date, p.publication_abstract, pt.type_name, at.area_name
    ORDER BY p.publication_date DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_lower_role_users` (IN `p_user_id` VARCHAR(50))   BEGIN
  SELECT au.user_id, au.full_name, sp.program_name, ar.role_name
  FROM app_user au
    JOIN study_program sp ON au.program_id = sp.program_id
    JOIN faculty f ON sp.faculty_id = f.faculty_id
    JOIN app_user_role aur ON au.user_id = aur.user_id
    JOIN app_role ar ON aur.role_id = ar.role_id
  WHERE au.user_id <> p_user_id
    AND ar.role_id > (SELECT aur.role_id
    FROM app_user_role aur
    WHERE aur.user_id = p_user_id)
    AND f.faculty_id = (SELECT sp1.faculty_id
    FROM app_user au1 JOIN study_program sp1 ON au1.program_id = sp1.program_id
    WHERE au1.user_id = p_user_id);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `app_role`
--

CREATE TABLE `app_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_role`
--

INSERT INTO `app_role` (`role_id`, `role_name`) VALUES
(1, 'administrator'),
(2, 'lecturer'),
(3, 'faculty admin'),
(4, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `app_user`
--

CREATE TABLE `app_user` (
  `user_id` varchar(50) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `password_salt` varchar(16) DEFAULT NULL,
  `password_pepper` varchar(16) DEFAULT NULL,
  `password_hash` varchar(256) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_user`
--

INSERT INTO `app_user` (`user_id`, `email`, `full_name`, `password_salt`, `password_pepper`, `password_hash`, `program_id`) VALUES
('2019390018', 'madina.chumaera@my.sampoernauniversity.ac.id', 'Madina Malahayati Chumaera', 'TWsDgjgerOzCHFWL', 'evbcwXgsROa4cgGj', '$2y$10$nGU7L0FF/ogVWzQpa9d3rObERF0AlN9cuh7jda0dihHXg/8QeDw1u', 8),
('2020390008', 'clark.kent@my.sampoernauniversity.ac.id', 'Clark Kent', '0wvj0CZZM6TgmQJa', '40zfnBlEMufMsTP6', '$2y$10$JLR3u0Jrs9AzLDz5pCy3Re/OWil/W9KnkpdrniUSDnt1nxc6q0Bfm', 8),
('2020390009', 'peter.parker@my.sampoernauniversity.ac.id', 'Peter Parker', 'nu9GXeZ6Yza5w3sO', 'j1Qq1Kx3aGYJzK4c', '$2y$10$nId4d.wwDTgUaTL6FhhmZuHD33yMj9NufZAhiRG9r1UkRXw81IRw6', 8),
('2020390016', 'jane.doe@my.sampoernauniversity.ac.id', 'Jane Doe', '2JGJfPMYuQO58DtT', 'WIsBUTce59YDLpZ2', '$2y$10$Bebp0Fhokwx2DXvCyOrZ0.zP5w4eo6FG1lcRYpwbV9KPT9.RWxDG6', 8),
('2020390017', 'john.doe@my.sampoernauniversity.ac.id', 'John Doe', 'EVNoe7oU9tWfXWmb', 'UGSHAyrmzc9RhhJ2', '$2y$10$v80mxsSRL6jilJHcPBgNmuJmY1BtISZqyvQcgqrTFEcTTRE5usWcK', 8),
('2020390018', 'mikha.wy@my.sampoernauniversity.ac.id', 'Mikha Kelaya Wy', 'MPzrRKy1UveJekkA', 'CHeowrY6XQ8qTmFi', '$2y$10$vCZIkikcCu/Cb8/B.ANiCOET8wvN3bjd3FefjyU25Ccd9OpC.yqPm', 8),
('2020390020', 'roger.cashley@my.sampoernauniversity.ac.id', 'Roger Cashley', '0iCMFCe6EoKjtEmZ', 'aUsnfQNawHk8gAvp', '$2y$10$xcvNdD38YCjK.Tf.U7GjiuEsOu.PWA6CqAzwZAT/8wEZzE1Z5ZKQG', 8),
('2021390001', 'dummy1@my.sampoernauniversity.ac.id', 'Dummy User 1', 'm30ZngPkQyEhaVOD', '5W1rCxqV2VSpjBnS', '$2y$10$DjU7i30cNhJPmKwGvDc6VeSaJ7yQ7Ts4rkT5tQIomwf9Zqy5B/91q', 5),
('2021390002', 'dummy2@my.sampoernauniversity.ac.id', 'Dummy User 2', 'ACwTiuG2aobXBpDV', 'l5JmHc0yx8u3ntAx', '$2y$10$3y4xO3dCWG0fA9wU0dio1.rO0j/diQnbr9pwJduEei7bGuMDyAC/S', 7),
('2021390003', 'dummy3@my.sampoernauniversity.ac.id', 'Dummy User 3', 'B4CFe41P9d4CKe8k', 'v4D0q330yrcgMxjF', '$2y$10$TiHOYlzJXXg5fJ.xqWq.ouzHVWJGBnOc/QCGsECCr/PHJflic4wre', 9),
('2021390004', 'dummy4@my.sampoernauniversity.ac.id', 'Dummy User 4', 'ODyH0TAFUQDkVOGC', 'oSGFkRk31xFZfzC7', '$2y$10$QTI2v2tg9od52uE.fyz2Aeiw1bRwJMJsq8mg/0x5oEc7j5d736TxK', 11),
('2021390005', 'dummy5@my.sampoernauniversity.ac.id', 'Dummy User 5', '2eoaJuvNArIyjZ58', '17BlyZlkTQgY5fsY', '$2y$10$X1fs29kyP1DZxkl/3jvya.qM5u/YeFYeGCvoF9MWW7ksjXgGPBtQ2', 4),
('ADMIN01', 'it.services@sampoernauniversity.ac.id', 'IT Services', 'j3YPWmQjz5j4WdfH', 'MvqVgI0OR1bVSCx6', '$2y$10$mK/xpeOHJgiZbIbCiiO9deYfsnSuqP.MHZc.uQBKMU3Ha4Eb4Rssq', NULL),
('CS01', 'media.ayu@sampoernauniversity.ac.id', 'Media Anugerah Ayu', 'xQEFRY188MW4sTcs', 'FZnhwETL7qnVvgwM', '$2y$10$fDcQuHnz1rzfUN2YgDXTcePimlXRMiOYiN/htzGJUcVlTaMHkiCXO', 2),
('FET01', 'maulidina.l@sampoernauniversity.ac.id', 'Maulidina Lubis', 'CocUKcIN0rnSOeZ3', '0Ik6Ba5aG4K9Xn22', '$2y$10$kmiFHW/ZeCf.blMXPUwb8u4nXWr4JFS/4BsWRax95PDYG3Ge7dASa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_user_role`
--

CREATE TABLE `app_user_role` (
  `user_id` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_user_role`
--

INSERT INTO `app_user_role` (`user_id`, `role_id`) VALUES
('ADMIN01', 1),
('2020390008', 2),
('2020390009', 2),
('2021390002', 2),
('2021390004', 2),
('CS01', 2),
('2021390003', 3),
('FET01', 3),
('2019390018', 4),
('2020390016', 4),
('2020390017', 4),
('2020390018', 4),
('2020390020', 4),
('2021390001', 4),
('2021390005', 4);

-- --------------------------------------------------------

--
-- Table structure for table `area_type`
--

CREATE TABLE `area_type` (
  `area_id` int(11) NOT NULL,
  `area_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `area_type`
--

INSERT INTO `area_type` (`area_id`, `area_name`) VALUES
(1, 'Artificial Intelligence'),
(2, 'Machine Learning'),
(3, 'Data Science'),
(4, 'Computer Vision'),
(5, 'Natural Language Processing'),
(6, 'Human-Computer Interaction'),
(7, 'Computer Networks'),
(8, 'Cybersecurity'),
(9, 'Database Systems'),
(10, 'Software Engineering'),
(11, 'Computer Graphics'),
(12, 'Computer Architecture'),
(13, 'Operating Systems'),
(14, 'Robotics'),
(15, 'Algorithm Design and Analysis'),
(16, 'Distributed Systems'),
(17, 'High-Performance Computing'),
(18, 'Computer Games and Animation'),
(19, 'Mobile and Web Applications Development'),
(20, 'Computer Science Education');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` varchar(10) NOT NULL,
  `faculty_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `faculty_name`) VALUES
('FAS', 'Faculty of Arts & Science'),
('FET', 'Faculty of Engineering & Technology'),
('FOB', 'Faculty of Business'),
('FOE', 'Faculty of Education');

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `publication_id` varchar(50) NOT NULL,
  `publication_title` varchar(100) NOT NULL,
  `publication_date` datetime NOT NULL,
  `lang` varchar(30) DEFAULT NULL,
  `publication_abstract` text NOT NULL,
  `doi` varchar(100) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `publication_ref` text NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `issue` int(11) DEFAULT NULL,
  `pages` varchar(10) DEFAULT NULL,
  `series` varchar(50) DEFAULT NULL,
  `publication_owner` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `publication_authors`
--

CREATE TABLE `publication_authors` (
  `publication_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `publication_content`
--

CREATE TABLE `publication_content` (
  `publication_id` varchar(50) NOT NULL,
  `content_file` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `publication_type`
--

CREATE TABLE `publication_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `publication_type`
--

INSERT INTO `publication_type` (`type_id`, `type_name`) VALUES
(1, 'Books'),
(2, 'Journals'),
(3, 'Magazines'),
(4, 'Newspapers'),
(5, 'Research papers'),
(6, 'Conference papers'),
(7, 'Technical reports'),
(8, 'Theses and dissertations'),
(9, 'Government publications'),
(10, 'Annual reports'),
(11, 'Brochures and pamphlets'),
(12, 'Newsletters'),
(13, 'User manuals'),
(14, 'Catalogs'),
(15, 'White papers'),
(16, 'Case studies'),
(17, 'Web articles and blog posts'),
(18, 'Social media posts'),
(19, 'Audio recordings'),
(20, 'Video recordings');

-- --------------------------------------------------------

--
-- Table structure for table `study_program`
--

CREATE TABLE `study_program` (
  `program_id` int(11) NOT NULL,
  `program_name` varchar(20) DEFAULT NULL,
  `faculty_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `study_program`
--

INSERT INTO `study_program` (`program_id`, `program_name`, `faculty_id`) VALUES
(1, 'Entrepreneurship', 'FOB'),
(2, 'Banking and Finance', 'FOB'),
(3, 'Digital Marketing', 'FOB'),
(4, 'Accounting', 'FOB'),
(5, 'Mechanical Engineeri', 'FET'),
(6, 'Industrial Engineeri', 'FET'),
(7, 'Visual Communication', 'FET'),
(8, 'Computer Science', 'FET'),
(9, 'Information Systems', 'FET'),
(10, 'English Language Edu', 'FOE'),
(11, 'Mathematics Educatio', 'FOE'),
(12, 'Psychology', 'FAS');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_app_user`
-- (See below for the actual view)
--
CREATE TABLE `vw_app_user` (
`user_id` varchar(50)
,`full_name` varchar(50)
,`email` varchar(70)
,`program_name` varchar(20)
,`faculty_id` varchar(10)
,`faculty_name` varchar(50)
,`role_name` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_app_user_roles`
-- (See below for the actual view)
--
CREATE TABLE `vw_app_user_roles` (
`user_id` varchar(50)
,`email` varchar(70)
,`role_id` int(11)
,`full_name` varchar(50)
,`role_name` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_publication`
-- (See below for the actual view)
--
CREATE TABLE `vw_publication` (
`publication_id` varchar(50)
,`publication_title` varchar(100)
,`publication_date` datetime
,`lang` varchar(30)
,`publication_abstract` text
,`doi` varchar(100)
,`type_id` int(11)
,`type_name` varchar(50)
,`area_id` int(11)
,`area_name` varchar(50)
,`publication_ref` text
,`volume` int(11)
,`issue` int(11)
,`pages` varchar(10)
,`series` varchar(50)
,`content_file` text
,`publication_owner` varchar(50)
,`authors` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_publication_report`
-- (See below for the actual view)
--
CREATE TABLE `vw_publication_report` (
`publication_id` varchar(50)
,`publication_title` varchar(100)
,`publication_date` datetime
,`lang` varchar(30)
,`publication_abstract` text
,`doi` varchar(100)
,`type_name` varchar(50)
,`area_name` varchar(50)
,`publication_ref` text
,`volume` int(11)
,`issue` int(11)
,`pages` varchar(10)
,`series` varchar(50)
,`user_id` varchar(50)
,`full_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_app_user`
--
DROP TABLE IF EXISTS `vw_app_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_app_user`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`full_name` AS `full_name`, `u`.`email` AS `email`, `p`.`program_name` AS `program_name`, `f`.`faculty_id` AS `faculty_id`, `f`.`faculty_name` AS `faculty_name`, `r`.`role_name` AS `role_name` FROM ((((`app_user` `u` left join `study_program` `p` on(`u`.`program_id` = `p`.`program_id`)) left join `faculty` `f` on(`p`.`faculty_id` = `f`.`faculty_id`)) left join `app_user_role` `ur` on(`u`.`user_id` = `ur`.`user_id`)) left join `app_role` `r` on(`ur`.`role_id` = `r`.`role_id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `vw_app_user_roles`
--
DROP TABLE IF EXISTS `vw_app_user_roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_app_user_roles`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`email` AS `email`, `ur`.`role_id` AS `role_id`, `u`.`full_name` AS `full_name`, `r`.`role_name` AS `role_name` FROM ((`app_user` `u` join `app_user_role` `ur` on(`u`.`user_id` = `ur`.`user_id`)) join `app_role` `r` on(`ur`.`role_id` = `r`.`role_id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `vw_publication`
--
DROP TABLE IF EXISTS `vw_publication`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_publication`  AS SELECT `p`.`publication_id` AS `publication_id`, `p`.`publication_title` AS `publication_title`, `p`.`publication_date` AS `publication_date`, `p`.`lang` AS `lang`, `p`.`publication_abstract` AS `publication_abstract`, `p`.`doi` AS `doi`, `p`.`type_id` AS `type_id`, `pt`.`type_name` AS `type_name`, `p`.`area_id` AS `area_id`, `at`.`area_name` AS `area_name`, `p`.`publication_ref` AS `publication_ref`, `p`.`volume` AS `volume`, `p`.`issue` AS `issue`, `p`.`pages` AS `pages`, `p`.`series` AS `series`, `pc`.`content_file` AS `content_file`, `p`.`publication_owner` AS `publication_owner`, group_concat(`a`.`full_name` separator ', ') AS `authors` FROM (((((`publication` `p` join `publication_type` `pt` on(`p`.`type_id` = `pt`.`type_id`)) join `area_type` `at` on(`p`.`area_id` = `at`.`area_id`)) left join `publication_content` `pc` on(`p`.`publication_id` = `pc`.`publication_id`)) left join `publication_authors` `pa` on(`p`.`publication_id` = `pa`.`publication_id`)) left join `app_user` `a` on(`pa`.`user_id` = `a`.`user_id`)) GROUP BY `p`.`publication_id`, `p`.`publication_title`, `p`.`publication_date`, `p`.`lang`, `p`.`publication_abstract`, `p`.`doi`, `p`.`type_id`, `pt`.`type_name`, `p`.`area_id`, `at`.`area_name`, `p`.`publication_ref`, `p`.`volume`, `p`.`issue`, `p`.`pages`, `p`.`series`, `pc`.`content_file` ORDER BY `a`.`full_name` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `vw_publication_report`
--
DROP TABLE IF EXISTS `vw_publication_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_publication_report`  AS SELECT `p`.`publication_id` AS `publication_id`, `p`.`publication_title` AS `publication_title`, `p`.`publication_date` AS `publication_date`, `p`.`lang` AS `lang`, `p`.`publication_abstract` AS `publication_abstract`, `p`.`doi` AS `doi`, `pt`.`type_name` AS `type_name`, `at`.`area_name` AS `area_name`, `p`.`publication_ref` AS `publication_ref`, `p`.`volume` AS `volume`, `p`.`issue` AS `issue`, `p`.`pages` AS `pages`, `p`.`series` AS `series`, `pa`.`user_id` AS `user_id`, `u`.`full_name` AS `full_name` FROM ((((`publication` `p` left join `publication_type` `pt` on(`p`.`type_id` = `pt`.`type_id`)) left join `area_type` `at` on(`p`.`area_id` = `at`.`area_id`)) left join `publication_authors` `pa` on(`p`.`publication_id` = `pa`.`publication_id`)) left join `app_user` `u` on(`pa`.`user_id` = `u`.`user_id`)) ORDER BY `p`.`publication_date` DESC, `p`.`publication_id` AS `DESCdesc` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_role`
--
ALTER TABLE `app_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `app_user`
--
ALTER TABLE `app_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `app_user_role`
--
ALTER TABLE `app_user_role`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `area_type`
--
ALTER TABLE `area_type`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`publication_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `area_id` (`area_id`);

--
-- Indexes for table `publication_authors`
--
ALTER TABLE `publication_authors`
  ADD PRIMARY KEY (`publication_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `publication_content`
--
ALTER TABLE `publication_content`
  ADD PRIMARY KEY (`publication_id`);

--
-- Indexes for table `publication_type`
--
ALTER TABLE `publication_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `study_program`
--
ALTER TABLE `study_program`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_user`
--
ALTER TABLE `app_user`
  ADD CONSTRAINT `app_user_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `study_program` (`program_id`);

--
-- Constraints for table `app_user_role`
--
ALTER TABLE `app_user_role`
  ADD CONSTRAINT `app_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`user_id`),
  ADD CONSTRAINT `app_user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `app_role` (`role_id`);

--
-- Constraints for table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `publication_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `publication_type` (`type_id`),
  ADD CONSTRAINT `publication_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area_type` (`area_id`);

--
-- Constraints for table `publication_authors`
--
ALTER TABLE `publication_authors`
  ADD CONSTRAINT `publication_authors_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`publication_id`),
  ADD CONSTRAINT `publication_authors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`user_id`);

--
-- Constraints for table `publication_content`
--
ALTER TABLE `publication_content`
  ADD CONSTRAINT `publication_content_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`publication_id`);

--
-- Constraints for table `study_program`
--
ALTER TABLE `study_program`
  ADD CONSTRAINT `study_program_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
