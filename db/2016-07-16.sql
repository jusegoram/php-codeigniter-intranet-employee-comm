-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 16, 2016 at 02:43 PM
-- Server version: 5.6.30
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `akcisinl_readycallcenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE IF NOT EXISTS `issues` (
`id` int(11) NOT NULL,
  `issue_name` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `updated_date` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable,0=>disabled'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `issue_name`, `created_date`, `updated_date`, `is_enabled`) VALUES
(1, 'H/W S/w Issue', '1467969820', '', 0),
(2, 'database issue', '1467993940', '', 0),
(5, 'New issue sebas', '1468297051', '', 0),
(6, 'Nubia Issues', '1468297197', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `avaya_number` varchar(255) NOT NULL,
  `user_logs` longtext NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `regarding_issue_id` varchar(255) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `updated_date` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `avaya_number`, `user_logs`, `field_name`, `regarding_issue_id`, `created_date`, `updated_date`) VALUES
(11, 3, 'sdad', '{"FIELD_ONE":"asdd","FIELD_TWO":"asdad","FIELD_THREE":"asda","FIELD_FOUR":"asdda","FIELD_FIVE":"asdad","FIELD_SIX":"dsadsa","FIELD_SEVEN":"asdd"}', '["Field 1","Field 2","Field 3","Field 4","Field 5","Field 6sdadsadd","Field 7","Field 8","Field 9","Field 10"]', '2', '1468679301', ''),
(12, 3, 'ASDAd', '{"FIELD_ONE":"asdadD","FIELD_TWO":"adsdAS","FIELD_THREE":"ASDD","FIELD_FIVE":"asdA","FIELD_SIX":"DSAD","FIELD_SEVEN":"ASDD"}', '["Field 1","Field 2","Field 3","Field 4","Field 5","Field 6sdadsadd","Field 7","Field 8","Field 9","Field 10"]', '2', '1468679317', ''),
(13, 3, 'ASDD', '{"FIELD_ONE":"SADD","FIELD_TWO":"asdD","FIELD_THREE":"ADSAD","FIELD_FOUR":"ASD","FIELD_FIVE":"asdad","FIELD_SIX":"DSA","FIELD_SEVEN":"asdd","FIELD_EIGHT":"dSAD","FIELD_NINE":"ASDD"}', '["Field 1","Field 2","Field 3","Field 4","Field 5","Field 6sdadsadd","Field 7","Field 8","Field 9","Field 10"]', '2', '1468679333', ''),
(14, 3, 'dsad', '{"FIELD_ONE":"adsd","FIELD_TWO":"asdad","FIELD_THREE":"asd","FIELD_FOUR":"asd","FIELD_FIVE":"adsd","FIELD_SIX":"asdd"}', '["Field One","Field Two","Field three","Field four","Field 5","Field 6sdadsadd","Field 7","Field 8","Field 9","Field 10"]', '2', '1468679380', '');

-- --------------------------------------------------------

--
-- Table structure for table `logs_field_name`
--

CREATE TABLE IF NOT EXISTS `logs_field_name` (
`id` int(11) NOT NULL,
  `field_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `field_value` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `logs_field_name`
--

INSERT INTO `logs_field_name` (`id`, `field_title`, `field_value`) VALUES
(1, 'FIELD_ONE', 'Field One'),
(2, 'FIELD_TWO', 'Field Two'),
(3, 'FIELD_THREE', 'Field three'),
(4, 'FIELD_FOUR', 'Field four'),
(5, 'FIELD_FIVE', 'Field 5'),
(6, 'FIELD_SIX', 'Field 6sdadsadd'),
(7, 'FIELD_SEVEN', 'Field 7'),
(8, 'FIELD_EIGHT', 'Field 8'),
(9, 'FIELD_NINE', 'Field 9'),
(10, 'FIELD_TEN', 'Field 10');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
`id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>warning, 2=>aggrement, 3=>training',
  `file_name` varchar(255) DEFAULT NULL,
  `notification_date` varchar(10) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `submitted_by` int(11) DEFAULT NULL,
  `manager_comment` text,
  `employee_comment` text,
  `is_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` varchar(10) NOT NULL,
  `updated_date` varchar(10) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `notification_type`, `file_name`, `notification_date`, `document_name`, `submitted_by`, `manager_comment`, `employee_comment`, `is_accepted`, `created_date`, `updated_date`, `is_enabled`) VALUES
(1, 3, 1, '1_1465061928.pdf', '1464998400', 'test doc', 2, 'manager comment', 'Juan sebastian Gomez', 1, '', NULL, 1),
(2, 3, 1, '1_1465062155.pdf', '1464998400', 'test coc ccc ', 2, 'test ', 'dffsfdf', 1, '', NULL, 1),
(3, 0, 0, 'dummy_pdf_1467272844.pdf', '1467244800', 'training', 2, 'Please have a look.', NULL, 0, '', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `performances`
--

CREATE TABLE IF NOT EXISTS `performances` (
`id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `performance_date` varchar(10) NOT NULL,
  `quality` varchar(255) DEFAULT NULL,
  `adherence` varchar(255) DEFAULT NULL,
  `hold_time` varchar(10) DEFAULT NULL,
  `transfer_rate` varchar(255) DEFAULT NULL,
  `quality_commitment` varchar(255) NOT NULL,
  `adherence_commitment` varchar(255) NOT NULL,
  `hold_time_commitment` varchar(255) NOT NULL,
  `transfer_rate_commitment` varchar(255) NOT NULL,
  `manager_commitment` text,
  `employee_commitment` text,
  `score` varchar(255) NOT NULL DEFAULT '0',
  `is_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` varchar(10) NOT NULL,
  `updated_date` varchar(10) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `performances`
