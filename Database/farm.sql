-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2022 at 07:28 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farm`
--
DROP DATABASE IF EXISTS `farm`;
CREATE DATABASE `farm`;
USE `farm`;
-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(255) CHARACTER SET latin1 NOT NULL,
  `createuser` varchar(255) DEFAULT NULL,
  `deleteuser` varchar(255) DEFAULT NULL,
  `createbid` varchar(255) DEFAULT NULL,
  `updatebid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`, `createuser`, `deleteuser`, `createbid`, `updatebid`) VALUES
(1, 'Admin', '1', '1', '1', '1'),
(2, 'RManager', NULL , NULL , '1', '1'),
(3, 'Cashier', NULL, NULL, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_out`
--

CREATE TABLE `losses` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `productname` VARCHAR(50) NOT NULL,
  `quantity` INT NOT NULL,
  `cause` VARCHAR(50) NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `date`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_losses_productname ON losses(productname);

INSERT INTO losses(productname, quantity, cause, type) VALUES
('Layers', 10, 'Damage', 'before stockin'),
('Broilers', 5, 'Theft', 'before stockin'),
('Duck Eggs', 8, 'Theft', 'before stockin'),
('Male Ducks', 20, 'Damage', 'after stockin'),
('Goose Eggs', 15, 'Theft', 'after stockin'),
('Male Goose', 6, 'Theft', 'after stockin'),
('Female Goose', 12, 'Damage', 'after stockin'),
('Ducklings', 9, 'Death', 'after stockin'),
('Goslings', 3, 'Death', 'after stockin'),
('Layers', 17, 'Damage', 'before stockin'),
('Broilers', 11, 'Death', 'before stockin'),
('Duck Eggs', 4, 'Theft', 'before stockin'),
('Male Ducks', 7, 'Damage', 'before stockin'),
('Goose Eggs', 14, 'Theft', 'before stockin'),
('Mature Goose', 2, 'Damage', 'before stockin');


-- --------------------------------------------------------
CREATE TABLE `expenses` (
	`id` int(11) auto_increment not null primary key,
    `name` varchar(20) not null,
    `description` varchar(200) NOT NULL,
    `total` int(20) NOT NULL,
    `status` int(2) NOT NULL DEFAULT 0,
    `date` timestamp NULL DEFAULT current_timestamp()
    ) engine=InnoDB DEFAULT CHARSET=latin1;
--
CREATE INDEX idx_expense
ON expenses (id);
INSERT INTO `expenses` (`name`, `description`, `total`) VALUES
('Feed', 'Purchase of chicken feed', 1000),
('Medication', 'Purchase of medication for sick chickens', 500),
('Chicks', 'Purchase of day-old chicks', 2000),
('Rent', 'Monthly rent for the poultry house', 3000),
('Electricity', 'Monthly electricity bill for the poultry house', 1500),
('Water', 'Monthly water bill for the poultry house', 500),
('Labor', 'Salary for farm workers', 5000),
('Vaccine', 'Purchase of vaccines for chickens', 1000),
('Transportation', 'Cost of transporting chickens to the market', 2000),
('Marketing', 'Cost of advertising and marketing', 1000),
('Supplies', 'Purchase of cleaning supplies and other supplies', 500),
('Fuel', 'Purchase of fuel for the generator', 1000),
('Repairs', 'Repairs to equipment and structures', 1500),
('Insurance', 'Insurance premium for the poultry farm', 2000),
('Taxes', 'Taxes paid to the government', 1000);
        
-- Table structure for table `forget_password`
--

CREATE TABLE `forget_password` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `temp_key` varchar(200) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE INDEX idx_email
ON forget_password (id);
-- -- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `Staffid` varchar(20) DEFAULT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `Photo` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'avatar15.jpg',
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX idx_admin
ON tbladmin (id);
--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `Staffid`, `AdminName`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Status`, `Photo`, `Password`, `AdminRegdate`) VALUES
(1, 'ADM-001', 'Admin', 'Francis', 'Nzuki', 0701723886, 'nzukifrancis20@gmail.com', 1, 'francis.jpg', '21232f297a57a5a743894a0e4a801fc3', '2022-10-15 10:18:39');
-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(200) DEFAULT NULL,
  `CategoryCode` varchar(50) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `CategoryCode`, `PostingDate`) VALUES
(1, 'GEESE', 'EGG-001', '2022-10-13 18:28:24'),
(2, 'CHICKEN', 'CKN-001', '2022-10-13 18:28:40'),
(3, 'DUCKS', 'CKN-001', '2022-10-13 18:28:40'),
(4, 'TURKEYS', 'CKN-001', '2022-10-13 18:28:40'),
(5, 'GOOSE', 'CKN-001', '2022-10-13 18:28:40');

-- --------------------------------------------------------
CREATE INDEX idx_category
ON tblcategory (id);
--
-- Table structure for table `tblcompany`
--

CREATE TABLE `tblcompany` (
  `id` int(11) NOT NULL,
  `regno` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `companyname` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `companyemail` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `country` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `companyphone` text NOT NULL,
  `companyaddress` varchar(255) CHARACTER SET latin1 NOT NULL,
  `companylogo` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'avatar15.jpg',
  `status` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `developer` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
CREATE INDEX idx_Id
ON tblcompany (id);
-- Dumping data for table `tblcompany`
--

INSERT INTO `tblcompany` (`id`, `regno`, `companyname`, `companyemail`, `country`, `companyphone`, `companyaddress`, `companylogo`, `status`, `developer`, `creationdate`) VALUES
(1, '3422232443223', 'KEEN Poultry Farm', 'keenpoultry@gmail.com', 'Kenya', '+254701723886', 'Nakuru', 'poultrylogo.png', '1', 'Francis', '2022-11-01 12:17:15');

-- ------------------------------------------------------
--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `InvoiceNumber` varchar(20) DEFAULT NULL,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerContactNo` bigint(12) DEFAULT NULL,
  `PaymentMode` varchar(100) DEFAULT NULL,
  `InvoiceGenDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` int(2) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
