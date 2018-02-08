-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2018 at 02:41 PM
-- Server version: 10.0.29-MariaDB-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mic_news`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
`id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `detail` text,
  `thumbnail` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `app_show` enum('customer','business') DEFAULT NULL,
  `is_customer` int(1) unsigned NOT NULL,
  `is_business` int(1) unsigned NOT NULL,
  `position` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `sent_status` enum('1','2') NOT NULL COMMENT '1=Active (not sent), 2=Sent ',
  `sent_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `name`, `detail`, `thumbnail`, `image`, `app_show`, `is_customer`, `is_business`, `position`, `start_date`, `end_date`, `created_at`, `updated_at`, `status`, `sent_status`, `sent_date`) VALUES
(5, 'แซ่บ เว่อร์ ไก่ทอด สูตร กรอบ อร่อย ถึงใจ', '<p>แซ่บ เว่อร์ ไก่ทอด สูตร กรอบ อร่อย ถึงใจ จำหน่ายแล้วทุกสาขา เพียงชิ้นละ 22 บาทเท่านั้น</p>\r\n<p>Have you ever imagine about combining Malar Grilled Chicken and Chicken Rice? If you want to find out what the taste look like, you can try our newly launch Boneless Malar Grilled Chicken with Oily Rice at every Five Star Extra.</p>\r\n<p>A rice menu with truly differentiated taste and full of protein can available at 2800 Ks ONLY! Also you can try this with promotion.&nbsp;</p>\r\n<p>Promotion Period: From 3 to 5 February</p>\r\n<p>For every customer who order any rice menu, can get 1 Boneless Malar Grilled Chicken with Oily Rice by scanning promotion QR Code at all Five Star Extra restaurants.</p>\r\n<p>Redemption Process</p>\r\n<p>STEP 1 : Find the Happy QR Code sticker at all Five Star Extra Outlets</p>\r\n<p>STEP 2 : Choose the SCAN CODE Function and it will pop up the QR code scanner</p>\r\n<p>STEP 3 : Point your mobile phone to scan our Happy QR code sticker&nbsp;</p>\r\n<p>STEP 4 : Press Redeem</p>\r\n<p>STEP 5 : Show the Redeem Code Screen to the Cashier and get FREE 1&nbsp; Boneless Malar Grilled Chicken with Oily Rice</p>\r\n<p>CONDITIONS :</p>\r\n<p>* Be hurry! Your Happy time is running out. Show the code to cashier within 15 minutes to redeem your&nbsp; Boneless Malar Grilled Chicken with Oily Rice</p>\r\n<p>* 1 Member can only scan 1 time per day</p>\r\n<p>*TERMS &amp; CONDITIONS APPLY</p>', 'http://staging-dynamic-cdn.eggdigital.com/dBjlmjk6K.jpg', 'http://staging-dynamic-cdn.eggdigital.com/dBjlmjk6K.jpg', 'customer', 1, 1, 3, '2018-01-01 00:00:00', '2018-03-31 00:00:00', '2017-12-26 10:50:51', '2018-02-02 17:13:25', 'active', '1', '0000-00-00 00:00:00'),
(6, 'เปิดตัวแล้ว!! ไก่ย่างห้าดาว สูตรนิวออร์ลีนส์ อร่อยเข้มสะใจยันคำสุดท้าย', '<div class="news_detail-date ng-binding">&nbsp;</div>\r\n<div class="news_detail-date ng-binding">เปิดตัวแล้ว ไก่ย่างห้าดาวนิวออร์ลีนส์<br />ต้นตำรับจากอเมริกา รสเข้ม เข้าเนื้อ อร่อยเข้มสะใจยันคำสุดท้าย พิเศษสุดๆเพียงตัวละ 120 บาท อร่อยเข้มสะใจยันคำสุดท้าย พิเศษเพียงตัวละ 120 บาท (วันนี้ - 31 มี.ค 2560)</div>\r\n<div class="news_detail-date ng-binding">&nbsp;</div>\r\n<div class="news_detail-date ng-binding">\r\n<p>Have you ever imagine about combining Malar Grilled Chicken and Chicken Rice? If you want to find out what the taste look like, you can try our newly launch Boneless Malar Grilled Chicken with Oily Rice at every Five Star Extra.</p>\r\n<p>A rice menu with truly differentiated taste and full of protein can available at 2800 Ks ONLY! Also you can try this with promotion.&nbsp;</p>\r\n<p>Promotion Period: From 3 to 5 February</p>\r\n<p>For every customer who order any rice menu, can get 1 Boneless Malar Grilled Chicken with Oily Rice by scanning promotion QR Code at all Five Star Extra restaurants.</p>\r\n<p>Redemption Process</p>\r\n<p>STEP 1 : Find the Happy QR Code sticker at all Five Star Extra Outlets</p>\r\n<p>STEP 2 : Choose the SCAN CODE Function and it will pop up the QR code scanner</p>\r\n<p>STEP 3 : Point your mobile phone to scan our Happy QR code sticker&nbsp;</p>\r\n<p>STEP 4 : Press Redeem</p>\r\n<p>STEP 5 : Show the Redeem Code Screen to the Cashier and get FREE 1&nbsp; Boneless Malar Grilled Chicken with Oily Rice</p>\r\n<p>CONDITIONS :</p>\r\n<p>* Be hurry! Your Happy time is running out. Show the code to cashier within 15 minutes to redeem your&nbsp; Boneless Malar Grilled Chicken with Oily Rice</p>\r\n<p>* 1 Member can only scan 1 time per day</p>\r\n<p>*TERMS &amp; CONDITIONS APPLY</p>\r\n</div>', 'http://staging-dynamic-cdn.eggdigital.com/dM59TVKAU.jpg', 'http://staging-dynamic-cdn.eggdigital.com/dM59TVKAU.jpg', 'customer', 1, 1, 2, '2018-01-01 00:00:00', '2018-05-31 00:00:00', '2018-01-04 16:15:13', '2018-02-02 17:13:33', 'active', '1', '0000-00-00 00:00:00'),
(11, 'test', '12356t7y8u9i123123', 'adsa2121.jpg', '2131.jpg', 'customer', 0, 0, 1, '2017-09-20 00:00:00', '2017-10-20 23:59:59', '2018-02-02 11:23:36', '2018-02-02 11:23:36', 'active', '1', '0000-00-00 00:00:00'),
(12, 'testtesttest2', '<p>testtesttest2</p>', 'http://staging-dynamic-cdn.eggdigital.com/eq2fs8MK2.jpeg', 'http://staging-dynamic-cdn.eggdigital.com/eq2fs8MK2.jpeg', 'customer', 0, 0, 0, '2018-02-02 00:00:00', '2018-02-28 23:59:59', '2018-02-02 15:51:33', '2018-02-02 15:51:33', 'active', '1', '0000-00-00 00:00:00'),
(13, 'Grilled Pork Ball Promotion', '<p>Recently launched Grilled Pork Ball''s promotion is comming!!!</p>\r\n<p>Let''s get 2 Grilled Pork Ball with only 1000 Ks by scaning QR Code at outlet with CP Five Star Mobile Application.</p>\r\n<p>DURATION: Feb 1st - 5th</p>\r\n<p>Let''s enjoy the promotion</p>\r\n<p>STEP 1 : Find the Happy QR Code sticker at every Five Star Outlets in Myanmar <br />STEP 2 : Choose the SCAN CODE Function and it will pop up the QR code scanner.<br />STEP 3 : Point your mobile phone to scan our Happy QR code sticker<br />STEP 4 : Press Redeem and Get 5 Point <br />STEP 5 : Show the Redeem Code Screen to the Cashier and get discount</p>\r\n<p>CONDITIONS :<br />* Be hurry! Your Happy time is running out. Show the code to cashier within 15 minutes to get discount<br />* 1 member can scan as they buy</p>', 'http://staging-dynamic-cdn.eggdigital.com/dKjNUAW7M.jpg', 'http://staging-dynamic-cdn.eggdigital.com/dKjNUAW7M.jpg', 'customer', 1, 1, 1, '2018-02-01 00:00:00', '2018-03-31 00:00:00', '2018-02-02 16:41:59', '2018-02-02 17:13:17', 'active', '1', '0000-00-00 00:00:00'),
(14, 'testtesttesttesttesttesttesttesttest', '<p>testtesttesttesttesttesttesttesttest</p>', 'http://staging-dynamic-cdn.eggdigital.com/bmnAIlweU.jpeg', 'http://staging-dynamic-cdn.eggdigital.com/bmnAIlweU.jpeg', 'customer', 1, 0, 0, '2018-02-02 00:00:00', '2018-02-28 00:00:00', '2018-02-02 17:17:57', '2018-02-02 17:19:14', 'inactive', '1', '0000-00-00 00:00:00'),
(15, 'Coca Cola Combo Set', '<p>Have you ever imagine about combining Malar Grilled Chicken and Chicken Rice? If you want to find out what the taste look like, you can try our newly launch Boneless Malar Grilled Chicken with Oily Rice at every Five Star Extra.</p>\r\n<p>A rice menu with truly differentiated taste and full of protein can available at 2800 Ks ONLY! Also you can try this with promotion.&nbsp;</p>\r\n<p>Promotion Period: From 3 to 5 February</p>\r\n<p>For every customer who order any rice menu, can get 1 Boneless Malar Grilled Chicken with Oily Rice by scanning promotion QR Code at all Five Star Extra restaurants.</p>\r\n<p>Redemption Process</p>\r\n<p>STEP 1 : Find the Happy QR Code sticker at all Five Star Extra Outlets</p>\r\n<p>STEP 2 : Choose the SCAN CODE Function and it will pop up the QR code scanner</p>\r\n<p>STEP 3 : Point your mobile phone to scan our Happy QR code sticker&nbsp;</p>\r\n<p>STEP 4 : Press Redeem</p>\r\n<p>STEP 5 : Show the Redeem Code Screen to the Cashier and get FREE 1&nbsp; Boneless Malar Grilled Chicken with Oily Rice</p>\r\n<p>CONDITIONS :</p>\r\n<p>* Be hurry! Your Happy time is running out. Show the code to cashier within 15 minutes to redeem your&nbsp; Boneless Malar Grilled Chicken with Oily Rice</p>\r\n<p>* 1 Member can only scan 1 time per day</p>\r\n<p>*TERMS &amp; CONDITIONS APPLY</p>', 'http://staging-dynamic-cdn.eggdigital.com/djzhqWMM6.png', 'http://staging-dynamic-cdn.eggdigital.com/djzhqWMM6.png', 'customer', 1, 0, 0, '2018-01-01 00:00:00', '2018-03-31 23:59:59', '2018-02-02 17:18:42', '2018-02-02 17:18:42', 'active', '1', '0000-00-00 00:00:00'),
(16, 'The Jumbo Ball 1 get 1 Free', '<p class="p1">It''s time to get the "Jumbo Ball" rolling!!!</p>\r\n<p class="p2">&nbsp;</p>\r\n<p class="p1">Try the bigger and higher meat product, Jumbo Ball? Appetizing with spicy flavour and freshness . Only 500Ks per stick!</p>\r\n<p class="p2">&nbsp;</p>\r\n<p class="p1">DURATION : 21-27 September</p>\r\n<p class="p2">&nbsp;</p>\r\n<p class="p1">For Five Star Application members, get FREE 1 stick of Jumbo Ball when you buy another a stick of Jumbo Ball! Find and scan the Happy QR code at our 122 participating CP Five Star outlets.</p>\r\n<p class="p2">&nbsp;</p>\r\n<p class="p1">LET''S JOIN THE HAPPY TIME!</p>\r\n<p class="p1">STEP 1 : Find the Happy QR Code sticker at 122 participating Five Star Outlets</p>\r\n<p class="p1">STEP 2 : Choose the SCAN CODE Function and it will pop up the QR code scanner</p>\r\n<p class="p1">STEP 3 : Point your mobile phone to scan our Happy QR code sticker</p>\r\n<p class="p1">STEP 4 : Press Redeem</p>\r\n<p class="p1">STEP 5 : Show the Redeem Code Screen to the Cashier and get FREE 1 stick of Jumbo Ball</p>\r\n<p class="p2">&nbsp;</p>\r\n<p class="p1">CONDITIONS :</p>\r\n<p class="p1">* Be hurry! Your Happy time is running out. Show the code to cashier within 15 minutes to redeem your Jumbo Ball.</p>\r\n<p class="p1">* Scan and get FREE 1 stick of Jumbo Ball.</p>\r\n<p class="p1">* 1 Member can make unlimited scan per day.</p>\r\n<p class="p2">&nbsp;</p>\r\n<p class="p1">PARTICIPATING 122 OUTLETS as followoing;</p>\r\n<p class="p1">Dala</p>\r\n<p class="p1">Sein Gay Har Pyay</p>\r\n<p class="p1">Orange (Yedagon)</p>\r\n<p class="p1">Yuzana Plaza</p>\r\n<p class="p1">Central Mart -2</p>\r\n<p class="p1">Junction Zawanna</p>\r\n<p class="p1">Yankin</p>\r\n<p class="p1">Tarmwe Orange</p>\r\n<p class="p1">Kyauk Myaung</p>\r\n<p class="p1">Kyaik Kasan Pagoda</p>\r\n<p class="p1">Kyauk Tan</p>\r\n<p class="p1">Orange (Thanlyin)</p>\r\n<p class="p1">Phayargone Junction</p>\r\n<p class="p1">Tharkayta Cinema</p>\r\n<p class="p1">Mandalay Market</p>\r\n<p class="p1">Sky Net Dagon Seikkan</p>\r\n<p class="p1">11 Mart East Dagon</p>\r\n<p class="p1">11 Mart 133 Junction</p>\r\n<p class="p1">Khone Padaythar</p>\r\n<p class="p1">Kyal Ni Shwe Pauk Kan</p>\r\n<p class="p1">Medicine 2</p>\r\n<p class="p1">Htauk Kyant</p>\r\n<p class="p1">Kan Thar Yar</p>\r\n<p class="p1">Gamonepwint</p>\r\n<p class="p1">Junction 8</p>\r\n<p class="p1">Orange (Phaw Kan)</p>\r\n<p class="p1">BOC</p>\r\n<p class="p1">Tadarphyu</p>\r\n<p class="p1">Htan Chauk Pin</p>\r\n<p class="p1">YGN-1 (Myay-Ni-Gone)</p>\r\n<p class="p1">YGN-2 (37 street)</p>\r\n<p class="p1">Gandamar Whole Sale Market</p>\r\n<p class="p1">Sandar Myine Mart</p>\r\n<p class="p1">Dagon Center</p>\r\n<p class="p1">San Pya Cenema</p>\r\n<p class="p1">Super One Kyeik-Ka-San</p>\r\n<p class="p1">Thamine Junction</p>\r\n<p class="p1">Sein Gay Har Parami</p>\r\n<p class="p1">Gamone Pwint (Hledan)</p>\r\n<p class="p1">Butar yone</p>\r\n<p class="p1">Thone Gwa Thanlyin</p>\r\n<p class="p1">Pinlon Market</p>\r\n<p class="p1">South Okkala Pagoda</p>\r\n<p class="p1">North Dagon 35</p>\r\n<p class="p1">Saw Bwar Gyi Gone</p>\r\n<p class="p1">Gyogone</p>\r\n<p class="p1">Than LanIn Mandalay</p>\r\n<p class="p1">Five Star (73 st)</p>\r\n<p class="p1">Kandawgyi</p>\r\n<p class="p1">56 Franchise</p>\r\n<p class="p1">62 Franchise</p>\r\n<p class="p1">Nan Shae</p>\r\n<p class="p1">Uni</p>\r\n<p class="p1">80x11</p>\r\n<p class="p1">Patheingyi</p>\r\n<p class="p1">35x58</p>\r\n<p class="p1">80 Convert</p>\r\n<p class="p1">Amarapura</p>\r\n<p class="p1">69 Franchise</p>\r\n<p class="p1">Themengone</p>\r\n<p class="p1">78 Kyawe Sae Kan</p>\r\n<p class="p1">Manawhari</p>\r\n<p class="p1">22 Franchise</p>\r\n<p class="p1">Kat Kyaw</p>\r\n<p class="p1">Tagonetine</p>\r\n<p class="p1">Diamond</p>\r\n<p class="p1">82 BEHS</p>\r\n<p class="p1">86 Franchise</p>\r\n<p class="p1">Fuji</p>\r\n<p class="p1">26 x 91 Franchise</p>\r\n<p class="p1">76 Franchise</p>\r\n<p class="p1">Ocean Naypyidaw</p>\r\n<p class="p1">Lewe</p>\r\n<p class="p1">Bago</p>\r\n<p class="p1">Nyaung Lay Pin</p>\r\n<p class="p1">Dawei</p>\r\n<p class="p1">Tha Htone Kiosk</p>\r\n<p class="p1">Pyay</p>\r\n<p class="p1">Aunglan</p>\r\n<p class="p1">Gyobingauk</p>\r\n<p class="p1">Shwe Gyin</p>\r\n<p class="p1">Bago Magadit</p>\r\n<p class="p1">Pyinmana</p>\r\n<p class="p1">Sein Daung (NPT)</p>\r\n<p class="p1">Pyinmana Elephant Cricle</p>\r\n<p class="p1">Hlegu</p>\r\n<p class="p1">Phyu</p>\r\n<p class="p1">Myoema Market</p>\r\n<p class="p1">Zayar Thiri (NPT)</p>\r\n<p class="p1">Taung Ngu</p>\r\n<p class="p1">Zayat Kwin</p>\r\n<p class="p1">Pha An</p>\r\n<p class="p1">Ocean (Mawlamying)</p>\r\n<p class="p1">Mudon</p>\r\n<p class="p1">Mawlaming (Pabedan)</p>\r\n<p class="p1">Kyaik Htee Yoe (Golden Rock)</p>\r\n<p class="p1">Mawlamying Industry</p>\r\n<p class="p1">Mawlamyine-2</p>\r\n<p class="p1">Than Phyu Zayat</p>\r\n<p class="p1">Myeik</p>\r\n<p class="p1">Pha An 3</p>\r\n<p class="p1">Pha An Phoe La Min</p>\r\n<p class="p1">Kyaik Hto</p>\r\n<p class="p1">Dawei 2</p>\r\n<p class="p1">Hmaw Bi</p>\r\n<p class="p1">Tike Kyee</p>\r\n<p class="p1">Hmaw Bi Mini Bus Stop</p>\r\n<p class="p1">Pyay 3</p>\r\n<p class="p1">Pyay 2</p>\r\n<p class="p1">Ma U Bin</p>\r\n<p class="p1">Bokalay Town</p>\r\n<p class="p1">Hinthada</p>\r\n<p class="p1">Pathein Bandula Road</p>\r\n<p class="p1">Sarmalout</p>\r\n<p class="p1">Pathein University</p>\r\n<p class="p1">Pyarpon</p>\r\n<p class="p1">Pan Ta Naw</p>\r\n<p class="p1">Luputa</p>\r\n<p class="p1">Kyauk Phyu</p>\r\n<p class="p1">Thabyaegone Market</p>\r\n<p class="p1">Bago Myothit</p>\r\n<p class="p1">Kyauk Tagar</p>\r\n<p class="p2">&nbsp;</p>\r\n<p class="p1">*TERMS &amp; CONDITIONS APPLY</p>', '', '', 'customer', 1, 0, 0, '2018-02-01 00:00:00', '2018-03-31 23:59:59', '2018-02-08 10:56:21', '2018-02-08 10:56:21', 'active', '1', '0000-00-00 00:00:00'),
(17, 'TEST', '<p>TEST</p>', '', '', 'customer', 1, 0, 0, '2018-02-08 00:00:00', '2018-02-15 23:59:59', '2018-02-08 11:21:44', '2018-02-08 11:21:44', 'active', '1', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
