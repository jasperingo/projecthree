-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin` (`id`, `name`, `password`, `add_date`) VALUES
(1,	'Jasper',	'$2y$10$z1u.697MWrKs6uJF9Qsm3eSHSu0vXk5ge10h.WQUwg9MidhvZM/dy',	'2020-10-24 13:26:20');

DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `acronym` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `department` (`id`, `name`, `acronym`, `add_date`) VALUES
(1,	'Computer Science',	'CSC',	'2020-10-24 13:39:53'),
(2,	'Information Technology',	'IFT',	'2020-10-24 13:39:53'),
(3,	'Cyber Security',	'CYS',	'2020-10-24 13:39:53'),
(4,	'Software Engineering',	'SWE',	'2020-10-24 13:39:53'),
(9,	'Medicine',	'MED',	'2020-10-28 12:03:51'),
(10,	'Biochemistry',	'BCH',	'2020-10-28 12:03:51'),
(11,	'Accounting',	'ACT',	'2020-10-28 12:03:51'),
(12,	'Mechanical Engineering',	'MCE',	'2020-10-28 12:03:51'),
(13,	'Political Science',	'PSC',	'2020-10-28 12:08:44'),
(14,	'Law',	'LAW',	'2020-10-28 12:08:44'),
(16,	'Marketing',	'MKT',	'2020-10-28 12:14:25'),
(17,	'Physics',	'PHY',	'2020-10-28 12:14:25'),
(18,	'Chemical Engineering',	'CHE',	'2020-10-28 12:14:25'),
(19,	'Business Administration',	'BAD',	'2020-10-28 17:31:35'),
(20,	'Agricultural Extension',	'AEX',	'2020-10-31 11:12:23'),
(21,	'Geology',	'GEO',	'2020-10-31 11:12:23'),
(22,	'Biology',	'BIO',	'2020-10-31 13:08:04'),
(23,	'Civil Engineering',	'CIE',	'2020-11-07 04:05:46'),
(24,	'Building Technology',	'BDT',	'2020-11-07 04:05:46'),
(25,	'Petroleum Engineering',	'PTE',	'2020-11-07 08:09:22'),
(26,	'Forestry and Wildlife',	'FWT',	'2020-11-07 08:10:35'),
(27,	'Automobile Engineering',	'AME',	'2020-11-07 11:53:21'),
(28,	'Industrial Chemistry',	'ICH',	'2020-11-07 11:53:21');

DROP TABLE IF EXISTS `download`;
CREATE TABLE `download` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) unsigned NOT NULL,
  `document_id` bigint(100) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `download` (`id`, `user_id`, `document_id`, `date`) VALUES
(1,	3,	3,	'2020-11-01 12:29:15'),
(2,	3,	3,	'2020-11-01 13:13:56'),
(3,	3,	3,	'2020-11-01 15:08:19'),
(4,	3,	3,	'2020-11-01 16:05:29'),
(5,	3,	3,	'2020-11-01 16:08:45'),
(6,	3,	3,	'2020-11-01 16:09:17'),
(7,	3,	4,	'2020-11-01 16:13:17'),
(8,	1,	4,	'2020-11-05 11:59:51'),
(9,	1,	4,	'2020-11-05 12:00:26'),
(10,	1,	4,	'2020-11-05 12:08:49'),
(11,	1,	4,	'2020-11-05 12:08:51'),
(12,	1,	4,	'2020-11-05 12:09:12'),
(13,	1,	4,	'2020-11-05 12:09:15'),
(14,	1,	4,	'2020-11-05 12:14:47'),
(15,	1,	4,	'2020-11-05 12:18:16'),
(16,	1,	4,	'2020-11-05 12:18:37'),
(17,	1,	4,	'2020-11-05 12:18:47'),
(18,	1,	4,	'2020-11-05 13:31:18'),
(19,	1,	4,	'2020-11-05 13:33:22'),
(20,	1,	4,	'2020-11-05 13:33:41'),
(21,	1,	4,	'2020-11-05 13:34:18'),
(22,	1,	4,	'2020-11-05 13:56:15'),
(23,	1,	4,	'2020-11-05 13:58:30'),
(24,	1,	4,	'2020-11-05 14:00:16'),
(25,	1,	4,	'2020-11-05 14:02:22'),
(26,	1,	4,	'2020-11-05 14:04:40'),
(27,	1,	4,	'2020-11-05 14:08:55'),
(28,	1,	4,	'2020-11-05 14:09:03'),
(29,	1,	4,	'2020-11-05 14:10:42'),
(30,	1,	4,	'2020-11-05 14:10:53'),
(31,	1,	4,	'2020-11-05 14:11:10'),
(32,	1,	4,	'2020-11-05 14:15:02'),
(33,	1,	4,	'2020-11-05 14:15:14'),
(34,	1,	4,	'2020-11-05 14:16:32'),
(35,	1,	4,	'2020-11-05 14:16:46'),
(36,	1,	4,	'2020-11-05 14:17:33'),
(37,	1,	4,	'2020-11-05 14:17:56'),
(38,	1,	4,	'2020-11-05 14:25:47'),
(39,	1,	4,	'2020-11-05 14:25:58'),
(40,	1,	4,	'2020-11-05 14:27:43'),
(41,	1,	4,	'2020-11-05 14:29:46'),
(42,	1,	4,	'2020-11-05 14:30:06'),
(43,	1,	4,	'2020-11-05 14:30:10'),
(44,	1,	4,	'2020-11-05 14:30:24'),
(45,	1,	4,	'2020-11-05 14:30:25'),
(46,	1,	4,	'2020-11-05 14:31:51'),
(47,	1,	4,	'2020-11-05 14:31:52'),
(48,	1,	4,	'2020-11-05 14:32:20'),
(49,	1,	4,	'2020-11-05 14:32:21'),
(50,	1,	4,	'2020-11-05 14:33:04'),
(51,	1,	4,	'2020-11-05 14:33:46'),
(52,	1,	4,	'2020-11-05 14:33:47'),
(53,	0,	4,	'2020-11-05 14:34:47'),
(54,	0,	4,	'2020-11-05 14:34:48'),
(55,	1,	4,	'2020-11-05 16:35:28'),
(56,	1,	4,	'2020-11-05 16:35:29'),
(57,	1,	4,	'2020-11-05 16:36:16'),
(58,	1,	4,	'2020-11-05 16:36:18'),
(59,	1,	4,	'2020-11-05 16:37:58'),
(60,	1,	4,	'2020-11-05 16:38:00'),
(61,	1,	4,	'2020-11-05 16:40:18'),
(62,	1,	4,	'2020-11-05 16:40:19'),
(63,	1,	4,	'2020-11-05 16:40:28'),
(64,	1,	4,	'2020-11-05 16:40:31'),
(65,	1,	4,	'2020-11-05 16:41:48'),
(66,	1,	4,	'2020-11-05 16:42:04'),
(67,	1,	4,	'2020-11-05 16:42:45'),
(68,	1,	4,	'2020-11-05 16:42:47'),
(69,	1,	4,	'2020-11-05 16:43:28'),
(70,	1,	4,	'2020-11-05 16:43:30'),
(71,	1,	4,	'2020-11-05 16:45:25'),
(72,	1,	4,	'2020-11-05 16:47:00'),
(73,	1,	4,	'2020-11-05 16:47:00'),
(74,	1,	4,	'2020-11-05 16:47:12'),
(75,	1,	4,	'2020-11-05 16:47:13'),
(76,	1,	4,	'2020-11-05 16:48:28'),
(77,	1,	4,	'2020-11-05 16:49:44'),
(78,	1,	4,	'2020-11-05 16:49:45'),
(79,	1,	4,	'2020-11-05 16:50:05'),
(80,	1,	4,	'2020-11-05 16:50:06'),
(81,	1,	4,	'2020-11-05 16:52:43'),
(82,	1,	4,	'2020-11-05 16:52:44'),
(83,	1,	4,	'2020-11-05 16:56:12'),
(84,	1,	4,	'2020-11-05 16:56:13'),
(85,	1,	4,	'2020-11-05 16:57:19'),
(86,	1,	4,	'2020-11-05 16:57:22'),
(87,	1,	4,	'2020-11-05 17:00:32'),
(88,	1,	4,	'2020-11-05 17:00:33'),
(89,	1,	4,	'2020-11-05 17:01:41'),
(90,	1,	4,	'2020-11-05 17:01:42'),
(91,	1,	4,	'2020-11-05 17:02:21'),
(92,	1,	4,	'2020-11-05 17:02:22'),
(93,	1,	4,	'2020-11-05 17:13:01'),
(94,	1,	4,	'2020-11-05 17:13:35'),
(95,	1,	4,	'2020-11-05 17:14:29'),
(96,	1,	4,	'2020-11-05 17:14:31'),
(97,	1,	4,	'2020-11-05 17:15:06'),
(98,	1,	4,	'2020-11-05 17:15:09'),
(99,	1,	4,	'2020-11-05 17:16:06'),
(100,	1,	4,	'2020-11-05 17:16:07'),
(101,	1,	4,	'2020-11-05 17:23:49'),
(102,	0,	4,	'2020-11-05 18:54:15'),
(103,	2,	4,	'2020-11-06 02:53:04'),
(104,	2,	3,	'2020-11-06 02:53:07'),
(105,	2,	3,	'2020-11-06 02:53:08'),
(106,	2,	3,	'2020-11-06 02:57:55'),
(107,	2,	4,	'2020-11-06 08:15:32'),
(108,	2,	3,	'2020-11-06 08:15:37'),
(109,	2,	3,	'2020-11-06 09:50:29'),
(110,	3,	5,	'2020-11-06 10:49:01'),
(111,	3,	3,	'2020-11-06 11:02:42'),
(112,	3,	4,	'2020-11-06 11:04:01'),
(113,	4,	4,	'2020-11-06 13:14:51');

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(100) unsigned NOT NULL,
  `sender_id` bigint(100) unsigned NOT NULL,
  `automated` int(10) unsigned NOT NULL,
  `seen` int(10) unsigned NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `message` (`id`, `project_id`, `sender_id`, `automated`, `seen`, `content`, `date`) VALUES
(1,	1,	1,	1,	1,	'',	'2020-10-25 12:49:20'),
(4,	1,	1,	2,	1,	'',	'2020-10-25 15:21:41'),
(5,	1,	1,	2,	1,	'',	'2020-10-25 15:22:23'),
(6,	1,	1,	2,	1,	'',	'2020-10-25 15:22:39'),
(7,	1,	2,	3,	1,	'',	'2020-10-26 00:10:53'),
(8,	1,	2,	3,	1,	'',	'2020-10-26 00:12:52'),
(9,	1,	2,	0,	1,	'Sir I have seen it',	'2020-10-26 07:33:31'),
(10,	1,	2,	0,	0,	'Can I change the headings?',	'2020-10-26 07:34:21'),
(11,	1,	2,	0,	0,	'Or should I leave it like that?',	'2020-10-26 07:35:01'),
(12,	1,	1,	4,	1,	'',	'2020-10-26 13:26:07'),
(13,	1,	1,	4,	1,	'',	'2020-10-26 13:26:21'),
(14,	1,	1,	4,	1,	'',	'2020-10-26 13:26:23'),
(15,	1,	1,	4,	1,	'',	'2020-10-26 13:33:01'),
(16,	1,	1,	4,	1,	'',	'2020-10-26 13:36:35'),
(17,	1,	1,	4,	1,	'',	'2020-10-26 13:38:05'),
(18,	1,	1,	5,	1,	'',	'2020-10-26 13:58:39'),
(19,	1,	1,	5,	1,	'',	'2020-10-26 14:01:23'),
(20,	3,	1,	1,	0,	'',	'2020-10-28 10:36:25'),
(21,	4,	1,	1,	1,	'',	'2020-10-28 10:37:08'),
(22,	3,	2,	0,	0,	'Welcome sir, let\'s get to work',	'2020-10-28 10:39:24'),
(24,	5,	3,	1,	1,	'',	'2020-10-30 18:51:26'),
(25,	5,	3,	2,	1,	'',	'2020-10-31 02:06:24'),
(26,	5,	2,	3,	1,	'',	'2020-10-31 03:07:06'),
(27,	5,	2,	3,	1,	'',	'2020-10-31 03:15:31'),
(28,	5,	3,	4,	1,	'',	'2020-10-31 03:49:35'),
(29,	5,	3,	5,	1,	'',	'2020-10-31 03:56:28'),
(30,	3,	1,	0,	0,	'3 days left to finish',	'2020-10-31 04:10:59'),
(31,	3,	1,	0,	0,	'3 days left to finish',	'2020-10-31 04:12:05'),
(32,	3,	1,	0,	0,	'3 days left to finish',	'2020-10-31 04:12:07'),
(33,	5,	3,	0,	1,	'3 days left to finish',	'2020-10-31 04:31:39'),
(34,	5,	3,	2,	1,	'',	'2020-11-05 20:02:27'),
(35,	5,	3,	2,	1,	'',	'2020-11-05 20:07:33'),
(36,	5,	3,	2,	1,	'',	'2020-11-05 20:07:36'),
(37,	5,	3,	2,	1,	'',	'2020-11-05 20:08:20'),
(38,	5,	3,	2,	1,	'',	'2020-11-05 20:08:28'),
(39,	6,	3,	1,	0,	'',	'2020-11-06 01:01:05'),
(40,	5,	2,	3,	0,	'',	'2020-11-06 10:43:51'),
(41,	5,	3,	2,	1,	'',	'2020-11-06 10:46:32'),
(42,	5,	3,	4,	1,	'',	'2020-11-06 10:59:17'),
(43,	5,	3,	4,	1,	'',	'2020-11-06 11:00:42'),
(44,	5,	3,	4,	1,	'',	'2020-11-06 11:01:59'),
(45,	5,	3,	4,	1,	'',	'2020-11-06 11:02:05'),
(46,	5,	3,	4,	1,	'',	'2020-11-06 11:02:52'),
(47,	5,	3,	5,	1,	'',	'2020-11-06 11:03:23'),
(48,	5,	3,	4,	1,	'',	'2020-11-06 11:03:34'),
(49,	5,	3,	4,	1,	'',	'2020-11-06 11:03:44'),
(50,	5,	3,	5,	1,	'',	'2020-11-06 11:03:51'),
(51,	5,	3,	4,	1,	'',	'2020-11-06 11:04:03'),
(52,	5,	2,	0,	0,	'Thank you sir. It has not been easy doing this project 🤗',	'2020-11-06 15:58:44'),
(53,	4,	2,	3,	0,	'',	'2020-11-06 16:10:10'),
(54,	4,	2,	0,	0,	'Thank you sir. Am ready to get down to business.',	'2020-11-06 16:10:52');

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `supervisor_id` bigint(100) unsigned NOT NULL,
  `student_id` bigint(100) unsigned NOT NULL,
  `university_id` bigint(100) unsigned NOT NULL,
  `department_id` bigint(100) unsigned NOT NULL,
  `topic` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `privacy` int(10) unsigned NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `project` (`id`, `supervisor_id`, `student_id`, `university_id`, `department_id`, `topic`, `description`, `privacy`, `creation_date`) VALUES
(1,	1,	2,	1,	2,	'E-learning effects',	'To tell the advantages of E-learning	',	0,	'2020-10-25 12:49:20'),
(3,	1,	2,	1,	4,	'C essentials',	'',	0,	'2020-10-28 10:36:25'),
(4,	1,	2,	1,	1,	'Logic Evaluation',	'',	0,	'2020-10-28 10:37:08'),
(5,	3,	2,	6,	14,	'Human rights and privileges',	'We humans deserve to survive and florist on earth.\r\nIt is our right to move ahead of time to a place of great progress',	1,	'2020-10-30 18:51:26'),
(6,	3,	5,	7,	17,	'Quantum particle mechanism',	'',	0,	'2020-11-06 01:01:05');

DROP TABLE IF EXISTS `project_document`;
CREATE TABLE `project_document` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(100) unsigned NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` int(10) unsigned NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `project_document` (`id`, `project_id`, `name`, `approved`, `upload_date`) VALUES
(1,	1,	'C IMT305.pdf',	0,	'2020-10-26 00:10:53'),
(3,	5,	'Document 16.pdf',	0,	'2020-10-31 03:07:06'),
(4,	5,	'Academic Session.pdf',	1,	'2020-10-31 03:15:31'),
(5,	5,	'IMT 411 Lecture  Note_2.docx',	0,	'2020-11-06 10:43:51'),
(6,	4,	'IMT 403 ASSIGNMENT BY HOD.docx',	0,	'2020-11-06 16:10:10');

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(100) unsigned NOT NULL,
  `sender_id` bigint(100) unsigned NOT NULL,
  `star` int(10) unsigned NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `review` (`id`, `project_id`, `sender_id`, `star`, `content`, `date`) VALUES