--

INSERT INTO `performances` (`id`, `user_id`, `performance_date`, `quality`, `adherence`, `hold_time`, `transfer_rate`, `quality_commitment`, `adherence_commitment`, `hold_time_commitment`, `transfer_rate_commitment`, `manager_commitment`, `employee_commitment`, `score`, `is_accepted`, `created_date`, `updated_date`, `is_enabled`) VALUES
(4, 3, '1468281600', '1', '2', '3', '6', '', '', '', '', 'sad', NULL, '12', 0, '1468255004', NULL, 1),
(5, 3, '1468281600', '5', '6', '1', '2', '', '', '', '', 'adf', NULL, '14', 0, '1468255020', NULL, 1),
(6, 3, '1468368000', '6', '6', '3', '1', '', '', '', '', 'asd', NULL, '16', 0, '1468255035', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
`id` int(11) NOT NULL,
  `password_expire_time` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `password_expire_time`) VALUES
(2, '12345555555');

-- --------------------------------------------------------

--
-- Table structure for table `site_links`
--

CREATE TABLE IF NOT EXISTS `site_links` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `site_links`
--

INSERT INTO `site_links` (`id`, `title`, `url`) VALUES
(1, 'DS Portal', 'http://dsportal.tracfone.com/Citrix/XenApp/auth/login.aspx'),
(2, 'DP Portal', 'http://dpportal.tracfone.com/Citrix/XenApp/auth/login.aspx'),
(3, 'Tracfone', 'http://www.tracfone.com/'),
(4, 'Net10', 'http://www.net10.com/directUnlimitedInternational?lang=en&app=NET10'),
(5, 'Safelink Wireless', 'http://www.safelinkwireless.com/'),
(6, 'Safelink Wireless Backup', 'http://www.safelinkwireless.com/Safelink/check_enroll'),
(7, 'RSS', 'http://durpdp00.ddc.vzwcorp.com:8585/rss/index.shtml'),
(8, 'Fedex', 'http://www.fedex.com/'),
(9, 'Get Zips', 'http://www.getzips.com/'),
(10, 'US Postal Service', 'http://www.usps.com/'),
(11, 'RTS (MVNO)', 'http://www.e-access.att.com/ebiz/mvnorts/default.aspx'),
(12, 'CCPT Webcsr', 'https://www.tracfone.com/CSRe_store.jsp'),
(13, 'Web-cs', 'https://web-cs.com/login.asp'),
(14, 'Straightalk BalanceCheck', 'https://www.straighttalk.com/CheckBalance'),
(15, 'UPS', 'http://www.ups.com'),
(16, 'Verizon Wireless', 'http://www.verizonwireless.com/b2c/index.html'),
(17, 'Care Telegence', 'https://resellergate.tdc.cingular.net'),
(18, 'T-Mobile', 'http://www.t-mobile.com'),
(19, 'MY CSP', 'https://mycsp.cingular.com'),
(20, 'Telegence', 'https://securegate.ctx.it.att.com/Citrix/SecureGate/auth/login.aspx'),
(21, 'RSSX', 'https://rssxportal.vzwcorp.com/'),
(22, 'SmartyStreets', 'http://smartystreets.com/'),
(23, 'Gsm Arena', 'http://www.gsmarena.com/'),
(24, 'Tracfone University', 'http://grovo.com/teams/tracfone'),
(25, 'T-Mobile Map', 'http://www.t-mobile.com/coverage.html'),
(26, 'T-Mobile Coverage Map', 'http://www.t-mobile.com/coverage/pcc.aspx'),
(27, 'USPS Backup', 'http://zip4.usps.com/zip4'),
(28, 'Cyber Source', 'https://ebc.cybersource.com/ebc/login/Logout.do'),
(29, 'WCCT', 'https://wholesaleportal.vzwcorp.com/'),
(30, 'Mobile Sphere', 'https://www.mobile-sphere.com/tf2/index.php'),
(31, 'Zed Tool', 'http://cc.tracfone.9squared.com/'),
(32, 'Global Exchange', 'https://idmsa.apple.com/IDMSWebAuth/classicLogin.html?appIdKey=45571f444c4f547116bfd052461b0b3ab1bc2b445a72138157ea8c5c82fed623'),
(33, 'Wholesale Resourse Center', 'https://cisresourcecenter.verizonwireless.com/content/wsc/login.html'),
(34, 'Sprint Caliry', 'https://ead.sprint.com/Citrix/EAD_XenAppGateway/site/default.aspx'),
(35, 'Sprint MVNO', 'https://144.226.83.90/mvno/controller/Admin/showLogin'),
(36, 'Training Apex', 'http://trainingapex.tracfone.com:10001/apex/f?p=100:1'),
(37, 'Training Tas', 'http://testtas.tracfone.com/AdfCrmConsole/'),
(38, 'Witness/Verint', 'http://dpblqmapp1:7001/wfo/control/signin'),
(39, 'Impact', 'http://dpblwfmapp1:7001/wfo'),
(40, 'Bright Point', 'https://www.im-mobilityonline.com/bpo/secure/Login'),
(41, 'Safelink CA', 'https://www.safelinkca.com/TracFoneWeb/en/index2.html#/'),
(42, 'STBYOP', 'http://stbyop.com/straighttalk'),
(43, 'NET10BYOP', 'http://www.net10byop.com/'),
(44, 'Interaction Ticket', 'http://10.249.64.118'),
(45, 'TELCELAMERICABYOP', 'http://telcelamericabyop.com/'),
(46, 'ERD Logger', 'http://10.248.18.81/localerdlogger/auth/login'),
(47, 'MO6 Midwest', 'http://10.248.171.92/erd/CaresMidwest1.ica'),
(48, 'Sprint Link', 'https://ead.sprint.com/Citrix/XenApp/auth/login.aspx'),
(49, 'Programming Day 1 Quiz', 'http://equality.tracfone.com/Programming_Day_1_Quiz_BZE'),
(50, 'Legacy Level IB Final Test 2011', 'http://equality.tracfone.com/Legacy_Level_IB_Final_Test_2011_BZE'),
(51, 'Legacy NH Level I', 'http://equality.tracfone.com/Legacy_NH_Level_I_BZE'),
(52, 'Impact 360', 'http://impact360.tracfone.com:7001/wfo/control/signin'),
(53, 'Safelink Backup', 'http://www.safelinkwireless.com/Safelink/check_enroll'),
(54, 'Google', 'http://google.com');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_email_send`
--

CREATE TABLE IF NOT EXISTS `temporary_email_send` (
`id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) unsigned NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1=> Mangeres, 2=> Employee',
  `username` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `job_title` tinyint(1) DEFAULT NULL COMMENT '1 => supervisor, 2=> QA',
  `assigned_qa` varchar(255) DEFAULT NULL,
  `assigned_supervisor` varchar(255) DEFAULT NULL,
  `hire_date` varchar(10) DEFAULT NULL,
  `activation_code` varchar(60) DEFAULT NULL,
  `is_change_password` tinyint(1) NOT NULL DEFAULT '0',
  `previous_password` varchar(255) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `updated_date` varchar(10) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `username`, `email`, `password`, `first_name`, `last_name`, `employee_id`, `job_title`, `assigned_qa`, `assigned_supervisor`, `hire_date`, `activation_code`, `is_change_password`, `previous_password`, `created_date`, `updated_date`, `is_enabled`) VALUES
