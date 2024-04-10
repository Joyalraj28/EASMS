-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2024 at 06:59 PM
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
-- Database: `easmsdb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Pro_EmployeeAttendanceDateFormat` (`empid` INT)   BEGIN
SELECT 
AttendanceID,
AttendanceDate, 
CONVERT(Signin, Date) AS SigninDate, 
CONVERT(Lunch,Date) AS LunchDate, 
CONVERT(Lunchout,Date) AS LunchoutDate,     									 
CONVERT(Signout,Date) AS SignoutDate FROM attendance WHERE EmployeeID_FK = empid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Pro_EmployeeLeavecredits` (IN `empid` INT)   BEGIN
CREATE TEMPORARY TABLE IF NOT EXISTS levid AS SELECT * FROM leavetypeids WHERE EmployeeID_FK = empid;
SELECT *
FROM `leavetype` lev 
LEFT JOIN  levid 
    ON lev.LeaveID = levid.leavetypeid
ORDER BY lev.ShortName ASC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accountant`
--

CREATE TABLE `accountant` (
  `EmployeeID` int(11) NOT NULL,
  `PriorityLevel` int(11) DEFAULT NULL,
  `ManageSalary` bit(1) DEFAULT NULL,
  `ManageAttendance` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountant`
--

INSERT INTO `accountant` (`EmployeeID`, `PriorityLevel`, `ManageSalary`, `ManageAttendance`) VALUES
(2, 1, b'1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `EmployeeID` int(11) NOT NULL,
  `PriorityLevel` int(11) DEFAULT NULL,
  `ManageEmployee` bit(1) DEFAULT NULL,
  `ManageLeave` bit(1) DEFAULT NULL,
  `ManageSalary` bit(1) DEFAULT NULL,
  `ManageAttendance` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`EmployeeID`, `PriorityLevel`, `ManageEmployee`, `ManageLeave`, `ManageSalary`, `ManageAttendance`) VALUES
(1, 1, b'1', b'1', b'1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AttendanceID` int(11) NOT NULL,
  `AttendanceDate` datetime DEFAULT NULL,
  `Signin` datetime DEFAULT NULL,
  `Lunch` datetime DEFAULT NULL,
  `Lunchout` datetime DEFAULT NULL,
  `Signout` datetime DEFAULT NULL,
  `LeaveApplicationID_FK` int(11) DEFAULT NULL,
  `EmployeeID_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AttendanceID`, `AttendanceDate`, `Signin`, `Lunch`, `Lunchout`, `Signout`, `LeaveApplicationID_FK`, `EmployeeID_FK`) VALUES
(1, '2024-04-10 08:00:00', '2024-04-10 08:00:00', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DepartmentID` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `CreateDate` datetime DEFAULT current_timestamp(),
  `UpdateDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `Admin_ID_FK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DepartmentID`, `Name`, `Description`, `CreateDate`, `UpdateDate`, `Admin_ID_FK`) VALUES
(1, 'Development', 'This development', '2024-04-02 10:38:17', '2024-04-02 10:38:17', 1),
(2, 'Accounting', 'this accounting ', '2024-04-02 10:39:28', '2024-04-02 10:39:28', 1),
(3, 'Admin', 'Admin team', '2024-04-02 10:40:31', '2024-04-02 10:40:31', NULL),
(4, 'Testing', 'Testing department', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `DesignationID` int(11) NOT NULL,
  `ShortName` varchar(25) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `CreateDate` datetime DEFAULT current_timestamp(),
  `UpdateDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `Admin_ID_FK` int(11) DEFAULT NULL,
  `DepartmentID_FK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`DesignationID`, `ShortName`, `Name`, `Description`, `CreateDate`, `UpdateDate`, `Admin_ID_FK`, `DepartmentID_FK`) VALUES