(1,	1,	3,	4,	'Nice',	'2020-10-26 16:00:30'),
(3,	5,	1,	3,	'Cool stuff',	'2020-10-31 11:57:37'),
(4,	5,	5,	5,	'Good stuff you guys did here.',	'2020-11-06 12:56:43'),
(5,	5,	4,	4,	'Really liked it 😁',	'2020-11-06 07:40:20');

DROP TABLE IF EXISTS `university`;
CREATE TABLE `university` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `acronym` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `university` (`id`, `name`, `acronym`, `address`, `description`, `add_date`) VALUES
(1,	'Federal University of Technology Owerri',	'FUTO',	'Owerri, Imo State Nigeria',	'FUTO is a technology university based in Owerri. \r\nConsisting of 9 faculties.',	'2020-10-24 13:39:53'),
(5,	'University of Port Harcourt',	'UNIPORT',	'Port Harcourt Rivers State',	'We good, we the best, we great.',	'2020-10-28 12:03:51'),
(6,	'University of Lagos',	'UNILAG',	'Ikeja Lagos State',	'We good',	'2020-10-28 12:08:44'),
(7,	'Covenant University',	'COVUNI',	'Bla bla bla State',	'Missionary school with high school fees',	'2020-10-28 12:14:25'),
(8,	'Federal Polytechnic Nekede',	'NEKEDEPOLY',	'Owerri Imo State',	'HND & ND',	'2020-10-28 17:31:35'),
(9,	'Abia State University',	'ABSU',	'Abia State, Nigeria',	'For the same time I don\'t have a car',	'2020-10-31 11:12:23'),
(10,	'Imo State University',	'IMSU',	'Owerri Imo State Nigeria',	'University owned by Imo State government.\r\nOffers both science and art courses.',	'2020-11-07 04:05:46'),
(11,	'University of Calabar',	'UNICAL',	'Calabar Cross Rivers State, Nigeria',	'The Federal university in Cross Rivers State Nigeria',	'2020-11-07 11:53:21');