(1, 1, 'manager', 'vic@mailinator.com', '6d3a65859d1f59a1e0f1917e14d18ec6', 'Amar', 'Kalra', '24154', 2, NULL, NULL, '1465059289', 'egege', 0, '{"1467125397":"085e40688c7c18da2553498060d2c4d3","1467130221":"54b602032ac114213b454a2685b6b148","1467813966":"6d3a65859d1f59a1e0f1917e14d18ec6"}', '1466632800', '1467813966', 1),
(2, 3, 'admin', 'manager@rca.com', 'c39febf2590651499b610617d2febcd9', 'Sebastian', 'Gomez', '45615', NULL, NULL, NULL, '1465171200', NULL, 0, '{"1467129334":"0d32f93c775e2eb303de0ea7f8e11ff1","1467129383":"554d19e8ee732bbfa38be59a0ff74896","1467129434":"f1233dd6385997bd925551469fd35998","1467129465":"ac6daf9a7db850334bf062253c9d0314","1467129484":"c39febf2590651499b610617d2febcd9"}', '1466632800', '1467129484', 1),
(3, 2, 'employee', 'employee@mailinator.com', 'c10233759886f7fce46e7fb11ec602e3', 'Naman', 'Tamrakar', '45616', 1, NULL, NULL, '1465059289', NULL, 0, '{"1467125397":"085e40688c7c18da2553498060d2c4d3"}', '', NULL, 1),
(4, 1, '22233313', '123@123.com', 'a45bdd36489912d0e70aab7e91ecf04f', 'Juan', 'Gomez', '22233313', NULL, NULL, NULL, '1468281600', NULL, 0, '{"1468348892":"a45bdd36489912d0e70aab7e91ecf04f"}', '1468348892', NULL, 1),
(7, 1, 'manager', 'ASD@CIS.COM', '54b602032ac114213b454a2685b6b148', 'Gaurav', 's', 'manager', 2, NULL, NULL, '1468454400', NULL, 0, '{"1468434653":"54b602032ac114213b454a2685b6b148"}', '1468434653', NULL, 1),
(8, 2, '1212', 'ASD@CIS.COM', 'b222ccd83c937563845e2a5a9f4cfaef', 'navab', 'khan', '1212', 2, 'manager', NULL, '1468454400', NULL, 0, '{"1468435146":"b222ccd83c937563845e2a5a9f4cfaef"}', '1468435146', NULL, 1),
(9, 2, 'dsf', 'ASD@CIS.COM', 'beee7b6b0806ffc8961ef518126c9106', 'dsdsad', 'sdfsfs', 'dsf', NULL, '24154', NULL, '1468454400', NULL, 0, '{"1468480828":"beee7b6b0806ffc8961ef518126c9106"}', '1468480828', NULL, 1),
(11, 1, '2323', 'ASD@CIS.COM', 'b222ccd83c937563845e2a5a9f4cfaef', 'Vikas', 'Burman', '2323', 1, NULL, NULL, '1468454400', NULL, 0, '{"1468483518":"b222ccd83c937563845e2a5a9f4cfaef"}', '1468483518', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_welcome_quotes`
--

CREATE TABLE IF NOT EXISTS `user_welcome_quotes` (
`id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `welcome_quote_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `welcome_quotes`
--

CREATE TABLE IF NOT EXISTS `welcome_quotes` (
`id` int(11) unsigned NOT NULL,
  `welcome_quote` text NOT NULL,
  `welcome_quote_date` varchar(10) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `updated_date` varchar(10) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `welcome_quotes`
--

INSERT INTO `welcome_quotes` (`id`, `welcome_quote`, `welcome_quote_date`, `created_date`, `updated_date`, `is_enabled`) VALUES
(1, 'Have a nice day!', '1466380800', '', NULL, 1),
(2, 'Hello Everyone!', '1467158400', '', NULL, 1),
(3, 'its a testing qoute', '1468195200', '', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_field_name`
--
ALTER TABLE `logs_field_name`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `performances`
--
ALTER TABLE `performances`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_links`
--
ALTER TABLE `site_links`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temporary_email_send`
--
ALTER TABLE `temporary_email_send`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_welcome_quotes`
--
ALTER TABLE `user_welcome_quotes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `welcome_quotes`
--
ALTER TABLE `welcome_quotes`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `logs_field_name`
--
ALTER TABLE `logs_field_name`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `performances`
--
ALTER TABLE `performances`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `site_links`
--
ALTER TABLE `site_links`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `temporary_email_send`
--
ALTER TABLE `temporary_email_send`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_welcome_quotes`
--
ALTER TABLE `user_welcome_quotes`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `welcome_quotes`
--
ALTER TABLE `welcome_quotes`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
