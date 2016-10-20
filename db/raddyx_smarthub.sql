-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2016 at 03:46 AM
-- Server version: 5.5.52-cll
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `raddyx_smarthub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE IF NOT EXISTS `admin_settings` (
  `id` int(11) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `bcc_email` varchar(100) NOT NULL,
  `from_email` varchar(100) NOT NULL,
  `support_email` varchar(100) NOT NULL,
  `site_name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `admin_email`, `bcc_email`, `from_email`, `support_email`, `site_name`) VALUES
(1, 'admin@smarthub.com', 'pradeepta20@gmail.com', 'info@smarthub.com', 'support@smarthub.com', 'SmartHub');

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE IF NOT EXISTS `mail_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `is_active` tinyint(4) NOT NULL COMMENT '1=Active / 0= Not',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `name`, `subject`, `content`, `is_active`) VALUES
(1, 'WELCOME_EMAIL', 'Welcome email', '<p>Hi [USERNAME],</p>\r\n\r\n<p>Thank you for creating an account with [SITE_NAME]</p>\r\n\r\n<p>Below are your login details.</p>\r\n\r\n<p>Username : [USERNAME]</p>\r\n\r\n<p>Password: [PASSWORD]</p>\r\n\r\n<p>Please click the below button to activate your account.</p>\r\n\r\n<p>[LINK]</p>\r\n\r\n<p>If above button&nbsp;is not working,copy and paste below link into your browser url.</p>\r\n\r\n<p>[LINK_TEXT]</p>\r\n\r\n<p>You can explore all of our valuable resources available to you now. You can also easily update your profile details if you need to.</p>\r\n\r\n<p>We hope you enjoy using our service, if you need any assistance please do not hesitate to contact our team at support@free4lancer.com.We are more than happy to help.</p>\r\n\r\n<p>Best Regards,</p>\r\n\r\n<p>Team [SITE_NAME]</p>\r\n\r\n<p>&nbsp;</p>\r\n', 1),
(2, 'FORGOT_PASSWORD', 'Forgot Password', '<p>&nbsp;</p>  <p>Hi [NAME],</p>  <p>As per your request the password has been reset!</p>  <p>Your updated login details are,</p>  <p> Email : [EMAIL]</p> <p> Password : [PASSWORD]</p>  <p>&nbsp;</p>  <p>Best Regards,</p>  <p>[SITENAME]</p>  <p>&nbsp;</p>', 1),
(3, 'PAYMENT_NOTIFICATION', 'Payment Notification', '<p>&nbsp;</p>\r\n\r\n<p>Hi  [NAME], </p>\r\n\r\n<p>This letter is a reminder for you to pay your bill for the month of [MONTH] .The payment for your bill for the month of [MONTH]  is due on the [DUE_DATE] and we request to you to pay it as soon as possible to enjoy uninterrupted services.</p>\r\n\r\n<p><b>Merchnat</b> : [MERCHNAT]</p>\r\n\r\n<p><b>Merchnat Note</b> : [NOTE]</p>\r\n\r\n<p><b>Customer ID: </b>[CUST_ID]</p>\r\n \r\n<p><b>Bill Amount : </b>[BILL_AMOUNT]</p>\r\n\r\n<p><b>Due Date : </b>[DUE_DATE]</p>\r\n\r\n<p><b>Last Payment Date : </b>[LAST_PAYMENT_DATE]</p>\r\n\r\n<p>Please click below link to pay your bill.</p>\r\n\r\n<p>[LINK]</p>\r\n\r\n<p>If you want to pay your bill directlly without logging into the website.Then click below link</p>\r\n\r\n<p>[DIRECT_LINK]</p>\r\n\r\n<p>Similarlly if you want to view all yours payment history and upcoming payment without logging into the website, then open below link and use you customer id code whcih is mentioned above.</p>\r\n\r\n<p>[VIEW_TRANSACTION_LINK]</p>\r\n\r\n<p>We hope to serve our customers well and solve their queries from time to time. So if you want to enjoy our service like before make sure you pay your bill on time. This letter is just a reminder to you regarding bill payment.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>If you have any kind of queries you can inform us at [SUPPORT_EMAIL] and kindly clear the payment as soon as possible</p> \r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Best Regards , </p> \r\n\r\n<p> Team [SITE_NAME] </p>\r\n\r\n<p>&nbsp;</p>', 1),
(4, 'PAYMENT_CONFIRMATION', 'Payment Confirmation Reciept', '<p>&nbsp;</p>\r\n<p>Dear  [NAME], </p>\r\n\r\n<p>The following is a confirmation of you bill payment of Rs. [BILL_AMOUNT] for the merchnat <b>[MERCHANT]</b>.</p>\r\n\r\n<p><b>Merchant</b> : [MERCHANT]</p>\r\n<p><b>Merchnat Note</b> : [NOTE]</p>\r\n<p><b>Customer ID: </b>[CUST_ID]</p> \r\n<p><b>Bill Amount : </b>[BILL_AMOUNT]</p>\r\n<p><b>Payment Date : </b>[PAYMENT_DATE]</p>\r\n\r\n<p>Thank you for using [SITE_NAME] for paying your bill .</p>\r\n\r\n<p>If you have any kind of queries you can inform us at [SUPPORT_EMAIL] and kindly clear the payment as soon as possible</p> \r\n\r\n<p>&nbsp;</p>\r\n\r\n<p> Best Regards , </p> \r\n<p> Team [SITE_NAME] </p>\r\n\r\n<p>&nbsp;</p>', 1),
(5, 'PAYMENT_FAILURE', 'Payment Failed', '<p>&nbsp;</p>\r\n<p>Dear  [NAME], </p>\r\n\r\n<p>Your payment of Rs. [BILL_AMOUNT] for the merchnat <b>[MERCHANT]</b> was failed due some error.You can pay your bill again by using the payment link whcih was sent to you.</p>\r\n\r\n<p><b>Merchant</b> : [MERCHANT]</p>\r\n<p><b>Merchnat Note</b> : [NOTE]</p>\r\n<p><b>Customer ID: </b>[CUST_ID]</p> \r\n<p><b>Bill Amount : </b>[BILL_AMOUNT]</p>\r\n<p><b>Due Date : </b>[DUE_DATE]</p>\r\n\r\n<p>If you have any kind of queries you can inform us at [SUPPORT_EMAIL] and kindly clear the payment as soon as possible</p> \r\n\r\n<p>&nbsp;</p>\r\n\r\n<p> Best Regards , </p> \r\n<p> Team [SITE_NAME] </p>\r\n\r\n<p>&nbsp;</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `merchant_profiles`
--

CREATE TABLE IF NOT EXISTS `merchant_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `merchant_profiles`
--