INSERT INTO `tblorders` (`id`, `ProductId`, `Quantity`, `InvoiceNumber`, `CustomerName`, `CustomerContactNo`, `PaymentMode`, `InvoiceGenDate`, `Status`) VALUES
(1, 2, 5, 'INV001', 'John Doe', 1234567890, 'Cash', '2023-03-30 12:00:00', 1),
(2, 8, 2, 'INV002', 'Jane Smith', 9876543210, 'Mpesa', '2023-03-30 12:15:00', 1),
(3, 4, 10, 'INV003', 'Bob Johnson', 5551234567, 'Cash', '2023-03-30 12:30:00', 1),
(4, 12, 1, 'INV004', 'Samantha Lee', 1112223333, 'Mpesa', '2023-03-30 12:45:00', 1),
(5, 3, 3, 'INV005', 'Tom Wilson', 4445556666, 'Cash', '2023-03-30 13:00:00', 1),
(6, 7, 8, 'INV006', 'Linda Chen', 9998887777, 'Mpesa', '2023-03-30 13:15:00', 1),
(7, 1, 2, 'INV007', 'Mike Davis', 7778889999, 'Cash', '2023-03-30 13:30:00', 1),
(8, 11, 1, 'INV008', 'Amy Kim', 3334445555, 'Mpesa', '2023-03-30 13:45:00', 1),
(9, 14, 5, 'INV009', 'David Lee', 2223334444, 'Cash', '2023-03-30 14:00:00', 1),
(10, 5, 10, 'INV010', 'Emily Chen', 6667778888, 'Mpesa', '2023-03-30 14:15:00', 1),
(11, 9, 3, 'INV011', 'Jessica Wu', 1112223333, 'Cash', '2023-03-30 14:30:00', 1),
(12, 6, 4, 'INV012', 'Mark Lee', 7776665555, 'Mpesa', '2023-03-30 14:45:00', 1),
(13, 10, 2, 'INV013', 'Jennifer Kim', 4445556666, 'Cash', '2023-03-30 15:00:00', 1),
(14, 13, 1, 'INV014', 'Alex Chang', 2223334444, 'Mpesa', '2023-03-30 15:15:00', 1),
(15, 15, 3, 'INV015', 'Sarah Lee', 9998887777, 'Cash', '2023-03-30 15:30:00', 1);


CREATE INDEX idx_ProductId
ON tblorders (ProductId);
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `ProductName` varchar(150) DEFAULT NULL,
  `ProductImage` varchar(255) DEFAULT NULL,
  `ProductPrice` decimal(10,0) DEFAULT NULL,
  `quantity_rem` integer(15) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE INDEX idx_ProductId
ON tblproducts (id);

INSERT INTO `tblproducts` (`id`, `CategoryName`, `ProductName`, `ProductImage`, `ProductPrice`, `quantity_rem`, `PostingDate`, `UpdationDate`) VALUES
(1, 'Chicken', 'Layers', 'layers.jpg', 1000, 1060, '2023-03-30 10:00:00', NULL),
(2, 'Chicken', 'Broilers', 'broilers.jpg', 1200, 5700, '2023-03-30 10:00:00', NULL),
(3, 'Ducks', 'Duck eggs', 'duck_eggs.jpg', 3, 800, '2023-03-30 10:00:00', NULL),
(4, 'Ducks', 'Male Duck', 'duck_meat.jpg', 12, 400, '2023-03-30 10:00:00', NULL),
(5, 'Goose', 'Goose eggs', 'goose_eggs.jpg', 4, 600, '2023-03-30 10:00:00', NULL),
(6, 'Goose', 'Mal Goose', 'goose_male.jpg', 15, 300, '2023-03-30 10:00:00', NULL),
(9, 'Ducks', 'Ducklings', 'ducklings.jpg', 800, 1270, '2023-03-30 10:00:00', NULL),
(10, 'Ducks', 'Mature ducks', 'mature_ducks.jpg', 2000, 508, '2023-03-30 10:00:00', NULL),
(11, 'Goose', 'Goslings', 'goslings.jpg', 500, 800, '2023-03-30 10:00:00', NULL),
(12, 'Goose', 'Mature geese', 'mature_geese.jpg', 2500, 300, '2023-03-30 10:00:00', NULL);

--

-- Indexes for dumped tables
--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcompany`
--
ALTER TABLE `tblcompany`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblitems`
--
-- ALTER TABLE `tblproducts`
--   ADD UNIQUE (`ProductName`);
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
-- ------------------------
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tblcompany`
--
ALTER TABLE `tblcompany`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
