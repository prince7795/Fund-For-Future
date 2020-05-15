-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2020 at 06:05 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vidyadan`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_performance`
--

CREATE TABLE `academic_performance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `academic_year` varchar(50) DEFAULT NULL,
  `marks_type` varchar(50) DEFAULT NULL,
  `sem1_score` varchar(20) DEFAULT NULL,
  `sem2_score` varchar(20) DEFAULT NULL,
  `sem1_kts` varchar(10) DEFAULT NULL,
  `sem2_kts` varchar(10) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edited_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_performance`
--

INSERT INTO `academic_performance` (`id`, `student_id`, `course`, `academic_year`, `marks_type`, `sem1_score`, `sem2_score`, `sem1_kts`, `sem2_kts`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edited_date`) VALUES
(1, 1, 'Engineering', '2016-2017', 'Pointer', '7.0', '0', '0', '2', 2, '2018/06/27 01:01:46 PM', 2, '2018/07/12 05:05:17 PM'),
(2, 1, 'Engineering', '2016-2017', 'Pointer', '0', '6.7', '2', '0', 2, '2018/06/27 01:02:19 PM', 2, '2018/07/12 05:05:37 PM'),
(3, 1, 'Engineering', '2017-2018', 'Pointer', '6.1', '6.7', '0', '0', 2, '2018/06/27 01:04:22 PM', NULL, NULL),
(4, 2, 'Engineering', '2016-2017', 'Pointer', '0', '0', '2', '3', 2, '2018/06/29 01:53:44 PM', NULL, NULL),
(5, 2, 'Engineering', '2016-2017', 'Pointer', '6.9', '8.1', '0', '0', 2, '2018/06/29 01:53:59 PM', NULL, NULL),
(6, 2, 'Engineering', '2015-2016', 'Pointer', '7', '7.5', '0', '0', 2, '2018/06/29 01:55:12 PM', NULL, NULL),
(7, 1, 'Diploma', '2015-2016', 'Percent', '50', '60', '0', '0', 2, '2018/06/29 03:57:40 PM', NULL, NULL),
(8, 3, 'Engineering', '2016-2017', 'Pointer', '6.7', '0', '0', '2', 2, '2018/06/29 04:07:32 PM', NULL, NULL),
(10, 6, 'Dip. Engg 1st', '2017-2018', 'Class', 'I st', '0', '1', '', 7, '2018/07/26 05:38:59 PM', 7, '2018/07/26 05:39:54 PM');

-- --------------------------------------------------------

--
-- Table structure for table `address_details`
--

CREATE TABLE `address_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `permanent_address` varchar(200) DEFAULT NULL,
  `permanent_landmark` varchar(100) DEFAULT NULL,
  `permanent_city` varchar(50) DEFAULT NULL,
  `permanent_taluka` varchar(50) DEFAULT NULL,
  `permanent_state` varchar(50) DEFAULT NULL,
  `permanent_pincode` varchar(20) DEFAULT NULL,
  `present_address` varchar(200) DEFAULT NULL,
  `present_landmark` varchar(100) DEFAULT NULL,
  `present_city` varchar(50) DEFAULT NULL,
  `present_taluka` varchar(50) DEFAULT NULL,
  `present_state` varchar(50) DEFAULT NULL,
  `present_pincode` varchar(20) DEFAULT NULL,
  `submited_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address_details`
--

INSERT INTO `address_details` (`id`, `student_id`, `permanent_address`, `permanent_landmark`, `permanent_city`, `permanent_taluka`, `permanent_state`, `permanent_pincode`, `present_address`, `present_landmark`, `present_city`, `present_taluka`, `present_state`, `present_pincode`, `submited_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, 'thane', 'thane', 'thane', 'thane', 'maharashtra', '400607', 'thane', 'thane', 'thane', 'thane', 'maharashtra', '400607', 2, '2018/06/26 06:25:36 PM', 2, '2018/07/11 04:33:09 PM'),
(2, 2, 'nerul', 'nerul', 'navi mumbai', 'navi mumbai', 'maharashtra', '400700', 'nerul', 'nerul', 'navi mumbai', 'navi mumbai', 'maharashtra', '400700', 2, '2018/06/26 06:26:58 PM', NULL, NULL),
(3, 3, 'ghatkopar', 'ghatkopar', 'mumbai', 'mumbai', 'maharashtra', '400001', 'ghatkopar', 'ghatkopar', 'mumbai', 'mumbai', 'm', '400001', 2, '2018/06/26 06:29:42 PM', NULL, NULL),
(6, 6, 'BLDG NO 4, SOLITAIRE PARK, CHAKALA, ANDHERI (W)', 'MAHARASHTRA', 'MUMBAI', 'MUMBAI', 'Maharashtra', '411033', 'Jayawant apt, plot no 69, Flat no B-22, Prem lok park', 'Maharashtra', 'Chinchwad, Pune', 'mumbi', 'MAHARASHTRA', '400093', 2, '2018/07/26 03:21:24 PM', 2, '2018/07/26 03:22:18 PM');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `type` enum('superadmin','admin','kp') NOT NULL DEFAULT 'admin',
  `first_name` varchar(30) DEFAULT NULL,
  `middle_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `kp_code` varchar(30) DEFAULT NULL,
  `vsm_branch` varchar(50) DEFAULT NULL,
  `dob` varchar(30) DEFAULT NULL,
  `permanent_address` varchar(200) DEFAULT NULL,
  `current_address` varchar(200) DEFAULT NULL,
  `alternate_email` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `alternative_number` varchar(30) DEFAULT NULL,
  `academic_qualification` varchar(50) DEFAULT NULL,
  `academic_specialization` varchar(50) DEFAULT NULL,
  `occupation` varchar(50) DEFAULT NULL,
  `additional_skills` varchar(500) DEFAULT NULL,
  `worked_in_ngo` varchar(30) DEFAULT NULL,
  `ngo_explanation` varchar(500) DEFAULT NULL,
  `meeting_location` varchar(50) DEFAULT NULL,
  `mentor_voluneer` varchar(50) DEFAULT NULL,
  `overall_governance` varchar(1000) DEFAULT NULL,
  `overall_administration` varchar(1000) DEFAULT NULL,
  `academic` varchar(1000) DEFAULT NULL,
  `accounts` varchar(1000) DEFAULT NULL,
  `event_management` varchar(1000) DEFAULT NULL,
  `public_relation` varchar(1000) DEFAULT NULL,
  `db_preparation` varchar(1000) DEFAULT NULL,
  `reports` varchar(1000) DEFAULT NULL,
  `how_know_vsm` varchar(50) DEFAULT NULL,
  `how_know_vsm_explanation` varchar(500) DEFAULT NULL,
  `any_other_info` varchar(500) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `type`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `kp_code`, `vsm_branch`, `dob`, `permanent_address`, `current_address`, `alternate_email`, `mobile_number`, `alternative_number`, `academic_qualification`, `academic_specialization`, `occupation`, `additional_skills`, `worked_in_ngo`, `ngo_explanation`, `meeting_location`, `mentor_voluneer`, `overall_governance`, `overall_administration`, `academic`, `accounts`, `event_management`, `public_relation`, `db_preparation`, `reports`, `how_know_vsm`, `how_know_vsm_explanation`, `any_other_info`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 'superadmin', 'superadmin', NULL, NULL, 'superadmin@vsm.com', '123456', NULL, 'Thane', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'admin', 'admin', NULL, NULL, 'admin@vsm.com', '123456', NULL, 'Thane', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'kp', 'test KP', NULL, NULL, 'kp@vsm.com', '123456', NULL, 'Thane', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'kp', 'nilesh', 'shamrao', 'khamkar', 'nileshkhmkr@gmail.com', '123456', 'kp123', 'Thane', '2018/06/30', 'thane', 'thane', '', '123456789', '123456789', 'Graduate', 'Mathematics', 'Service', 'NA', 'Yes', 'in annadan sahayyak mandal', 'Thane', 'Volunteer', 'Revisit Mission & Vision statement, Impact assessment data', 'General Admin (Office), Helpdesk functions', 'Streamwise career counselling, Library, Internships/Jobs for VSM Students', 'Monthly Accounts, Student Expenses, Fund Raising', 'All Calendar events, Monthly meetings, Annual Vardhapan Diwas', 'Digital Media, Print Media, Website Maint & Updates', 'Volunteer, Donor, Students (Present & Alumni)', 'House Visit Reports, Monthly meetings minutes, Monthly Ahawal', 'Through reference', '', 'NA', 2, '2018/06/30 01:15:41 PM', 2, '2018/07/13 03:27:15 PM'),
(5, 'kp', 'pranav', '', 'pujare', 'pranav@gmail.com', '123456', 'vsm321', 'Pune', '2018/06/19', 'nerul', 'nerul', 'pranav@gmail.com', '123456789', '', 'PHD', 'Science', 'Govt. Employee', 'NA', 'No', 'in vastradan sahayyak mandal', 'Pune', 'Mentor', 'Revisit Mission & Vision statement, Impact assessment data', 'Helpdesk functions', 'Library, Internships/Jobs for VSM Students', 'Student Expenses', 'Monthly meetings, Annual Vardhapan Diwas', 'Write ups as per media specs, Communication with stake holders', 'Volunteer', 'House Visit Reports, Monthly meetings minutes', 'Through print media', '', '', 2, '2018/06/30 01:18:41 PM', NULL, NULL),
(7, 'kp', 'ashutosh', 'zzzz', 'Gadgil', 'agadgil@hotmail.com', '123456', '', 'Borivili', '2018/07/26', 'BLDG NO 4, SOLITAIRE PARK\r\nCHAKALA, ANDHERI (e)', 'BLDG NO 4, SOLITAIRE PARK\r\nCHAKALA, ANDHERI (e)', 'agadgil@hotmail.com', '2266572759', '', 'Graduate', 'Mathematics', 'Retired', 'IT & admin', 'Yes', 'Mmb of rotary bvi', 'Borivili', 'Mentor', 'SOPs, Policies, Flow Charts, Impact assessment data', 'General Admin (Office)', 'Streamwise career counselling', 'Fund Raising', 'Monthly meetings', 'Website Maint & Updates', 'Students (Present & Alumni)', 'House Visit Reports', 'Through reference', '', 'tkz', 2, '2018/07/26 04:56:05 PM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `annual_reports`
--

CREATE TABLE `annual_reports` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `year` varchar(30) DEFAULT NULL,
  `earn_and_learn` varchar(50) DEFAULT NULL,
  `earn_and_learn_explanation` varchar(500) DEFAULT NULL,
  `any_vsm_work` varchar(1000) DEFAULT NULL,
  `activity_outstation_student` varchar(1000) DEFAULT NULL,
  `strengths` varchar(500) DEFAULT NULL,
  `weekness` varchar(500) DEFAULT NULL,
  `need_help_in` varchar(500) DEFAULT NULL,
  `can_offer_help_in` varchar(500) DEFAULT NULL,
  `future_volunteer` varchar(30) DEFAULT NULL,
  `continuation_discontinuation` varchar(500) DEFAULT NULL,
  `final_conclusion` varchar(50) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `annual_reports`
--

INSERT INTO `annual_reports` (`id`, `student_id`, `year`, `earn_and_learn`, `earn_and_learn_explanation`, `any_vsm_work`, `activity_outstation_student`, `strengths`, `weekness`, `need_help_in`, `can_offer_help_in`, `future_volunteer`, `continuation_discontinuation`, `final_conclusion`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, '2018', 'Yes', 'works in apptroid as an intern', 'Yes, he does all the documentation works for new  student registartions', 'NA', 'fast learner', 'NA', 'frameworks', 'coding', 'Yes', 'continue', 'Continue with special attention', 5, '2018/06/30 04:18:47 PM', 2, '2018/07/13 12:39:48 PM'),
(2, 2, '2018', 'Yes', 'works in apptroid', 'no', 'yes', 'nice photographer', 'NA', 'api development', 'android app devlopment', 'Yes', 'continue', 'Continue', 4, '2018/06/30 05:21:49 PM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assistance_details`
--

CREATE TABLE `assistance_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `institution_name` varchar(200) DEFAULT NULL,
  `contact_number` varchar(30) DEFAULT NULL,
  `assistance_type` varchar(50) DEFAULT NULL,
  `academic_year` varchar(50) DEFAULT NULL,
  `value` float(10,2) DEFAULT '0.00',
  `remark` varchar(200) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assistance_details`
--

INSERT INTO `assistance_details` (`id`, `student_id`, `institution_name`, `contact_number`, `assistance_type`, `academic_year`, `value`, `remark`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, 'Apptroid Technology Pvt. Ltd.', '0123456789', 'Books', '2015-2016', 5000.00, 'Some nice remark or explanation about apptroid', 2, '2018/06/27 01:31:31 PM', 2, '2018/07/12 04:14:02 PM'),
(2, 1, 'Tata Consultancy Services', '0123456789', 'Tutions', '2015-2016', 10000.00, 'remark or explanation about TCS', 2, '2018/06/27 01:32:45 PM', 2, '2018/07/12 04:15:08 PM'),
(3, 1, 'Tata Consultancy Services', '0123456789', 'Fees', '2015-2016', 50000.00, NULL, 2, '2018/06/27 01:33:07 PM', NULL, NULL),
(4, 2, 'Tata Consultancy Services', '0123465789', 'Fees', '2016-2017', 100000.00, 'Some nice remark or explanation about TCS', 2, '2018/06/28 12:17:50 PM', NULL, NULL),
(7, 6, 'Tata Consultancy Services', '66572569', 'Fees', '2017-2018', 12000.00, 'partial assistance bnn', 2, '2018/07/26 04:09:30 PM', 2, '2018/07/26 04:10:02 PM');

-- --------------------------------------------------------

--
-- Table structure for table `budgeted_expenses`
--

CREATE TABLE `budgeted_expenses` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `academic_year` varchar(30) DEFAULT NULL,
  `expense_criteria` varchar(50) DEFAULT NULL,
  `budgeted_expenses` float(10,2) DEFAULT '0.00',
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edit_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `budgeted_expenses`
--

INSERT INTO `budgeted_expenses` (`id`, `student_id`, `academic_year`, `expense_criteria`, `budgeted_expenses`, `submitted_by_admin`, `submission_date`, `last_edit_by`, `last_edit_date`) VALUES
(1, 1, '2015-2016', 'Lodging & Boarding', 20000.00, 2, '2018/06/27 03:26:31 PM', NULL, NULL),
(2, 1, '2015-2016', 'Annual Fees', 100000.00, 2, '2018/06/27 03:26:52 PM', NULL, NULL),
(3, 1, '2015-2016', 'Study Material', 5000.00, 2, '2018/06/27 03:27:13 PM', NULL, NULL),
(4, 1, '2015-2016', 'Other', 5000.00, 2, '2018/06/27 03:27:32 PM', 2, '2018/07/12 06:18:19 PM'),
(5, 2, '2017-2018', 'Annual Fees', 25000.00, 2, '2018/06/28 06:28:54 PM', NULL, NULL),
(6, 2, '2017-2018', 'Annual Fees', 2333.00, 2, '2018/06/28 06:29:01 PM', NULL, NULL),
(7, 2, '2017-2018', 'Annual Fees', 366135.00, 2, '2018/06/28 06:29:08 PM', NULL, NULL),
(9, 6, '2018-2019', 'Lodging & Boarding', 4000.00, 2, '2018/07/26 04:29:07 PM', NULL, NULL),
(10, 6, '2018-2019', 'Annual Fees', 23000.00, 2, '2018/07/26 04:30:23 PM', NULL, NULL),
(11, 1, '2019-2020', 'Conveyance', 1000.00, 1, '2020/05/05 09:02:33 PM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `career_plan`
--

CREATE TABLE `career_plan` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `career_plan` varchar(200) DEFAULT NULL,
  `career_explanation` varchar(500) DEFAULT NULL,
  `earn_and_learn` varchar(50) DEFAULT NULL,
  `earn_and_learn_explanation` varchar(500) DEFAULT NULL,
  `parent_contribution` varchar(50) DEFAULT NULL,
  `parent_contribution_explanation` varchar(500) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `career_plan`
--

INSERT INTO `career_plan` (`id`, `student_id`, `career_plan`, `career_explanation`, `earn_and_learn`, `earn_and_learn_explanation`, `parent_contribution`, `parent_contribution_explanation`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, 'Engineering', 'IT engineering from pillai\'s college, panvel', 'Yes', 'He will work in apptroid as a part time intern tester for rs.5000 per month', 'No', '', 2, '2018/06/27 12:00:23 PM', 2, '2018/07/12 05:55:42 PM'),
(2, 6, 'IT professional', 'wd like to b software engg', 'Yes', 'will be working part time, parents will also help', 'Yes', 'will bear 15% of fees', 2, '2018/07/26 04:13:56 PM', 2, '2018/07/26 04:20:46 PM');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `student_email` varchar(50) DEFAULT NULL,
  `student_mobile` varchar(20) DEFAULT NULL,
  `student_landline` varchar(30) DEFAULT NULL,
  `parent_email` varchar(50) DEFAULT NULL,
  `parent_mobile` varchar(20) DEFAULT NULL,
  `parent_landline` varchar(30) DEFAULT NULL,
  `alternate_email` varchar(50) DEFAULT NULL,
  `alternate_mobile` varchar(20) DEFAULT NULL,
  `alternate_landline` varchar(30) DEFAULT NULL,
  `neighbour_email` varchar(50) DEFAULT NULL,
  `neighbour_mobile` varchar(20) DEFAULT NULL,
  `neighbour_landline` varchar(30) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`id`, `student_id`, `student_email`, `student_mobile`, `student_landline`, `parent_email`, `parent_mobile`, `parent_landline`, `alternate_email`, `alternate_mobile`, `alternate_landline`, `neighbour_email`, `neighbour_mobile`, `neighbour_landline`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, 'nilesh@apptroid.com', '123456789', '0123456789', 'nilesh@apptroid.com', '0123456789', '0123456789', 'nilesh@apptroid.com', '0123456789', '0123456789', 'nilesh@apptroid.com', '0123456789', '0123456789', 2, '2018/06/27 06:57:50 AM', 2, '2018/07/11 05:18:02 PM'),
(2, 2, 'pranav@apptroid.com', '0123456789', '0123456789', 'pranav@apptroid.com', '0123456789', '0123456789', 'pranav@apptroid.com', '0123456789', '0123456789', 'pranav@apptroid.com', '0123456789', '0123456789', 2, '2018/06/27 06:59:44 AM', NULL, ''),
(7, 6, 'agadgil@hotmail.com', '9987505311', '', 'ss@gmail.com', '8765432199', '1234567899', '', '', '', '', '', '', 2, '2018/07/26 03:24:16 PM', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `decoding`
--

CREATE TABLE `decoding` (
  `id` int(11) NOT NULL,
  `specifier` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `decoding`
--

INSERT INTO `decoding` (`id`, `specifier`, `value`, `description`) VALUES
(1, 'academic-year', '2015-2016', '2015-2016'),
(2, 'academic-year', '2016-2017', '2016-2017'),
(3, 'academic-year', '2017-2018', '2017-2018'),
(4, 'academic-year', '2018-2019', '2018-2019'),
(5, 'academic-year', '2019-2020', '2019-2020'),
(6, 'caste', 'Open', 'Open'),
(7, 'caste', 'SC', 'SC'),
(8, 'caste', 'OBC', 'OBC'),
(9, 'caste', 'ST', 'ST'),
(10, 'caste', 'NT', 'NT'),
(11, 'document_type', 'Adhar card', 'Adhar card'),
(12, 'document_type', 'PAN card', 'PAN card'),
(13, 'document_type', 'Caste certificate', 'Caste certificate'),
(14, 'document_type', 'Voting card', 'Voting card'),
(15, 'document_type', 'Ration card', 'Ration card'),
(16, 'document_type', 'Driving licence', 'Driving licence'),
(17, 'document_type', 'Marksheet', 'Marksheet'),
(18, 'document_type', 'Leaving certificate', 'Leaving certificate'),
(19, 'document_type', 'Birth certificate', 'Birth certificate'),
(20, 'document_type', 'Other certificate', 'Other certificate'),
(21, 'document_type', 'Domicile certificate', 'Domicile certificate'),
(22, 'occupation', 'Service', 'Service'),
(23, 'occupation', 'Govt. Employee', 'Govt. Employee'),
(24, 'occupation', 'House-wife/husband', 'House-wife/husband'),
(25, 'occupation', 'Retired', 'Retired'),
(26, 'occupation', 'Self Employed', 'Self Employed'),
(27, 'qualification', '7th', '7th'),
(28, 'qualification', '10th', '10th'),
(29, 'qualification', 'Diploma', 'Diploma'),
(30, 'qualification', '12th', '12th'),
(31, 'qualification', 'Graduate', 'Graduate'),
(32, 'qualification', 'Post Graduate', 'Post Graduate'),
(33, 'qualification', 'PHD', 'PHD'),
(34, 'qualification', 'Illiterate', 'Illiterate'),
(35, 'qualification', '5th', '5th'),
(36, 'referral_type', 'Relative', 'Relative'),
(37, 'referral_type', 'Friend', 'Friend'),
(38, 'referral_type', 'Internet', 'Internet'),
(39, 'referral_type', 'Teacher / Principal', 'Teacher / Principal'),
(40, 'referral_type', 'Other', 'Other'),
(41, 'vsm-branch', 'Thane', 'Thane'),
(42, 'vsm-branch', 'Pune', 'Pune'),
(43, 'vsm-branch', 'Nagpur', 'Nagpur'),
(44, 'vsm-branch', 'Borivili', 'Borivili'),
(45, 'vsm-branch', 'Shahapur', 'Shahapur'),
(46, 'assistance_type', 'Fees', 'Fees'),
(47, 'assistance_type', 'Tutions', 'Tutions'),
(48, 'assistance_type', 'Books', 'Books'),
(49, 'institution', 'Apptroid Technology Pvt. Ltd.', 'Apptroid Technology Pvt. Ltd.'),
(50, 'institution', 'Tata Consultancy Services', 'Tata Consultancy Services'),
(51, 'organisation', 'Mahendra', 'Mahendra'),
(52, 'organisation', 'Brahman Seva Sangh', 'Brahman Seva Sangh'),
(53, 'academic', 'Streamwise career counselling', 'Streamwise career counselling'),
(54, 'academic', 'Library', 'Library'),
(55, 'academic', 'Internships/Jobs for VSM Students', 'Internships/Jobs for VSM Students'),
(56, 'academic', 'Workshops', 'Workshops'),
(57, 'academic', 'Data of Scholarships available', 'Data of Scholarships available'),
(58, 'academic_specialization', 'Mathematics', 'Mathematics'),
(59, 'academic_specialization', 'Science', 'Science'),
(60, 'academic_specialization', 'History', 'History'),
(61, 'academic_specialization', 'English', 'English'),
(62, 'academic_specialization', 'Commerce', 'Commerce'),
(63, 'academic_specialization', 'Arts', 'Arts'),
(64, 'accounts', 'Monthly Accounts', 'Monthly Accounts'),
(65, 'accounts', 'Student Expenses', 'Student Expenses'),
(66, 'accounts', 'Fund Raising', 'Fund Raising'),
(67, 'accounts', 'VSM Budget', 'VSM Budget'),
(68, 'accounts', 'Student Budget', 'Student Budget'),
(69, 'accounts', 'Annual Report for Donors', 'Annual Report for Donors'),
(70, 'accounts', 'Audit Handling', 'Audit Handling'),
(71, 'accounts', 'Audit Handling', 'Audit Handling'),
(72, 'db-preparation', 'Volunteer', 'Volunteer'),
(73, 'db-preparation', 'Donor', 'Donor'),
(74, 'db-preparation', 'Students (Present & Alumni)', 'Students (Present & Alumni)'),
(75, 'db-preparation', 'Project specific databases', 'Project specific databases'),
(76, 'db-preparation', 'Scholarship database', 'Scholarship database'),
(77, 'db-preparation', 'Career guidance databases', 'Career guidance databases'),
(78, 'db-preparation', 'Friends of VSM', 'Friends of VSM'),
(79, 'event_management ', 'All Calendar events', 'All Calendar events'),
(80, 'event_management ', 'Monthly meetings', 'Monthly meetings'),
(81, 'event_management ', 'Annual Vardhapan Diwas', 'Annual Vardhapan Diwas'),
(82, 'event_management ', 'Event Expenses', 'Event Expenses'),
(83, 'overall_admin', 'General Admin (Office)', 'General Admin (Office)'),
(84, 'overall_admin', 'Helpdesk functions', 'Helpdesk functions'),
(85, 'overall_admin', 'Hostel Management incl. property maintenance, budget & expenses', 'Hostel Management incl. property maintenance, budget & expenses'),
(86, 'overall_admin', 'Archives & Documentation incl. photos, Audio Visuals etc', 'Archives & Documentation incl. photos, Audio Visuals etc'),
(87, 'overall_admin', 'Admission & Delisting Procedure', 'Admission & Delisting Procedure'),
(88, 'overall_admin', 'Issue of recommendation letter', 'Issue of recommendation letter'),
(89, 'overall_admin', 'Managing meetings at Khopat office', 'Managing meetings at Khopat office'),
(90, 'overall_admin', 'Arranging & Booking external venues for VSM meetings & Workshops', 'Arranging & Booking external venues for VSM meetings & Workshops'),
(91, 'overall_admin', 'List of Govt. Hostels available for Adiwasis, SC/ST, OBCs students', 'List of Govt. Hostels available for Adiwasis, SC/ST, OBCs students'),
(92, 'overall_governance', 'SOPs, Policies, Flow Charts', 'SOPs, Policies, Flow Charts'),
(93, 'overall_governance', 'Revisit Mission & Vision statement', 'Revisit Mission & Vision statement'),
(94, 'overall_governance', 'Impact assessment data', 'Impact assessment data'),
(95, 'overall_governance', 'CSR presentation', 'CSR presentation'),
(96, 'overall_governance', 'Admission Criteria/Guidelines', 'Admission Criteria/Guidelines'),
(97, 'overall_governance', 'Designing Internship Modules (for outside students)', 'Designing Internship Modules (for outside students)'),
(98, 'overall_governance', 'Logo designing', 'Logo designing'),
(99, 'overall_governance', 'Guidelines on formation of committees/teams & tenures', 'Guidelines on formation of committees/teams & tenures'),
(100, 'overall_governance', 'Performance Evaluation', 'Performance Evaluation'),
(101, 'overall_governance', 'Yearly Event Calendar', 'Yearly Event Calendar'),
(102, 'public-social', 'Digital Media', 'Digital Media'),
(103, 'public-social', 'Print Media', 'Print Media'),
(104, 'public-social', 'Website Maint & Updates', 'Website Maint & Updates'),
(105, 'public-social', 'Write ups as per media specs', 'Write ups as per media specs'),
(106, 'public-social', 'Communication with stake holders', 'Communication with stake holders'),
(107, 'public-social', 'VSM Bulletin', 'VSM Bulletin'),
(108, 'reports', 'House Visit Reports', 'House Visit Reports'),
(109, 'reports', 'Monthly meetings minutes', 'Monthly meetings minutes'),
(110, 'reports', 'Monthly Ahawal', 'Monthly Ahawal'),
(111, 'reports', 'Annual Report (Month wise activities)', 'Annual Report (Month wise activities)'),
(112, 'reports', 'Success Stories', 'Success Stories'),
(113, 'reports', 'Event Reports & Fotos', 'Event Reports & Fotos'),
(114, 'career_option', 'Engineering', 'Engineering'),
(115, 'career_option', 'Doctor', 'Doctor'),
(116, 'career_option', 'Accountant', 'Accountant'),
(117, 'career_option', 'IT professional', 'IT professional'),
(118, 'career_option', 'Nursing', 'Nursing'),
(119, 'career_option', 'Applied Arts', 'Applied Arts'),
(120, 'career_option', 'ITI', 'ITI'),
(121, 'career_option', 'Architects ', 'Architects '),
(122, 'career_option', 'Teaching', 'Teaching'),
(123, 'career_option', 'Para Medical - Physio', 'Para Medical - Physio'),
(124, 'career_option', 'Para Medical - Optometry', 'Para Medical - Optometry'),
(125, 'career_option', 'Para Medical - Lab Technician', 'Para Medical - Lab Technician'),
(126, 'career_option', 'Law', 'Law'),
(127, 'career_option', 'Medico', 'Medico'),
(128, 'career_option', 'Bio-technology', 'Bio-technology'),
(129, 'career_option', 'Commerce', 'Commerce'),
(130, 'contact_person_type', 'Student', 'Student'),
(131, 'contact_person_type', 'Parent', 'Parent'),
(132, 'contact_person_type', 'Neighbour', 'Neighbour'),
(133, 'contact_person_type', 'Other', 'Other'),
(134, 'contact_person_type', 'Applicant', 'Applicant'),
(135, 'courses', 'Dip. Engg 1st', 'Dip. Engg 1st'),
(136, 'courses', 'Dip. Engg 2nd', 'Dip. Engg 2nd'),
(137, 'courses', 'Dip. Engg 3rd', 'Dip. Engg 3rd'),
(138, 'courses', 'Engg 1sr year', 'Engg 1sr year'),
(139, 'courses', 'Engg 2nd year', 'Engg 2nd year'),
(140, 'courses', 'Engg 3rd year', 'Engg 3rd year'),
(141, 'courses', 'Engg 4th year', 'Engg 4th year'),
(142, 'courses', 'Graduation 1st yr(Bsc, Bcom, BA, BFA, BBA, BFM)', 'Graduation 1st yr(Bsc, Bcom, BA, BFA, BBA, BFM)'),
(143, 'courses', 'Graduation 2nd yr(Bsc, Bcom, BA, BFA, BBA, BFM)', 'Graduation 2nd yr(Bsc, Bcom, BA, BFA, BBA, BFM)'),
(144, 'courses', 'Gradation 3rd yr(Bsc, Bcom, BA, BFA,BBA,BFM)', 'Gradation 3rd yr(Bsc, Bcom, BA, BFA,BBA,BFM)'),
(145, 'courses', 'Post Graduation 1st yr(Msc, Mcom, MA, ME)', 'Post Graduation 1st yr(Msc, Mcom, MA, ME)'),
(146, 'courses', 'Post Graduation 2nd yr(Msc, Mcom, MA, ME)', 'Post Graduation 2nd yr(Msc, Mcom, MA, ME)'),
(147, 'courses', 'Diploma', 'Diploma'),
(148, 'courses', 'Engineering', 'Engineering'),
(149, 'courses', 'Pharmacy', 'Pharmacy'),
(150, 'courses', 'ITI', 'ITI'),
(151, 'education_class', 'STD 4th', 'STD 4th'),
(152, 'education_class', 'STD 5th  [S.S.C]', 'STD 5th  [S.S.C]'),
(153, 'education_class', 'STD 6th  [S.S.C]', 'STD 6th  [S.S.C]'),
(154, 'education_class', 'STD 7th  [S.S.C]', 'STD 7th  [S.S.C]'),
(155, 'education_class', 'STD 8th  [S.S.C]', 'STD 8th  [S.S.C]'),
(156, 'education_class', 'STD 9th [S.S.C]', 'STD 9th [S.S.C]'),
(157, 'education_class', 'STD 10th [S.S.C]', 'STD 10th [S.S.C]'),
(158, 'education_class', 'STD 10th [C.B.S.C.]', 'STD 10th [C.B.S.C.]'),
(159, 'education_class', 'STD 10th [I.G.S.C.]', 'STD 10th [I.G.S.C.]'),
(160, 'education_class', 'Homibaba', 'Homibaba'),
(161, 'education_class', 'Scholarship 4th std', 'Scholarship 4th std'),
(162, 'education_class', 'Scholarship  7th std', 'Scholarship  7th std'),
(163, 'education_class', 'Intermediate Drawing Exam', 'Intermediate Drawing Exam'),
(164, 'education_class', 'Elementary Drawing Exam', 'Elementary Drawing Exam'),
(165, 'education_class', 'Singing -Pravinya', 'Singing -Pravinya'),
(166, 'education_class', 'Singing -Visharad', 'Singing -Visharad'),
(167, 'education_result', 'Pass', 'Pass'),
(168, 'education_result', 'Fail', 'Fail'),
(169, 'education_result', '1 A.T.K.T.', '1 A.T.K.T.'),
(170, 'education_result', '2 A.T.K.T.', '2 A.T.K.T.'),
(171, 'education_result', '3 A.T.K.T.', '4 A.T.K.T.'),
(172, 'education_units', 'Pointer', 'Pointer'),
(173, 'education_units', 'Percent', 'Percent'),
(174, 'education_units', 'Class', 'Class'),
(175, 'education_units', 'Marks', 'Marks'),
(176, 'education_units', 'Grade', 'Grade'),
(177, 'expense_head', 'Lodging & Boarding', 'Lodging & Boarding'),
(178, 'expense_head', 'Annual Fees', 'Annual Fees'),
(179, 'expense_head', 'Study Material', 'Study Material'),
(180, 'expense_head', 'Conveyance', 'Conveyance'),
(181, 'expense_head', 'Other', 'Other'),
(182, 'relation', 'Father', 'Father'),
(183, 'relation', 'Mother', 'Mother'),
(184, 'relation', 'Brother', 'Brother'),
(185, 'relation', 'Sister', 'Sister'),
(186, 'relation', 'Uncle', 'Uncle'),
(187, 'relation', 'Aunty', 'Aunty'),
(188, 'relation', 'Cousin', 'Cousin'),
(189, 'relation', 'Brother-in-Law', 'Brother-in-law'),
(190, 'relation', 'grand mother', 'grand mother'),
(191, 'relation', 'grand father', 'grand father'),
(192, 'relation', 'sister in law', 'sister in law'),
(194, 'extra_exams', 'Drawing (Preliminary / Elimentary)', 'Drawing (Preliminary / Elimentary)'),
(195, 'extra_exams', 'Scholarship (Std. 4th / 7th)', 'Scholarship (Std. 4th / 7th)'),
(196, 'extra_exams', 'Homi-Bhabha', 'Homi-Bhabha'),
(197, 'extra_exams', 'Tilak or other university exams', 'Tilak or other university exams'),
(198, 'extra_exams', 'Elocution / Esaay / Street play', 'Elocution / Esaay / Street play'),
(199, 'reporting_last_date', '15', '15');

-- --------------------------------------------------------

--
-- Table structure for table `educational_details`
--

CREATE TABLE `educational_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `academic_year` varchar(50) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `extra_exam_appeared` varchar(200) DEFAULT NULL,
  `marks_type` varchar(30) DEFAULT NULL,
  `marks_units` varchar(20) NOT NULL,
  `result` varchar(50) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `educational_details`
--

INSERT INTO `educational_details` (`id`, `student_id`, `class`, `academic_year`, `type`, `extra_exam_appeared`, `marks_type`, `marks_units`, `result`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, 'STD 10th [S.S.C]', '2015-2016', 'Academic', 'Homi-Bhabha', 'Marks', '99', 'Pass', 2, '2018/06/27 08:11:08 AM', 2, '2018/07/12 02:25:39 PM'),
(2, 1, 'STD 9th [S.S.C]', '2015-2016', 'Non-Academic', 'Elocution / Esaay / Street play', 'Class', 'A', 'Pass', 2, '2018/06/27 08:11:36 AM', NULL, NULL),
(3, 2, 'STD 8th  [S.S.C]', '2016-2017', 'Non-Academic', 'Scholarship (Std. 4th / 7th)', 'Class', '20', 'Fail', 2, '2018/06/28 06:22:15 PM', NULL, NULL),
(4, 2, 'STD 5th  [S.S.C]', '2017-2018', 'Non-Academic', 'Scholarship (Std. 4th / 7th)', 'Percent', '82', '1 A.T.K.T.', 2, '2018/06/28 06:22:41 PM', 4, '2018/07/27 03:48:43 PM'),
(9, 6, 'STD 10th [I.G.S.C.]', '2018-2019', 'Academic', '', 'Percent', '100', 'Pass', 2, '2018/07/26 03:43:26 PM', NULL, NULL),
(10, 6, '', '2016-2017', 'Non-Academic', 'Drawing (Preliminary / Elimentary)', 'Grade', 'a', 'Pass', 2, '2018/07/26 04:06:31 PM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_master`
--

CREATE TABLE `event_master` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_master`
--

INSERT INTO `event_master` (`id`, `name`, `location`, `date`) VALUES
(1, 'Monthly mtg', 'Borivali', '2018/06/05'),
(2, 'Be frank', 'Borivali', '2018/06/03'),
(3, 'Monthly mtg', 'Borivali', '2018/07/14'),
(5, 'vardhapan din', 'thane', '2018/08/15');

-- --------------------------------------------------------

--
-- Table structure for table `family_details`
--

CREATE TABLE `family_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `relation` varchar(50) DEFAULT NULL,
  `education` varchar(200) DEFAULT NULL,
  `profession` varchar(200) DEFAULT NULL,
  `monthly_income` float(10,2) DEFAULT '0.00',
  `other_monthly_income` float(10,2) DEFAULT '0.00',
  `total_annual_income` float(10,2) DEFAULT '0.00',
  `income_cert_submitted` varchar(30) DEFAULT NULL,
  `income_certificate_path` varchar(200) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `family_details`
--

INSERT INTO `family_details` (`id`, `student_id`, `name`, `relation`, `education`, `profession`, `monthly_income`, `other_monthly_income`, `total_annual_income`, `income_cert_submitted`, `income_certificate_path`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, 'shamrao', 'Father', '10th', 'Retired', 30000.00, 0.00, 360000.00, 'Yes', 'test.png', 2, '2018/06/27 07:50:11 AM', 2, '2018/07/12 11:41:03 AM'),
(2, 1, 'suvarna', 'Mother', '5th', NULL, 0.00, 0.00, 0.00, 'No', '', 2, '2018/06/27 07:55:39 AM', NULL, NULL),
(3, 2, 'monish', 'Brother', '12th', 'Self Employed', 50000.00, 0.00, 600000.00, 'Yes', 'child-1.jpg', 2, '2018/06/28 12:05:01 PM', 2, '2018/07/12 09:00:17 PM'),
(11, 6, 'xxx', 'Father', 'Diploma', 'Retired', 1000.00, 500.00, 18000.00, 'No', '', 2, '2018/07/26 03:32:13 PM', 2, '2018/07/26 03:59:00 PM'),
(12, 6, 'radha', 'Mother', '7th', 'House-wife/husband', 0.00, 0.00, 0.00, 'No', '', 2, '2018/07/26 03:33:55 PM', 2, '2018/07/27 03:11:37 PM'),
(13, 8, 'Elmo Sears', 'Father', '10th', 'Govt. Employee', 12.00, 11.00, 276.00, 'No', '', 2, '2020/05/05 08:53:10 PM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kp_assigned`
--

CREATE TABLE `kp_assigned` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `kp_id` int(11) DEFAULT '0',
  `from_date` varchar(25) DEFAULT NULL,
  `to_date` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kp_assigned`
--

INSERT INTO `kp_assigned` (`id`, `student_id`, `kp_id`, `from_date`, `to_date`) VALUES
(1, 1, 3, '2018/07/23', NULL),
(2, 2, 4, '2018/07/25', NULL),
(3, 3, 4, '2018/07/27', NULL),
(6, 5, 0, NULL, NULL),
(7, 6, 7, '2018/07/27', NULL),
(8, 4, 3, NULL, NULL),
(9, 7, 0, NULL, NULL),
(10, 8, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kp_functions`
--

CREATE TABLE `kp_functions` (
  `1` int(11) NOT NULL,
  `kp_id` int(11) NOT NULL,
  `function_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kp_functions`
--

INSERT INTO `kp_functions` (`1`, `kp_id`, `function_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_reports`
--

CREATE TABLE `monthly_reports` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `year` varchar(30) DEFAULT NULL,
  `month` varchar(30) DEFAULT NULL,
  `extra_curricular_activities` varchar(1000) DEFAULT NULL,
  `book1_name` varchar(50) DEFAULT NULL,
  `book1_author` varchar(50) DEFAULT NULL,
  `book1_remarks` varchar(200) DEFAULT NULL,
  `book2_name` varchar(50) DEFAULT NULL,
  `book2_author` varchar(50) DEFAULT NULL,
  `book2_remarks` varchar(200) DEFAULT NULL,
  `book3_name` varchar(50) DEFAULT NULL,
  `book3_author` varchar(50) DEFAULT NULL,
  `book3_remarks` varchar(50) DEFAULT NULL,
  `montly_events` varchar(1000) DEFAULT NULL,
  `event_remarks` varchar(1000) DEFAULT NULL,
  `comments_opinion` varchar(1000) DEFAULT NULL,
  `social_work_drive` varchar(30) DEFAULT NULL,
  `social_work_explanation` varchar(1000) DEFAULT NULL,
  `noteworthy_experience` varchar(1000) DEFAULT NULL,
  `health_issue` varchar(1000) DEFAULT NULL,
  `contact_with_kp` varchar(50) DEFAULT NULL,
  `advance_settlement` varchar(50) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monthly_reports`
--

INSERT INTO `monthly_reports` (`id`, `student_id`, `year`, `month`, `extra_curricular_activities`, `book1_name`, `book1_author`, `book1_remarks`, `book2_name`, `book2_author`, `book2_remarks`, `book3_name`, `book3_author`, `book3_remarks`, `montly_events`, `event_remarks`, `comments_opinion`, `social_work_drive`, `social_work_explanation`, `noteworthy_experience`, `health_issue`, `contact_with_kp`, `advance_settlement`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, '2018', '06', 'abcd', 'abcd', 'abcd', 'abcd', '', '', '', '', '', '', 'Monthly mtg - (Borivali) - 2018/07/02, Be frank - (Borivali) - 2018/06/03', 'NA', 'NA', 'Yes', 'food distibution for poor people', 'NA', 'NA', 'Regular', 'Slow', 5, '2018/07/25 08:06:39 AM', 2, '2018/07/13 12:18:19 PM'),
(2, 2, '2018', '06', 'photography', 'the secret', 'the secret', 'the secret', '', '', '', '', '', '', 'Be frank - (Borivali) - 2018/06/03, Monthly mtg - (Borivali) - 2018/06/05', 'NA', 'NA', 'Yes', 'social awareness posts', 'NA', 'NA', 'Regular', 'Slow', 4, '2018/07/27 05:23:18 PM', NULL, NULL),
(5, 6, '2018', '06', 'shivaji', 'shivaji', 'e', 'read', '', '', '', '', '', '', 'vardhapan din - (thane) - 2018/08/15, Be frank - (Borivali) - 2018/06/03', 'NA', 'Has been regular', 'Yes', 'social drive dtls', 'NA', 'NA test pending', 'Regular', 'Fast', 7, '2018/07/28 05:14:45 PM', 7, '2018/07/27 03:50:10 PM');

-- --------------------------------------------------------

--
-- Table structure for table `referral_details`
--

CREATE TABLE `referral_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `name_of_referral` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `referral_details`
--

INSERT INTO `referral_details` (`id`, `student_id`, `name_of_referral`, `mobile`, `email`, `type`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(2, 1, 'pranav', '0123456789', 'pranav@apptroid.com', 'Relative', 2, '2018/06/27 05:39:51 PM', 2, '2018/07/12 07:40:09 PM'),
(3, 2, 'IBN lokmat', '', '', 'Internet', 2, '2018/06/27 05:41:58 PM', NULL, NULL),
(4, 6, 'asdf', '8585580616', 'mitesh.gadgil@gmail.com', 'Relative', 2, '2018/07/26 04:38:55 PM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_docs`
--

CREATE TABLE `student_docs` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `doc_type` varchar(200) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_docs`
--

INSERT INTO `student_docs` (`id`, `student_id`, `doc_type`, `file_path`, `description`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 1, 'PAN card', '6.jpg', '', 2, '2018/06/27 04:32:17 PM', 2, '2018/07/12 07:17:32 PM'),
(2, 1, 'Voting card', '5.jpg', 'test', 2, '2018/06/27 04:33:07 PM', 2, '2018/07/12 07:17:56 PM'),
(3, 1, 'Marksheet', 'dummy-pdf_2.pdf', '', 2, '2018/06/27 04:33:35 PM', NULL, NULL),
(4, 2, 'Voting card', 'index.jpg', 'jkgbkjb', 2, '2018/06/28 06:33:40 PM', NULL, NULL),
(5, 2, 'Adhar card', 'dummy-pdf_2.pdf', '', 2, '2018/06/29 11:43:38 AM', NULL, NULL),
(16, 6, 'PAN card', 'Vision.docx', 'yet to b recd', 2, '2018/07/26 04:32:08 PM', NULL, NULL),
(17, 6, 'Adhar card', 'Vision.docx', '', 2, '2018/07/26 04:34:08 PM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `id` int(11) NOT NULL,
  `application_id` varchar(50) DEFAULT NULL,
  `student_code` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `dob` varchar(30) DEFAULT NULL,
  `caste` varchar(50) DEFAULT NULL,
  `vsm_branch` varchar(50) DEFAULT NULL,
  `csr` varchar(30) DEFAULT NULL,
  `csr_organisation` varchar(50) DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `status` enum('Pending','Rejected','Enrolled') NOT NULL DEFAULT 'Pending',
  `remark_by_commitee` varchar(500) DEFAULT NULL,
  `submitted_by_admin` int(11) DEFAULT NULL,
  `submission_date` varchar(30) DEFAULT NULL,
  `last_edited_by` int(11) DEFAULT NULL,
  `last_edit_date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `application_id`, `student_code`, `first_name`, `middle_name`, `last_name`, `dob`, `caste`, `vsm_branch`, `csr`, `csr_organisation`, `photo`, `status`, `remark_by_commitee`, `submitted_by_admin`, `submission_date`, `last_edited_by`, `last_edit_date`) VALUES
(1, 'APPL1', 'STUD2', 'nilesh', 'shamrao', 'khamkar', '1992/10/24', 'Open', 'Thane', 'No', NULL, 'guy-5.jpg', 'Enrolled', 'He is a hard working student, so we are ready to support him.', 2, '2018/06/26 05:07:42 PM', 2, '2018/06/27 04:01:46 PM'),
(2, 'APPL2', 'STUD3', 'Pranav', 'Uday', 'Pujare', '1994/12/20', 'Open', 'Thane', 'Yes', 'Apptroid', 'guy-6.jpg', 'Enrolled', 'enrolled', 2, '2018/06/26 05:17:00 PM', 2, '2018/07/12 09:04:36 PM'),
(3, 'APPL3', 'STUD5', 'Tushar', 'Prakash', 'Hadawale', '1993/08/22', 'Open', 'Thane', 'No', '', 'guy-3.jpg', 'Enrolled', 'test', 2, '2018/06/26 05:18:12 PM', 2, '2018/07/25 08:10:31 AM'),
(4, 'APPL4', 'STUD1', 'Hardik', '', 'Malde', '1999/02/03', 'Open', 'Thane', NULL, NULL, '(angel)_scaled_30.png', 'Enrolled', 'Approved', 2, '2018/07/25 08:12:40 AM', NULL, NULL),
(5, 'APPL5', NULL, 'satyajit', 'r', 'patil', '2018/07/25', 'Open', 'Borivili', NULL, NULL, '', 'Pending', NULL, 2, '2018/07/25 08:31:37 PM', NULL, NULL),
(6, 'APPL6', 'STUD4', 'ramesh', 'r', 'patil', '2018/07/26', 'SC', 'Shahapur', 'Yes', 'Mahendra', 'images.png', 'Enrolled', 'enrolled.', 2, '2018/07/26 03:04:22 PM', 2, '2018/07/26 04:36:49 PM'),
(7, 'APPL7', NULL, 'Vishal', '', 'Jatolia', '2018/07/28', 'Open', 'Thane', NULL, NULL, '', 'Pending', NULL, 2, '2018/07/28 05:13:06 PM', NULL, NULL),
(8, 'APPL8', NULL, 'Sophia', 'Shafira Howe', 'Salazar', '2020/05/07', 'Open', 'Pune', NULL, NULL, '', 'Pending', NULL, 2, '2020/05/05 08:51:43 PM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `affected_student` int(11) DEFAULT NULL,
  `affected_kp` int(11) DEFAULT NULL,
  `affected_decoding` int(11) DEFAULT NULL,
  `affected_event` int(11) DEFAULT NULL,
  `time` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `admin_id`, `module`, `action`, `affected_student`, `affected_kp`, `affected_decoding`, `affected_event`, `time`) VALUES
(1, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/27 01:51:10 PM'),
(2, 2, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/27 01:51:15 PM'),
(3, 2, 'family details', 'edit', 6, 0, 0, 0, '2018/07/27 03:11:37 PM'),
(4, 2, 'KP allocation', 'edit', 6, 3, 0, 0, '2018/07/27 03:25:48 PM'),
(5, 2, 'KP allocation', 'edit', 6, 7, 0, 0, '2018/07/27 03:25:55 PM'),
(6, 2, 'application status', 'edit', 6, 0, 0, 0, '2018/07/27 03:26:04 PM'),
(7, 2, 'decoding', 'edit', 0, 0, 196, 0, '2018/07/27 03:34:11 PM'),
(8, 2, 'decoding', 'edit', 0, 0, 196, 0, '2018/07/27 03:34:20 PM'),
(9, 2, 'events', 'edit', 0, 0, 0, 5, '2018/07/27 03:34:34 PM'),
(10, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/27 03:47:52 PM'),
(11, 4, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/27 03:48:15 PM'),
(12, 4, 'educational details', 'edit', 2, 0, 0, 0, '2018/07/27 03:48:43 PM'),
(13, 4, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/27 03:48:48 PM'),
(14, 5, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/27 03:49:07 PM'),
(15, 5, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/27 03:49:27 PM'),
(16, 7, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/27 03:49:31 PM'),
(17, 7, 'monthly report', 'edit', 6, 0, 0, 0, '2018/07/27 03:50:10 PM'),
(18, 7, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/27 03:50:15 PM'),
(19, 2, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/27 03:50:20 PM'),
(20, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 12:56:59 PM'),
(21, 3, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 12:57:06 PM'),
(22, 3, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 12:58:52 PM'),
(23, 2, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 12:58:58 PM'),
(24, 2, 'application status', 'edit', 3, 0, 0, 0, '2018/07/28 04:11:01 PM'),
(25, 2, 'KP allocation', 'edit', 3, 4, 0, 0, '2018/07/28 04:11:01 PM'),
(26, 2, 'application', 'add', 7, 0, 0, 0, '2018/07/28 05:13:06 PM'),
(27, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 05:18:19 PM'),
(28, 3, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 05:18:52 PM'),
(29, 3, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 05:22:08 PM'),
(30, 2, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 05:22:13 PM'),
(31, 2, 'decoding', 'edit', 0, 0, 199, 0, '2018/07/28 06:00:13 PM'),
(32, 2, 'decoding', 'edit', 0, 0, 199, 0, '2018/07/28 06:00:26 PM'),
(33, 2, 'decoding', 'edit', 0, 0, 199, 0, '2018/07/28 06:00:42 PM'),
(34, 2, 'decoding', 'edit', 0, 0, 199, 0, '2018/07/28 06:01:00 PM'),
(35, 2, 'decoding', 'edit', 0, 0, 199, 0, '2018/07/28 06:29:54 PM'),
(36, 2, 'decoding', 'edit', 0, 0, 199, 0, '2018/07/28 06:30:07 PM'),
(37, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 06:47:47 PM'),
(38, 3, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 06:47:58 PM'),
(39, 3, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 06:49:40 PM'),
(40, 2, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 06:49:46 PM'),
(41, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 06:50:09 PM'),
(42, 2, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 06:50:15 PM'),
(43, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 06:50:23 PM'),
(44, 3, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 06:50:28 PM'),
(45, 3, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 06:50:39 PM'),
(46, 2, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 06:50:44 PM'),
(47, 2, 'annual report', 'delete', 2, 0, 0, 0, '2018/07/28 07:09:30 PM'),
(48, 2, 'monthly report', 'delete', 6, 0, 0, 0, '2018/07/28 07:10:01 PM'),
(49, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 07:10:39 PM'),
(50, 3, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 07:10:45 PM'),
(51, 3, 'admin panel', 'logout', 0, 0, 0, 0, '2018/07/28 07:11:36 PM'),
(52, 2, 'admin panel', 'login', 0, 0, 0, 0, '2018/07/28 07:11:41 PM'),
(53, 2, 'student documents', 'add', 1, 0, 0, 0, '2018/08/07 03:32:42 PM'),
(54, 2, 'student documents', 'delete', 1, 0, 0, 0, '2018/08/07 03:33:36 PM'),
(55, 2, 'admin panel', 'login', 0, 0, 0, 0, '2019/04/29 07:53:39 PM'),
(56, 2, 'admin panel', 'login', 0, 0, 0, 0, '2019/05/28 08:18:48 PM'),
(57, 2, 'admin panel', 'login', 0, 0, 0, 0, '2019/09/16 01:12:08 PM'),
(58, 2, 'admin panel', 'login', 0, 0, 0, 0, '2019/12/05 12:06:29 PM'),
(59, 2, 'admin panel', 'login', 0, 0, 0, 0, '2020/05/05 08:48:22 PM'),
(60, 2, 'application', 'add', 8, 0, 0, 0, '2020/05/05 08:51:43 PM'),
(61, 2, 'family details', 'add', 8, 0, 0, 0, '2020/05/05 08:53:10 PM'),
(62, 2, 'admin panel', 'logout', 0, 0, 0, 0, '2020/05/05 08:55:58 PM'),
(63, 3, 'admin panel', 'login', 0, 0, 0, 0, '2020/05/05 08:56:08 PM'),
(64, 3, 'admin panel', 'logout', 0, 0, 0, 0, '2020/05/05 08:59:11 PM'),
(65, 1, 'admin panel', 'login', 0, 0, 0, 0, '2020/05/05 08:59:33 PM'),
(66, 1, 'budgted expenses', 'add', 1, 0, 0, 0, '2020/05/05 09:02:33 PM'),
(67, 1, 'admin panel', 'logout', 0, 0, 0, 0, '2020/05/05 09:04:16 PM'),
(68, 3, 'admin panel', 'login', 0, 0, 0, 0, '2020/05/05 09:04:27 PM'),
(69, 3, 'admin panel', 'logout', 0, 0, 0, 0, '2020/05/05 09:06:40 PM'),
(70, 1, 'admin panel', 'login', 0, 0, 0, 0, '2020/05/05 09:07:02 PM'),
(71, 1, 'decoding', 'add', 0, 0, 200, 0, '2020/05/05 09:08:51 PM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_performance`
--
ALTER TABLE `academic_performance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address_details`
--
ALTER TABLE `address_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `annual_reports`
--
ALTER TABLE `annual_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assistance_details`
--
ALTER TABLE `assistance_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budgeted_expenses`
--
ALTER TABLE `budgeted_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_plan`
--
ALTER TABLE `career_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decoding`
--
ALTER TABLE `decoding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educational_details`
--
ALTER TABLE `educational_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_master`
--
ALTER TABLE `event_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_details`
--
ALTER TABLE `family_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kp_assigned`
--
ALTER TABLE `kp_assigned`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kp_functions`
--
ALTER TABLE `kp_functions`
  ADD PRIMARY KEY (`1`);

--
-- Indexes for table `monthly_reports`
--
ALTER TABLE `monthly_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referral_details`
--
ALTER TABLE `referral_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_docs`
--
ALTER TABLE `student_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_performance`
--
ALTER TABLE `academic_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `address_details`
--
ALTER TABLE `address_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `annual_reports`
--
ALTER TABLE `annual_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assistance_details`
--
ALTER TABLE `assistance_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `budgeted_expenses`
--
ALTER TABLE `budgeted_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `career_plan`
--
ALTER TABLE `career_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `decoding`
--
ALTER TABLE `decoding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `educational_details`
--
ALTER TABLE `educational_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_master`
--
ALTER TABLE `event_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `family_details`
--
ALTER TABLE `family_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kp_assigned`
--
ALTER TABLE `kp_assigned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kp_functions`
--
ALTER TABLE `kp_functions`
  MODIFY `1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `monthly_reports`
--
ALTER TABLE `monthly_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `referral_details`
--
ALTER TABLE `referral_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_docs`
--
ALTER TABLE `student_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
