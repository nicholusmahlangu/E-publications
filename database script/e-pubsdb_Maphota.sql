-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 12:00 PM
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
(28, 19, 16, NULL, 'Assigned', '2025-02-17 13:31:57', NULL),
(29, 20, 22, NULL, 'Assigned', '2025-03-25 07:27:53', NULL),
(30, 21, 22, NULL, 'Assigned', '2025-03-25 08:50:43', NULL);

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
  `isbnRegistered` enum('Author') NOT NULL,
  `externalPlatforms` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `country`, `idNumber`, `bookName`, `authorFullName`, `authorAddress`, `authorContact`, `authorEmail`, `publisherName`, `publisherAddress`, `publisherContact`, `publisherEmail`, `format`, `publicationDate`, `openAccess`, `isbnRegistered`, `externalPlatforms`, `created_at`) VALUES
(2, 'South Africa', '', 'Honour', 'William Smith', '2588 New Eerstrust Block D', '0713991678', 'nicolasmahlangu75@gmail.com', 'Molebogang Mahlangu', '1896 Orchards New Road Avenue', '0812346754', 'linkiesebola345@gmail.com', '', '2025-02-26', 'Yes', 'Author', 'Microsoft Azure', '2025-02-17 13:41:45'),
(3, 'South Africa', '9112235417080', 'Sie', 'Siesie', 'gdftftd', '0699609675', 'gdd@gmail.com', 'Rank', 'gdftftd', '09999999', 'gdd@gmail.com', '', '2025-03-24', 'Yes', 'Author', 'Amazon', '2025-03-23 19:40:32');

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
  `status` enum('Unassigned','Pending','Assigned','Reviewed') DEFAULT 'Unassigned',
  `ISBNtype` enum('Electronic','Print','Mobi','Epub') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_informationsheet`
--

INSERT INTO `book_informationsheet` (`Book_ID`, `PublisherEmail`, `AuthorName`, `AuthorPseudonym`, `EditorName`, `PublicationTitle`, `BookEdition`, `Impression`, `Isbn`, `SetISBN`, `PublisherName`, `PublisherAddress`, `PublicationYear`, `Price`, `FictionOrNonFiction`, `Genre`, `PublicationLanguage`, `EnglishVersionTitle`, `FileUpload`, `downloads`, `status`, `ISBNtype`) VALUES
(17, 'n.mahlungu@outlook.com', 'Nicholas Makgoba', 'Molebogeng Mahlangu', 'niMk', 'The chronicles of Honour', '2nd', 'Knowledgeable', '2147483648765', '13 digits', 'Reitumetse Mahlangu', '1896 RDP Ext Hammanskraal 0407', '2018', 156.78, 'Fiction', 'Academic', 'English', 'The chronicles of Honour', '67b32e373a0e9_Contact Information (Responses) - Form responses 1.pdf', 1, 'Pending', 'Electronic'),
(18, 'n.mahlungu@outlook.com', 'Nicholas Makgoba', 'Molebogeng Mahlangu', 'niMk', 'The chronicles of Humility', '2nd', 'Knowledgeable', '2147483648768', '13 digits', 'Reitumetse Mahlangu', '1896 RDP Ext Hammanskraal 0407', '2018', 156.78, 'Fiction', 'Academic', 'English', 'The chronicles of Humility', '67b32eeee49eb_Contact Information (Responses) - Form responses 1.pdf', 0, 'Reviewed', 'Electronic'),
(19, 'n.mahlungu@outlook.com', 'Nicholas Makgoba', 'Molebogeng Mahlangu', 'niMk', 'The chronicles of Africa', '2nd', 'Knowledgeable', '2147483648764', '13 digits', 'Reitumetse Mahlangu', '1896 RDP Ext Hammanskraal 0407', '2018', 156.78, 'Fiction', 'Academic', 'English', 'The chronicles of Africa', '67b32f6baeb14_Contact Information (Responses) - Form responses 1.pdf', 0, 'Assigned', 'Electronic'),
(20, 'n.mahlungu@outlook.com', 'Nicholas Makgoba', 'Molebogeng Mahlangu', 'niMk', 'The chronicles of Venecular', '2nd', 'Knowledgeable', '2147483648762', '13 digits', 'Reitumetse Mahlangu', '1896 RDP Ext Hammanskraal 0407', '2018', 156.78, 'Fiction', 'Academic', 'English', 'The chronicles of Venecular', '67b330cd814f0_Contact Information (Responses) - Form responses 1.pdf', 0, 'Assigned', 'Electronic'),
(21, 'maphota@nlsa.ac.za', 'Maphota', 'Sie', 'jjbjbd', 'Winners circle', 'dhhd', 'hdgygd', '1234567891234', 'set', 'gfdtftd', 'gdftftd', '2012', 10, 'Fiction', 'fhghgf', 'hfgyf', 'fvgf', '67e26da19a3db_Week four November 2024 Timesheet.pdf', 0, 'Assigned', 'Electronic'),
(22, 'Maphota@nlsa.ac.za', 'Sie', 'eric', 'jjbjbd', 'Winners circle', 'Limited', 'Yes', '1111111111111', '5', 'Nick', 'PTA', '2050', 1e23, 'Fiction', 'Action', 'Tsonga', 'fvgf', '67e3ef91d2cd3_Week four November 2024 Timesheet.pdf', 0, 'Unassigned', 'Print'),
(23, 'Maphota@nlsa.ac.za', 'Sie', 'eric', 'jjbjbd', 'Winners circle', 'Limited', 'Yes', '1111111111112', '5', 'Nick', 'PTA', '2000', 1e23, 'Fiction', 'Action', 'Tsonga', 'must not require this field', '67e3f0240001d_Week four November 2024 Timesheet.pdf', 0, 'Unassigned', 'Electronic');

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
(10, 'New Task Assigned', 'A new task has been assigned for Book ID: 19.', '', '2025-02-17', NULL, '2025-02-17 13:31:57', 16),
(11, 'New Task Assigned', 'A new task has been assigned for Book ID: 20.', '', '2025-03-25', NULL, '2025-03-25 07:27:54', 22),
(12, 'New Task Assigned', 'A new task has been assigned for Book ID: 21.', '', '2025-03-25', NULL, '2025-03-25 08:50:43', 22);

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
(16, 'Reitumetse Mahlangu', 'n.mahlungu@outlook.com', '0711218836', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, NULL),
(18, 'Maphota Shiburi', 'Sie@nlsa.ac.za', '0699609675', '$2y$10$yyc6CbQWneT/kGbGQghD0e4qUMPh1mjga47sO25pVaoh/nehscKiK', NULL, NULL, NULL),
(19, 'Maphota Shiburi', 'Siemon@nlsa.ac.za', '0699609675', '$2y$10$Ophbof2TMNVIi6AK.VsFw.V2ysdx/3lEI5ZY1yy51DXKMUZ1dMUq2', NULL, NULL, NULL),
(20, 'Maphota Shiburi', 'SiemonShiburi@nlsa.ac.za', '0699609675', '$2y$10$fhQ0z.ZNxHtBpByRw9FcpORtvFwp2WZeEWzMkA62ro38PfJi38UKm', NULL, NULL, NULL),
(21, 'Maphota Shiburi', 'Shiburi@nlsa.ac.za', '0699609675', '$2y$10$B3HVE5tXvpzPuZmTFSd7weZ6fhxU4nfaamAASR81uEfoT5zbU6fZq', NULL, NULL, NULL),
(22, 'Simon', 'Shiburi.Maphota@nlsa.ac.za', '0699609675', '$2y$10$D02aFViomjLn4wMMJbastOMKeoLV1kw5kFj7i73HnzHGzpWrwdG6G', NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `book_informationsheet`
--
ALTER TABLE `book_informationsheet`
  MODIFY `Book_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
