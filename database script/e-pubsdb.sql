-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2025 at 07:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-pubsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `Contact` varchar(10) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `username`, `Contact`, `Password`) VALUES
(1, 'admin@nlsa.ac.za', '0711218836', 'admin'),
(2, 'admin1@nlsa.ac.za', '0711218836', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `cataloguer_id` int(11) DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `status` enum('Reviewed','Pending','Assigned') NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `book_id`, `cataloguer_id`, `assigned_by`, `status`, `assigned_at`, `completed_at`) VALUES
(26, 17, 15, NULL, 'Assigned', '2025-02-17 13:30:00', NULL),
(27, 18, 15, NULL, 'Assigned', '2025-02-17 13:31:46', NULL),
(28, 19, 16, NULL, 'Assigned', '2025-02-17 13:31:57', NULL);

--
-- Triggers `assignments`
--
DELIMITER $$
CREATE TRIGGER `after_assignments_delete` AFTER DELETE ON `assignments` FOR EACH ROW BEGIN
    -- Reset the book_informationsheet status
    UPDATE book_informationsheet
    SET status = 'Unassigned'
    WHERE Book_ID = OLD.book_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_assignments_insert` AFTER INSERT ON `assignments` FOR EACH ROW BEGIN
    -- Update the book_informationsheet table
    UPDATE book_informationsheet
    SET status = 'Assigned'
    WHERE Book_ID = NEW.book_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_assignments_update` AFTER UPDATE ON `assignments` FOR EACH ROW BEGIN
    -- Update the book_informationsheet status
    IF NEW.status IN ('Assigned', 'In Progress', 'Completed') THEN
        UPDATE book_informationsheet
        SET status = NEW.status
        WHERE Book_ID = NEW.book_id;
    END IF;

    -- Set completed_at timestamp if status is 'Completed'
    IF NEW.status = 'Completed' AND OLD.status != 'Completed' THEN
        UPDATE Assignments
        SET completed_at = NOW()
        WHERE id = NEW.id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `country` text NOT NULL,
  `bookName` varchar(255) NOT NULL,
  `authorFullName` varchar(255) NOT NULL,
  `authorAddress` text NOT NULL,
  `authorContact` varchar(15) NOT NULL,
  `authorEmail` varchar(255) NOT NULL,
  `publisherName` varchar(255) NOT NULL,
  `publisherAddress` text NOT NULL,
  `publisherContact` varchar(15) NOT NULL,
  `publisherEmail` varchar(255) NOT NULL,
  `format` enum('Print','Electronic','Both') NOT NULL,
  `publicationDate` date NOT NULL,
  `openAccess` enum('Yes','No') NOT NULL,
  `isbnRegistered` enum('Author') NOT NULL,
  `externalPlatforms` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `country`, `bookName`, `authorFullName`, `authorAddress`, `authorContact`, `authorEmail`, `publisherName`, `publisherAddress`, `publisherContact`, `publisherEmail`, `format`, `publicationDate`, `openAccess`, `isbnRegistered`, `externalPlatforms`, `created_at`) VALUES
