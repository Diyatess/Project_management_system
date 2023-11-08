-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2023 at 09:26 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskmaster`
--

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `rid`) VALUES
(1, 'admin', 'taskmasterhub2023@gmail.com', '0e7517141fb53f21ee439b355b5a1d0a\r\n', 2);

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `username`, `cname`, `contact`, `email`, `password`, `rid`, `verify_token`, `verify_status`, `request_id`) VALUES
(4, 'Jaimol', 'Jaimol Joy', '8874563210', 'jaimoljoy2001@gmail.com', 'c86e825f2f207c2d5fab6db6098fbcdf', 1, NULL, NULL, NULL),
(16, 'Diya', 'Diya Tess', '6282746001', 'diyatesjohn@gmail.com', '744609e71adad82a6f4d128648d85500', 1, '73f5ed44434593c636f152a42ae73e2b', 1, 1),
(17, 'Hilal', 'Habeeb', '9562075338', 'hilalhabb@gmail.com', 'bf695b85c70ef45eb89284854fe75e9b', 1, '8442a05d71169098098b58c9ae64067a', 0, NULL),
(18, 'treesa', 'Treesa John', '7896541234', 'treesajohndiya@gmail.com', 'dfa89fccdee77ebf628416b13bdcc2e0', 1, '80663f1cddc1534f1064d19de72567b5', 1, 5);

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`desig_id`, `desig_type`, `Salary`) VALUES
(1, 'Designer', 25000),
(2, 'Codder', 260000),
(3, 'Tester', 25000);

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `fname`, `lname`, `gender`, `dob`, `email`, `contact`, `address`, `city`, `state`, `pincode`, `country`, `hiredate`, `rid`, `password`, `desig_id`) VALUES
(1, 'Jacob', 'John', 'Male', '2000-03-25', 'jacobjohn@gmail.com', '9988776655', 'Illiparambil H', 'Kothamangalam', 'Kerala', '686693', 'India', '2021-08-23', 4, '222222', 1),
(12, 'Diya Tes', 'Santy', 'Female', '2020-10-12', 'diyatesjohn@gmail.com', '06282746004', 'Illiparambil H', 'Kothamangalam', 'Kerala', '686693', 'India', '2022-12-10', 4, '111111', 1),
(15, 'Jaimol', 'Joy', 'Female', '1998-10-12', 'jaimoljoy20@gmail.com', '07845120096', 'Blue Rose', 'cherpungal', 'Kerala', '68699', 'India', '2020-01-10', 4, '888888', 3),
(16, 'Kavya', 'John', 'Female', '1997-06-05', 'kavyarosej@gmail.com', '7852364002', 'punnathill', 'Ernakulam', 'Kerala', '686687', 'India', '2021-10-12', 4, '123456', 2),
(17, 'Treesa', 'John', 'Female', '1999-02-25', 'diyatessjohn@gmail.com', '06282746004', 'Malamel', 'Vazhakala', 'Kerala', '686693', 'India', '2022-05-24', 4, '123456', 2),
(19, 'Jisha', 'John', 'Female', '1990-01-15', 'jishajohn0011@gmail.com', '9446881315', 'Tharaniyil H', 'Kozhikode', 'Kerala', '686687', 'India', '2016-10-10', 4, '444444', 3);

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `recipient_id`, `message_text`, `timestamp`, `is_read`) VALUES
(1, 1, 16, 'hi got your request', '2023-11-02 19:01:13', 0),
(2, 1, 16, 'hi', '2023-11-02 19:12:33', 0);

--
-- Dumping data for table `project_requests`
--

INSERT INTO `project_requests` (`request_id`, `project_name`, `project_description`, `client_email`, `status`, `created_at`) VALUES
(1, 'school management', 'manage full school.', 'diyatesjohn@gmail.com', 'Pending', '2023-11-01 19:00:40'),
(5, 'GYM Management', 'To manage everything in GYM. Need to give special attention to each client.', 'treesajohndiya@gmail.com', 'Pending', '2023-11-06 08:10:55');

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`rid`, `role`) VALUES
(1, 'client'),
(2, 'admin'),
(3, 'teamlead'),
(4, 'teammem');

--
-- Dumping data for table `teammember`
--

INSERT INTO `teammember` (`mid`, `id`, `pid`, `did`, `task_id`, `rid`) VALUES
(1, 16, NULL, NULL, NULL, 4),
(2, 17, NULL, NULL, NULL, 4),
(4, 19, NULL, NULL, NULL, 4);

--
-- Dumping data for table `team_lead`
--

INSERT INTO `team_lead` (`lead_id`, `leadname`, `lead_email`, `password`) VALUES
(1, 'TeamLead', 'taskmasterhub2023@gmail.com', 'f85dd16b649b41df02de33a4b2fd7c58');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
