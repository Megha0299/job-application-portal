-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2026 at 09:40 AM
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
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `address` text NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `willing_to_relocate` enum('Yes','No') NOT NULL,
  `highest_qualification` varchar(100) NOT NULL,
  `institution_name` varchar(255) NOT NULL,
  `graduation_year` year(4) NOT NULL,
  `cgpa_percentage` varchar(10) NOT NULL,
  `technical_skills` text NOT NULL,
  `certifications` text DEFAULT NULL,
  `total_experience` varchar(50) NOT NULL,
  `employment_status` enum('Employed','Unemployed','Notice Period','Student/Fresher') NOT NULL,
  `previous_organization` varchar(255) DEFAULT NULL,
  `job_title` varchar(150) DEFAULT NULL,
  `skills_summary` text NOT NULL,
  `resume_file_path` varchar(255) NOT NULL,
  `declaration_accepted` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `full_name`, `email`, `mobile_number`, `date_of_birth`, `gender`, `address`, `nationality`, `willing_to_relocate`, `highest_qualification`, `institution_name`, `graduation_year`, `cgpa_percentage`, `technical_skills`, `certifications`, `total_experience`, `employment_status`, `previous_organization`, `job_title`, `skills_summary`, `resume_file_path`, `declaration_accepted`, `created_at`) VALUES
(1, 'Test Candidate', 'test@example.com', '9876543210', '1998-05-15', 'Female', '123 Main Street', 'Indian', 'Yes', 'B.Tech', 'ABC University', '2020', '8.5', 'PHP, MySQL, JavaScript', 'Web Development Basics', '1-3 Years', 'Employed', 'Tech Corp', 'Junior Developer', 'Experienced in backend web development.', 'uploads/resumes/dummy_resume.pdf', 1, '2026-10-08 10:28:07'),
(2, 'Megha_sureshkumar', 'meghasureshkumar01@gmail.com', '9634856215', '2005-02-02', 'Female', 'gandhi street', 'Indian', 'Yes', 'Bachelor\'s Degree', 'Madurai Kamaraj University', '2026', '7.8', 'PHP, MySQL, JavaScript, HTML/CSS, Python', '', 'Fresher', 'Student/Fresher', '', '', 'i have a done proects in ml', 'uploads/resumes/98a25a35e22f8f68c653d9d4e5ffe8c7.pdf', 1, '2026-10-08 11:00:22'),
(3, 'Megha_sureshkumar', 'meghasureshkumar01@gmail.com', '9634856215', '2005-02-02', 'Female', 'gs v', 'Indian', 'Yes', 'Bachelor\'s Degree', 'Madurai Kamaraj University', '2026', '7.8', 'PHP, MySQL', '', 'Fresher', 'Student/Fresher', '', '', 'vbsf', 'uploads/resumes/202fc30e18229adf77cc8c703014f7ed.pdf', 1, '2026-10-08 11:06:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