DROP TABLE IF EXISTS `university_department`;
CREATE TABLE `university_department` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `university_id` bigint(100) unsigned NOT NULL,
  `department_id` bigint(100) unsigned NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `university_department` (`id`, `university_id`, `department_id`, `add_date`) VALUES
(1,	1,	1,	'2020-10-24 13:39:53'),
(2,	1,	2,	'2020-10-24 13:39:53'),
(3,	1,	3,	'2020-10-24 13:39:53'),
(4,	1,	4,	'2020-10-24 13:39:53'),
(10,	5,	10,	'2020-10-28 12:03:51'),
(9,	5,	9,	'2020-10-28 12:03:51'),
(12,	5,	12,	'2020-10-28 12:03:51'),
(29,	5,	11,	'2020-11-07 11:45:58'),
(13,	6,	13,	'2020-10-28 12:08:44'),
(14,	6,	14,	'2020-10-28 12:08:44'),
(15,	6,	1,	'2020-10-28 12:08:44'),
(16,	6,	12,	'2020-10-28 12:08:44'),
(17,	7,	16,	'2020-10-28 12:14:25'),
(18,	7,	17,	'2020-10-28 12:14:25'),
(19,	7,	2,	'2020-10-28 12:14:25'),
(20,	7,	18,	'2020-10-28 12:14:25'),
(21,	8,	19,	'2020-10-28 17:31:35'),
(22,	9,	20,	'2020-10-31 11:12:23'),
(23,	9,	21,	'2020-10-31 11:12:23'),
(25,	10,	23,	'2020-11-07 04:05:46'),
(26,	10,	24,	'2020-11-07 04:05:46'),
(27,	1,	25,	'2020-11-07 08:09:22'),
(28,	7,	26,	'2020-11-07 08:10:35'),
(31,	11,	27,	'2020-11-07 11:53:21'),
(32,	11,	28,	'2020-11-07 11:53:21'),
(33,	11,	21,	'2020-11-07 11:53:21');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `title` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign_up_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `title`, `first_name`, `last_name`, `email`, `password`, `photo_name`, `bio`, `sign_up_date`) VALUES
(1,	'Professor',	'Godwin',	'Pat',	'godwinpat@gmail.com',	'$2y$10$2hsDDlZriaFGma3xE62LQOy40NAtQ0gsoUVE.WYmimf3WfJQFXxyq',	'user1.jpg',	'Am a lecturer of Computer science and Cyber security. ',	'2020-10-19 19:08:58'),
(2,	'',	'John',	'Doe',	'jd@gmail.com',	'$2y$10$s8c7MmzR9pgiuplGzC1guObIpHYIy1oXyeuLb7Po7NnTXAuC1v8wO',	'user2.jpg',	'',	'2020-10-25 12:10:26'),
(3,	'Doctor',	'Yemi',	'Felakuti',	'yfk@gmail.com',	'$2y$10$64yGemeuIZ1L/Ayj6E.0mew4IQyjliQqCLhUgTxz2GkDlwJFlu.ca',	'user.jpg',	'This is the best way to be able to go kart wii sports',	'2020-10-29 12:19:20'),
(4,	'',	'Vivian',	'Uche',	'vivi@gmail.com',	'$2y$10$AKPzwKw0sMwGEQHCc/HCqebVe7RcYJLquRwkzCs3dvshVbr/nHTMO',	'user4.jpg',	'',	'2020-10-30 12:00:21'),
(5,	'Engineer',	'Benson',	'Greenwood',	'bg@yahoo.com',	'$2y$10$npHkJjJmjQPcW6V0BQ3ua.WK03pmVzfFWe9ogYjuOuH8Ie4eN4Bai',	'user.jpg',	'',	'2020-11-02 23:01:19');

