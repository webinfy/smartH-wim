-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 28, 2016 at 07:05 AM
-- Server version: 5.6.34
-- PHP Version: 5.6.28RC1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smarthub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

DROP TABLE IF EXISTS `admin_settings`;
CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `bcc_email` varchar(100) NOT NULL,
  `from_email` varchar(100) NOT NULL,
  `support_email` varchar(100) NOT NULL,
  `site_name` varchar(150) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `admin_email`, `bcc_email`, `from_email`, `support_email`, `site_name`, `created`, `modified`) VALUES
(1, 'admin@smarthub.com', 'pradeepta.raddyx@gmail.com', 'noreply@smarthub.com', 'support@smarthub.com', 'SmartHub', '2016-12-16 00:00:00', '2016-12-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password_otps`
--

DROP TABLE IF EXISTS `forgot_password_otps`;
CREATE TABLE `forgot_password_otps` (
  `id` int(11) NOT NULL,
  `uniqid` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forgot_password_otps`
--

INSERT INTO `forgot_password_otps` (`id`, `uniqid`, `user_id`, `otp`, `created`) VALUES
(1, '86a8ef402e498173f4cbdccf81f47e6d', 272, '737859', 1482833353);

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

DROP TABLE IF EXISTS `mail_templates`;
CREATE TABLE `mail_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `is_active` tinyint(4) NOT NULL COMMENT '1=Active / 0= Not',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `name`, `subject`, `content`, `is_active`, `created`, `modified`) VALUES
(1, 'WELCOME_EMAIL', 'Welcome email', '<p>Hi [USERNAME],</p>\r\n\r\n<p>Thank you for creating an account with [SITE_NAME]</p>\r\n\r\n<p>Below are your login details.</p>\r\n\r\n<p>Username : [USERNAME]</p>\r\n\r\n<p>Password: [PASSWORD]</p>\r\n\r\n<p>Please click the below button to activate your account.</p>\r\n\r\n<p>[LINK]</p>\r\n\r\n<p>If above button&nbsp;is not working,copy and paste below link into your browser url.</p>\r\n\r\n<p>[LINK_TEXT]</p>\r\n\r\n<p>You can explore all of our valuable resources available to you now. You can also easily update your profile details if you need to.</p>\r\n\r\n<p>We hope you enjoy using our service, if you need any assistance please do not hesitate to contact our team at support@smarthub.com.We are more than happy to help.</p>\r\n\r\n<p>Best Regards,</p>\r\n\r\n<p>Team [SITE_NAME]</p>\r\n\r\n<p>&nbsp;</p>\r\n', 1, '2016-10-26 00:00:00', '0000-00-00 00:00:00'),
(2, 'FORGOT_PASSWORD', 'Forgot Password', '<p>&nbsp;</p>  <p>Hi [NAME],</p>  <p>As per your request the password has been reset!</p>  <p>Your updated login details are,</p>  <p> Email : [EMAIL]</p> <p> Password : [PASSWORD]</p>  <p>&nbsp;</p>  <p>Best Regards,</p>  <p>[SITENAME]</p>  <p>&nbsp;</p>', 1, '2016-10-26 00:00:00', '2016-10-26 00:00:00'),
(5, 'PAYMENT_FAILURE', 'Payment Failed', '<p>&nbsp;</p>\r\n<p>Dear  [NAME], </p>\r\n<p>Your payment of Rs. [BILL_AMOUNT] for the merchant <b>[MERCHANT]</b> was failed due some error.You can pay your bill again by using the payment link which was sent to you.</p>\r\n\r\n<p><b>Merchant</b> : [MERCHANT]</p>\r\n<p><b>Webfront Title</b> : [WEBFRONT_TITLE]</p>\r\n<p><b>Customer Name: </b>[NAME]</p> \r\n<p><b>Customer Email: </b>[EMAIL]</p> \r\n<p><b>Customer Phone: </b>[PHONE]</p> \r\n<p><b>Bill Amount : </b>[BILL_AMOUNT]</p>\r\n<p><b>Payment Cycle Date : </b>[PAYMENT_CYCLE_DATE]</p>\r\n\r\n\r\n<p>If you have any kind of queries you can inform us at [SUPPORT_EMAIL] and kindly clear the payment as soon as possible</p> <p>&nbsp;</p>\r\n<p> Best Regards , </p> \r\n<p> Team [SITE_NAME] </p>\r\n<p>&nbsp;</p>', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'PAYMENT_NOTIFICATION', 'Payment Notification', '<p>&nbsp;</p>\r\n<p>Dear  [NAME], </p>\r\n<p>You have received a payment request from [MERCHANT] for INR [BILL_AMOUNT] against Invoice No [INVOICE_NO].</p> \r\n\r\n<p>Request you to click on the below url for initiating the payment by entering your mobile number & OTP.</p>\r\n\r\n<p>OTP will be sent via a separate mail.</p> \r\n<p><a href=\'[PAYMENT_LINK]\'>Click Here to Login and Pay.</a></p> \r\n\r\n<p>If you want to pay your bill directly without logging into the website.Then click below link</p>\r\n\r\n<p>[DIRECT_LINK]</p>\r\n\r\n<p>Similarly, if you want to view all your payment history and upcoming payment without logging into the website, then open below link and use your customer id code which is mentioned above.</p>\r\n\r\n<p>[VIEW_TRANSACTION_LINK]</p>\r\n\r\n\r\n<p>Regards,</p>\r\n<p>Admin [MERCHANT]</p>\r\n<p>This is an electronically auto generated e-mail. Please do not reply to this mail.</p>', 1, '2016-11-14 05:12:11', '2016-11-14 04:10:10'),
(7, 'WELCOME_EMAIL_TO_USER', 'Welcome email', '<p>Hi [NAME],</p>\r\n\r\n<p>We have creating an account with [SITE_NAME]</p>\r\n\r\n<p>Below are your login details.</p>\r\n\r\n<p>Username : [USERNAME]</p>\r\n\r\n<p>Password: [PASSWORD]</p>\r\n\r\n<p>You can explore all of our valuable resources available to you now. You can also easily update your profile details if you need to.</p>\r\n\r\n<p>We hope you enjoy using our service, if you need any assistance please do not hesitate to contact our team at support@smarthub.com.We are more than happy to help.</p>\r\n\r\n<p>Best Regards,</p>\r\n\r\n<p>Team [SITE_NAME]</p>\r\n\r\n<p>&nbsp;</p>\r\n', 1, '2016-10-27 00:00:00', '2016-10-27 00:00:00'),
(8, 'REGISTER_OTP', 'OTP for User Registration', '<p>&nbsp;</p>\r\n<p>Hi [NAME]</p>\r\n\r\n\r\n<p>Please use this below code as your otp</p>\r\n\r\n<p>OTP : [OTP]</p>\r\n\r\n<p>Best Regards,</p>\r\n<p>Team [SITE_NAME]</p>\r\n<p>&nbsp;</p>', 1, '2016-10-31 00:00:00', '2016-10-31 00:00:00'),
(9, 'PAYMENT_CONFIRMATION', 'Payment Confirmation Reciept', '<p>&nbsp;</p>\n<p>Dear  [NAME], </p>\n<p>&nbsp;</p>\n<p>Payment Confirmation.</p>\n<p>&nbsp;</p>\n<p>Your Payment of Rs.[BILL_AMOUNT] for Invoice [INVOICE_NO] is successful.</p>\n<p>&nbsp;</p>\n<p>This is an electronically auto generated e-mail. Please do not reply to this mail.</p>\n<p>&nbsp;</p>', 1, '2016-11-14 00:00:00', '2016-11-14 05:09:14'),
(15, 'PAYMENT_CONFIRMATION_MERCHANT', 'Payment Confirmation ', '<p>&nbsp;</p>\r\n<p>Dear  [MERCHANT], </p>\r\n<p>&nbsp;</p>\r\n\r\n<p>You have received a payment amount of Rs.[BILL_AMOUNT] from the customer [NAME].</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Customer Name : [NAME]</p>\r\n<p>Bill Amount : Rs.[BILL_AMOUNT]</p>\r\n<p>Invoice No. :[INVOICE_NO]</p>\r\n<p>Payment Date. :[PAYMENT_DATE]</p>\r\n<p>&nbsp;</p>\r\n\r\n<p>This is an electronically auto generated e-mail. Please do not reply to this mail.</p>\r\n<p>&nbsp;</p>', 1, '2016-11-14 00:00:00', '2016-11-14 05:09:14'),
(11, 'FORGOT_PASSWORD_OTP', 'OTP for Forgot Password', '<p>Hi [NAME]</p><p>Please use this below code as your otp for forgot password</p><p>OTP : [OTP]</p><p>Best Regards,</p><p>Team [SITE_NAME]</p>', 1, '2016-11-21 00:00:00', '2016-11-21 00:00:00'),
(12, 'FORGOT_PASSWORD_MAIL', 'Forgot Password', '<p>Hi &nbsp;[NAME],</p>\r\n\r\n<p>Thank you for getting in touch with us [SITE_NAME].</p>\r\n\r\n<p>Please click on below link to change your password.</p>\r\n\r\n<p>[LINK]</p>\r\n\r\n<p>If above link is not working please copy below URL and paste it in your Navigation bar</p>\r\n\r\n<p>[LINK_TEXT]</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>You can explore all of our valuble resources available to you now. You can also easily update your profile details if you need to.</p>\r\n\r\n<p>We hope you enjoy using our service, if you need any assistance please do not hesitate to contact our team at support@smarthub.com. &nbsp;We are more than happy to help.</p>\r\n\r\n<p>Best Regards,</p>\r\n\r\n<p>Team [SITE_NAME]</p>\r\n\r\n<p>&nbsp;</p>', 1, '2016-11-21 00:00:00', '2016-11-21 00:00:00'),
(13, 'PAYMENT_CONFIRMATION_SMS', 'Payment Confirmation SMS', 'Transaction No. [TXN_ID]  for Rs [BILL_AMOUNT] done for [MERCHANT] has [STATUS]', 1, '2016-12-02 00:00:00', '2016-12-02 00:00:00'),
(14, 'PAYMENT_NOTIFICATION_SMS', 'Payment Notification SMS', 'Use this Below Link to process Payment of amount INR [BILL_AMOUNT].[DIRECT_LINK]', 1, '2016-12-02 00:00:00', '2016-12-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `merchant_profiles`
--

DROP TABLE IF EXISTS `merchant_profiles`;
CREATE TABLE `merchant_profiles` (
  `id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `description` text,
  `logo` varchar(100) DEFAULT NULL,
  `payuid` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `facebook_url` varchar(100) DEFAULT NULL,
  `twitter_url` varchar(100) DEFAULT NULL,
  `convenience_fee_amount` decimal(10,2) DEFAULT NULL,
  `payu_key` varchar(255) DEFAULT NULL,
  `payu_salt` text,
  `regd_no` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `state` varchar(60) DEFAULT NULL,
  `country` varchar(60) DEFAULT NULL,
  `contact1_name` varchar(60) DEFAULT NULL,
  `contact1_email` varchar(60) DEFAULT NULL,
  `contact1_phone` varchar(60) DEFAULT NULL,
  `contact2_name` varchar(60) DEFAULT NULL,
  `contact2_email` varchar(60) DEFAULT NULL,
  `contact2_phone` varchar(60) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merchant_profiles`
--

INSERT INTO `merchant_profiles` (`id`, `merchant_id`, `phone`, `address`, `description`, `logo`, `payuid`, `website`, `facebook_url`, `twitter_url`, `convenience_fee_amount`, `payu_key`, `payu_salt`, `regd_no`, `city`, `state`, `country`, `contact1_name`, `contact1_email`, `contact1_phone`, `contact2_name`, `contact2_email`, `contact2_phone`, `created`, `modified`) VALUES
(3, 3, '1234567890', 'Puri1', 'Hello1', '1480422513110.png', '23451', 'as', 'sdasdas', 'sdSD', '100.00', 'xlIeC9', 'qVCckzCA', '1234', 'BBSR', 'Odisha', 'India', 'Prakash Guru', 'prakash@gmail.com', '9999999999', 'Soumya Das', 'soumya@gmail.com', '8888888888', '2016-10-27 12:30:29', '2016-10-31 13:57:48'),
(15, 236, '9009093304', 'Paschim Vihar', 'Keshav\'s Webfront', 'c000cd0ae55e8ca092dc5e93d6254c45.jpg', '2345', 'http://exampletest.com', '', '', '100.00', 'xlIeC9', 'qVCckzCA', '1234', '', '', '', '', '', '', '', '', '', '2016-11-23 13:02:59', '2016-11-23 13:02:59'),
(19, 242, '9861371390', 'Bhubaneswar, Orissa', 'Raddyx Technologies Merchant Account', 'a9ae9f51711c89d180d661a2bc634abc.png', '1234567', '', '', '', '200.00', 'xlIeC9', 'qVCckzCA', '1234', 'BBSR', 'Odisha', 'India', 'Parakas', 'prakash@gmail.com', '111111111', 'Soumya', 'soumya@gmail.com', '2222222', '2016-11-24 06:23:20', '2016-11-24 06:23:20'),
(21, 244, '7503099789', 'Gurgaon', 'Project', 'facfc8c28818819f4d8de78932e5b245.png', '67878768', '', '', '', '0.00', 'xlIeC9', 'qVCckzCA', '1234', '', '', '', '', '', '', '', '', '', '2016-11-25 10:31:27', '2016-11-25 10:31:27'),
(22, 247, '99990090090', 'Paschi vihar', 'amity web', 'a51e5b9efa5d7ca492c40e9f68e3c429.png', '12345', 'www.dfff.com', 'www.dfff.com', 'www.dfff.com', '100.00', 'xlIeC9', 'qVCckzCA', '1234', 'Bhubaneswar', 'Odisha', 'India', '', '', '', '', '', '', '2016-11-25 12:56:27', '2016-11-25 12:56:27'),
(29, 288, '8018596272', 'BBSR', 'Lorem Ipsum...', '1482820187719.png', '123456', NULL, NULL, NULL, '100.00', 'xlIeC9', 'qVCckzCA', '9876543', 'Bhubaneswar', 'Odisha', 'India', NULL, NULL, NULL, NULL, NULL, '', '2016-12-20 11:24:58', '2016-12-20 11:24:58'),
(30, 289, '456789098765', 'dfgjkllohgfdguioplkjbv', 'dfgjklkjhgfcgjkl', '1482233222528.png', '3456', NULL, NULL, NULL, '0.00', 'xlIeC9', 'qVCckzCA', '34567', 'gurgaon', 'haryana', 'india', NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-20 11:27:02', '2016-12-20 11:27:02'),
(31, 291, '9999999999', 'BBSR', 'BBSR', '1482237664668.png', '34567', NULL, NULL, NULL, '20.00', 'xlIeC9', 'qVCckzCA', '434234234', 'Bhubaneswar', 'Odisha', 'India', NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-20 12:40:31', '2016-12-20 12:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

DROP TABLE IF EXISTS `otps`;
CREATE TABLE `otps` (
  `id` int(11) NOT NULL,
  `uniqid` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(100) NOT NULL,
  `webfront_id` int(11) NOT NULL,
  `uploaded_payment_file_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `payee_custom_fields` varchar(1000) DEFAULT NULL,
  `convenience_fee_amount` decimal(10,2) DEFAULT '0.00',
  `late_fee_amount` decimal(10,2) DEFAULT '0.00',
  `fee` decimal(10,2) DEFAULT '0.00',
  `payment_custom_fields` varchar(1000) DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  `unmappedstatus` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '1=Paid/0=Unpaid',
  `payment_date` date DEFAULT NULL,
  `followup_counter` tinyint(4) DEFAULT '0' COMMENT 'No of times mail sent',
  `paid_amount` decimal(10,2) DEFAULT '0.00',
  `txn_id` varchar(50) DEFAULT NULL,
  `mode` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `uniq_id`, `webfront_id`, `uploaded_payment_file_id`, `customer_id`, `name`, `email`, `phone`, `payee_custom_fields`, `convenience_fee_amount`, `late_fee_amount`, `fee`, `payment_custom_fields`, `note`, `unmappedstatus`, `status`, `payment_date`, `followup_counter`, `paid_amount`, `txn_id`, `mode`, `created`, `modified`) VALUES
(1, '06c9cd70af15ab97eb3d593e27074e8b', 20, 1, 272, 'Pradeepta Khatoi', 'pradeepta.raddyx@gmail.com', '8018596272', '{"83":{"field":"Address","value":"BBSR"}}', '0.00', '3333.00', '600.00', '{"35":{"field":"Eletric Bill","value":100},"36":{"field":"Water Bill","value":200}}', 'Happy Birthday', 'captured', 1, '2016-12-16', 1, '700.00', 'TXN14818868849089', 'CC', '2016-12-16 09:26:26', '2016-12-16 09:26:26'),
(2, '6235beb4652128acb33c74141ee84b0d', 20, 1, 273, 'Chinmay Sahoo', 'chinmaysahu235@gmail.com', '8018596273', '{"83":{"field":"Address","value":"BBSR"}}', '100.00', '3333.00', '650.00', '{"35":{"field":"Eletric Bill","value":100},"36":{"field":"Water Bill","value":200}}', 'Happy Birthday', NULL, 0, NULL, 1, '0.00', NULL, NULL, '2016-12-16 09:26:26', '2016-12-16 09:26:26'),
(3, '58437d66c2be52e20a5cf6fc8c2d7446', 20, 2, 272, 'Pradeepta Khatoi', 'pradeepta.raddyx@gmail.com', '8018596272', '{"83":{"field":"Address","value":"BBSR"}}', '100.00', '3333.00', '600.00', '{"35":{"field":"Eletric Bill","value":100},"36":{"field":"Water Bill","value":200}}', 'Happy Birthday', 'failed', 0, NULL, 1, '0.00', NULL, NULL, '2016-12-19 12:50:07', '2016-12-19 12:50:07'),
(4, 'c8a36881de759737e9eb2ff010e5ca66', 20, 2, 273, 'Chinmay Sahoo', 'chinmaysahu235@gmail.com', '8018596273', '{"83":{"field":"Address","value":"BBSR"}}', '100.00', '3333.00', '650.00', '{"35":{"field":"Eletric Bill","value":100},"36":{"field":"Water Bill","value":200}}', 'Happy Birthday', NULL, 0, NULL, 0, '0.00', NULL, NULL, '2016-12-19 12:50:07', '2016-12-19 12:50:07'),
(5, '521759ac3b507c26dd8d6549b1eb0c2a', 20, 3, 272, 'Pradeepta Khatoi', 'pradeepta.raddyx@gmail.com', '8018596272', '{"83":{"field":"Address","value":"BBSR"}}', '100.00', '3333.00', '600.00', '{"35":{"field":"Eletric Bill","value":100},"36":{"field":"Water Bill","value":200}}', NULL, 'failed', 0, NULL, 0, '0.00', NULL, NULL, '2016-12-19 12:55:48', '2016-12-19 12:55:48'),
(6, 'a68ef2e225d8f6a2b8c4fc09a2aac836', 20, 3, 273, 'Chinmay Sahoo', 'chinmaysahu235@gmail.com', '8018596273', '{"83":{"field":"Address","value":"BBSR"}}', '100.00', '3333.00', '650.00', '{"35":{"field":"Eletric Bill","value":100},"36":{"field":"Water Bill","value":200}}', NULL, NULL, 0, NULL, 0, '0.00', NULL, NULL, '2016-12-19 12:55:48', '2016-12-19 12:55:48'),
(7, '50fc2db204fe329b8cb7e001349eae8e', 27, 4, 272, 'Pradeepta Khatoi', 'praxdeepta20@gmail.com', '8018596272', '{"84":{"field":"Address","value":"BBSR"}}', '100.00', '0.00', '600.00', '{"37":{"field":"Eletric Bill","value":100},"38":{"field":"Water Bill","value":200}}', NULL, 'failed', 0, NULL, 1, '0.00', NULL, NULL, '2016-12-20 12:03:40', '2016-12-20 12:03:40'),
(8, '0b4cc8984e38ad96672da73ee560a16a', 27, 4, 273, 'Soumya Das', 'soumya@gmail.com', '8018596273', '{"84":{"field":"Address","value":"BBSR"}}', '100.00', '0.00', '700.00', '{"37":{"field":"Eletric Bill","value":100},"38":{"field":"Water Bill","value":200}}', NULL, NULL, 0, NULL, 0, '0.00', NULL, NULL, '2016-12-20 12:03:40', '2016-12-20 12:03:40'),
(9, '4340795cd07c01755e2a4ab9f4e3b4ce', 30, NULL, 272, 'Pradeepta Khatoi', 'pradeepta.raddyx@gmail.com', '8018596272', '{"87":{"field":"Address","value":"BBSR"}}', '0.00', '0.00', '300.00', '{"Tips":"100","Total Amount":"200"}', NULL, 'failed', 0, '2016-12-20', 1, '300.00', NULL, NULL, '2016-12-20 12:12:44', '2016-12-20 12:12:44'),
(10, '27094964edb0e2f73463b0ef70d5d036', 31, 5, 272, 'Pradeepta Khatoi', 'pradeepta.raddyx@gmail.com', '8018596272', '{"88":{"field":"Address","value":"BBSR"}}', '20.00', '0.00', '350.00', '{"43":{"field":"Electic Bill","value":100},"44":{"field":"Water Bill","value":200}}', 'Happy Journey', 'failed', 0, NULL, 0, '0.00', NULL, NULL, '2016-12-20 12:44:24', '2016-12-20 12:44:24'),
(11, 'd465bb5934b6860549ac3ea97a43bb80', 31, 5, 273, 'Jyoto Das', 'jyotiprasanna.dash@gmail.com', '8018596273', '{"88":{"field":"Address","value":"BBSR"}}', '20.00', '0.00', '550.00', '{"43":{"field":"Electic Bill","value":100},"44":{"field":"Water Bill","value":200}}', 'Happy Journey', NULL, 0, NULL, 0, '0.00', NULL, NULL, '2016-12-20 12:44:24', '2016-12-20 12:44:24'),
(12, 'a748ed55d3bc09b3e5e541e42c764c82', 31, 6, 272, 'Pradeepta Khatoi', 'pradeepta.raddyx@gmail.com', '8018596272', '{"88":{"field":"Address","value":"BBSR"}}', '0.00', '0.00', '350.00', '{"43":{"field":"Electic Bill","value":100},"44":{"field":"Water Bill","value":200}}', 'Happy Journey', 'captured', 1, '2016-12-27', 1, '370.00', 'TXN14828355725868', 'CC', '2016-12-20 12:45:42', '2016-12-20 12:45:42'),
(13, 'e582985de094feb939cd23373db5625c', 31, 6, 273, 'Jyoto Das', 'jyotiprasanna.dash@gmail.com', '8018596273', '{"88":{"field":"Address","value":"BBSR"}}', '20.00', '0.00', '550.00', '{"43":{"field":"Electic Bill","value":100},"44":{"field":"Water Bill","value":200}}', 'Happy Journey', NULL, 0, NULL, 1, '0.00', NULL, NULL, '2016-12-20 12:45:42', '2016-12-20 12:45:42'),
(14, '448857c5835062a6a8f776a1d5fdde1c', 28, 7, 292, 'bhupendra', 'bhupendra.khatri@payu.in', '8377884231', '{"85":{"field":"CITY","value":"jodhpur"}}', '0.00', '0.00', '100.00', '{"41":{"field":"Electricity Fees","value":100},"42":{"field":"admin Fees","value":100}}', NULL, 'captured', 1, '2016-12-20', 0, '100.00', 'TXN14822391028870', 'CC', '2016-12-20 12:47:32', '2016-12-20 12:47:32'),
(17, '8d774fe898a7f4c67e544f4addc5ce17', 31, 9, 272, 'Pradeepta Khatoi', 'pradeepta.raddyx@gmail.com', '8018596272', '{"88":{"field":"Address","value":"BBSR"}}', '0.00', '0.00', '350.00', '{"43":{"field":"Electic Bill","value":100},"44":{"field":"Water Bill","value":200}}', NULL, 'captured', 1, '2016-12-27', 1, '370.00', 'TXN14828348136741', 'CC', '2016-12-20 13:08:53', '2016-12-20 13:08:53'),
(18, '92a0929b1710426a98ff7ee0ee1b1ba2', 31, 9, 273, 'Jyoto Das', 'jyotiprasanna.dash@gmail.com', '8018596273', '{"88":{"field":"Address","value":"BBSR"}}', '20.00', '0.00', '550.00', '{"43":{"field":"Electic Bill","value":100},"44":{"field":"Water Bill","value":200}}', NULL, NULL, 0, NULL, 1, '0.00', NULL, NULL, '2016-12-20 13:08:53', '2016-12-20 13:08:53'),
(19, 'e360d3d99939818cbee479507456c0a4', 28, 10, 293, 'ayush mittal', 'ayush.mbd@gmail.com', '7503099896', '{"85":{"field":"CITY","value":"gurgaon"}}', '0.00', '0.00', '300.00', '{"41":{"field":"Electricity Fees","value":100},"42":{"field":"admin Fees","value":200}}', NULL, 'failed', 0, NULL, 0, '0.00', NULL, NULL, '2016-12-21 06:40:39', '2016-12-21 06:40:39'),
(22, '328bbbcc31d2be5598cc6b5585b9c8c3', 27, 13, 294, 'Partha Sarathi Maharana', 'partha@gmail.com', '9853248829', '{"84":{"field":"Address","value":"BBSR"}}', '100.00', '0.00', '650.00', '{"37":{"field":"Eletric Bill","value":100},"38":{"field":"Water Bill","value":200}}', NULL, NULL, 0, NULL, 1, '0.00', NULL, NULL, '2016-12-27 09:45:32', '2016-12-27 09:45:32'),
(23, 'a26aedfb516f1f37c9f26d267381b7b3', 27, 13, 272, 'Pradeepta Kumar Khatoi', 'pradeepta20@gmail.com', '8018596272', '{"84":{"field":"Address","value":"BBSR"}}', '100.00', '0.00', '600.00', '{"37":{"field":"Eletric Bill","value":100},"38":{"field":"Water Bill","value":200}}', NULL, NULL, 0, NULL, 0, '0.00', NULL, NULL, '2016-12-27 09:45:32', '2016-12-27 09:45:32'),
(24, '1b5c19dfbdd4b37c0eed1e976588eb0a', 27, 13, 294, 'Pradeepta Khatoi', 'pradeepta.raddyx@gmail.com', '8280955059', '{"84":{"field":"Address","value":"BBSR"}}', '100.00', '0.00', '600.00', '{"37":{"field":"Eletric Bill","value":100},"38":{"field":"Water Bill","value":200}}', NULL, NULL, 0, NULL, 1, '0.00', NULL, NULL, '2016-12-27 09:45:32', '2016-12-27 09:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `split_settlements`
--

DROP TABLE IF EXISTS `split_settlements`;
CREATE TABLE `split_settlements` (
  `id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `webfront_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `split_settlements`
--

INSERT INTO `split_settlements` (`id`, `merchant_id`, `webfront_id`, `created`, `modified`) VALUES
(1, 3, 4, '2016-12-19 10:21:24', '2016-12-19 10:21:24');

-- --------------------------------------------------------

--
-- Table structure for table `split_settlement_mappings`
--

DROP TABLE IF EXISTS `split_settlement_mappings`;
CREATE TABLE `split_settlement_mappings` (
  `id` int(11) NOT NULL,
  `split_settlement_id` int(11) NOT NULL,
  `webfront_payment_attribute_id` int(11) NOT NULL,
  `sub_merchant_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `split_settlement_mappings`
--

INSERT INTO `split_settlement_mappings` (`id`, `split_settlement_id`, `webfront_payment_attribute_id`, `sub_merchant_id`, `created`) VALUES
(1, 1, 9, 6, '2016-12-19 10:21:24'),
(2, 1, 8, 10, '2016-12-19 10:21:24');

-- --------------------------------------------------------

--
-- Table structure for table `sub_merchants`
--

DROP TABLE IF EXISTS `sub_merchants`;
CREATE TABLE `sub_merchants` (
  `id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `payumid` varchar(60) DEFAULT NULL,
  `result` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_merchants`
--

INSERT INTO `sub_merchants` (`id`, `merchant_id`, `name`, `email`, `payumid`, `result`, `created`, `modified`) VALUES
(1, 242, '1111111', '111111@gmail.com', '123456', '5694375', '2016-11-30 08:42:37', '2016-11-30 08:42:38'),
(6, 3, 'Prakash Guru', 'prakash@gmail.com', '1234567', '5694392', '2016-11-30 08:46:50', '2016-11-30 08:46:50'),
(7, 236, 'Sanjib', 'sanjib@gmail.com', '23432', '5694565', '2016-11-30 10:30:22', '2016-11-30 10:30:23'),
(8, 236, 'Rajesh', 'rajesh@gmail.com', '324123', '5694566', '2016-11-30 10:31:10', '2016-11-30 10:31:10'),
(9, 255, 'Prakash', 'prakash321@gmail.com', '54321', '5706602', '2016-12-15 12:47:29', '2016-12-15 12:47:30'),
(10, 3, 'Soumya', 'soumya321@gmail.com', '654321', '5706603', '2016-12-15 12:48:09', '2016-12-15 12:48:10'),
(11, 288, 'Prakash Guru', 'prakash09@gmail.com', '0988888', '5709957', '2016-12-20 12:21:18', '2016-12-20 12:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_payment_files`
--

DROP TABLE IF EXISTS `uploaded_payment_files`;
CREATE TABLE `uploaded_payment_files` (
  `id` int(11) NOT NULL,
  `webfront_id` int(11) NOT NULL,
  `payment_cycle_date` date NOT NULL,
  `file` varchar(100) NOT NULL,
  `upload_count` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploaded_payment_files`
--

INSERT INTO `uploaded_payment_files` (`id`, `webfront_id`, `payment_cycle_date`, `file`, `upload_count`, `created`, `modified`) VALUES
(1, 20, '2016-12-25', '1481880386.xlsx', 2, '2016-12-16 09:26:26', '2016-12-16 09:26:26'),
(2, 20, '2016-12-30', '1482151807.xlsx', 2, '2016-12-19 12:50:07', '2016-12-19 12:50:07'),
(3, 20, '2017-01-01', '1482151807.xlsx', 2, '2016-12-19 12:55:48', '2016-12-19 12:55:48'),
(4, 27, '2016-12-01', '1482235378.xlsx', 2, '2016-12-20 12:02:58', '2016-12-20 12:02:58'),
(5, 31, '2016-12-31', '1482237863.xlsx', 2, '2016-12-20 12:44:24', '2016-12-20 12:44:24'),
(6, 31, '2016-12-30', '1482237942.xlsx', 2, '2016-12-20 12:45:42', '2016-12-20 12:45:42'),
(7, 28, '2016-12-23', '1482238052.xlsx', 1, '2016-12-20 12:47:32', '2016-12-20 12:47:32'),
(9, 31, '2017-01-01', '1482237942.xlsx', 2, '2016-12-20 13:08:53', '2016-12-20 13:08:53'),
(10, 28, '2017-01-04', '1482302439.xlsx', 1, '2016-12-21 06:40:39', '2016-12-21 06:40:39'),
(13, 27, '2016-12-30', '1482831754.xlsx', 3, '2016-12-27 09:42:34', '2016-12-27 09:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `type` smallint(4) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `last_login_date` datetime DEFAULT NULL,
  `last_login_ip` varchar(25) DEFAULT NULL,
  `access` tinyint(4) DEFAULT NULL,
  `qstr` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uniq_id`, `name`, `username`, `email`, `password`, `phone`, `created_by`, `type`, `is_active`, `last_login_date`, `last_login_ip`, `access`, `qstr`, `created`, `modified`) VALUES
(1, '026232a816372579655bf2224567891', 'Pradeepta Khatoi', 'admin', 'admin@smarthub.com', '$2y$10$yywjkw7eV.BCbj.OU/4J..g2dzS71jpq2oiqUmG0LrjuDUF2RPJiS', '9874512035', 0, 1, 1, '2016-12-20 12:38:29', '202.191.214.174', 0, '', '2016-10-20 00:00:00', '2016-12-20 12:21:51'),
(2, '026232a816372579655bfrr24567892', 'Branch Admin', '', 'branchadmin@smarthub.com', '$2y$10$yywjkw7eV.BCbj.OU/4J..g2dzS71jpq2oiqUmG0LrjuDUF2RPJiS', '785415565854', 0, 2, 1, '2016-12-01 09:47:55', '202.191.214.174', 0, '', '0000-00-00 00:00:00', '2016-10-28 15:28:13'),
(3, '1be57cad10c6a23238077a762959c627', 'Merchant', 'merchant', 'merchant@smarthub.com', '$2y$10$vDusAYFlU.cq9oatsqwTkuLzyZ88MMypgUewXOXWrjvFhqozizl8e', '', 1, 3, 1, '2016-12-26 13:11:40', '202.191.214.174', 0, '', '2016-10-24 14:10:36', '2016-12-09 07:01:52'),
(236, 'e65bce9d8c75b8aad13d82209ec1f383', 'KeshavFinal', '', 'keshavfinal@webinfomart.com', '$2y$10$RuHmeOgkeHWhr0Z8yx1jTu9yoyzJ84Z8ZdXLMxWU6UNyfg/wcSerC', '', NULL, 3, 1, '2016-12-20 11:41:00', '14.140.161.92', 0, '', '2016-11-23 13:02:59', '2016-11-23 13:02:59'),
(242, 'a7705d2f0f242d6d63c506169ffe1209', 'Raddyx', '', 'jyoti@gmail.com', '$2y$10$Z6Tm1eNqaCLrOVu9pwTOgO9tH7ubfOs3obBk1AwShaS/jy8dr7xM6', '', NULL, 3, 1, '0000-00-00 00:00:00', '', 0, '', '2016-11-24 06:23:20', '2016-11-24 06:23:20'),
(244, 'c841049d3958b0ce3461ab0f12242a30', 'Ayush', '', 'ayush.mittal@payu.in', '$2y$10$LHfrMTEwRUv92fqfjRtgy.P83WDdyJzqMS.ieFQ5WbQiLxnUHWv/S', '', NULL, 3, 1, '2016-12-21 06:37:16', '182.75.40.98', 0, '', '2016-11-25 10:31:27', '2016-11-25 10:31:27'),
(247, '871934f7c984c749163264e2aaacf90c', 'Amity', '', 'amity@webinfo.com', '$2y$10$USiuLx1EVOrJGXBUBmEVjuea0j8yliR9mgU8HRrzjhk20BtHTpCkO', '', NULL, 3, 1, '2016-11-25 13:00:09', '150.107.8.156', 0, '', '2016-11-25 12:56:27', '2016-11-25 12:56:27'),
(272, 'a96772c0b0893e2f9e1032d5aa1a5d3a', 'Pradeepta Khatoi', NULL, 'pradeepta.raddyx@gmail.com', '$2y$10$ytrcZfmMuTS9NM5k4HpQne9g/PRrf.yRKLkoc3bFh.8yD3W5WYN52', '8018596272', NULL, 4, 1, '2016-12-20 12:47:06', '202.191.214.174', NULL, 'e940777f90c6727fee3ea08c4f768694', '2016-12-16 09:26:26', '2016-12-19 13:21:44'),
(273, '4186b758cf16db8809da3c044b97e475', 'Chinmay Sahoo', NULL, 'chinmaysahu235@gmail.com', NULL, '8018596273', NULL, 4, 1, NULL, NULL, NULL, NULL, '2016-12-16 09:26:26', '2016-12-16 09:26:26'),
(288, 'd2187f4d0317319b7d22380eeacd5ecf', 'EagleSociety', NULL, 'pradeepta20@gmail.com', '$2y$10$UJKYEVuPchUUIBfQM9z23eecwXH1nMBeTlgS8i8hI4pGBuWH1v4Gy', '', NULL, 3, 1, '2016-12-27 06:27:44', '202.191.214.174', NULL, NULL, '2016-12-20 11:24:58', '2016-12-20 11:24:58'),
(289, 'ef02aba2b5a9a0601efcc1b2ff0f0b49', 'SUNCITY', NULL, 'bhp@gmail.com', '$2y$10$sHW.QyRmEs.IJ2zVVAwNt.3vYyZ2rvPW1dDdtkEeJFFwJ.xGPxQVu', '', NULL, 3, 1, '2016-12-21 06:37:48', '182.75.40.98', NULL, NULL, '2016-12-20 11:27:02', '2016-12-20 11:27:02'),
(290, 'f58ba0a6295e28939779bc25a9fa111f', 'RakeshSethi', NULL, 'rakesh@gmail.com', '$2y$10$ByH0ItoYzmRxAsl5jaeSr.8SH6yZp0bNAXrdzXaiz2lhNGU0xmCRC', '8888888899', 288, 3, 1, NULL, NULL, 2, NULL, '2016-12-20 12:23:41', '2016-12-20 12:23:41'),
(291, 'bb7419266d1e698898fab350e3c6ff37', 'RaddyxPicnic20162017', NULL, 'pradeepta.raddyx@gmail.com', '$2y$10$UIYXVmoHRg.RU/BG/YFUfeMfA9/RhYtMc3oM6CTi/aywT6qSQuJ6O', '', NULL, 3, 1, '2016-12-27 10:22:43', '202.191.214.174', NULL, NULL, '2016-12-20 12:40:31', '2016-12-20 12:40:31'),
(292, '443a9321ba3ee42e621023ea5a15018a', 'bhupendra', NULL, 'bhupendra.khatri@payu.in', NULL, '8377884231', NULL, 4, 1, NULL, NULL, NULL, NULL, '2016-12-20 12:47:32', '2016-12-20 12:47:32'),
(293, 'f3327f98751a69a9aed35e4dca4f898c', 'ayush mittal', NULL, 'ayush.mbd@gmail.com', NULL, '7503099896', NULL, 4, 1, NULL, NULL, NULL, NULL, '2016-12-21 06:40:39', '2016-12-21 06:40:39'),
(294, 'cfa63e2e814ac9fb48e12eafea572571', 'Partha Sarathi Maharana', NULL, 'partha@gmail.com', NULL, '9853248829', NULL, 4, 1, NULL, NULL, NULL, NULL, '2016-12-27 09:42:34', '2016-12-27 09:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

DROP TABLE IF EXISTS `user_logins`;
CREATE TABLE `user_logins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_ip` varchar(25) NOT NULL,
  `login_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_logins`
--

INSERT INTO `user_logins` (`id`, `user_id`, `login_ip`, `login_date`) VALUES
(429, 291, '202.191.214.174', '2016-12-27 10:22:43'),
(428, 288, '202.191.214.174', '2016-12-27 06:27:44');

-- --------------------------------------------------------

--
-- Table structure for table `validations`
--

DROP TABLE IF EXISTS `validations`;
CREATE TABLE `validations` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `reg_exp` varchar(100) NOT NULL,
  `err_msg` varchar(100) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Yes/0=No',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `validations`
--

INSERT INTO `validations` (`id`, `name`, `reg_exp`, `err_msg`, `is_active`, `created`, `modified`) VALUES
(1, 'No Validation', '', '', 1, '2016-10-05 00:00:00', '2016-10-20 00:00:00'),
(2, 'Numeric', '^(0|[1-9][0-9]*)$', 'Please enter numeric value ', 1, '2016-10-05 00:00:00', '2016-10-20 00:00:00'),
(3, 'Alphanumeric', '^[a-zA-Z0-9]*$', 'Please enter alpha numeric value ', 1, '2016-10-05 00:00:00', '2016-10-20 00:00:00'),
(4, 'Character', '^[a-zA-Z]*$', 'Please enter character value ', 1, '2016-10-05 00:00:00', '2016-10-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `webfronts`
--

DROP TABLE IF EXISTS `webfronts`;
CREATE TABLE `webfronts` (
  `id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `payment_cycle_date` date DEFAULT NULL,
  `customer_name_alias` varchar(100) DEFAULT 'Name',
  `customer_email_alias` varchar(100) DEFAULT 'Email',
  `customer_phone_alias` varchar(100) DEFAULT 'Phone',
  `customer_note_alias` varchar(100) DEFAULT 'Note',
  `total_amount_alias` varchar(100) DEFAULT 'Total Amount',
  `late_fee_amount` decimal(10,2) DEFAULT '0.00',
  `fee_amount` decimal(10,2) DEFAULT '0.00',
  `file` varchar(200) DEFAULT NULL,
  `upload_completed` tinyint(4) DEFAULT '0' COMMENT '1=Yes/0=No',
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '1=Yes/0=No',
  `is_published` tinyint(4) DEFAULT '1' COMMENT '1=Yes/0=No',
  `uploaded_payment_file_count` int(11) DEFAULT NULL,
  `error_log` varchar(100) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0' COMMENT '0=Basic,1=Advanced',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webfronts`
--

INSERT INTO `webfronts` (`id`, `merchant_id`, `url`, `email`, `phone`, `address`, `logo`, `title`, `description`, `payment_cycle_date`, `customer_name_alias`, `customer_email_alias`, `customer_phone_alias`, `customer_note_alias`, `total_amount_alias`, `late_fee_amount`, `fee_amount`, `file`, `upload_completed`, `is_deleted`, `is_published`, `uploaded_payment_file_count`, `error_log`, `type`, `created`, `modified`) VALUES
(1, 3, 'Webinfy', 'keshav@webinfy.com', '9990498605', 'Paschim Vihar', '1480591545373.png', 'Webinfo Webfront', 'This is Webinfo\'s Webfront', '2016-11-30', 'Full Name', 'Email Address', 'Phone', 'Note', 'Total Amount', '25.00', '0.00', '', 0, 0, 1, 0, '', 0, '2016-11-23 05:08:36', '2016-12-01 11:25:45'),
(2, 3, 'WebinfyAdvanced', 'webinfy@webinfomart.com', '8527321888', 'Paschim Vihar', '93568f3ec578180a3762d46450330cd4.jpg', 'Webinfo WebFront Advance', 'Advanced Webfront for Webinfomart', '2016-12-07', 'Customer Name', 'Customer Email', 'Customer Mobile', 'Note', 'Total Amount', '50.00', '100.00', '', 0, 0, 1, 0, '', 1, '2016-11-23 07:00:35', '2016-12-01 10:22:27'),
(3, 3, 'jyotitest', 'jyoti.raddyx@gmail.com', '8888888888', 'Bhubaneswar', 'c44f37059123583bb37dbc4d6c8de82e.jpg', 'Jyoti Test', 'Jyoti testing basic webfront', '2016-11-30', 'Student Name', 'Email Id', 'Mobile No', 'Customer Note', 'Total Fee', '10.00', '0.00', '', 0, 0, 1, 0, '', 0, '2016-11-23 09:06:45', '2016-11-23 09:06:45'),
(4, 3, 'KeshavsWebFront', 'merchant@smarthub.com', '8888888888', 'Puri1', '9167d44dd3375df938a19ce11b8d6cd7.jpg', 'KeshavWebfront', 'Hello1', '0000-00-00', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '120.00', '0.00', '', 0, 0, 1, 0, '', 0, '2016-11-23 11:44:26', '2016-11-23 11:44:26'),
(5, 3, 'jyotitestadvance', 'merchant@smarthub.com', '8888888888', 'Puri1', 'd6e9b1e35160ce6f4cc1aea388fd474e.jpg', 'Jyoti Test Advance', 'Hello1', '2016-11-30', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '50.00', '0.00', '', 0, 0, 1, 0, '', 1, '2016-11-23 12:44:08', '2016-11-23 12:44:08'),
(6, 236, 'KeshavWebfrontTest', 'keshavfinal@webinfomart.com', '9009093304', 'Paschim Vihar', 'c633bdbfb06a56682b8e6e76f17b8c5f.jpg', 'Testing Keshav', 'Keshav\'s Webfront', '0000-00-00', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '200.00', '0.00', '', 0, 0, 1, 0, '', 0, '2016-11-23 13:06:14', '2016-11-23 13:06:14'),
(7, 236, 'KeshavTestAdvance', 'keshavfinal@webinfomart.com', '9009093304', 'Paschim Vihar', '29eead470a58c530f3cbf94748b3ed75.jpg', 'Keshav Advance Test', 'Keshav\'s Webfront', '2016-12-05', 'Full Name', 'Email Add', 'Phone Number', 'Note', 'Total Amount', '120.00', '0.00', '', 0, 0, 1, 0, '', 1, '2016-11-23 13:18:46', '2016-11-23 13:18:46'),
(12, 244, 'ayushwebfront', 'ayush.mittal@payu.in', '7503099789', 'Gurgaon', '', 'Ayush Society', 'This is Land Project For Ayush Society based on Haryana govt.', '0000-00-00', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '100.00', '0.00', '', 0, 1, 1, 0, '', 0, '2016-11-25 10:33:29', '2016-11-28 11:04:49'),
(13, 247, 'AmitySchoolWebfront', 'amity@webinfo.com', '99990090090', 'paschi vihar', '', 'Amity School Webfront', 'AmitySchoolWebfront', '0000-00-00', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '20.00', '0.00', '', 0, 0, 1, 0, '', 0, '2016-11-25 13:00:57', '2016-11-25 13:00:57'),
(14, 244, 'ayush', 'ayush.mittal@payu.in', '7503099896', 'Gurgaon', '29466fc5f78fbfe064e2a1d2f8f9a747.png', 'Ayush Society Payu', 'Project', '0000-00-00', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '200.00', '0.00', '', 0, 1, 1, 0, '', 0, '2016-11-28 11:06:09', '2016-11-28 11:18:29'),
(15, 244, 'payuindia', 'ayush.mittal@payu.in', '7503099789', 'Gurgaon', '5fe11999a3250ef2551e7f2342a1189e.jpg', 'Payu', 'Project', '0000-00-00', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '9.00', '0.00', '', 0, 0, 1, 0, '', 0, '2016-11-28 11:20:17', '2016-11-28 11:20:17'),
(20, 3, 'NewYearPinic', 'pradeeptakumarkhatoi@gmail.com', '8888888888', 'Puri1', '1481879987329.png', 'New Year Picnic', 'Hello1', '1970-01-01', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '3333.00', '0.00', '', 0, 0, 1, 3, '', 0, '2016-11-29 04:28:45', '2016-12-16 09:19:47'),
(22, 244, 'Manikchand', 'ayush.mittal@payu.in', '7503099789', 'Gurgaon', '1480404962888.png', 'Ram', 'Project', '0000-00-00', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '200.00', '0.00', '', 0, 0, 1, 0, '', 0, '2016-11-29 07:36:02', '2016-11-29 07:36:02'),
(23, 265, 'DurgaPuja', 'sahridaya@webinfomart.com', '99994595050', 'rgdfgeg egtre', '', 'Durga Puja Webfront', 'fhjks kjfgfdkjgfd', '2016-11-30', 'Customer Name', 'Email', 'Phone', 'Note', 'Total Amount', '20.00', '0.00', '', 0, 0, 1, 0, '', 1, '2016-11-30 08:48:58', '2016-11-30 08:48:58'),
(27, 288, 'Picnic2017', 'pradeepta20@gmail.com', '8018596272', 'BBSR', '1482235448884.png', 'Picnic 2017', 'Lorem Ipsum...', '1970-01-01', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '0.00', '0.00', NULL, 0, 0, 1, 2, NULL, 0, '2016-12-20 11:25:48', '2016-12-20 12:04:07'),
(28, 289, 'SUNCITY', 'bhp@gmail.com', '456789098765', 'dfgjkllohgfdguioplkjbv', NULL, 'SUNCITY WEBFRONT', 'This is suncity webfront', NULL, 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '0.00', '0.00', NULL, 0, 0, 1, 2, NULL, 0, '2016-12-20 11:29:01', '2016-12-20 11:29:01'),
(29, 236, 'KeshavChecking', 'keshavfinal@webinfomart.com', '9009093304', 'Paschim Vihar', NULL, 'Keshav Check', 'Keshav\'s Webfront', NULL, 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '10.00', '0.00', NULL, 0, 0, 1, NULL, NULL, 0, '2016-12-20 11:41:30', '2016-12-20 11:41:30'),
(30, 288, 'Advance2', 'pradeepta20@gmail.com', '8018596272', 'BBSR', NULL, 'Advance2', 'Lorem Ipsum...', '2016-12-28', 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '0.00', '0.00', NULL, 0, 0, 1, NULL, NULL, 1, '2016-12-20 12:11:18', '2016-12-20 12:11:18'),
(31, 291, 'picnic', 'pradeepta.raddyx@gmail.com', '9999999999', 'BBSR', NULL, 'Picnic 2017', 'BBSR', NULL, 'Name', 'Email', 'Phone', 'Note', 'Total Amount', '0.00', '0.00', NULL, 0, 0, 1, 3, NULL, 0, '2016-12-20 12:41:43', '2016-12-20 12:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `webfront_fields`
--

DROP TABLE IF EXISTS `webfront_fields`;
CREATE TABLE `webfront_fields` (
  `id` int(11) NOT NULL,
  `webfront_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_mandatory` tinyint(4) DEFAULT '1' COMMENT '1=Yes/0=No',
  `validation_id` smallint(6) DEFAULT NULL,
  `input_type` tinyint(4) DEFAULT '1' COMMENT '1=Textbox/2=TextArea/3=Radio/4=Dropdown',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webfront_fields`
--

INSERT INTO `webfront_fields` (`id`, `webfront_id`, `name`, `is_mandatory`, `validation_id`, `input_type`, `created`) VALUES
(1, 1, 'Country', 1, 0, 0, '0000-00-00 00:00:00'),
(2, 1, 'Address', 1, 0, 0, '0000-00-00 00:00:00'),
(55, 5, 'Age', 1, 2, 1, '0000-00-00 00:00:00'),
(56, 6, 'Address', 1, 0, 0, '0000-00-00 00:00:00'),
(57, 6, 'Country', 1, 0, 0, '0000-00-00 00:00:00'),
(58, 7, 'Age', 1, 2, 1, '0000-00-00 00:00:00'),
(59, 7, 'Country', 1, 4, 1, '0000-00-00 00:00:00'),
(60, 7, 'Sex', 1, 1, 3, '0000-00-00 00:00:00'),
(61, 11, 'Working Time', 1, 0, 0, '0000-00-00 00:00:00'),
(62, 12, 'Address', 1, 0, 0, '0000-00-00 00:00:00'),
(63, 12, 'Country', 1, 0, 0, '0000-00-00 00:00:00'),
(67, 14, 'water charges', 1, 0, 0, '0000-00-00 00:00:00'),
(68, 14, 'electricity charges', 1, 0, 0, '0000-00-00 00:00:00'),
(69, 14, 'Maintenance', 1, 0, 0, '0000-00-00 00:00:00'),
(70, 15, 'water Charges', 1, 0, 0, '0000-00-00 00:00:00'),
(71, 15, 'security Charges', 1, 0, 0, '0000-00-00 00:00:00'),
(72, 15, 'Maintenance', 1, 0, 0, '0000-00-00 00:00:00'),
(73, 2, 'Address', 1, 1, 2, '0000-00-00 00:00:00'),
(74, 2, 'Age', 1, 2, 1, '0000-00-00 00:00:00'),
(75, 2, 'Country', 1, 4, 1, '0000-00-00 00:00:00'),
(76, 2, 'Sex', 1, 1, 3, '0000-00-00 00:00:00'),
(77, 22, 'Driver Charges', 1, 0, 0, '0000-00-00 00:00:00'),
(78, 22, 'Garden Charges', 1, 0, 0, '0000-00-00 00:00:00'),
(79, 22, 'Cleaning Charges', 1, 0, 0, '0000-00-00 00:00:00'),
(80, 23, 'Address', 1, 1, 2, '0000-00-00 00:00:00'),
(81, 23, 'Flat No.', 1, 2, 1, '0000-00-00 00:00:00'),
(82, 24, 'Payment1', 1, 2, 1, '0000-00-00 00:00:00'),
(83, 20, 'Address', 1, NULL, 1, NULL),
(84, 27, 'Address', 1, NULL, 1, NULL),
(85, 28, 'CITY', 1, NULL, 1, NULL),
(86, 29, 'City', 1, NULL, 1, NULL),
(87, 30, 'Address', 1, 1, 0, NULL),
(88, 31, 'Address', 1, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webfront_field_values`
--

DROP TABLE IF EXISTS `webfront_field_values`;
CREATE TABLE `webfront_field_values` (
  `id` int(11) NOT NULL,
  `webfront_field_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webfront_field_values`
--

INSERT INTO `webfront_field_values` (`id`, `webfront_field_id`, `value`) VALUES
(27, 60, 'Male'),
(28, 60, 'Female'),
(29, 76, 'Male'),
(30, 76, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `webfront_payment_attributes`
--

DROP TABLE IF EXISTS `webfront_payment_attributes`;
CREATE TABLE `webfront_payment_attributes` (
  `id` int(11) NOT NULL,
  `webfront_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_user_entered` tinyint(4) DEFAULT NULL COMMENT '1=Yes/0=No',
  `is_required` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Yes/0=No',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webfront_payment_attributes`
--

INSERT INTO `webfront_payment_attributes` (`id`, `webfront_id`, `name`, `value`, `is_user_entered`, `is_required`, `created`) VALUES
(4, 2, 'Total Payment', '5000.00', 1, 1, '0000-00-00 00:00:00'),
(5, 2, 'Additional Amount', '0.00', 0, 0, '0000-00-00 00:00:00'),
(6, 3, 'Library Fee', '0.00', 0, 0, '0000-00-00 00:00:00'),
(7, 3, 'Sports Fee', '0.00', 0, 0, '0000-00-00 00:00:00'),
(8, 4, 'Water', '0.00', 0, 0, '0000-00-00 00:00:00'),
(9, 4, 'Electric', '0.00', 0, 0, '0000-00-00 00:00:00'),
(10, 5, 'Amount', '500.00', 1, 1, '0000-00-00 00:00:00'),
(11, 5, 'Swacha Bharat', '0.00', 0, 0, '0000-00-00 00:00:00'),
(12, 6, 'Water', '0.00', 0, 0, '0000-00-00 00:00:00'),
(13, 6, 'Electric', '0.00', 0, 0, '0000-00-00 00:00:00'),
(14, 7, 'Fees', '0.00', 0, 0, '0000-00-00 00:00:00'),
(15, 7, 'Fixed Charges', '350.00', 1, 0, '0000-00-00 00:00:00'),
(16, 11, 'Payment Period', '0.00', 0, 0, '0000-00-00 00:00:00'),
(17, 12, 'Water Charges', '0.00', 0, 0, '0000-00-00 00:00:00'),
(18, 12, 'Electricity Charges', '0.00', 0, 0, '0000-00-00 00:00:00'),
(19, 12, 'Security Charges', '0.00', 0, 0, '0000-00-00 00:00:00'),
(20, 13, 'Sports Fee', '0.00', 0, 0, '0000-00-00 00:00:00'),
(21, 13, 'Library Fee', '0.00', 0, 0, '0000-00-00 00:00:00'),
(22, 23, 'Durga Puja Entry Fees', '500.00', 1, 0, '0000-00-00 00:00:00'),
(23, 24, 'Payment1', '100.00', 1, 0, '0000-00-00 00:00:00'),
(24, 24, 'Payment 2', '0.00', 0, 0, '0000-00-00 00:00:00'),
(25, 25, 'Customer 1', '0.00', 0, 0, '0000-00-00 00:00:00'),
(32, 1, 'Water Charges', '0.00', 0, 0, '0000-00-00 00:00:00'),
(33, 1, 'Electric Charges', '0.00', 0, 0, '0000-00-00 00:00:00'),
(34, 1, 'Development Fees', '0.00', 0, 0, '0000-00-00 00:00:00'),
(35, 20, 'Eletric Bill', '0.00', 0, 1, '0000-00-00 00:00:00'),
(36, 20, 'Water Bill', '0.00', 0, 1, '0000-00-00 00:00:00'),
(37, 27, 'Eletric Bill', '0.00', NULL, 1, NULL),
(38, 27, 'Water Bill', '0.00', NULL, 1, NULL),
(39, 30, 'Total Amount', '200.00', 1, 1, NULL),
(40, 30, 'Tips', '0.00', 0, 1, NULL),
(41, 28, 'Electricity Fees', '0.00', NULL, 1, NULL),
(42, 28, 'admin Fees', '0.00', NULL, 1, NULL),
(43, 31, 'Electic Bill', '0.00', NULL, 1, NULL),
(44, 31, 'Water Bill', '0.00', NULL, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forgot_password_otps`
--
ALTER TABLE `forgot_password_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchant_profiles`
--
ALTER TABLE `merchant_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `split_settlements`
--
ALTER TABLE `split_settlements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `split_settlement_mappings`
--
ALTER TABLE `split_settlement_mappings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_merchants`
--
ALTER TABLE `sub_merchants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploaded_payment_files`
--
ALTER TABLE `uploaded_payment_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `validations`
--
ALTER TABLE `validations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webfronts`
--
ALTER TABLE `webfronts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webfront_fields`
--
ALTER TABLE `webfront_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webfront_field_values`
--
ALTER TABLE `webfront_field_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webfront_payment_attributes`
--
ALTER TABLE `webfront_payment_attributes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forgot_password_otps`
--
ALTER TABLE `forgot_password_otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `merchant_profiles`
--
ALTER TABLE `merchant_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `split_settlements`
--
ALTER TABLE `split_settlements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `split_settlement_mappings`
--
ALTER TABLE `split_settlement_mappings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sub_merchants`
--
ALTER TABLE `sub_merchants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `uploaded_payment_files`
--
ALTER TABLE `uploaded_payment_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=430;
--
-- AUTO_INCREMENT for table `validations`
--
ALTER TABLE `validations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `webfronts`
--
ALTER TABLE `webfronts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `webfront_fields`
--
ALTER TABLE `webfront_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `webfront_field_values`
--
ALTER TABLE `webfront_field_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `webfront_payment_attributes`
--
ALTER TABLE `webfront_payment_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