INSERT INTO `merchant_profiles` (`id`, `user_id`, `logo`, `created`, `modified`) VALUES
(1, 3, 'fa06ef57576c08fee0265100741680de.jpg', '2016-09-01 07:42:23', '2016-09-01 07:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(100) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `uploaded_payment_file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `custom_fields` varchar(1000) NOT NULL,
  `total_fee` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=Paid/0=Unpaid',
  `due_date` date NOT NULL,
  `payment_date` date NOT NULL,
  `followup_counter` tinyint(4) NOT NULL COMMENT 'No of times mail sent',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `uniq_id`, `merchant_id`, `uploaded_payment_file_id`, `user_id`, `name`, `email`, `phone`, `custom_fields`, `total_fee`, `status`, `due_date`, `payment_date`, `followup_counter`, `created`, `modified`) VALUES
(4, 'a4700b75624c130f6aeaba5021261409', 3, 3, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '8000.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:00', '2016-09-01 09:45:00'),
(5, 'f77abb2935aebf825064c06b1536b7cd', 3, 3, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400}', '600.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:00', '2016-09-01 09:45:00'),
(6, '07d0c97ca5f27cb40507199d25d4ecef', 3, 4, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '8000.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:35', '2016-09-01 09:45:35'),
(7, '009bf9b18d207ad8e2ad61001ea1e75d', 3, 4, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400}', '600.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:35', '2016-09-01 09:45:35'),
(8, '889fc3b62809a52a0a8fda4a6236da38', 3, 4, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '8000.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(9, '5a782e47bb26827f6bafa0b0694bf76a', 3, 4, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400}', '600.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(10, '4d31fe8f37299099ba7db7c04ccc6256', 3, 4, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '8000.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(11, '7ebdd00c1b49e6ac72241b41fc27b3b9', 3, 4, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400}', '600.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(12, '36691d19d4f7f138e7a9186c06fb5ce9', 3, 4, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '8000.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(13, '6564e40dcb21ece696a69e59997f8754', 3, 4, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400}', '600.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(14, '109b46794f0526ae015116e7ec64555f', 3, 4, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '8000.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(15, '6ba5f119acf68e45c843264c395280a7', 3, 4, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400}', '600.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(16, '89fce7d4d65b14a9c2e7f613b5006475', 3, 4, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '8000.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(17, 'aa77c6bbe5f65afd934dbf5796ea10ac', 3, 4, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400}', '600.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 09:45:45', '2016-09-01 09:45:45'),
(18, '338a832b8b87209f3c874a050c5256c7', 3, 5, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300,"gas_bill":8000}', '100.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(19, '50a1c4209f5a68d2271a7ef659819fb7', 3, 5, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400,"gas_bill":600}', '200.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(20, 'ed386e015915c3e7815ef4375c268737', 3, 5, 135, 'Rajesh Purohit', 'rajesh@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '666.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(22, '59074db1871d065fa7085b3dd9568f2e', 3, 5, 136, 'Sanjib Pradhan', 'psanjib.tutu@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(23, '6f2b59c9ce982956cda65bb19854f98f', 3, 5, 137, 'Debasish Das', 'debadash00@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(24, 'e3f99894fb0b34b5b1e38fe53603406e', 3, 5, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400,"gas_bill":600}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(25, 'bb815303623be70677bcbaf126022acd', 3, 5, 136, 'Sanjib Pradhan', 'psanjib.tutu@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(26, '92ec263067ae3c486479958b21f88f95', 3, 5, 136, 'Sanjib Pradhan', 'psanjib.tutu@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(27, 'aeda764c0277db6fdddd2c431ba72fb6', 3, 5, 138, 'Sanghamitra Rout', 'srout@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '666.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(28, 'cf21d14ac689c7d8a474f150604107ba', 3, 5, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300,"gas_bill":8000}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(29, '7156bae41e26bf8bebe9963ec71366ac', 3, 5, 135, 'Rajesh Purohit', 'rajesh@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(31, '4825f4bad6992eb0d6c6ae606bb0ab30', 3, 5, 135, 'Rajesh Purohit', 'rajesh@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(32, '0a2dbb579fe71b3abede6a8dd8f421e1', 3, 5, 139, 'Partha Sarathi Mahrana', 'partha@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '888.00', 1, '2016-09-30', '2016-09-01', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(33, '3fba037f641d02de94ec8bcf07a0b035', 3, 5, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400,"gas_bill":600}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(34, 'ab6909fedbf9c8cdc733794cd3be58cb', 3, 5, 140, 'Kanhu Charan Rath', 'kanhu@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(35, 'b707b78fccaddb56da2c4f8092548d55', 3, 5, 139, 'Partha Sarathi Mahrana', 'partha@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(36, '21d87fc56b1decbb3eca0609d81e3d8c', 3, 5, 137, 'Debasish Das', 'debadash00@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(37, '231dd61a3ce47776d93e2aa6dedacf75', 3, 5, 138, 'Sanghamitra Rout', 'srout@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(38, '0dc1966d7746e1eb97a5608a8d707368', 3, 5, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300,"gas_bill":8000}', '100.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:05', '2016-09-01 10:09:05'),
(39, '8d97cc01bdfb1f252d26dc33a9b79fdc', 3, 5, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400,"gas_bill":600}', '200.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:05', '2016-09-01 10:09:05'),
(40, '5252576e20e8df9aa2254e6fb1f76679', 3, 5, 135, 'Rajesh Purohit', 'rajesh@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '666.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(41, 'b8bd78ba301b4a3544bc3fd99b5c36f9', 3, 5, 69, 'Pradeepta Khatoi', 'pradeepta20@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300,"gas_bill":0}', '666.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(42, '80739b9aa13d1b04bace9f3c984a7eab', 3, 5, 136, 'Sanjib Pradhan', 'psanjib.tutu@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(43, '490f8b30dda0389af9776ce25f29a9df', 3, 5, 137, 'Debasish Das', 'debadash00@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(44, '2336de2ae9340252ace964522142643a', 3, 5, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400,"gas_bill":600}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(45, 'afd0c37f3486a33ae4a6be3bc807bd92', 3, 5, 136, 'Sanjib Pradhan', 'psanjib.tutu@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(46, 'b1f4705e36906fe12d061d71acdec31d', 3, 5, 136, 'Sanjib Pradhan', 'psanjib.tutu@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(47, '10a43bb987d388186f86dffa8cd3f777', 3, 5, 138, 'Sanghamitra Rout', 'srout@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '666.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(48, '161c45149058cdc32eccef4a793e4641', 3, 5, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300,"gas_bill":8000}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(49, '54bd90d0a279059524e179be323c1f2c', 3, 5, 135, 'Rajesh Purohit', 'rajesh@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '66.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(50, '54c19cbe0b86b00bc5e95b742eaaa460', 3, 5, 69, 'Pradeepta Khatoi', 'pradeepta20@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300,"gas_bill":0}', '88.00', 1, '2016-09-30', '2016-09-08', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(51, '9764f93eb7041ea465eaf7de672e0f16', 3, 5, 135, 'Rajesh Purohit', 'rajesh@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(52, '5d78a27ce4e467f68adafbc70e907687', 3, 5, 139, 'Partha Sarathi Mahrana', 'partha@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '888.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(53, '2288455d4ff7f5d2b231c76a6eac7e88', 3, 5, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400,"gas_bill":600}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(54, '3d0d1ee6c80e7518d52ef8661ff1369b', 3, 5, 140, 'Kanhu Charan Rath', 'kanhu@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(55, '04263096d99a53920f9f62aee82f0f9d', 3, 5, 139, 'Partha Sarathi Mahrana', 'partha@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(56, '36c2df0efc4811188430a9502af53e54', 3, 5, 137, 'Debasish Das', 'debadash00@gmail.com', '3333333333', '{"electic_bill":300,"water_bill":400,"gas_bill":5500}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(57, '792afa3fb86aef4d40871df74815110f', 3, 5, 138, 'Sanghamitra Rout', 'srout@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000,"gas_bill":903.55}', '88.00', 0, '2016-09-30', '0000-00-00', 1, '2016-09-01 10:09:06', '2016-09-01 10:09:06'),
(60, 'bd77fae01d8b0c8e59956ba6e7644700', 3, 7, 133, 'Sarat Das', 'sarat@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '8000.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 13:52:13', '2016-09-01 13:52:13'),
(61, '74eb9040a8cbb28ad4c7925951cfadcd', 3, 7, 134, 'Charan Maharana', 'charan@gmail.com', '2222222222', '{"electic_bill":200,"water_bill":400}', '600.00', 0, '2016-09-08', '0000-00-00', 1, '2016-09-01 13:52:13', '2016-09-01 13:52:13'),
(62, '1fbad3a75dff7a5720ec25ce87447c61', 3, 7, 69, 'Pradeepta Khatoi', 'pradeepta20@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '500.00', 0, '2016-09-29', '0000-00-00', 1, '2016-09-01 13:52:13', '2016-09-01 13:52:13'),
(63, 'a4f064c6094005d1f006dfb07c4fcef3', 3, 7, 140, 'Kanhu Charan Rath', 'kanhu@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000}', '903.55', 0, '2016-09-29', '0000-00-00', 1, '2016-09-01 13:52:13', '2016-09-01 13:52:13'),
(64, '19f75381d755313c6f9ff10589dbaa30', 3, 10, 69, 'Pradeepta Khatoi', 'pradeepta20@gmail.com', '1111111111', '{"electic_bill":100,"water_bill":300}', '500.00', 0, '2016-09-29', '0000-00-00', 1, '2016-09-20 09:28:53', '2016-09-20 09:28:53'),
(65, 'e04b1908347838a8207d7eee6283a150', 3, 10, 140, 'Kanhu Charan Rath', 'kanhu@gmail.com', '4444444444', '{"electic_bill":400,"water_bill":5000}', '903.55', 0, '2016-09-29', '0000-00-00', 1, '2016-09-20 09:28:53', '2016-09-20 09:28:53'),
(66, 'c32c315bc1f9832dbb99c6fd50d92933', 3, 11, 141, 'kamakshi', 'kamakshi.khaneja@hdfcbank.com', '74747848484', '{"electic_bill":12,"water_bill":123}', '4565.00', 0, '2016-09-20', '0000-00-00', 1, '2016-09-20 10:19:20', '2016-09-20 10:19:20'),
(67, '663df528068ab9dfb528c59b095e177b', 3, 11, 142, 'bhupendra', 'bhupendra.khatri@payu.in', '8377884231', '{"electic_bill":15,"water_bill":67}', '76.00', 0, '2016-09-20', '0000-00-00', 1, '2016-09-20 10:19:20', '2016-09-20 10:19:20');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_payment_files`
--

CREATE TABLE IF NOT EXISTS `uploaded_payment_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `title` varchar(250) NOT NULL,
  `note` varchar(200) NOT NULL,
  `custom_fields` varchar(500) NOT NULL,
  `payment_count` int(11) NOT NULL,
  `upload_completed` tinyint(4) NOT NULL COMMENT '1=Yes/0=no',
  `is_confirmed` tinyint(4) NOT NULL COMMENT '1=Yes/0=No',
  `last_payment_date` date NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `uploaded_payment_files`
--

INSERT INTO `uploaded_payment_files` (`id`, `merchant_id`, `file`, `title`, `note`, `custom_fields`, `payment_count`, `upload_completed`, `is_confirmed`, `last_payment_date`, `created`) VALUES
(3, 3, '2dd9b2feede6653f4af9ead5e43c64f6-Payments -10.xlsx', 'Payments -10.xlsx', 'Test-1', '{"electic_bill":"Electic Bill","water_bill":"Water Bill"}', 2, 1, 0, '2016-09-30', '2016-09-01 09:44:58'),
(4, 3, 'caa5ce8abf558bc893fa22483da6d67e-Payments -1000.xlsx', 'Payments -1000.xlsx', 'Test-2', '{"electic_bill":"Electic Bill","water_bill":"Water Bill"}', 12, 1, 0, '2016-09-29', '2016-09-01 09:45:17'),
(5, 3, 'bc54f1b2ec03866887813ccc1b6c4c3f-Payments -100.xlsx', 'Payments -100.xlsx', 'Test-3', '{"electic_bill":"Electic Bill","water_bill":"Water Bill","gas_bill":"Gas Bill"}', 38, 1, 0, '2016-09-30', '2016-09-01 10:07:56'),
(7, 3, '91977eb9948524edcb1b71120a72415e-Payments -10.xlsx', 'Payments -10.xlsx', 'Test-4', '{"electic_bill":"Electic Bill","water_bill":"Water Bill"}', 4, 1, 0, '2016-09-30', '2016-09-01 13:52:13'),
(8, 3, '2dac8c7fbf246d301dda48d20f499d17-SampleExcel pay u.xlsx', 'SampleExcel pay u.xlsx', 'Bill for house rent', '{"electricity_bill":"Electricity Bill","water_bill":"Water Bill","parking_charges":"Parking Charges"}', 0, 1, 0, '2016-09-30', '2016-09-20 06:19:33'),
(9, 3, '1cb41b2716cce0e76976d63bbd8942c2-SampleExcel pay u.xlsx', 'SampleExcel pay u.xlsx', 'Maintainance Bill', '{"electricity_bill":"Electricity Bill","water_bill":"Water Bill","parking_charges":"Parking Charges"}', 0, 1, 0, '2016-09-30', '2016-09-20 06:31:02'),
(10, 3, '954bbae47d17d013c6845e1cbd7de307-Payments -10.xlsx', 'Payments -10.xlsx', 'Pkk Test-1', '{"electic_bill":"Electic Bill","water_bill":"Water Bill"}', 2, 1, 0, '2016-09-30', '2016-09-20 09:28:52'),
(11, 3, 'b85639d8ee2495ae9c37dd7699704568-SampleExcel (5).xlsx', 'SampleExcel (5).xlsx', 'sample billll', '{"electic_bill":"Electic Bill","water_bill":"Water Bill"}', 2, 1, 0, '2016-09-30', '2016-09-20 10:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` varchar(20) NOT NULL,
  `uniq_id` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(256) NOT NULL,
  `created_by` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1=Sys Admin/2=bank/3=Merchant/4=Customer',
  `is_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Active/0=In-Active',
  `last_login_date` datetime NOT NULL,
  `last_login_ip` varchar(25) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `cust_id`, `uniq_id`, `email`, `password`, `name`, `phone`, `address`, `created_by`, `type`, `is_active`, `last_login_date`, `last_login_ip`, `created`, `modified`) VALUES
(1, '100000001', '026232a816372579655bf2224567891', 'admin@smarthub.com', '$2y$10$CQ7SeeDokW8ofNzoaQhR4eBkjeI5DTfLAqyPj.DQ9J5Nc6VAunIdq', '', '', '', 0, 1, 1, '2016-10-18 07:10:41', '202.191.214.174', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '100000002', '026232a816372579655bfrr24567892', 'branchadmin@smarthub.com', '$2y$10$CQ7SeeDokW8ofNzoaQhR4eBkjeI5DTfLAqyPj.DQ9J5Nc6VAunIdq', '', '', '', 0, 2, 1, '2016-10-18 07:11:49', '202.191.214.174', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '100000003', '026232ggh5372579655bf2224567893', 'merchant@smarthub.com', '$2y$10$CQ7SeeDokW8ofNzoaQhR4eBkjeI5DTfLAqyPj.DQ9J5Nc6VAunIdq', 'ME- 1', '8888888888', 'BBSR', 2, 3, 1, '2016-10-17 16:40:20', '1.39.40.82', '0000-00-00 00:00:00', '2016-09-20 09:52:11'),
(69, '100000069', '026232ggghj725796h55bf2224567894', 'pradeepta20@gmail.com', '$2y$10$RgPZW8aksCNToANFhqzKROKEew8dfAFK1DecCDLjT3i1WdYMmfM5W', '', '', '', 0, 4, 1, '2016-10-14 14:40:32', '182.74.170.70', '2016-08-19 07:39:09', '2016-08-31 10:43:15'),
(133, '100000134', '57b7cb5f1c1b96bf8fd8278b1b0a34d1', 'sarat@gmail.com', '', 'Sarat Das', '1111111111', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-08-31 13:14:17', '2016-08-31 13:14:17'),
(134, '100000134', '56bb030e1b1f4bd822bd86f5c304ce14', 'charan@gmail.com', '', 'Charan Maharana', '2222222222', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-08-31 13:14:17', '2016-08-31 13:14:17'),
(135, '100000135', '864f2d990d27e844babf34046ca8899a', 'rajesh@gmail.com', '', 'Rajesh Purohit', '3333333333', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-08-31 13:14:17', '2016-08-31 13:14:17'),
(136, '100000136', '094fbbc9d9d1788fed2d916fe16078c3', 'psanjib.tutu@gmail.com', '', 'Sanjib Pradhan', '3333333333', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(137, '100000137', '96e606b83a08af64f78796aeefe683e0', 'debadash00@gmail.com', '', 'Debasish Das', '3333333333', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(138, '100000138', 'c2b7cc294407b7ecc79e6efd8c9899df', 'srout@gmail.com', '', 'Sanghamitra Rout', '4444444444', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(139, '100000139', '8b8d7564d57a832a5ac2b419922dfb0d', 'partha@gmail.com', '', 'Partha Sarathi Mahrana', '4444444444', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(140, '100000140', '0a1756a8056fec22e8ecd99fca2098fc', 'kanhu@gmail.com', '', 'Kanhu Charan Rath', '4444444444', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-09-01 10:07:57', '2016-09-01 10:07:57'),
(141, '100000141', 'e686e44fc9723bf80d04566034f4dadd', 'kamakshi.khaneja@hdfcbank.com', '', 'kamakshi', '74747848484', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-09-20 10:19:20', '2016-09-20 10:19:20'),
(142, '100000142', 'dfa3d0c2c214e84ddf05332f1cb3508a', 'bhupendra.khatri@payu.in', '', 'bhupendra', '8377884231', '', 3, 4, 1, '0000-00-00 00:00:00', '', '2016-09-20 10:19:20', '2016-09-20 10:19:20');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