DROP TABLE IF EXISTS `user_recover_password`;
CREATE TABLE `user_recover_password` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) unsigned NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` int(10) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_recover_password` (`id`, `user_id`, `code`, `used`, `date`) VALUES
(1,	1,	'81HM07',	1,	'2020-10-23 19:36:21'),
(2,	1,	'AJXFNM',	1,	'2020-10-23 19:37:39'),
(3,	1,	'JO1TAR',	0,	'2020-10-24 10:26:32'),
(4,	3,	'JYRQ2S',	1,	'2020-10-30 15:19:25'),
(5,	4,	'9YKOYP',	1,	'2020-11-04 13:18:34'),
(6,	4,	'H0M2B2',	1,	'2020-11-04 13:20:15'),
(7,	4,	'9UJZSP',	1,	'2020-11-04 14:01:53'),
(8,	4,	'BBNE51',	1,	'2020-11-04 14:02:28'),
(9,	4,	'4YS9EY',	0,	'2020-11-04 14:04:47');

DROP TABLE IF EXISTS `user_sign_in`;
CREATE TABLE `user_sign_in` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(100) unsigned NOT NULL,
  `code` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired` int(10) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_sign_in` (`id`, `user_id`, `code`, `expired`, `date`) VALUES
(1,	1,	'es8oN779FlD7/d8BblUMnxScSzRSV0fr',	0,	'2020-10-19 19:08:58'),
(2,	1,	'p7L5QGRuBjD0NO/lmFcggjd8nHLhmH2D',	1,	'2020-10-19 20:31:12'),
(3,	1,	'QcANBVjbU9+D7brFWmGmpCLAWdF+itI3',	0,	'2020-10-20 13:16:43'),
(4,	1,	'nUOZNJHhsF0ndp3MqvG6uSLYwomDXiFD',	1,	'2020-10-20 13:23:37'),
(17,	4,	'Oc6SDMXNXrDem1lzqfjD4XQ74rnMetkY',	0,	'2020-10-30 12:00:21'),
(16,	3,	'/4g5A8Onlz9/yGdjHp7Tsp6ru+2cwCHJ',	0,	'2020-10-29 12:19:20'),
(15,	2,	'Zrc5hQvJsky71pGQ5Tr8fl6khSKvsBrs',	0,	'2020-10-25 23:48:31'),
(18,	4,	'JEFVIxbdwc++PJJ+ZTl2uUeoQgYihV8S',	0,	'2020-10-30 13:00:42'),
(19,	5,	'UiYhnhV9ks03STdOdlP/BHWYMCLhajDM',	0,	'2020-11-02 23:01:19'),
(20,	1,	'/RP/hoGpD22AXZrtdlUDyY2bF9BEp68Y',	1,	'2020-11-03 06:13:03'),
(21,	1,	'Wn+VhGPS7K0kkoWlTmksBwxj75My9Lbh',	1,	'2020-11-04 14:12:01'),
(22,	3,	'7BH9VRBLpU38s5bZH+MHmGfthndJ2NYR',	1,	'2020-11-05 18:54:30'),
(23,	2,	'MjnXqwxRb9S6sJHaBSWYyKcok0S1IvRS',	1,	'2020-11-05 20:37:55'),
(24,	3,	'opMun5yyQGY913ZqztU8aMn24hjLXgxq',	1,	'2020-11-05 20:39:20'),
(25,	5,	'u8+e+KO2SBqkbcm9RVQsAZdteSdjccm3',	1,	'2020-11-06 01:05:40'),
(26,	2,	'cXQdQ5H8dNvD5DVQprR4m51IS+rjv5G6',	1,	'2020-11-06 01:08:26'),
(27,	3,	'u4J6KYxEGCCUnXBbj2aYHjtRI13Z7Xy2',	1,	'2020-11-06 10:45:55'),
(28,	4,	'JaBw4O/XWyLzJr/LARztJ+7plZ7A1G6w',	1,	'2020-11-06 13:12:47'),
(29,	2,	'Kr5NapBYifrNWGDGFNbVGR+1vR/0mBnH',	0,	'2020-11-06 13:42:32');

-- 2020-11-07 12:23:10
