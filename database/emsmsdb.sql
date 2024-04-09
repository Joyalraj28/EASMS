CREATE TABLE `system_info` (
  `id` int(30) PRIMARY KEY  AUTO_INCREMENT NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Employee aattendance and salary management'),
(2, 'short_name', 'EASMS'),
(3, 'logo', 'uploads/1706500320_EMS.png'),
(4, 'user_avatar', 'uploads/user_avatar.jpg'),
(5, 'cover', 'uploads/1706501340_startup-593341_1280.jpg'),
(6,'login_bg', 'uploads/login_background.jpg')



CREATE TABLE Employee(
  EmployeeID INT PRIMARY KEY AUTO_INCREMENT,
  Avatar BLOB,
  Fullname VARCHAR(50),
  Gender VARCHAR(10),
  DOB DATE,
  Status BIT,
  Address VARCHAR(100),
  NetSalary DECIMAL(4,2),
  Email VARCHAR(50),
  Password VARCHAR(50),
  DesignationID_FK INT,
  FOREIGN KEY (DesignationID_FK) REFERENCES designation(DesignationID),
  Admin_ID_FK INT,
  FOREIGN KEY (Admin_ID_FK) REFERENCES Admin(EmployeeID)
);

CREATE TABLE EmployeePhoneno(
	PhoneNo INT PRIMARY KEY,
    EmployeeID_FK INT,
    FOREIGN KEY (EmployeeID_FK) REFERENCES Employee(EmployeeID)
);

CREATE TABLE Accountant(
    EmployeeID INT PRIMARY KEY,
    PriorityLevel INT,
    ManageSalary BIT,
    ManageAttendance BIT
);

CREATE TABLE Admin(
    EmployeeID INT PRIMARY KEY,
    PriorityLevel INT,
    ManageEmployee BIT,
    ManageLeave BIT,
    ManageSalary BIT,
    ManageAttendance BIT
);

CREATE TABLE Department(
 DepartmentID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(50),
  Description VARCHAR(100),
  CreateDate DATETIME,
  UpdateDate DATETIME,
  Admin_ID_FK INT,
  FOREIGN KEY (Admin_ID_FK) REFERENCES Admin(EmployeeID)
);

CREATE TABLE Designation(
    DesignationID INT PRIMARY KEY AUTO_INCREMENT,
    ShortName VARCHAR(25),
    Name VARCHAR(50),
    Description VARCHAR(100),
    CreateDate DATETIME,
    UpdateDate DATETIME,
    Admin_ID_FK INT,
    DepartmentID_FK INT,
    FOREIGN KEY (DepartmentID_FK) REFERENCES Department(DepartmentID),
    FOREIGN KEY (Admin_ID_FK) REFERENCES Admin(EmployeeID)
);

CREATE TABLE LeaveType(
    LeaveID INT PRIMARY KEY,
    ShortName VARCHAR(50),
    Description VARCHAR(100),
    DefaultCredit INT,
    CreateDate DATETIME,
    UpdateDate DATETIME,
    Status BIT,
    Admin_ID_FK INT,
    FOREIGN KEY (Admin_ID_FK) REFERENCES Admin(EmployeeID)
    );


CREATE TABLE LeaveApplication (
    LeaveID INT PRIMARY KEY,
    ApplyEmpID_FK INT,
    LeaveDate Datetime,
    Reason VARCHAR(50),
    StartDate Datetime,
    EndDate datetime,
    Status Varchar(25),
    LeaveApplicationID_FK INT,
    AprroveEmpID_FK INT,
    FOREIGN KEY (ApplyEmpID_FK) REFERENCES employee(EmployeeID),
    FOREIGN KEY (AprroveEmpID_FK) REFERENCES Admin(EmployeeID),
    FOREIGN KEY (LeaveApplicationID_FK) REFERENCES LeaveType(LeaveID)
);

CREATE TABLE Attendance  (
    AttendanceID INT PRIMARY KEY,
    AttendanceDate Datetime,
    Signin Datetime,
    Lunch Datetime,
    Lunchout datetime, 
    Signout datetime, 
    LeaveApplicationID_FK INT,
    FOREIGN KEY (LeaveApplicationID_FK) REFERENCES LeaveType(LeaveID)
);

ALTER TABLE Employee 
ADD COLUMN AdminID_FK INT,
ADD FOREIGN KEY (AdminID_FK) REFERENCES Admin(EmployeeID)

ALTER TABLE Employee 
ADD COLUMN DesignationID_FK INT,
ADD FOREIGN KEY (DesignationID_FK) REFERENCES designation(DesignationID)