(2, 'South Africa', 'Honour', 'William Smith', '2588 New Eerstrust Block D', '0713991678', 'nicolasmahlangu75@gmail.com', 'Molebogang Mahlangu', '1896 Orchards New Road Avenue', '0812346754', 'linkiesebola345@gmail.com', '', '2025-02-26', 'Yes', 'Author', 'Microsoft Azure', '2025-02-17 13:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `book_informationsheet`
--

CREATE TABLE `book_informationsheet` (
  `Book_ID` int(100) NOT NULL,
  `PublisherEmail` varchar(100) NOT NULL,
  `AuthorName` varchar(100) NOT NULL,
  `AuthorPseudonym` varchar(100) NOT NULL,
  `EditorName` varchar(100) NOT NULL,
  `PublicationTitle` varchar(100) NOT NULL,
  `BookEdition` varchar(100) NOT NULL,
  `Impression` varchar(100) NOT NULL,
  `Isbn` text NOT NULL,
  `SetISBN` varchar(20) NOT NULL,
  `PublisherName` varchar(50) NOT NULL,
  `PublisherAddress` varchar(100) NOT NULL,
  `PublicationYear` varchar(100) NOT NULL,
  `Price` double NOT NULL,
  `FictionOrNonFiction` varchar(50) NOT NULL,
  `Genre` varchar(100) NOT NULL,
  `PublicationLanguage` varchar(100) NOT NULL,
  `EnglishVersionTitle` varchar(100) NOT NULL,
  `FileUpload` varchar(255) NOT NULL,
  `downloads` int(11) DEFAULT 0,
  `status` enum('Unassigned','Pending','Assigned','Reviewed') DEFAULT 'Unassigned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_informationsheet`
--

INSERT INTO `book_informationsheet` (`Book_ID`, `PublisherEmail`, `AuthorName`, `AuthorPseudonym`, `EditorName`, `PublicationTitle`, `BookEdition`, `Impression`, `Isbn`, `SetISBN`, `PublisherName`, `PublisherAddress`, `PublicationYear`, `Price`, `FictionOrNonFiction`, `Genre`, `PublicationLanguage`, `EnglishVersionTitle`, `FileUpload`, `downloads`, `status`) VALUES
(17, 'n.mahlungu@outlook.com', 'Nicholas Makgoba', 'Molebogeng Mahlangu', 'niMk', 'The chronicles of Honour', '2nd', 'Knowledgeable', '2147483648765', '13 digits', 'Reitumetse Mahlangu', '1896 RDP Ext Hammanskraal 0407', '2018', 156.78, 'Fiction', 'Academic', 'English', 'The chronicles of Honour', '67b32e373a0e9_Contact Information (Responses) - Form responses 1.pdf', 1, 'Pending'),
(18, 'n.mahlungu@outlook.com', 'Nicholas Makgoba', 'Molebogeng Mahlangu', 'niMk', 'The chronicles of Humility', '2nd', 'Knowledgeable', '2147483648768', '13 digits', 'Reitumetse Mahlangu', '1896 RDP Ext Hammanskraal 0407', '2018', 156.78, 'Fiction', 'Academic', 'English', 'The chronicles of Humility', '67b32eeee49eb_Contact Information (Responses) - Form responses 1.pdf', 0, 'Reviewed'),
(19, 'n.mahlungu@outlook.com', 'Nicholas Makgoba', 'Molebogeng Mahlangu', 'niMk', 'The chronicles of Africa', '2nd', 'Knowledgeable', '2147483648764', '13 digits', 'Reitumetse Mahlangu', '1896 RDP Ext Hammanskraal 0407', '2018', 156.78, 'Fiction', 'Academic', 'English', 'The chronicles of Africa', '67b32f6baeb14_Contact Information (Responses) - Form responses 1.pdf', 0, 'Assigned'),
(20, 'n.mahlungu@outlook.com', 'Nicholas Makgoba', 'Molebogeng Mahlangu', 'niMk', 'The chronicles of Venecular', '2nd', 'Knowledgeable', '2147483648762', '13 digits', 'Reitumetse Mahlangu', '1896 RDP Ext Hammanskraal 0407', '2018', 156.78, 'Fiction', 'Academic', 'English', 'The chronicles of Venecular', '67b330cd814f0_Contact Information (Responses) - Form responses 1.pdf', 0, 'Unassigned');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('catalogue','reminder','alert') NOT NULL,
  `date` date DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cataloguer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `description`, `type`, `date`, `file_path`, `created_at`, `cataloguer_id`) VALUES
(8, 'New Task Assigned', 'A new task has been assigned for Book ID: 17.', '', '2025-02-17', NULL, '2025-02-17 13:30:00', 15),
(9, 'New Task Assigned', 'A new task has been assigned for Book ID: 18.', '', '2025-02-17', NULL, '2025-02-17 13:31:46', 15),
(10, 'New Task Assigned', 'A new task has been assigned for Book ID: 19.', '', '2025-02-17', NULL, '2025-02-17 13:31:57', 16);

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL,
  `country` text NOT NULL,
  `idNumber` varchar(13) NOT NULL,
  `bookName` varchar(255) NOT NULL,
  `authorFullName` varchar(255) NOT NULL,
  `authorAddress` text NOT NULL,
  `authorContact` varchar(15) NOT NULL,
  `authorEmail` varchar(255) NOT NULL,
  `publisherName` varchar(255) NOT NULL,
  `publisherAddress` text NOT NULL,
  `publisherContact` varchar(15) NOT NULL,
  `publisherEmail` varchar(255) NOT NULL,
  `format` enum('Print','Electronic','Both') NOT NULL,
  `publicationDate` date NOT NULL,
  `openAccess` enum('Yes','No') NOT NULL,
  `isbnRegistered` enum('Publisher') NOT NULL,
  `externalPlatforms` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `Contact` varchar(10) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `verify_status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `FullName`, `EmailAddress`, `Contact`, `Password`, `verify_token`, `verify_status`, `created_at`) VALUES
(15, 'Nicholus Mahlangu', 'nicholus.mahlangu@nlsa.ac.za', '0766180918', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, NULL),
(16, 'Reitumetse Mahlangu', 'n.mahlungu@outlook.com', '0711218836', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookk_id` (`book_id`),
  ADD KEY `cataloguer_id` (`cataloguer_id`),
  ADD KEY `assigned_by` (`assigned_by`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_informationsheet`
--
ALTER TABLE `book_informationsheet`
  ADD PRIMARY KEY (`Book_ID`),
  ADD KEY `idx_book_id` (`Book_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cataloguer_user` (`cataloguer_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `verify_token` (`verify_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_informationsheet`
--
ALTER TABLE `book_informationsheet`
  MODIFY `Book_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book_informationsheet` (`Book_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`cataloguer_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_3` FOREIGN KEY (`assigned_by`) REFERENCES `admin` (`Admin_ID`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_cataloguer_user` FOREIGN KEY (`cataloguer_id`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`cataloguer_id`) REFERENCES `users` (`User_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`cataloguer_id`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