(1, 'DD', 'Desktop development', 'Desktop development', '2024-04-02 10:41:31', '2024-04-02 10:41:31', 1, 1),
(2, 'AC', 'Accountant', 'Accountant team', '2024-04-02 10:42:37', '2024-04-02 10:42:37', 1, 2),
(3, 'AD', 'Admin', 'Admin', '2024-04-02 10:44:15', '2024-04-02 10:44:15', NULL, 3),
(4, NULL, 'Testing', 'Testing Team', NULL, NULL, NULL, NULL),
(5, NULL, 'Web development', 'Web development', '2024-04-03 17:09:34', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` int(11) NOT NULL,
  `Avatar` varchar(100) DEFAULT NULL,
  `Fullname` varchar(50) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Status` bit(1) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `NetSalary` decimal(4,2) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `DesignationID_FK` int(11) DEFAULT NULL,
  `Admin_ID_FK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeID`, `Avatar`, `Fullname`, `Gender`, `DOB`, `Status`, `Address`, `NetSalary`, `Email`, `Password`, `DesignationID_FK`, `Admin_ID_FK`) VALUES
(1, NULL, 'John', 'Male', '1999-03-18', b'1', 'Jaffna', 99.99, 'John@gmail.com', '123', 3, NULL),
(2, NULL, 'Raj Leo', 'Male', '1999-03-18', b'1', 'Jaffna', 99.99, 'raj@gmail.com', '123', 2, 1),
(3, NULL, 'Joyal', 'Male', '1999-03-18', b'1', 'Jaffna', 99.99, 'singarasajoyalraj@gmail.com', '123', 1, 1),
(7, NULL, 'test test', 'Male', '2024-04-02', b'1', 'Jaffna', 1.00, 'aaaa', '11', 1, 1),
(8, NULL, 'test uiy', 'Male', '2024-05-03', b'1', 'Jaffna', 1.00, 'tttuioik', '345', 1, 1),
(9, NULL, 'test mm', 'Male', '2024-04-02', b'1', 'Jaffna', 1.00, 'tttuioikj', 'jj', 1, 1),
(10, NULL, 'test mm', 'Male', '2024-04-02', b'1', 'Jaffna', 1.00, 'tttuioikjw', 'jj', 1, 1),
(11, 'uploads/_user.png', 'Singarasa joyalraj', 'Male', '2024-04-02', b'1', 'Jaffna', 99.99, 'joyalraj@gmail.com', '122', 1, 1),
(12, NULL, 'Tamil nathan', 'Male', '2024-04-03', b'1', 'Jaffna', 99.99, 'tamil@gmail.com', '111', 1, 1),
(13, 'uploads/_emp.png', 'root test', 'Male', '2024-04-02', b'1', 'Jaffna', 99.99, 'root@gmail.com', '234', 1, 1),
(14, 'uploads/tt ww_emp.png', 'tt ww', 'Male', '2024-04-25', b'1', 'Jaffna', 99.99, 'tt@gmail.com', '200', 1, 1),
(15, 'uploads/tt2 ww_emp.png', 'tt2 ww', 'Male', '2024-04-25', b'1', 'Jaffna', 99.99, 'tt2@gmail.com', '200', 1, 1),
(16, 'uploads/thanusan raj_emp.jpg', 'thanusan raj', 'Male', '2024-04-18', b'1', 'Jaffna', 99.99, 'thansh@gmail.com', '389289', 1, 1),
(17, NULL, 'Thansuan Nakarasa', 'Male', '2024-04-04', b'1', 'Jaffna', 99.99, 'Thanusan@gmail.com', '123', 1, 1),
(18, NULL, 'Thayani Berun', 'Female', '1999-02-02', b'1', 'Jaffna', 99.99, 'Thayani@gmail.com', '123', 1, 1),
(22, NULL, 'Ram Raja', 'Male', '1993-02-03', b'1', 'Jaffna', 99.99, 'ram@gmail.com', '123', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employeephoneno`
--

CREATE TABLE `employeephoneno` (
  `id` int(11) NOT NULL,
  `PhoneNo` int(11) NOT NULL,
  `EmployeeID_FK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeephoneno`
--

INSERT INTO `employeephoneno` (`id`, `PhoneNo`, `EmployeeID_FK`) VALUES
(1, 761936168, 22),
(2, 761936262, 22),
(3, 761932168, 22),
(16, 5645665, 0),
(17, 7866766, 0),
(18, 8978777, 0),
(19, 5645665, 2),
(20, 7866766, 2),
(21, 8978777, 2),
(22, 761936168, 22),
(23, 761936262, 22),
(24, 761932168, 22),
(25, 123439489, 12);

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplication`
--

CREATE TABLE `leaveapplication` (
  `LeaveAppicationID` int(11) NOT NULL,
  `ApplyEmpID_FK` int(11) DEFAULT NULL,
  `LeaveDate` datetime DEFAULT NULL,
  `Reason` varchar(50) DEFAULT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL,
  `Status` int(25) DEFAULT NULL,
  `LeaveTypeID_FK` int(11) DEFAULT NULL,
  `AprroveEmpID_FK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leavetype`
--

CREATE TABLE `leavetype` (
  `LeaveID` int(11) NOT NULL,
  `ShortName` varchar(50) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `DefaultCredit` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT current_timestamp(),
  `UpdateDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `Status` bit(1) DEFAULT NULL,
  `Admin_ID_FK` int(11) DEFAULT NULL,
  `TypeOfLeave` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leavetype`
--

INSERT INTO `leavetype` (`LeaveID`, `ShortName`, `Description`, `DefaultCredit`, `CreateDate`, `UpdateDate`, `Status`, `Admin_ID_FK`, `TypeOfLeave`) VALUES
(1, 'test', 'test', 17, '2024-04-03 16:20:30', '2024-04-09 19:55:31', b'1', 1, 1),
(2, 'test3', 'to', 20, '2024-04-03 17:06:05', '2024-04-03 17:08:25', b'1', NULL, 0),
(3, 'test3', 'ttt', 20, '2024-04-03 17:06:22', '2024-04-03 17:06:22', b'1', NULL, 0),
(4, 'PL', 'Personal leave', 7, '2024-04-09 18:54:22', '2024-04-09 18:56:09', b'1', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `leavetypeids`
--

CREATE TABLE `leavetypeids` (
  `EmployeeID_FK` int(11) NOT NULL,
  `leavetypeid` int(11) NOT NULL,
  `leavecredit` int(11) DEFAULT NULL,
  `DefultCredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leavetypeids`
--

INSERT INTO `leavetypeids` (`EmployeeID_FK`, `leavetypeid`, `leavecredit`, `DefultCredit`) VALUES
(11, 4, 7, 7),
(12, 4, 7, 7),
(12, 1, 16, 17),
(3, 4, 7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Employee attendance and salary management'),
(2, 'short_name', 'EASMS'),
(3, 'logo', 'uploads/1706500320_EMS.png'),
(4, 'user_avatar', 'uploads/user_avatar.jpg'),
(5, 'cover', 'uploads/1706501340_startup-593341_1280.jpg'),
(6, 'login_bg', 'uploads/login_background.jpg'),
(7, 'about', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel pharetra elit. Suspendisse potenti. Quisque aliquam justo ut ipsum porta ullamcorper. Curabitur ac lectus hendrerit, tristique sem in, cursus sapien. Vivamus metus augue, pharetra ac lobortis vel, eleifend sed diam. Sed lacus mauris, dictum eget est in, maximus egestas arcu. Nunc vel est ut est elementum laoreet. Phasellus quis tincidunt ex. Morbi vestibulum molestie turpis, id pellentesque augue viverra in. Donec laoreet lorem id viverra molestie. Vivamus in odio sed lectus ultricies eleifend. Nunc eget erat blandit, tristique odio nec, blandit purus. Vivamus facilisis laoreet ex, vel ultricies nisl molestie in. Proin laoreet finibus nulla quis auctor. Etiam pulvinar ligula et diam tincidunt dapibus.\r\n\r\nNulla pulvinar nisl nec neque mollis imperdiet. Curabitur dignissim convallis arcu, a maximus neque dictum id. Praesent justo libero, semper sed auctor eu, ultricies id quam. Sed et orci non sem imperdiet lobortis at non mi. Suspendisse consectetur consectetur dolor, interdum imperdiet orci venenatis nec. Sed vehicula orci sollicitudin facilisis ultricies. Mauris non nibh nec orci convallis mollis ac in lectus. Cras eu cursus urna, non semper mi. Ut in tortor in odio feugiat interdum. Integer ut ante non purus luctus maximus eu vitae nulla. Nam quam felis, condimentum non molestie sed, ornare at nunc. In rhoncus mi id justo gravida congue.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountant`
--
ALTER TABLE `accountant`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD KEY `LeaveApplicationID_FK` (`LeaveApplicationID_FK`),
  ADD KEY `attendance_employeeID_FK` (`EmployeeID_FK`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepartmentID`),
  ADD KEY `Admin_ID_FK` (`Admin_ID_FK`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`DesignationID`),
  ADD KEY `DepartmentID_FK` (`DepartmentID_FK`),
  ADD KEY `Admin_ID_FK` (`Admin_ID_FK`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD KEY `DesignationID_FK` (`DesignationID_FK`),
  ADD KEY `Admin_ID_FK` (`Admin_ID_FK`);

--
-- Indexes for table `employeephoneno`
--
ALTER TABLE `employeephoneno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmployeeID_FK` (`EmployeeID_FK`);

--
-- Indexes for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD PRIMARY KEY (`LeaveAppicationID`),
  ADD KEY `ApplyEmpID_FK` (`ApplyEmpID_FK`),
  ADD KEY `AprroveEmpID_FK` (`AprroveEmpID_FK`),
  ADD KEY `LeaveApplicationID_FK` (`LeaveTypeID_FK`);

--
-- Indexes for table `leavetype`
--
ALTER TABLE `leavetype`
  ADD PRIMARY KEY (`LeaveID`),
  ADD KEY `Admin_ID_FK` (`Admin_ID_FK`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `DesignationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `employeephoneno`
--
ALTER TABLE `employeephoneno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `leavetype`
--
ALTER TABLE `leavetype`
  MODIFY `LeaveID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_employeeID_FK` FOREIGN KEY (`EmployeeID_FK`) REFERENCES `employee` (`EmployeeID`),
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`LeaveApplicationID_FK`) REFERENCES `leavetype` (`LeaveID`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`Admin_ID_FK`) REFERENCES `admin` (`EmployeeID`);

--
-- Constraints for table `designation`
--
ALTER TABLE `designation`
  ADD CONSTRAINT `designation_ibfk_1` FOREIGN KEY (`DepartmentID_FK`) REFERENCES `department` (`DepartmentID`),
  ADD CONSTRAINT `designation_ibfk_2` FOREIGN KEY (`Admin_ID_FK`) REFERENCES `admin` (`EmployeeID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`DesignationID_FK`) REFERENCES `designation` (`DesignationID`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`Admin_ID_FK`) REFERENCES `admin` (`EmployeeID`);

--
-- Constraints for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD CONSTRAINT `leaveapplication_ibfk_1` FOREIGN KEY (`ApplyEmpID_FK`) REFERENCES `employee` (`EmployeeID`),
  ADD CONSTRAINT `leaveapplication_ibfk_2` FOREIGN KEY (`AprroveEmpID_FK`) REFERENCES `admin` (`EmployeeID`),
  ADD CONSTRAINT `leaveapplication_ibfk_3` FOREIGN KEY (`LeaveTypeID_FK`) REFERENCES `leavetype` (`LeaveID`);

--
-- Constraints for table `leavetype`
--
ALTER TABLE `leavetype`
  ADD CONSTRAINT `leavetype_ibfk_1` FOREIGN KEY (`Admin_ID_FK`) REFERENCES `admin` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
