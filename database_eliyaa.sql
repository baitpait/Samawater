-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 23, 2025 at 11:24 AM
-- Server version: 10.11.5-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sarfesak_eliyaa`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admin@eliyaa.com|46.60.53.127', 'i:1;', 1762459606),
('admin@eliyaa.com|46.60.53.127:timer', 'i:1762459606;', 1762459606);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_withdraws`
--

CREATE TABLE `cash_withdraws` (
  `id` int(11) NOT NULL,
  `distributor_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_withdraws`
--

INSERT INTO `cash_withdraws` (`id`, `distributor_id`, `total_amount`, `notes`, `created_at`, `updated_at`) VALUES
(5, 6, 100, NULL, '2025-12-14 08:39:18', '2025-12-14 08:39:18');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `created_at`, `updated_at`) VALUES
(3, 'اذنا', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(4, 'أريحا', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(5, 'الخليل', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(6, 'السموع', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(7, 'الشيوخ', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(8, 'الظاهرية', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(9, 'يطا', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(10, 'بني نعيم', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(11, 'بيت أمر', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(12, 'بيت لحم', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(13, 'ترقوميا', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(14, 'حلحول', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(15, 'دورا', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(16, 'رام الله', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(17, 'سعير', '2025-11-11 10:52:55', '2025-11-11 10:52:55'),
(18, 'بلا', '2025-11-11 10:52:55', '2025-11-11 10:52:55');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `contract_no` varchar(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `phone_one` varchar(50) DEFAULT NULL,
  `phone_two` varchar(50) DEFAULT NULL,
  `client_type` int(11) DEFAULT NULL,
  `subscription_type_id` int(11) DEFAULT NULL,
  `subscription_status_id` int(11) DEFAULT NULL,
  `subscription_start_date` date DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `bottle_balance` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `city_name` text DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `contract_no`, `name`, `city_id`, `address`, `phone_one`, `phone_two`, `client_type`, `subscription_type_id`, `subscription_status_id`, `subscription_start_date`, `longitude`, `latitude`, `bottle_balance`, `notes`, `image`, `created_at`, `updated_at`, `city_name`, `distributor_id`) VALUES
(1, 'C0000521', 'علام التلبيشي - المنزل', 15, 'المجد', '0599422036', NULL, 1, 4, 1, '2025-12-21', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-21 18:32:55', 'دورا', NULL),
(2, 'C0000522', 'مروان الشحاتيت - المصنع', 15, 'المجد', '0599715551', NULL, 1, 4, 1, '2025-12-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(3, 'C0000524', 'جهاد صبري شحاتيت', 15, 'بلا/المجد', '0599079539', NULL, 1, 4, 1, '2025-12-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(4, 'C0000523', 'علي ياسين مخارزة', 8, NULL, '0599671615', NULL, 1, 4, 1, '2025-12-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(5, 'C0000101', 'بلدية اذنا', 3, 'البلدية', '0599261029', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'اذنا', NULL),
(6, 'C0000046', 'أيمن ماجد محمد المسالمة /المصنع', 15, NULL, '0599432376', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(7, 'C0000166', 'خلدون العمايرة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(8, 'C0000371', 'محمود حسين مسالمة  ( مصنع دوور )', 15, 'المطينة - دير سمت مصنع اور دور', '0598822433', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(9, 'C0000091', 'باسم يونس عبد الرحمن مسالمة / برستيج', 15, 'بلا', '0599377312', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(10, 'C0000519', 'محمد شبلي المسالة شركة', 15, 'بلا/بين بيت عوا ودير سامت', '0599759287', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(11, 'C0000525', 'حليمة خشان', 15, 'بلا/سنجر / خلف المخراز', '0594718988', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(12, 'C0000057', 'إيمان خليل محمد مسالمة', 15, 'بيت عوا حارة عمار', '0599379701', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(13, 'C0000053', 'إسماعيل عوض صلاح السويطي ( المنزل )', 15, 'مقابل مسجد خالد بن الوليد', '0597672164', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(14, 'C0000520', 'احمد مطاوع المسالمة', 15, 'بلا/بيت عوا جبل عمار', '0599308968', NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(15, 'C0000103', 'بلدية دورا', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(16, 'C0000514', 'مهند نصري يوسف صبيح', 12, 'بلا/بيت لحم مفرق رمزونات مخيم دهيشة الدوحة', '0597507748', NULL, 1, 4, 1, '2025-12-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(17, 'C0000423', 'نزار سدر', 5, 'الخليل - حارة الشيخ', '0595703555', NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(18, 'C0000223', 'شاهر عابدين / بلازا', 5, NULL, NULL, NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(19, 'C0000282', 'عيسى جبرائيل عوض أبو سعدة', 5, NULL, '0569134501', NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(20, 'C0000070', 'الإغاثة الطبية الفلسطينية / الخليل', 5, 'الخليل - الحرس - بجانب البنك العربي', '022292210', NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(21, 'C0000518', 'عبد الله القواسمة /محل جمرة للاراقيل', 5, 'بلا/الخليل شارع السلام بالقرب من رمزونات المدارس', '0566588880', NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(22, 'C0000476', 'شركة كير ميديكس لاين للتوريدات الطبية/ عنان مجاهد', 5, 'بلا/عين سارة _ الحرس _ بجانب عابدين للصرافة', '0599678203', NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(23, 'C0000074', 'الدرابيع نسايب وسام ربعي', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(24, 'C0000084', 'الوطنية للتأمين / فرع الخليل', 15, 'الخليل طلعة التربية القديمة بجانب الوكالة', '0562000040', NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(25, 'C0000356', 'محمد محمود عبد الرحمن التلبيشي', 15, NULL, '0599991559', NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(26, 'C0000438', 'هيثم بسام عمر شاهين', 5, 'الخليل - الحرس بجانب بيت فخري الشريف', '0599228456', NULL, 1, 4, 1, '2025-12-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(27, 'C0000043', 'أيمن أبو اسنينة', 5, NULL, '0599973671', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(28, 'C0000461', 'عزات العواودة / كهرباء الاصدقاء', 5, 'بلا/الخليل _ البصة', '0593973994', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(29, 'C0000026', 'أكرم عايد أحمد الفقيه', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(30, 'C0000106', 'بهية جاد الله', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(31, 'C0000167', 'خلدون عوني ابو ريان', 15, NULL, '0598604101', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(32, 'C0000296', 'كامل يوسف سلامة أبو فردة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(33, 'C0000462', 'رامي يوسف عمرو / الجد', 15, 'بلا/حنينة _ الماجور _ بالقرب من مغسلة النمورة', '0595327500', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(34, 'C0000096', 'بلال الشعراوي', 15, 'دورا - سنجر - إن هاوس للمفروشات', '0599777859', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(35, 'C0000517', 'عماد الصوص', 15, 'دورا وسط البلد', '0599233451', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(36, 'C0000361', 'محمد نايف محمد عمرو / محلات صخر التجارية', 15, NULL, '0592336114', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(37, 'C0000004', 'أبو موسى السيخ / زبون', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(38, 'C0000428', 'نضال ياسر بريويش', 15, 'دورا واد سود', '0599642270', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(39, 'C0000083', 'الهلال الأحمر', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(40, 'C0000458', 'يحيى ابو هاشم', 15, 'بلا', '0562550761', NULL, 1, 4, 1, '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(41, 'C0000370', 'محمود احمد محمد السويطي / دورا ناقة نوح', 15, NULL, '0599276070', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(42, 'C0000516', 'شركة المناصرة للاستيراد والاصدير', 5, 'بلا/شارع الملك فيصل _ مجمع خلف _ مقابل التربية قديما', '0569391904', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(43, 'C0000468', 'الاكاديمية المهنية للعلوم المالية', 5, 'بلا/عين سارة _ عمارة جوال _ الطابق الخامس', '0597278486', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(44, 'C0000007', 'أحمد حكمت أحمد قشطاوي', 5, 'بين مفرق الجامعة و مفرق المدارس', '0599044225', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(45, 'C0000162', 'خالد محمد إبراهيم خليل', 12, 'الدوحة', '0597150682', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(46, 'C0000515', 'ابو سند ابو صبيح', 12, 'بلا/بيت لحم / الخضر اول الخضر المدخل الرئيسي', '0586969988', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(47, 'C0000513', 'الدكتور منذر الدرعاوي', 12, 'بلا/بيت لحم العبيدية بجانب شورما العبيدية', '0595223858', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(48, 'C0000511', 'عبد الكريم محمد عرار', 12, 'بلا/بيت لحم الكركفة منطقة اريج', '0599386009', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(49, 'C0000512', 'نقابة التمريض /بيت لحم', 12, 'بلا/بيت لحم بجانب مستشفى بيت جالا الحكومي', '0598956225', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(50, 'C0000279', 'عمار محمد عبد الرحمن التلبيشي', 15, NULL, '0599704311', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(51, 'C0000259', 'عبيدة محمد عبد الرحمن التلبيشي / المنزل', 15, 'دورا - سنجر بالقرب من مشتل الاطرش - بجانب كراج رام', '0597318885', NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(52, 'C0000510', 'علام التلبيشي / الكرفان', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(53, 'C0000145', 'حمدي أحمد علي موسى 1', 12, NULL, NULL, NULL, 1, 4, 1, '2025-12-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(54, 'C0000146', 'حمدي أحمد علي موسى 2', 12, 'الخضر  منزل حمدي موسى', '0598574258', NULL, 1, 4, 1, '2025-12-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(55, 'C0000449', 'وليد محمد محمود جوابرة', 12, 'شارع الصف - إسكانات ميلاد', '0568120406', NULL, 1, 4, 1, '2025-12-15', 35.2008774, 31.7027485, NULL, NULL, NULL, NULL, '2025-12-22 11:50:08', 'بيت لحم', NULL),
(56, 'C0000176', 'رائدة ابو غربية', 5, 'الخليل/ مفرق ابو الحلاوة / في طريق مطعم ابو مازن', '0599034064', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(57, 'C0000137', 'حامد حمادة أحمد إدريس', 5, NULL, '0599777848', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(58, 'C0000019', 'أسامة فوزي الحداد / عيادة الجلدة', 5, 'الجلدة دوار الجلدة - مركز الجلدة الطبي التخصصي', '0593206086', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(59, 'C0000220', 'سهام محمد سلمان ناصر الدين', 5, 'الخليل - المقاطعة - بجانب المخابرات - ناصر الدين ل', '0599511555', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(60, 'C0000240', 'شركة كيوكرد', 5, 'حارة زغير بالقرب من كرستال ابو سنينة', '0598844430', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(61, 'C0000071', 'الإغاثة الطبية المقر العام', 5, 'مفرق الجامعه عمارة السنابل الطابق الارضي', '0599798036', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(62, 'C0000002', 'Universal Matresses مصنع فرشات يونيفيرسال', 13, NULL, NULL, NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ترقوميا', NULL),
(63, 'C0000404', 'مكتب العنان للتخليص الجمركي', 15, NULL, '0599380241', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(64, 'C0000345', 'محمد عبد المجيد فطافطة', 13, NULL, '0595538381', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ترقوميا', NULL),
(65, 'C0000231', 'شركة اوبتيموس', 5, 'الخليل نمرة', '0568823262', NULL, 1, 4, 1, '2025-12-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(66, 'C0000045', 'أيمن ماجد محمد المسالمة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(67, 'C0000104', 'بلدية دير سامت', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(68, 'C0000508', 'مجد ابو هشهش', 15, 'بلا/الفوار _ اول مدخل المخيم _ مقابل عيادات الوكالة', '0569400647', NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(69, 'C0000505', 'بسام بسام مطاوع مسالمة', 15, 'بلا/بيت عوا _ شركة برستيج', '0562333611', NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(70, 'C0000199', 'سارة السراحنة /جامعة القدس المفتوحة', 9, NULL, '0598035009', NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(71, 'C0000377', 'محمود محمد أحمد الهليس', 9, NULL, '0569200387', NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(72, 'C0000507', 'حلويات تاج الملك / سامر الحسيني', 9, 'بلا/مقابل جامعة القدس المفتوحة', '0592682220', NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(73, 'C0000173', 'دفاع مدني دورا', 15, 'ابو هلال', NULL, NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(74, 'C0000244', 'صديق مجدي محمد مسالمة', 15, 'بيت عوا - خلف مدرسة الكرامة', '0598171546', NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(75, 'C0000440', 'هيثم ماجد محمد المسالمة', 15, NULL, '0599395016', NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(76, 'C0000506', 'بكر ابو رجب', 9, 'بلا/بالقرب من الامن الوقائي  _ بجانب مركز اسعاف النور', '0598743882', NULL, 1, 4, 1, '2025-12-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(77, 'C0000500', 'المهندس سنتر / انس سدر', 5, 'المجور/بجانب مسجد الحسين', NULL, NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(78, 'C0000498', 'احمد ابو منشار / المحل', 5, 'الهيبرون سننتر A', '0597180481', NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(79, 'C0000499', 'احمد ابو منشار / البيت', 5, 'بلا/نمرة', NULL, NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(80, 'C0000235', 'شركة كرستال ابو سنينة للزجاج والمرايا', 5, 'حارة زغير شارع السلام الدخلة جنب حلويات زغير', NULL, NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(81, 'C0000497', 'مختبر بيروت', 5, 'دوار ابن رشد', NULL, NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(82, 'C0000460', 'سعود شاهين', 5, NULL, '0569445039', NULL, 1, 4, 1, '2025-12-11', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-22 08:54:24', 'بلا', NULL),
(83, 'C0000496', 'هبة زماعرة', 14, 'مقابل ديوان زماعرة', NULL, NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'حلحول', NULL),
(84, 'C0000503', 'يوسف حماد العواودة', 15, 'خرسا/الشرفة', NULL, NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(85, 'C0000501', 'نهرو سمير شلالدة', 17, 'مقابل مركز الشرطة', NULL, NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'سعير', NULL),
(86, 'C0000292', 'فريد محمد علي جبارين', 17, NULL, '0569859598', NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'سعير', NULL),
(87, 'C0000502', 'طارق يوسف ربعي', 15, 'المجور', NULL, NULL, 1, 4, 1, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(88, 'C0000068', 'اسماعيل توفيق حسين الشوابكة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(89, 'C0000270', 'علي عمرو (مركز ايلياء الطبي )', 15, 'حنينة', '0567101777', NULL, 1, 4, 1, '2025-12-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(90, 'C0000119', 'جامعة بوليتكنيك فلسطين / دورا', 15, 'دائرة السير - طرامة - فحص البوليتكنيك', '0598611119', NULL, 1, 4, 1, '2025-12-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(91, 'C0000280', 'عوني محمد خليل الرجعي', 15, 'دورا مقابل منتزه الخطيب - صالون النور للسيدات', '0599782334', NULL, 1, 4, 1, '2025-12-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(92, 'C0000495', 'لؤي حمزة علي غانم', 15, 'بلا/كريسه عين فارس', '0594419995', NULL, 1, 4, 1, '2025-12-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(93, 'C0000365', 'محمد يعقوب عيسى دعنا', 5, NULL, '0599250521', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(94, 'C0000009', 'أحمد عليان محمد فخري شاهين', 5, NULL, '0598694202', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(95, 'C0000211', 'سليم هشام الرجبي / مختبر عاشور', 5, NULL, NULL, NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(96, 'C0000383', 'مديرية الاقتصاد الوطني الخليل', 5, NULL, '022226393', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(97, 'C0000025', 'أطباء بلا حدود / فرع أسبانيا', 5, 'الخليل - عين سارة طلعة المونونايت خلف الصليب الأحم', NULL, NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(98, 'C0000493', 'نور مرقة / حارة العجوري', 5, 'بلا/الخليل واد الهرية العجوري', '0972568662269', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(99, 'C0000144', 'حكم محمد عفيف الناظر', 5, 'حرم الرامة - خلف مصنع الحرباوي', '0567666966', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(100, 'C0000326', 'محمد ابو زاكية', 5, 'عين سارة - قبال كازية مارينا - برج خالد الطابق الث', '0594123103', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(101, 'C0000072', 'البيوت السعيدة للثقافة و التنمية', 5, 'عين سارة بجانب فندق الامانة', '0595014941', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(102, 'C0000095', 'بشرى عبد الحميد بشير مرعب', 14, 'حلحول - بجانب معرض محرم للسيارات', '0595295222', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'حلحول', NULL),
(103, 'C0000013', 'أحمد محمد علي السويطي', 15, NULL, '0568190200', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(104, 'C0000494', 'المركز الحديث للعلاج الطبيعي والتاهيل', 9, 'بلا/يطا _ بجانب صيدلية القدس _ مثلث المزرعة', '0595789536', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(105, 'C0000480', 'يزيد محمد الحطاب', 15, 'بلا/حدب الفوار', '0528952002', NULL, 1, 4, 1, '2025-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(106, 'C0000135', 'حازم عبد العزيز حسين الرجوب / والده', 15, 'أبو هلال - شارع المستشفى', '0568999902', NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(107, 'C0000192', 'ريمون حنا عبد الأحد سفر', 12, NULL, '0598464104', NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(108, 'C0000204', 'سامر عمر ابراهيم القربي', 12, NULL, '0522432169', NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(109, 'C0000354', 'محمد فيصل محمد أبو عياش', 12, NULL, NULL, NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(110, 'C0000430', 'نفيرا صلاح عبد الله عفانة', 12, NULL, NULL, NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(111, 'C0000490', 'محمد عريقات', 12, 'بلا/ابو ديس _ عمارة المجد _ بالقرب من صيدلية السنابل', '0597799000', NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(112, 'C0000492', 'ممدوح محمد تيم مزهر', 12, 'بلا/مخيم الدهيشة _ طلعة شركة مراد للسيارات', '0569752033', NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(113, 'C0000112', 'تامر محمد عبد الحروب', 12, NULL, '0569666627', NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(114, 'C0000491', 'مصعب ابراهيم أبو عليا', 12, 'بلا/مخيم الدهيشة / بالقرب من مسجد الشهداء', '0599351641', NULL, 1, 4, 1, '2025-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(115, 'C0000058', 'إيهاب طالب محمد العمايرة', 15, 'دورا - غنيم - عمارة طالب ربعي', '0595271519', NULL, 1, 4, 1, '2025-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(116, 'C0000207', 'سرية يونس عودة الرجوب 1', 15, 'دورا / الكوم / مسجد الكوم الكبير', '0594240490', NULL, 1, 4, 1, '2025-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(117, 'C0000102', 'بلدية بيت عوا', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(118, 'C0000466', 'امين ماجد مسالمة /شركة ابو يامن للابواب الفولاذية', 15, 'بلا/بيت عوا /جبل عمار', '0599308968', NULL, 1, 4, 1, '2025-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(119, 'C0000488', 'رهام بيوتي كلينك / رهام طه', 15, 'بلا/دورا  عمارة الدابوقي الطابق الاول', '0595835740', NULL, 1, 4, 1, '2025-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(120, 'C0000129', 'جواهر عماد محمد الشرحة', 15, 'ديرسامت حارة الشرحة', '0598175676', NULL, 1, 4, 1, '2025-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(121, 'C0000456', 'يوسف عبد القادر مسالمة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(122, 'C0000489', 'بهاء ابو راس / جولدن موبايل', 15, 'بلا/دورا وسط البلد الدخله مقابل شورما بلدنا', '0568888960', NULL, 1, 4, 1, '2025-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(123, 'C0000486', 'محمد نظام فنون / شركة فنون كلاسيك', 5, 'بلا/عند رمزونات الشرعية بالقرب من سفينة الصياد', '0598515091', NULL, 1, 4, 1, '2025-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(124, 'C0000421', 'نبيل اسماعيل حسن التلاحمة /البيت', 15, NULL, '0599886661', NULL, 1, 4, 1, '2025-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(125, 'C0000459', 'عدي ابو هاشم / الملحمة', 15, 'بلا/بجانب الاصيل مول', '0569887995', NULL, 1, 4, 1, '2025-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(126, 'C0000172', 'دار القرأن', 15, 'مسجد ابو جياش', '0599035842', NULL, 1, 4, 1, '2025-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(127, 'C0000487', 'ماهر يوسف سليمان اولاد محمد', 15, 'بلا/الطبقة _ حارة امطير', '0569970123', NULL, 1, 4, 1, '2025-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(128, 'C0000305', 'مؤسسة الأقصى للخدمات الجامعية / رائد اطميزي', 5, 'بلا', NULL, NULL, 1, 4, 1, '2025-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(129, 'C0000317', 'ماهر محمد النمورة', 15, NULL, '0592111447', NULL, 1, 4, 1, '2025-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(130, 'C0000465', 'شركة نصركو للمقاولات / احمد نصر', 15, 'بلا/دورا_ طرامة', '0597442494', NULL, 1, 4, 1, '2025-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(131, 'C0000077', 'الضراغمة مول', 5, NULL, NULL, NULL, 1, 4, 1, '2025-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(132, 'C0000039', 'أنس محمد عوني شاهين', 5, 'الخليل / عين سارة / مقابل ال KFC', '0597449937', NULL, 1, 4, 1, '2025-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(133, 'C0000485', 'محمد خليل دوفش /مستودع النور للادوية', 5, 'بلا/نمرة مقابل البيت البيت العامر', '0598557557', NULL, 1, 4, 1, '2025-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(134, 'C0000016', 'أسامة أبو فردة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(135, 'C0000319', 'عبد الفتاح الدرابيع', 15, NULL, '0593553320', NULL, 1, 4, 1, '2025-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(136, 'C0000484', 'الدكتور علاء محمد التلبيشي /عيادة دورا', 15, 'بلا/دورا وسط البلد', '0592283777', NULL, 1, 4, 1, '2025-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(137, 'C0000224', 'شركة آرام / فخري الشريف', 5, NULL, '0598216444', NULL, 1, 4, 1, '2025-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(138, 'C0000429', 'نعمان أحمد إسماعيل درابيع', 8, 'الظاهرية - مقابل الدفاع المدني / شركة النعمان للدع', '0597224909', NULL, 1, 4, 1, '2025-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(139, 'C0000110', 'تامر سميح سعيد عمرو 1', 15, NULL, '0568852777', NULL, 1, 4, 1, '2025-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(140, 'C0000302', 'لجنة زكاه جنوب الخليل', 15, NULL, '0598874810', NULL, 1, 4, 1, '2025-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(141, 'C0000381', 'مدرسة الخوارزمي', 15, NULL, NULL, NULL, 1, 4, 1, '2025-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(142, 'C0000109', 'تامر سميح سعيد عمرو / المحل دوار التحرير', 15, 'دوار التحرير', NULL, NULL, 1, 4, 1, '2025-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(143, 'C0000482', 'الدكتور عمر ابو هاشم', 8, 'بلا/بجانب سوق الحلال القديم', '0568045205', NULL, 1, 4, 1, '2025-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(144, 'C0000413', 'موسى عمر عمرو (السيخ)', 15, NULL, '0595309958', NULL, 1, 4, 1, '2025-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(145, 'C0000483', 'يزن الحطاب / مسجد شهداء غزة /مشعل الطيطي', 15, 'بلا/حدب الفوار بعد مكتبة القدس طريق على اليسار', '0568798456', NULL, 1, 4, 1, '2025-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(146, 'C0000067', 'اسامة فوزي الحداد / بيت اخوه', 5, NULL, '0569119135', NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(147, 'C0000222', 'شاهر طاهر عابدين', 5, NULL, NULL, NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(148, 'C0000227', 'شركة إيفل للمفروشات', 5, 'الخليل - وادي الهرية مفرق الحرية', '0599200712', NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(149, 'C0000234', 'شركة سما الأهلية للإنشاءات', 5, 'الخليل / وادي التفاح /عمارة الكنز /ط 8', NULL, NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(150, 'C0000481', 'الدكتور علاء محمد التلبيشي /عيادة الخليل', 5, 'بلا/دوار ابن رشد بجانب الغرفة التجارية', '0599318885', NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(151, 'C0000055', 'إكرام ابراهيم محمد مرعب', 5, 'حلحول - النبي يونس مقابل ميني ماركت البربراوي', '0595847658', NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(152, 'C0000343', 'محمد ظاهر عبد الحي الحموري', 5, 'شارع السلام - بالقرب من مفرق الجامعة - الحموري لله', '0569223070', NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(153, 'C0000287', 'فاتن يوسف محمد أبو عصبة', 14, 'حلحول - زبود - بجانب البنك الإسلامي مقابل ديوان ال', '0595203208', NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'حلحول', NULL),
(154, 'C0000169', 'خليل أحمد خليل أبو فردة', 15, 'دورا كنار طريق المقبرة', NULL, NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(155, 'C0000062', 'احسان خليل محمد دوفش', 5, 'الخليل / نمرة / مقابل بيتنا العامر', '0569113000', NULL, 1, 4, 1, '2025-11-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(156, 'C0000471', 'احمد ابو عنزة / الداخل المحتل', 18, 'بلا', NULL, NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بلا', NULL),
(157, 'C0000479', 'محمد السبعاوي', 18, 'بلا', NULL, NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بلا', NULL),
(158, 'C0000277', 'عماد ماجد محمد المسالمة', 15, NULL, '0599558091', NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(159, 'C0000314', 'مالك المشارقة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(160, 'C0000341', 'محمد طالب علي عمرو', 15, NULL, '0599364464', NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(161, 'C0000054', 'إسماعيل عوض صلاح السويطي/ المحل', 15, 'بيت عوا / الخانق/شركة بيركنز بور', '0598485532', NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(162, 'C0000250', 'عبد الرحمن التلبيشي', 15, 'سنجر عمارة المجد ط5', '0599876296', NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(163, 'C0000387', 'مركز الخدمات المساندة', 15, NULL, '0566770260', NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(164, 'C0000355', 'محمد ماجد محمد المسالمة', 15, 'بيت عوا - جبل عمار', '059930229', NULL, 1, 4, 1, '2025-11-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(165, 'C0000420', 'ناصركو للاتصالات', 5, 'الخليل- بجانب دائرة السير - عمارة حريزات', '0599816888', NULL, 1, 4, 1, '2025-11-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(166, 'C0000477', 'مفروشات ازار / فرع المنجرة', 5, 'بلا/واد الهرية _ بالقرب من الحسبة', '0594223224', NULL, 1, 4, 1, '2025-11-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(167, 'C0000478', 'شركة الحرم للصناعة البلاستيكية', 13, 'بلا', NULL, NULL, 1, 4, 1, '2025-11-27', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-22 11:55:18', 'بلا', NULL),
(168, 'C0000432', 'نور التلبيشي', 15, 'دورا سنجر عمالرة المجد الطابق الخامس', NULL, NULL, 1, 4, 1, '2025-11-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(169, 'C0000066', 'ادم يوسف محمد صلاح', 12, NULL, NULL, NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(170, 'C0000382', 'مدرسة بنات بيت لحم الثانويه سعاد', 12, NULL, NULL, NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(171, 'C0000408', 'منال محمود الأعرج', 12, NULL, NULL, NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(172, 'C0000416', 'ميساء ابراهيم عبد العزيز العزة', 12, NULL, '0599937000', NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(173, 'C0000417', 'ميساء محمد عبد الله زهران', 12, NULL, '0569023264', NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(174, 'C0000407', 'منال غازي مرعي عمار', 12, 'الدوحة - شارع المدارس - إسكان الدبابسة', '0599679488', NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(175, 'C0000475', 'سائد زازا', 12, 'بلا/الدوحة _ بالقرب من دار ابو ملش', '0598902052', NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(176, 'C0000394', 'معاذ علي يوسف علي', 12, 'بيت لحم / الخضر / قرب مستشفى اليمامة', '0569613307', NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(177, 'C0000419', 'ناصر محمد عبد الله زهران', 12, 'دهيشة / الحارة السرقية', '0598901593', NULL, 1, 4, 1, '2025-11-26', 35.1889452, 31.6929534, NULL, NULL, NULL, NULL, '2025-12-22 12:09:06', 'بيت لحم', NULL),
(178, 'C0000425', 'نشوان خاطر ابو شاهين', 12, 'منطقة DCO', '0549149177', NULL, 1, 4, 1, '2025-11-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(179, 'C0000041', 'أنور أحمد جبر الرجوب', 15, NULL, '0599328277', NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(180, 'C0000386', 'مركز الأردن للأشعة', 5, NULL, NULL, NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(181, 'C0000078', 'الغرفة التجارية / بهاء أبو سارة', 5, 'الغرفة التجارية بالخليل - شارع خالد بن الوليد', NULL, NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(182, 'C0000472', 'عبد الله عبد الرحيم الجولاني', 5, 'بلا/عقبة تفوح _ بالقرب من قاعات فينيا', '0599033958', NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(183, 'C0000111', 'تامر سميح سعيد عمرو 2', 15, NULL, '0568852777', NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(184, 'C0000391', 'مروان رجوب', 15, NULL, '0599648389', NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(185, 'C0000108', 'تامر سميح سعيد عمرو (نضال )', 15, 'ابو هلال بجانب المخابرات', '0569991881', NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(186, 'C0000474', 'مفروشات ازار', 15, 'بلا/سنجر  _ بالقرب من كراج رامي اليمني', '0594223224', NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(187, 'C0000327', 'محمد اديب الشروانة', 15, 'دورا - غنيم - قرب المحكمة', '0598315008', NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(188, 'C0000473', 'شركة العامر لمواد البناء / عامر ابو منشار', 15, 'بلا/سنجر _ بالقرب من كازية الجنوب', '0566222377', NULL, 1, 4, 1, '2025-11-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(189, 'C0000226', 'شركة إزدهار فلسطين للاستثمار و التنمية', 5, 'الخليل - الحرايق - حديقة الخليل التكنولوجية الطابق', '022233222', NULL, 1, 4, 1, '2025-11-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(190, 'C0000124', 'جمانة الدميري / شركة ميلون بال للسياحة', 5, 'مقابل جامعة الخليل - بجانب بروستيد الجامعة', '0599937602', NULL, 1, 4, 1, '2025-11-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(191, 'C0000082', 'المسافر للتأمين ( ايهاب & عبيدة )', 15, NULL, NULL, NULL, 1, 4, 1, '2025-11-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(192, 'C0000202', 'سامر العواودة', 15, NULL, '0599328494', NULL, 1, 4, 1, '2025-11-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(193, 'C0000318', 'ماهر محمود عبد ربه مقبول', 15, NULL, NULL, NULL, 1, 4, 1, '2025-11-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(194, 'C0000396', 'معتز يوسف يوسف المصري', 15, NULL, '0597800101', NULL, 1, 4, 1, '2025-11-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(195, 'C0000451', 'ياسمين يونس محمد الشراونة', 15, NULL, '0594506208', NULL, 1, 4, 1, '2025-11-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(196, 'C0000088', 'ايهاب عبد الحليم الدراويش / منزل', 15, 'بلا/الشرفة مقابل روضة سنبلة فلسطين', NULL, NULL, 1, 4, 1, '2025-11-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(197, 'C0000125', 'جمعية الإغاثة الطبية الفلسطينية', 3, 'إذنا - طلعة الميدان مقابل ملحمة عبدو', NULL, NULL, 1, 4, 1, '2025-11-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'اذنا', NULL),
(198, 'C0000126', 'جهاد حمدان محمد السويطي', 15, NULL, '0598554285', NULL, 1, 4, 1, '2025-11-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(199, 'C0000289', 'فادي سويطي (ناقة نوح)', 15, NULL, '0599382072', NULL, 1, 4, 1, '2025-11-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(200, 'C0000470', 'مكتب وجاهة لقطع السيارات', 15, 'بلا/دورا_ خرسا - بحانب صالة وجاهة للأفراح', '0593015981', NULL, 1, 4, 1, '2025-11-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(201, 'C0000426', 'نضال تيسير ابو ذريع / جرار', 15, 'دورا - كنار - بجانب فنون', '0599228022', NULL, 1, 4, 1, '2025-11-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(202, 'C0000300', 'لؤي عزمي محمود عمرو', 15, 'واد عبيد', '0599961800', NULL, 1, 4, 1, '2025-11-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(203, 'C0000278', 'عماد ماجد محمد مسالمة / محلات', 15, NULL, NULL, NULL, 1, 4, 1, '2025-11-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(204, 'C0000389', 'مركز شرطة دورا', 15, 'واد ابو القمرة', NULL, NULL, 1, 4, 1, '2025-11-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(205, 'C0000316', 'ماهر خالد محمد اسميرات 2', 9, NULL, '0549342313', NULL, 1, 4, 1, '2025-11-20', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-22 11:50:56', 'السموع', NULL),
(206, 'C0000347', 'محمد عماد حسن ذيابي', 9, NULL, '0598050575', NULL, 1, 4, 1, '2025-11-20', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-22 11:46:43', 'دورا', NULL),
(207, 'C0000442', 'وسام حريبات / مكتبة القدس 2', 9, 'الفوار - حدب الفوار - مكتبة القدس', '0599999664', NULL, 1, 4, 1, '2025-11-20', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-22 11:46:55', 'دورا', NULL),
(208, 'C0000008', 'أحمد سامي أبو حميد', 9, 'مستشفى ابو القاسم / قسم الولادة', '0566880947', NULL, 1, 4, 1, '2025-11-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(209, 'C0000155', 'حناء أحمد حسين الزين / مستشفى أو الحسن قاسم', 9, 'يطا - مستشفى أبو الحسن قاسم', '0569830016', NULL, 1, 4, 1, '2025-11-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(210, 'C0000431', 'نهلة أحمد موسى أبو قبيطة', 9, 'مقابل مدرسة المثنى', '0599984376', NULL, 1, 4, 1, '2025-11-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(211, 'C0000469', 'محمد زياد العواودة / العواودة للاجهزة الكهربائية', 9, 'بلا/رقعة _ بجانب البوليفارد مول _ بالقرب من بنك فلسطين', '0599451693', NULL, 1, 4, 1, '2025-11-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'يطا', NULL),
(212, 'C0000284', 'عيسى رفيفان خليل أبو شرار - كازية أبو شرار', 15, 'دورا - خرسا - كازية أبو شرار', '0569250590', NULL, 1, 4, 1, '2025-11-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(213, 'C0000177', 'راديو صوت الشباب', 8, NULL, NULL, NULL, 1, 4, 1, '2025-11-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(214, 'C0000080', 'المركز الألماني لزراعة الأسنان', 8, 'الظاهرية - المركز الألماني لزراعة الأسنان', '0597593075', NULL, 1, 4, 1, '2025-11-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(215, 'C0000150', 'حمزة حسن سلامة أبو زنيد', 8, 'الظاهرية - مثلث البرج محطة أبو زنيد للزيوت وفلاتر', '0595267822', NULL, 1, 4, 1, '2025-11-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(216, 'C0000059', 'ابو الخير لكهرباء السيارات', 8, NULL, '0592477194', NULL, 1, 4, 1, '2025-11-19', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-22 11:46:23', 'دورا', NULL),
(217, 'C0000453', 'يزن إياد عامر الدرابيع', 15, NULL, '0568400709', NULL, 1, 4, 1, '2025-11-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(218, 'C0000090', 'باسل مثقال عمرو', 15, 'شارع البنوك - عمارة الإسراء - ط2 عيادة الدكتور باس', '0595327500', NULL, 1, 4, 1, '2025-11-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(219, 'C0000079', 'الفلسطينية للدعاية / اشتراك', 5, NULL, NULL, NULL, 1, 4, 1, '2025-11-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(220, 'C0000295', 'قصي فؤاد تيسير الجعبري (مختبر نبض )', 5, 'عمارة جذور ط3', '0598504600', NULL, 1, 4, 1, '2025-11-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(221, 'C0000448', 'وكالة الغوث قسم القروض', 5, 'عين سارة - بجانب مخبز فنون و مطعم الشريف الطابق ال', '0592168262', NULL, 1, 4, 1, '2025-11-18', 35.0978725, 31.5338174, NULL, NULL, NULL, NULL, '2025-12-23 11:07:40', 'الخليل', NULL),
(222, 'C0000161', 'خالد زهير عزات الأشهب', 5, 'وادي الهرية - مقابل صيدلية حجازي الجديدة', '0599660875', NULL, 1, 4, 1, '2025-11-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(223, 'C0000063', 'احسان محمد خليل دوفش / عيادة ترقوميا', 13, NULL, NULL, NULL, 1, 4, 1, '2025-11-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ترقوميا', NULL),
(225, 'C0000049', 'إبراهيم عبد الرحمن صادق النتشة', 5, 'راس الجورة مقابل الزغل', '0569150030', NULL, 1, 4, 1, '2025-11-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(226, 'C0000241', 'شعاع وائل خالد ملش', 12, NULL, '0598949590', NULL, 1, 4, 1, '2025-11-17', 35.1807414, 31.7004114, NULL, NULL, NULL, NULL, '2025-12-22 09:53:48', 'بيت لحم', NULL),
(227, 'C0000189', 'رنين خالد سالم حمدان', 12, NULL, NULL, NULL, 1, 4, 1, '2025-11-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(228, 'C0000186', 'رتيبة عبد الفتاح محمد رمضان', 12, 'الدوحة - بجانب المغربي مول', '0599276611', NULL, 1, 4, 1, '2025-11-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(229, 'C0000001', 'فتحي محمد محمود أبو غنية', 12, 'بيت لحم / شارع الصف - بالقرب من نقابة المهندسين', '0592387631', NULL, 1, 4, 1, '2025-11-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(230, 'C0000435', 'هاني محمود أحمد بشير', 12, 'مخيم الدهيشة - مقابل اسكان الحايك', '0599981055', NULL, 1, 4, 1, '2025-11-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(231, 'C0000184', 'رانية عودة حسين ملش', 12, NULL, '0597136013', NULL, 1, 4, 1, '2025-11-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(232, 'C0000203', 'سامر صلاح الدين أبو سنينة', 5, 'الجلدة - مدرسة الريان', '0569054625', NULL, 1, 4, 1, '2025-11-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(233, 'C0000467', 'المهندس عبد الله الداعور التميمي /مكتب الشروق الهن', 5, 'بلا/الخليل _شارع عين سارة بالقرب من نادي اضواء المدينة', '0599678550', NULL, 1, 4, 1, '2025-11-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(234, 'C0000087', 'ايمن رجوب', 15, NULL, '0599327638', NULL, 1, 4, 1, '2025-11-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(235, 'C0000464', 'شركة بستنجي لمواد البناء /محمد محمود بستنجي', 15, 'بلا/دورا _ مقابل كازية اليمني', '0597399223', NULL, 1, 4, 1, '2025-11-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(236, 'C0000463', 'نور محمد سعيد', 5, 'بلا/الخليل _دوار الجلدة', '0598427888', NULL, 1, 4, 1, '2025-11-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(237, 'C0000171', 'خيري  جودي سلهب للفرش المنزلي', 5, 'مجمع خلف التجاري مقابل التربية و التعليم القديمة', '0597130755', NULL, 1, 4, 1, '2025-11-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(238, 'C0000183', 'رامية محمد محمود المغربي', 12, NULL, '0568244857', NULL, 1, 4, 1, '2025-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(239, 'C0000267', 'علاء حسن يعقوب دعدوع', 12, NULL, '0592330139', NULL, 1, 4, 1, '2025-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(240, 'C0000265', 'عزو ماجد إبراهيم عمايرة', 15, 'اسكان فلسطين / ط4 / غنيم', '0599072096', NULL, 1, 4, 1, '2025-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(241, 'C0000444', 'وسام ربعي (بيت اهلو )', 15, 'حنينة', '0595697364', NULL, 1, 4, 1, '2025-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(242, 'C0000392', 'مريم حماد أبو عطوان', 15, 'دورا / الطبقة / بالقرب من الخزان', '0562000483', NULL, 1, 4, 1, '2025-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(243, 'C0000179', 'رامي عبد المجيد سويطي', 15, 'ناقة نوح', '0562000522', NULL, 1, 4, 1, '2025-11-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(244, 'C0000276', 'علي يوسف محمود علي', 12, 'الخضر / بجانب مستشفى اليمامة', NULL, NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(245, 'C0000130', 'جورج حنانيا', 12, NULL, NULL, NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(246, 'C0000194', 'زكريا فوزي داوود حليسي / 2', 12, 'الدوحة - نزول الحاووز', '0569334410', NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(247, 'C0000427', 'نضال عبد الفتاح محمد اللحام', 12, 'الكركفة عمارة العملة', '0592634748', NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(248, 'C0000193', 'زكريا فوزي داوود حليسي', 12, 'بت لحم - الدوحة - مقابل مخبز الدوحة - محل جوالات ت', '0569334410', NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(249, 'C0000035', 'أمير فاروق الحج محمود', 12, 'بيت جالا - حديقة البط - محل العصافير', '0569922990', NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(250, 'C0000379', 'مختبر ميد لاب الطبي 1', 12, 'بيت لحم عمارة مرة - الطابق الأرضي بجانب معهد جالكس', NULL, NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(251, 'C0000358', 'محمد مصطفى عبد الله عمرو', 12, 'حوسان - الشارع الرئيسي - مفرق نحالين - عيادة الدكت', '0566332302', NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(252, 'C0000195', 'زهانه ثابت أولاد محمد', 15, NULL, '022200515', NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(253, 'C0000133', 'حازم الرجوب', 15, NULL, NULL, NULL, 1, 4, 1, '2025-11-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(254, 'C0000020', 'أسامة فوزي رضوان الحداد', 5, NULL, '0593206086', NULL, 1, 4, 1, '2025-11-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(255, 'C0000157', 'حنين إبراهيم القواسمة', 5, 'الخليل/ واد التفاح / بجانب الخليل مول', '0598644448', NULL, 1, 4, 1, '2025-11-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(256, 'C0000050', 'إسراء علي عمرو / جامعة القدس الخليل', 5, 'جامعة القدس المفتوحة /فرع الخليل', NULL, NULL, 1, 4, 1, '2025-11-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(257, 'C0000122', 'جمال إبراهيم خليل صلاح', 12, NULL, '0598726519', NULL, 1, 4, 1, '2025-11-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(258, 'C0000022', 'أشرف حسن حسين الدرابيع', 15, NULL, '0599116000', NULL, 1, 4, 1, '2025-11-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(259, 'C0000158', 'خالد أحمد عاصي عمرو', 15, NULL, '0599873078', NULL, 1, 4, 1, '2025-11-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(260, 'C0000003', 'آمال محمود إسماعيل أبو عرقوب', 15, NULL, '0592960490', NULL, 1, 4, 1, '2025-11-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(261, 'C0000089', 'باسل ماهر الخطيب ( مطعم برشلونة )', 15, NULL, '0593908946', NULL, 1, 4, 1, '2025-11-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(262, 'C0000271', 'علي محمد علي الرجوب /المرمل', 15, NULL, '0569667788', NULL, 1, 4, 1, '2025-11-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(263, 'C0000032', 'أمجد يوسف محمد شاور 4', 5, NULL, NULL, NULL, 1, 4, 1, '2025-11-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(264, 'C0000424', 'نسيم زين الدين بدر', 5, NULL, '0599373442', NULL, 1, 4, 1, '2025-11-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(265, 'C0000339', 'محمد سميح اسماعيل التلاحمة / عالم السجاد', 5, 'عالم السجاد', NULL, NULL, 1, 4, 1, '2025-11-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(266, 'C0000138', 'حسن أبو سمرة محمد  دعدوع', 12, NULL, NULL, NULL, 1, 4, 1, '2025-11-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(267, 'C0000197', 'زيد زياد خليل عواودة', 15, 'دورا - واد أبو القمرة - ثري زد - بجانب الكراجات', NULL, NULL, 1, 4, 1, '2025-11-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(269, 'C0000153', 'حمزة يوسف محمد الدرابيع / الوطنية للتامين', 15, NULL, '0562000091', NULL, 1, 4, 1, '2025-11-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(270, 'C0000038', 'أنس عماد بدرية', 5, NULL, NULL, NULL, 1, 4, 1, '2025-11-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(271, 'C0000113', 'تامر موسى علي مناصرة', 5, 'الخليل / الحاووز الاول / بجانب مول البايض', '0598214528', NULL, 1, 4, 1, '2025-11-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(272, 'C0000011', 'أحمد محمد عبد الرحمن مسالمة', 15, NULL, '0592818863', NULL, 1, 4, 1, '2025-11-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(273, 'C0000288', 'فادي اسماعيل عبدالقادر اولاد محمد', 15, NULL, '0599433008', NULL, 1, 4, 1, '2025-11-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(274, 'C0000337', 'محمد خالد عودة حداد', 5, NULL, '0599623684', NULL, 1, 4, 1, '2025-11-04', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-22 11:45:54', 'دورا', NULL),
(275, 'C0000366', 'محمد يعقوب عيسى دعنا/المحل', 15, NULL, NULL, NULL, 1, 4, 1, '2025-11-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(276, 'C0000286', 'فؤاد عودة الله الدراويش / المحجر', 15, 'مصنع الشايش', '0599124896', NULL, 1, 4, 1, '2025-11-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(277, 'C0000012', 'أحمد محمد علي الجولاني', 12, NULL, '0595420699', NULL, 1, 4, 1, '2025-11-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(278, 'C0000399', 'معتصم أحمد علي موسى', 12, NULL, NULL, NULL, 1, 4, 1, '2025-11-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(279, 'C0000037', 'أنس أحمد محمود زغارنة', 12, 'بيت لحم / أرطاس مقابل صيدلية أرطاس', '0568766523', NULL, 1, 4, 1, '2025-11-03', 35.1894464, 31.6914338, NULL, NULL, NULL, NULL, '2025-12-22 12:17:37', 'بيت لحم', NULL),
(280, 'C0000328', 'محمد المهدي حسن شوكة', 12, 'مستشفى بيت جالا - قسم الأورام', '0595982761', NULL, 1, 4, 1, '2025-11-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(281, 'C0000393', 'مصنع باطون مسافات معتز ماجد', 8, NULL, '0594899961', NULL, 1, 4, 1, '2025-11-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(282, 'C0000351', 'محمد فايز محمد النمورة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-11-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(283, 'C0000362', 'محمد نبيل شعبان حسونة', 5, 'الخليل /عيصى بالقرب من الشركة المتحدة مقابل مفروشا', '0599222737', NULL, 1, 4, 1, '2025-10-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(284, 'C0000232', 'شركة ايركول', 3, 'مقابل البلدية', '0569003732', NULL, 1, 4, 1, '2025-10-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'اذنا', NULL),
(285, 'C0000105', 'بهاء الهيموني', 5, 'الخليل / طريق بيت كاحل / مقابل بيبسي', NULL, NULL, 1, 4, 1, '2025-10-28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(286, 'C0000219', 'سناء يونس احمد القواسمة', 5, NULL, NULL, NULL, 1, 4, 1, '2025-10-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(287, 'C0000243', 'صالون الزهرة البيضاء', 5, NULL, '0598474444', NULL, 1, 4, 1, '2025-10-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(288, 'C0000299', 'كهرباء الأصدقاء / زبون', 5, NULL, NULL, NULL, 1, 4, 1, '2025-10-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(289, 'C0000242', 'شكري علي شكري اللحام', 12, NULL, NULL, NULL, 1, 4, 1, '2025-10-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(290, 'C0000443', 'وسام حسن محمد عيسى', 12, 'بالقرب من مستشفى اليمامة', '0598629842', NULL, 1, 4, 1, '2025-10-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(291, 'C0000217', 'سمير محمود إسماعيل أبو شرخ (1)', 12, 'بيت جالا بالقرب من ال DCO', '0599818468', NULL, 1, 4, 1, '2025-10-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(292, 'C0000297', 'كرم أبو عليان', 12, 'دهيشة', NULL, NULL, 1, 4, 1, '2025-10-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(293, 'C0000136', 'حازم منذر الجعبري', 5, 'الخليل / نمرة / خلف مسجد نمرة', '0598135814', NULL, 1, 4, 1, '2025-10-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(294, 'C0000208', 'سعاد علي خليل كرجه', 14, 'منشار الحلايقة / العفنة', NULL, NULL, 1, 4, 1, '2025-10-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'حلحول', NULL),
(295, 'C0000160', 'خالد بشير أبو عصبة', 14, NULL, '0597083236', NULL, 1, 4, 1, '2025-10-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'حلحول', NULL),
(296, 'C0000159', 'خالد أحمد محمد نصار', 15, NULL, '0599250942', NULL, 1, 4, 1, '2025-10-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL);
INSERT INTO `clients` (`id`, `contract_no`, `name`, `city_id`, `address`, `phone_one`, `phone_two`, `client_type`, `subscription_type_id`, `subscription_status_id`, `subscription_start_date`, `longitude`, `latitude`, `bottle_balance`, `notes`, `image`, `created_at`, `updated_at`, `city_name`, `distributor_id`) VALUES
(297, 'C0000331', 'محمد جمال حسن السراحنة', 15, NULL, '0595081005', NULL, 1, 4, 1, '2025-10-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(298, 'C0000165', 'خلاف عبد الجبار التلاحمة', 15, 'دورا / مدرسة النجوم', '0598031576', NULL, 1, 4, 1, '2025-10-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(299, 'C0000403', 'معهد جلاكسي للتدريب - فرع الخليل', 5, 'عين سارة - بجانب الخدمات العسكرية الطابق الثاني', '0595860257', NULL, 1, 4, 1, '2025-10-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(300, 'C0000307', 'مؤمن الخطيب / المنزل', 14, 'الخليل -حلحول - بالقرب من مصنع حسونة للكاسات', '0599559727', NULL, 1, 4, 1, '2025-10-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'حلحول', NULL),
(301, 'C0000306', 'مؤمن الخطيب / المحل', 5, 'الخليل - دوار ابن رشد - عمارة خلف الطابق الارضي', '0599559727', NULL, 1, 4, 1, '2025-10-21', NULL, NULL, 0, NULL, NULL, NULL, '2025-12-23 07:06:05', 'دورا', NULL),
(302, 'C0000342', 'محمد ظاهر الحموري 2', 5, NULL, NULL, NULL, 1, 4, 1, '2025-10-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(303, 'C0000060', 'ابو عزمي دودين', 15, 'دورا الهجري', NULL, NULL, 1, 4, 1, '2025-10-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(304, 'C0000117', 'ثائر ربعي / الصحة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-10-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(305, 'C0000006', 'أحمد ابراهيم حسين العمايرة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-10-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(306, 'C0000330', 'محمد بسام يونس المسالمة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-10-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(307, 'C0000281', 'عيادة الطبقة / هاني ابو عطوان', 15, NULL, '0598494658', NULL, 1, 4, 1, '2025-10-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(308, 'C0000229', 'شركة العدنان للتأمين', 15, NULL, NULL, NULL, 1, 4, 1, '2025-10-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(309, 'C0000076', 'الشركة الدولية للكمبيوتر', 5, 'الخليل - دخلة بنك الإسكان', '0599227446', NULL, 1, 4, 1, '2025-10-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(310, 'C0000434', 'هاله محمد جميل القواسمة', 5, 'المستشفى الأهلي / عمارة جوهرة الاهلي الطابق 4', '0568546664', NULL, 1, 4, 1, '2025-10-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(311, 'C0000401', 'معرض يوسف ابو علان', 8, 'بجانب ابو زنيد للزيوت و الفلاتر', '0599678364', NULL, 1, 4, 1, '2025-10-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(312, 'C0000233', 'شركة جفرا للتأمين', 15, NULL, NULL, NULL, 1, 4, 1, '2025-10-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(313, 'C0000405', 'مكتب لمسات الهندسي', 5, NULL, '0599523370', NULL, 1, 4, 1, '2025-10-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(314, 'C0000310', 'مؤيد ربعي /زبون', 15, NULL, NULL, NULL, 1, 4, 1, '2025-10-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(316, 'C0000170', 'خليل محمد ابراهيم الشوامرة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-10-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(317, 'C0000409', 'منذر عودة حسين ملش', 12, NULL, '0599089893', NULL, 1, 4, 1, '2025-10-13', 35.1807532, 31.7004257, NULL, NULL, NULL, NULL, '2025-12-22 09:53:28', 'بيت لحم', NULL),
(318, 'C0000131', 'جورج نمر موسى الصراص', 12, 'بيت جالا - الحارة - القلعة', '0595198940', NULL, 1, 4, 1, '2025-10-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(319, 'C0000114', 'تمام أحمد حسن خلاوي', 12, 'بيت لحم - واد رحال - مسجد الشافعي', '0595054086', NULL, 1, 4, 1, '2025-10-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(320, 'C0000116', 'ثائر ربعي / البيت', 15, NULL, NULL, NULL, 1, 4, 1, '2025-10-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(321, 'C0000402', 'معز الدين عبد الكريم محمد طهبوب', 5, 'الخليل - مفرق الجبان - ديوان المحتسب', '0599666246', NULL, 1, 4, 1, '2025-10-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(322, 'C0000422', 'نبيل اسماعيل حسن التلاحمة /المحلات', 15, NULL, '0599886661', NULL, 1, 4, 1, '2025-10-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(323, 'C0000029', 'أمجد يوسف محمد شاور 1', 5, 'طلعة الهيموني(مقابل الرياض مول)', '0599300009', NULL, 1, 4, 1, '2025-10-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(324, 'C0000018', 'أسامة فوزي الحداد', 5, 'واد الهرية - مقابل مفروشات إيفل', '0569119135', NULL, 1, 4, 1, '2025-10-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(325, 'C0000134', 'حازم عبد الحميد فرج الله', 3, 'إذنا واد الناقية - الدوار محل ألمنيوم حازم عطر', '0599082477', NULL, 1, 4, 1, '2025-10-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'اذنا', NULL),
(326, 'C0000400', 'معتصم جبرائيل داوود', 8, 'الظاهرية بجانب مخرطة سعادة', '0569080452', NULL, 1, 4, 1, '2025-10-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الظاهرية', NULL),
(327, 'C0000099', 'بلال محمود طه دودين', 15, NULL, '0599599778', NULL, 1, 4, 1, '2025-10-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(328, 'C0000151', 'حمزة محمد حسين ابو وردة', 15, 'دورا / مقابل ديوان سويطي / ابو وردة للدهانات', '0568184089', NULL, 1, 4, 1, '2025-10-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(329, 'C0000075', 'الزهرة البيضاء', 5, NULL, NULL, NULL, 1, 4, 1, '2025-10-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(330, 'C0000107', 'بيت السراميك / محسن مسودة', 5, NULL, NULL, NULL, 1, 4, 1, '2025-10-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(331, 'C0000436', 'هبة أحمد خليل النمورة', 15, 'الهجري مكتب التربية و التعليم', '0599664910', NULL, 1, 4, 1, '2025-10-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(332, 'C0000385', 'مرام محمد فخري حرب', 5, 'الخليل /جبل أبو رمان بجانب مدرسة عبدالحي شاهين', '0598035054', NULL, 1, 4, 1, '2025-09-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(333, 'C0000097', 'بلال الشعراوي 2', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(334, 'C0000044', 'أيمن إسحاق خليل صلاح', 12, 'بيت لحم أم ركبة بجانب منزل المشترك كلثوم صلاح', '0587807581', NULL, 1, 4, 1, '2025-09-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(335, 'C0000452', 'ياسين رضوان الحداد', 5, NULL, '0599315556', NULL, 1, 4, 1, '2025-09-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(336, 'C0000311', 'ماجد جبر أحمد الرجوب', 15, NULL, '0568401110', NULL, 1, 4, 1, '2025-09-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(337, 'C0000390', 'مركز فحص السيارات البوليتكنيك', 5, 'عين سارة مقابل مخبز عادل فنون', '022221098', NULL, 1, 4, 1, '2025-09-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الخليل', NULL),
(338, 'C0000033', 'أمل خليل عبد العزيز أبو عرقوب', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(339, 'C0000181', 'رامي كمال محمود النمورة 1', 15, NULL, '0569772400', NULL, 1, 4, 1, '2025-09-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(340, 'C0000264', 'عز عبد ربه حسين ردايدة', 12, NULL, '0594711077', NULL, 1, 4, 1, '2025-09-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(341, 'C0000262', 'عدي نعيم محمد السويطي / دورا - كريسة', 15, NULL, '0569585766', NULL, 1, 4, 1, '2025-09-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(342, 'C0000504', 'احمد علان', 18, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بلا', NULL),
(343, 'C0000324', 'محمد إبراهيم يوسف فرج', 12, NULL, '0595477121', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'test', NULL, NULL, '2025-12-23 15:25:40', 'بيت لحم', NULL),
(344, 'C0000360', 'محمد نادر محمد عطيلة / مؤسسة هزاع', 12, NULL, '0569100190', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(345, 'C0000374', 'محمود طه محمود كنعان (1)', 12, NULL, '0599180940', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(346, 'C0000375', 'محمود طه محمود كنعان (2)', 12, 'محمود طه محمود كنعان (2)', '0599180940', '0599180940', 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'test', NULL, NULL, '2025-12-23 07:39:01', 'بيت لحم', NULL),
(348, 'C0000257', 'عبيدة العسيلي', 12, 'بيت لحم / عمارة القاسم', NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيت لحم', NULL),
(353, 'C0000364', 'محمد هاني جودي سلهب', 5, NULL, '0595355523', NULL, 1, 4, 1, '2025-09-01', 35.1122830, 31.5208246, 0, NULL, NULL, NULL, '2025-12-23 09:29:06', 'دورا', NULL),
(354, 'C0000455', 'يوسف ربعي', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'test', NULL, NULL, '2025-12-23 14:47:24', 'دورا', NULL),
(356, 'C0000115', 'تيسير عبد الجليل الرجعي', 15, 'الطبقة', '0562501446', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'test', NULL, NULL, '2025-12-23 14:50:07', 'دورا', NULL),
(357, 'C0000454', 'يوسف حاتم عبد الفتاح عمرو', 15, 'الماجور / مشغل حلويات', '0595095713', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'ttt', NULL, NULL, '2025-12-23 15:04:43', 'دورا', NULL),
(362, 'C0000201', 'سامر أحمد سلمان مشارقة', 15, 'دورت - أبو العشوش - شركة السامر لقطع السيارات', '0599446881', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(363, 'C0000191', 'رولا يونس محمد المشارقة', 15, NULL, '0599446881', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'ttt', NULL, NULL, '2025-12-23 15:06:33', 'دورا', NULL),
(364, 'C0000249', 'عبد الحميد محمد عبد الحميد أبو شيخة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(365, 'C0000261', 'عدي سالم اسماعيل السويطي', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(366, 'C0000346', 'محمد عبد ربه ربعي', 15, 'د', NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-22 21:30:00', 'دورا', NULL),
(368, 'C0000376', 'محمود عبد العزيز محمد السويطي', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'test', NULL, NULL, '2025-12-23 07:44:57', 'دورا', NULL),
(369, 'C0000398', 'معتز يونس عبد الله أبو هليل 2', 15, NULL, '0599746547', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(370, 'C0000457', 'يونس محمد يوسف الشراونة', 15, NULL, '0599897730', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(371, 'C0000254', 'عبد الله ياسر عبد الله السويطي Kids Club', 15, 'Kids Club بيت عوا', NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(372, 'C0000323', 'محمد إبراهيم سليمان مسالمة', 15, 'بيت عوا - واد السيميا - بالقرب من المراد مول', '0561288755', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(373, 'C0000335', 'محمد حسين حسن مسالمة', 15, 'بيت عوا بجانب شركة بريستيج', '0598211648', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'test', NULL, NULL, '2025-12-23 14:38:14', 'دورا', NULL),
(375, 'C0000017', 'أسامة أحمد عبد الرزاق التلاحمة', 15, 'دورا - أبو العشوش - بجانب مسجد أبو العشوش', '0569171656', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, 'test', NULL, NULL, '2025-12-23 07:39:21', 'دورا', NULL),
(376, 'C0000322', 'محمد أحمد حسين دراويش', 15, 'دورا - خلف مصنع عيسى لولي', '0569964255', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(378, 'C0000332', 'محمد جهاد أحمد كتلو', 15, 'دورا - غنيم بالقرب من محلات ألو الراغب', '0592696950', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(379, 'C0000175', 'رائد محمد حسين دراويش', 15, 'دورا ابو هلال', '0599897775', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(380, 'C0000268', 'علاء حسين محمود الدراويش', 15, 'دورا بجانب مركز الشرطة', '0568858616', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(381, 'C0000439', 'هيثم عز الدين محمود عمرو', 15, 'ناقة نوح', '0595536270', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(382, 'C0000418', 'نادر محمود مقبول', 15, 'واد ابو القمرة /فوق عز الحروب', '0562000494', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(383, 'C0000052', 'إسماعيل عبد الله محمد السويطي', 15, 'بيت عوا - حارة داهود بالقرب من صالة ساندرا', '0597425821', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(384, 'C0000446', 'وسيم محمود ابراهيم المسالمة', 15, NULL, '0598584882', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(385, 'C0000152', 'حمزة ياسر عبد الله السويطي', 15, 'بيت عوا وسط البلد صالة ساندرا', '0598521253', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(386, 'C0000100', 'بلال مصباح حسين أبو ذريع', 15, 'بيت عوا - الحارة التحتا - المنجرة', '0595354474', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(387, 'C0000372', 'محمود سليم النمورة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(388, 'C0000040', 'أنور أبو هاشم', 15, NULL, '0599424427', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(389, 'C0000069', 'اشرف فوزي عبد القادر أبو اهليل', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(390, 'C0000123', 'جمال عبد الناصر دودين', 15, NULL, '0598912255', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(391, 'C0000141', 'حسين جبارة  الفقيه', 15, NULL, '0568503004', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(392, 'C0000294', 'فوزي فواز الرجوب', 15, NULL, '0599328493', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(393, 'C0000395', 'معتز محمد سليمان السويطي', 15, NULL, '0592686806', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(394, 'C0000253', 'عبد الله ياسر عبد الله السويطي', 15, 'بيت عوا وسط البلد قاعة ساندرا', '0595574155', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(395, 'C0000098', 'بلال عودة موسى أولاد محمد', 15, 'خربة سلامة', '0597638024', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(396, 'C0000023', 'أشرف فوزي عبد القادر أبو هليل 2', 15, 'دورا - الناموس', '0562887004', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(397, 'C0000180', 'رامي فوزي عبد اللطيف أبو دوش', 15, 'دورا - غنيم عمارة أبو طارق العمايرة', '0569496151', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(398, 'C0000359', 'محمد موسى حسين درابيع', 15, 'واد أبو القمرة - عمارة البنك الإسلامي', NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(399, 'C0000412', 'مهند موسى سويطي', 15, 'نقة نوح بالقرب من شركة الكهرباء', '0595800526', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(400, 'C0000024', 'أشرف محمد خليل عمرو', 15, NULL, '0599707732', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(401, 'C0000245', 'صفوت عبد اللطيف محمد الشراونة', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(402, 'C0000121', 'جعفر عبد العزيز محمد السويطي', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(403, 'C0000118', 'ثائر محمد سليمان السويطي /البيت', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(404, 'C0000216', 'سليمان حسن سليمان السويطي', 15, NULL, NULL, NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(405, 'C0000363', 'محمد نبيل عيسى المسالمة', 15, 'بيت عوا - السيميا - معرض الشروات', '0599152200', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(406, 'C0000005', 'أحمد إسماعيل عبد الله السويطي', 15, 'بيت عوا - وسط البلد - قاعة ساندرا', '0562887032', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(407, 'C0000411', 'مهنا محمد يوسف الشراونة', 15, 'دورا / دير سامت بجانب مسجد شرحبيل بن حسنة', '0599049416', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(408, 'C0000206', 'سامي طالب عمرو', 15, 'دورا عمارة الدردون بجانب صالة بريستيج', '0595116051', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(409, 'C0000441', 'وئام غالب حسن أبو عرقوب', 15, 'واد الشاجنة - حارة أبو عرقوب', '0599431751', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(410, 'C0000325', 'محمد إسماعيل عبد الله السويطي', 15, 'بيت عوا - خلة داهود', '0595959912', NULL, 1, 4, 1, '2025-09-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'دورا', NULL),
(411, NULL, 'المجاميع', NULL, NULL, NULL, NULL, 1, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_statuses`
--

CREATE TABLE `client_statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL,
  `min_percentage` decimal(5,2) NOT NULL,
  `max_percentage` decimal(5,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_statuses`
--

INSERT INTO `client_statuses` (`id`, `status_name`, `min_percentage`, `max_percentage`, `created_at`, `updated_at`) VALUES
(1, 'غير ملتزم', 0.00, 49.00, '2025-11-11 12:07:38', '2025-11-11 12:07:38'),
(2, 'ملتزم إلى حد ما', 50.00, 74.00, '2025-11-11 12:07:38', '2025-11-11 12:07:38'),
(3, 'جيد جدًا', 75.00, 89.00, '2025-11-11 12:07:38', '2025-11-11 12:07:38'),
(4, 'مميز', 90.00, 100.00, '2025-11-11 12:07:38', '2025-11-11 12:07:38');

-- --------------------------------------------------------

--
-- Table structure for table `client_types`
--

CREATE TABLE `client_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_types`
--

INSERT INTO `client_types` (`id`, `type_name`, `created_at`, `updated_at`) VALUES
(1, 'فردي', '2025-11-11 12:09:03', '2025-11-11 12:09:03'),
(2, 'مؤسسة', '2025-11-11 12:09:03', '2025-11-11 12:09:03'),
(3, 'تجاري', '2025-11-11 12:09:03', '2025-11-11 12:09:03'),
(5, 'قطاعي', '2025-12-09 09:13:17', '2025-12-09 09:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `bottle_received` int(11) NOT NULL DEFAULT 0,
  `bottle_empty` int(11) NOT NULL DEFAULT 0,
  `distributor_id` int(11) DEFAULT NULL,
  `paymant` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `client_id`, `delivery_date`, `bottle_received`, `bottle_empty`, `distributor_id`, `paymant`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-12-21', 0, 0, 0, 0, NULL, NULL),
(2, 2, '2025-12-21', 1, 1, 0, 0, NULL, '2025-12-23 00:33:19'),
(3, 3, '2025-12-21', 0, 0, 0, 0, NULL, NULL),
(4, 4, '2025-12-21', 0, 0, 0, 0, NULL, NULL),
(5, 5, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(6, 6, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(7, 7, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(8, 8, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(9, 9, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(10, 10, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(11, 11, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(12, 12, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(13, 13, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(14, 14, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(15, 15, '2025-12-20', 0, 0, 0, 0, NULL, NULL),
(16, 16, '2025-12-19', 0, 0, 0, 0, NULL, NULL),
(17, 17, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(18, 18, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(19, 19, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(20, 20, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(21, 21, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(22, 22, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(23, 23, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(24, 24, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(25, 25, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(26, 26, '2025-12-18', 0, 0, 0, 0, NULL, NULL),
(27, 27, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(28, 28, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(29, 29, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(30, 30, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(31, 31, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(32, 32, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(33, 33, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(34, 34, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(35, 35, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(36, 36, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(37, 37, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(38, 38, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(39, 39, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(40, 40, '2025-12-17', 0, 0, 0, 0, NULL, NULL),
(41, 41, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(42, 42, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(43, 43, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(44, 44, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(45, 45, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(46, 46, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(47, 47, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(48, 48, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(49, 49, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(50, 50, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(51, 51, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(52, 52, '2025-12-16', 0, 0, 0, 0, NULL, NULL),
(53, 53, '2025-12-15', 0, 0, 0, 0, NULL, NULL),
(54, 54, '2025-12-15', 0, 0, 0, 0, NULL, NULL),
(55, 55, '2025-12-15', 0, 0, 0, 0, NULL, NULL),
(56, 56, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(57, 57, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(58, 58, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(59, 59, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(60, 60, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(61, 61, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(62, 62, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(63, 63, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(64, 64, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(65, 65, '2025-12-14', 0, 0, 0, 0, NULL, NULL),
(66, 66, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(67, 67, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(68, 68, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(69, 69, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(70, 70, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(71, 71, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(72, 72, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(73, 73, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(74, 74, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(75, 75, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(76, 76, '2025-12-13', 0, 0, 0, 0, NULL, NULL),
(77, 77, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(78, 78, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(79, 79, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(80, 80, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(81, 81, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(82, 82, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(83, 83, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(84, 84, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(85, 85, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(86, 86, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(87, 87, '2025-12-11', 0, 0, 0, 0, NULL, NULL),
(88, 88, '2025-12-10', 0, 0, 0, 0, NULL, NULL),
(89, 89, '2025-12-10', 0, 0, 0, 0, NULL, NULL),
(90, 90, '2025-12-10', 0, 0, 0, 0, NULL, NULL),
(91, 91, '2025-12-10', 0, 0, 0, 0, NULL, NULL),
(92, 92, '2025-12-10', 0, 0, 0, 0, NULL, NULL),
(93, 93, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(94, 94, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(95, 95, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(96, 96, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(97, 97, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(98, 98, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(99, 99, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(100, 100, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(101, 101, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(102, 102, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(103, 103, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(104, 104, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(105, 105, '2025-12-09', 0, 0, 0, 0, NULL, NULL),
(106, 106, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(107, 107, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(108, 108, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(109, 109, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(110, 110, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(111, 111, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(112, 112, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(113, 113, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(114, 114, '2025-12-08', 0, 0, 0, 0, NULL, NULL),
(115, 115, '2025-12-07', 0, 0, 0, 0, NULL, NULL),
(116, 116, '2025-12-06', 0, 0, 0, 0, NULL, NULL),
(117, 117, '2025-12-06', 0, 0, 0, 0, NULL, NULL),
(118, 118, '2025-12-06', 0, 0, 0, 0, NULL, NULL),
(119, 119, '2025-12-06', 0, 0, 0, 0, NULL, NULL),
(120, 120, '2025-12-06', 0, 0, 0, 0, NULL, NULL),
(121, 121, '2025-12-06', 0, 0, 0, 0, NULL, NULL),
(122, 122, '2025-12-06', 0, 0, 0, 0, NULL, NULL),
(123, 123, '2025-12-04', 0, 0, 0, 0, NULL, NULL),
(124, 124, '2025-12-04', 0, 0, 0, 0, NULL, NULL),
(125, 125, '2025-12-04', 0, 0, 0, 0, NULL, NULL),
(126, 126, '2025-12-04', 0, 0, 0, 0, NULL, NULL),
(127, 127, '2025-12-04', 0, 0, 0, 0, NULL, NULL),
(128, 128, '2025-12-03', 0, 0, 0, 0, NULL, NULL),
(129, 129, '2025-12-03', 0, 0, 0, 0, NULL, NULL),
(130, 130, '2025-12-03', 0, 0, 0, 0, NULL, NULL),
(131, 131, '2025-12-02', 0, 0, 0, 0, NULL, NULL),
(132, 132, '2025-12-02', 0, 0, 0, 0, NULL, NULL),
(133, 133, '2025-12-02', 0, 0, 0, 0, NULL, NULL),
(134, 134, '2025-12-02', 0, 0, 0, 0, NULL, NULL),
(135, 135, '2025-12-02', 0, 0, 0, 0, NULL, NULL),
(136, 136, '2025-12-02', 0, 0, 0, 0, NULL, NULL),
(137, 137, '2025-12-02', 0, 0, 0, 0, NULL, NULL),
(138, 138, '2025-12-01', 0, 0, 0, 0, NULL, NULL),
(139, 139, '2025-12-01', 0, 0, 0, 0, NULL, NULL),
(140, 140, '2025-12-01', 0, 0, 0, 0, NULL, NULL),
(141, 141, '2025-12-01', 0, 0, 0, 0, NULL, NULL),
(142, 142, '2025-12-01', 0, 0, 0, 0, NULL, NULL),
(143, 143, '2025-12-01', 0, 0, 0, 0, NULL, NULL),
(144, 144, '2025-12-01', 0, 0, 0, 0, NULL, NULL),
(145, 145, '2025-12-01', 0, 0, 0, 0, NULL, NULL),
(146, 146, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(147, 147, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(148, 148, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(149, 149, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(150, 150, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(151, 151, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(152, 152, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(153, 153, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(154, 154, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(155, 155, '2025-11-30', 0, 0, 0, 0, NULL, NULL),
(156, 156, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(157, 157, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(158, 158, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(159, 159, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(160, 160, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(161, 161, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(162, 162, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(163, 163, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(164, 164, '2025-11-29', 0, 0, 0, 0, NULL, NULL),
(165, 165, '2025-11-27', 0, 0, 0, 0, NULL, NULL),
(166, 166, '2025-11-27', 0, 0, 0, 0, NULL, NULL),
(167, 167, '2025-11-27', 0, 0, 0, 0, NULL, NULL),
(168, 168, '2025-11-27', 0, 0, 0, 0, NULL, NULL),
(169, 169, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(170, 170, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(171, 171, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(172, 172, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(173, 173, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(174, 174, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(175, 175, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(176, 176, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(177, 177, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(178, 178, '2025-11-26', 0, 0, 0, 0, NULL, NULL),
(179, 179, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(180, 180, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(181, 181, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(182, 182, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(183, 183, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(184, 184, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(185, 185, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(186, 186, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(187, 187, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(188, 188, '2025-11-25', 0, 0, 0, 0, NULL, NULL),
(189, 189, '2025-11-23', 0, 0, 0, 0, NULL, NULL),
(190, 190, '2025-11-23', 0, 0, 0, 0, NULL, NULL),
(191, 191, '2025-11-23', 0, 0, 0, 0, NULL, NULL),
(192, 192, '2025-11-23', 0, 0, 0, 0, NULL, NULL),
(193, 193, '2025-11-23', 0, 0, 0, 0, NULL, NULL),
(194, 194, '2025-11-23', 0, 0, 0, 0, NULL, NULL),
(195, 195, '2025-11-23', 0, 0, 0, 0, NULL, NULL),
(196, 196, '2025-11-23', 0, 0, 0, 0, NULL, NULL),
(197, 197, '2025-11-22', 0, 0, 0, 0, NULL, NULL),
(198, 198, '2025-11-22', 0, 0, 0, 0, NULL, NULL),
(199, 199, '2025-11-22', 0, 0, 0, 0, NULL, NULL),
(200, 200, '2025-11-22', 0, 0, 0, 0, NULL, NULL),
(201, 201, '2025-11-22', 0, 0, 0, 0, NULL, NULL),
(202, 202, '2025-11-22', 0, 0, 0, 0, NULL, NULL),
(203, 203, '2025-11-22', 0, 0, 0, 0, NULL, NULL),
(204, 204, '2025-11-22', 0, 0, 0, 0, NULL, NULL),
(205, 205, '2025-11-20', 0, 0, 0, 0, NULL, NULL),
(206, 206, '2025-11-20', 0, 0, 0, 0, NULL, NULL),
(207, 207, '2025-11-20', 0, 0, 0, 0, NULL, NULL),
(208, 208, '2025-11-20', 0, 0, 0, 0, NULL, NULL),
(209, 209, '2025-11-20', 0, 0, 0, 0, NULL, NULL),
(210, 210, '2025-11-20', 0, 0, 0, 0, NULL, NULL),
(211, 211, '2025-11-20', 0, 0, 0, 0, NULL, NULL),
(212, 212, '2025-11-19', 0, 0, 0, 0, NULL, NULL),
(213, 213, '2025-11-19', 0, 0, 0, 0, NULL, NULL),
(214, 214, '2025-11-19', 0, 0, 0, 0, NULL, NULL),
(215, 215, '2025-11-19', 0, 0, 0, 0, NULL, NULL),
(216, 216, '2025-11-19', 0, 0, 0, 0, NULL, NULL),
(217, 217, '2025-11-19', 0, 0, 0, 0, NULL, NULL),
(218, 218, '2025-11-19', 0, 0, 0, 0, NULL, NULL),
(219, 219, '2025-11-18', 0, 0, 0, 0, NULL, NULL),
(220, 220, '2025-11-18', 0, 0, 0, 0, NULL, NULL),
(221, 221, '2025-11-18', 0, 0, 0, 0, NULL, NULL),
(222, 222, '2025-11-18', 0, 0, 0, 0, NULL, NULL),
(223, 223, '2025-11-18', 0, 0, 0, 0, NULL, NULL),
(224, 224, '2025-11-18', 0, 0, 0, 0, NULL, NULL),
(225, 225, '2025-11-18', 0, 0, 0, 0, NULL, NULL),
(226, 226, '2025-11-17', 0, 0, 0, 0, NULL, NULL),
(227, 227, '2025-11-17', 0, 0, 0, 0, NULL, NULL),
(228, 228, '2025-11-17', 0, 0, 0, 0, NULL, NULL),
(229, 229, '2025-11-17', 0, 0, 0, 0, NULL, NULL),
(230, 230, '2025-11-17', 0, 0, 0, 0, NULL, NULL),
(231, 231, '2025-11-17', 0, 0, 0, 0, NULL, NULL),
(232, 232, '2025-11-16', 0, 0, 0, 0, NULL, NULL),
(233, 233, '2025-11-16', 0, 0, 0, 0, NULL, NULL),
(234, 234, '2025-11-15', 0, 0, 0, 0, NULL, NULL),
(235, 235, '2025-11-13', 0, 0, 0, 0, NULL, NULL),
(236, 236, '2025-11-13', 0, 0, 0, 0, NULL, NULL),
(237, 237, '2025-11-13', 0, 0, 0, 0, NULL, NULL),
(238, 238, '2025-11-12', 0, 0, 0, 0, NULL, NULL),
(239, 239, '2025-11-12', 0, 0, 0, 0, NULL, NULL),
(240, 240, '2025-11-12', 0, 0, 0, 0, NULL, NULL),
(241, 241, '2025-11-12', 0, 0, 0, 0, NULL, NULL),
(242, 242, '2025-11-12', 0, 0, 0, 0, NULL, NULL),
(243, 243, '2025-11-11', 0, 0, 0, 0, NULL, NULL),
(244, 244, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(245, 245, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(246, 246, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(247, 247, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(248, 248, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(249, 249, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(250, 250, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(251, 251, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(252, 252, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(253, 253, '2025-11-10', 0, 0, 0, 0, NULL, NULL),
(254, 254, '2025-11-09', 0, 0, 0, 0, NULL, NULL),
(255, 255, '2025-11-09', 0, 0, 0, 0, NULL, NULL),
(256, 256, '2025-11-09', 0, 0, 0, 0, NULL, NULL),
(257, 257, '2025-11-09', 0, 0, 0, 0, NULL, NULL),
(258, 258, '2025-11-09', 0, 0, 0, 0, NULL, NULL),
(259, 259, '2025-11-09', 0, 0, 0, 0, NULL, NULL),
(260, 260, '2025-11-08', 0, 0, 0, 0, NULL, NULL),
(261, 261, '2025-11-08', 0, 0, 0, 0, NULL, NULL),
(262, 262, '2025-11-08', 0, 0, 0, 0, NULL, NULL),
(263, 263, '2025-11-06', 0, 0, 0, 0, NULL, NULL),
(264, 264, '2025-11-06', 0, 0, 0, 0, NULL, NULL),
(265, 265, '2025-11-06', 0, 0, 0, 0, NULL, NULL),
(266, 266, '2025-11-06', 0, 0, 0, 0, NULL, NULL),
(267, 267, '2025-11-06', 0, 0, 0, 0, NULL, NULL),
(268, 268, '2025-11-06', 0, 0, 0, 0, NULL, NULL),
(269, 269, '2025-11-05', 0, 0, 0, 0, NULL, NULL),
(270, 270, '2025-11-04', 0, 0, 0, 0, NULL, NULL),
(271, 271, '2025-11-04', 0, 0, 0, 0, NULL, NULL),
(272, 272, '2025-11-04', 0, 0, 0, 0, NULL, NULL),
(273, 273, '2025-11-04', 0, 0, 0, 0, NULL, NULL),
(274, 274, '2025-11-04', 0, 0, 0, 0, NULL, NULL),
(275, 275, '2025-11-04', 0, 0, 0, 0, NULL, NULL),
(276, 276, '2025-11-04', 0, 0, 0, 0, NULL, NULL),
(277, 277, '2025-11-03', 0, 0, 0, 0, NULL, NULL),
(278, 278, '2025-11-03', 0, 0, 0, 0, NULL, NULL),
(279, 279, '2025-11-03', 0, 0, 0, 0, NULL, NULL),
(280, 280, '2025-11-03', 0, 0, 0, 0, NULL, NULL),
(281, 281, '2025-11-01', 0, 0, 0, 0, NULL, NULL),
(282, 282, '2025-11-01', 0, 0, 0, 0, NULL, NULL),
(283, 283, '2025-10-30', 0, 0, 0, 0, NULL, NULL),
(284, 284, '2025-10-29', 0, 0, 0, 0, NULL, NULL),
(285, 285, '2025-10-28', 0, 0, 0, 0, NULL, NULL),
(286, 286, '2025-10-27', 0, 0, 0, 0, NULL, NULL),
(287, 287, '2025-10-27', 0, 0, 0, 0, NULL, NULL),
(288, 288, '2025-10-27', 0, 0, 0, 0, NULL, NULL),
(289, 289, '2025-10-27', 0, 0, 0, 0, NULL, NULL),
(290, 290, '2025-10-27', 0, 0, 0, 0, NULL, NULL),
(291, 291, '2025-10-27', 0, 0, 0, 0, NULL, NULL),
(292, 292, '2025-10-27', 0, 0, 0, 0, NULL, NULL),
(293, 293, '2025-10-26', 0, 0, 0, 0, NULL, NULL),
(294, 294, '2025-10-26', 0, 0, 0, 0, NULL, NULL),
(295, 295, '2025-10-23', 0, 0, 0, 0, NULL, NULL),
(296, 296, '2025-10-23', 0, 0, 0, 0, NULL, NULL),
(297, 297, '2025-10-22', 0, 0, 0, 0, NULL, NULL),
(298, 298, '2025-10-22', 0, 0, 0, 0, NULL, NULL),
(299, 299, '2025-10-21', 0, 0, 0, 0, NULL, NULL),
(300, 300, '2025-10-21', 0, 0, 0, 0, NULL, NULL),
(301, 301, '2025-10-21', 0, 0, 0, 0, NULL, NULL),
(302, 302, '2025-10-19', 0, 0, 0, 0, NULL, NULL),
(303, 303, '2025-10-19', 0, 0, 0, 0, NULL, NULL),
(304, 304, '2025-10-19', 0, 0, 0, 0, NULL, NULL),
(305, 305, '2025-10-18', 0, 0, 0, 0, NULL, NULL),
(306, 306, '2025-10-18', 0, 0, 0, 0, NULL, NULL),
(307, 307, '2025-10-18', 0, 0, 0, 0, NULL, NULL),
(308, 308, '2025-10-16', 0, 0, 0, 0, NULL, NULL),
(309, 309, '2025-10-15', 0, 0, 0, 0, NULL, NULL),
(310, 310, '2025-10-15', 0, 0, 0, 0, NULL, NULL),
(311, 311, '2025-10-15', 0, 0, 0, 0, NULL, NULL),
(312, 312, '2025-10-15', 0, 0, 0, 0, NULL, NULL),
(313, 313, '2025-10-14', 0, 0, 0, 0, NULL, NULL),
(314, 314, '2025-10-14', 0, 0, 0, 0, NULL, NULL),
(315, 315, '2025-10-14', 0, 0, 0, 0, NULL, NULL),
(316, 316, '2025-10-14', 0, 0, 0, 0, NULL, NULL),
(317, 317, '2025-10-13', 0, 0, 0, 0, NULL, NULL),
(318, 318, '2025-10-13', 0, 0, 0, 0, NULL, NULL),
(319, 319, '2025-10-13', 0, 0, 0, 0, NULL, NULL),
(320, 320, '2025-10-13', 0, 0, 0, 0, NULL, NULL),
(321, 321, '2025-10-12', 0, 0, 0, 0, NULL, NULL),
(322, 322, '2025-10-11', 0, 0, 0, 0, NULL, NULL),
(323, 323, '2025-10-08', 0, 0, 0, 0, NULL, NULL),
(324, 324, '2025-10-07', 0, 0, 0, 0, NULL, NULL),
(325, 325, '2025-10-06', 0, 0, 0, 0, NULL, NULL),
(326, 326, '2025-10-06', 0, 0, 0, 0, NULL, NULL),
(327, 327, '2025-10-04', 0, 0, 0, 0, NULL, NULL),
(328, 328, '2025-10-04', 0, 0, 0, 0, NULL, NULL),
(329, 329, '2025-10-02', 0, 0, 0, 0, NULL, NULL),
(330, 330, '2025-10-02', 0, 0, 0, 0, NULL, NULL),
(331, 331, '2025-10-02', 0, 0, 0, 0, NULL, NULL),
(332, 332, '2025-09-30', 0, 0, 0, 0, NULL, NULL),
(333, 333, '2025-09-30', 0, 0, 0, 0, NULL, NULL),
(334, 334, '2025-09-29', 0, 0, 0, 0, NULL, NULL),
(335, 335, '2025-09-23', 0, 0, 0, 0, NULL, NULL),
(336, 336, '2025-09-21', 0, 0, 0, 0, NULL, NULL),
(337, 337, '2025-09-18', 0, 0, 0, 0, NULL, NULL),
(338, 338, '2025-09-11', 0, 0, 0, 0, NULL, NULL),
(339, 339, '2025-09-07', 0, 0, 0, 0, NULL, NULL),
(340, 340, '2025-09-04', 0, 0, 0, 0, NULL, NULL),
(341, 341, '2025-09-04', 0, 0, 0, 0, NULL, NULL),
(342, 342, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(343, 343, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(344, 344, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(345, 345, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(346, 346, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(347, 347, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(348, 348, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(349, 349, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(350, 350, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(351, 351, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(352, 352, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(353, 353, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(354, 354, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(355, 355, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(356, 356, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(357, 357, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(358, 358, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(359, 359, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(360, 360, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(361, 361, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(362, 362, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(363, 363, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(364, 364, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(365, 365, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(366, 366, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(367, 367, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(368, 368, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(369, 369, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(370, 370, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(371, 371, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(372, 372, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(373, 373, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(374, 374, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(375, 375, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(376, 376, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(377, 377, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(378, 378, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(379, 379, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(380, 380, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(381, 381, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(382, 382, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(383, 383, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(384, 384, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(385, 385, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(386, 386, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(387, 387, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(388, 388, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(389, 389, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(390, 390, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(391, 391, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(392, 392, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(393, 393, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(394, 394, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(395, 395, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(396, 396, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(397, 397, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(398, 398, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(399, 399, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(400, 400, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(401, 401, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(402, 402, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(403, 403, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(404, 404, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(405, 405, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(406, 406, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(407, 407, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(408, 408, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(409, 409, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(410, 410, '2025-09-01', 0, 0, 0, 0, NULL, '2025-12-22 08:52:22'),
(411, 279, '2025-12-22', 5, 6, 13, 100, '2025-12-22 12:23:14', '2025-12-22 12:23:14'),
(412, 244, '2025-12-22', 7, 5, 13, 125, '2025-12-22 12:24:41', '2025-12-23 16:43:51'),
(413, 230, '2025-12-22', 5, 5, 13, 100, '2025-12-22 12:25:00', '2025-12-22 12:25:00'),
(414, 230, '2025-12-22', 5, 5, 13, 100, '2025-12-22 12:25:00', '2025-12-22 12:25:00'),
(415, 317, '2025-12-22', 6, 5, 13, 100, '2025-12-22 12:25:37', '2025-12-22 12:25:37');

-- --------------------------------------------------------

--
-- Table structure for table `distributors`
--

CREATE TABLE `distributors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributors`
--

INSERT INTO `distributors` (`id`, `name`, `phone`, `username`, `password_hash`, `status`, `notes`, `created_at`, `updated_at`, `latitude`, `longitude`, `last_update`) VALUES
(13, 'بكر عمرو', '0562884482', 'baker', '$2y$12$09ihjZy0CAgFBWfRbYjQKenhQLC2G2KDmv4/k/ULKeXl8cn/g8Q2.', '1', NULL, '2025-12-21 18:42:23', '2025-12-23 17:12:12', '31.4671873', '35.0300111', '2025-12-23 17:12:12'),
(14, 'Test', '0569102721', 'Test', '$2y$12$rdAv1h/7VXKnJHh3FLbZeu058HGJ96Qbvy1BkNkuf.lLV2rfLhag.', '1', NULL, '2025-12-23 07:42:22', '2025-12-23 15:19:42', '31.4749108', '35.0115042', '2025-12-23 15:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"0d69a62f-ebec-4af9-8d22-e3076800cfbe\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763889803, 1763889803),
(2, 'default', '{\"uuid\":\"8ef6e505-5d2d-4c62-a93a-16941410bab5\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763891693, 1763891693),
(3, 'default', '{\"uuid\":\"5780c417-3b19-4445-b37e-8f982f3f32d4\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763891991, 1763891991),
(4, 'default', '{\"uuid\":\"28b4c385-4404-4ad9-addd-d06fab2d5366\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763892122, 1763892122),
(5, 'default', '{\"uuid\":\"cb7a0da3-64d7-4f70-a1be-18d45538f318\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763892405, 1763892405),
(6, 'default', '{\"uuid\":\"63520337-9e8d-4e17-a41b-09482d920e36\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763892658, 1763892658),
(7, 'default', '{\"uuid\":\"f91d6375-1f10-4360-bc28-dd885f8cf760\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893571, 1763893571),
(8, 'default', '{\"uuid\":\"7a03714c-da57-41a3-86e7-457a019f9603\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893578, 1763893578),
(9, 'default', '{\"uuid\":\"e2d33745-ce83-47e6-9c62-18d6861cc58e\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893583, 1763893583),
(10, 'default', '{\"uuid\":\"28abf679-6cf3-48f4-a121-c9785eaf7f2c\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893587, 1763893587),
(11, 'default', '{\"uuid\":\"7e5c883a-ceea-4db4-82d7-4d5f274a3479\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893591, 1763893591),
(12, 'default', '{\"uuid\":\"82610df0-07e3-4ea3-822c-a247880da771\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893591, 1763893591),
(13, 'default', '{\"uuid\":\"e620fe74-0882-44d5-83c3-95963d9395dd\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893613, 1763893613),
(14, 'default', '{\"uuid\":\"aaa2c364-3d27-441d-91df-aac92da9dbdf\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893613, 1763893613),
(15, 'default', '{\"uuid\":\"c4ed036f-c1e4-4232-9a62-d4f017ba4fb6\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893633, 1763893633),
(16, 'default', '{\"uuid\":\"ef06e46c-89ea-4bdb-a450-09674e7d0ab0\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893633, 1763893633),
(17, 'default', '{\"uuid\":\"253e8573-353c-4dce-a2b9-d2f8abf2bb34\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893648, 1763893648),
(18, 'default', '{\"uuid\":\"0dcd0bd2-1026-4e75-bc9d-79c748385fe6\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893648, 1763893648),
(19, 'default', '{\"uuid\":\"18b66559-a8a2-42f5-a2f5-ab6dfe3fe1d2\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893662, 1763893662),
(20, 'default', '{\"uuid\":\"9bdf4433-8527-4ca5-87dc-724fb4f22f05\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893678, 1763893678),
(21, 'default', '{\"uuid\":\"0702dc21-7b52-4bcc-8d30-b570e4674ae2\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893678, 1763893678),
(22, 'default', '{\"uuid\":\"708c762b-babc-42df-925c-6138a128708d\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893704, 1763893704),
(23, 'default', '{\"uuid\":\"7de8c982-a0b8-47d5-9779-ece291211796\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893704, 1763893704),
(24, 'default', '{\"uuid\":\"c3f405fe-6883-4b0d-b695-e0a4efbcc39b\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893723, 1763893723),
(25, 'default', '{\"uuid\":\"98cd968d-f772-467b-a58d-5cf27f4daa59\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893723, 1763893723),
(26, 'default', '{\"uuid\":\"7b1549bd-336d-4d00-ae18-4ecbc006bda3\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893723, 1763893723),
(27, 'default', '{\"uuid\":\"b47ac61a-bd66-42aa-9a9c-cac844d8d34d\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893741, 1763893741),
(28, 'default', '{\"uuid\":\"b42c05f5-9c47-45ac-bf29-6fa48d848ec1\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893741, 1763893741),
(29, 'default', '{\"uuid\":\"a2aa8709-ed65-4f37-8872-cfc5df8fa50e\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893741, 1763893741),
(30, 'default', '{\"uuid\":\"d1beafa8-0e8e-4053-b536-29833ff81291\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893793, 1763893793),
(31, 'default', '{\"uuid\":\"d3442eb7-2a4c-4634-91a1-bbb050ceb537\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893793, 1763893793),
(32, 'default', '{\"uuid\":\"e22bfbda-97d6-4dd2-b860-790cc63529a7\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893793, 1763893793),
(33, 'default', '{\"uuid\":\"2c35d014-59f1-456d-80dd-c4e44b0d1a66\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893793, 1763893793),
(34, 'default', '{\"uuid\":\"53bc3ae4-2ef6-4f71-8e4c-2e2f5f11c353\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893832, 1763893832),
(35, 'default', '{\"uuid\":\"13e7661b-820f-426f-8b81-1400f5acf6eb\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893832, 1763893832),
(36, 'default', '{\"uuid\":\"903bfa4e-57fe-4988-ba3e-1a2bb5ae8be9\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893832, 1763893832),
(37, 'default', '{\"uuid\":\"291e609d-edeb-4476-b362-70aa8edef2ae\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893832, 1763893832),
(38, 'default', '{\"uuid\":\"76ad6d4f-d034-44f6-a655-1b6ddd49a14c\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893832, 1763893832),
(39, 'default', '{\"uuid\":\"9b281648-3434-4d84-9247-20c35bb9e821\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893861, 1763893861),
(40, 'default', '{\"uuid\":\"5b56a390-1515-4160-ad68-79a94f0f845b\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893861, 1763893861),
(41, 'default', '{\"uuid\":\"3fb94276-8bd7-4515-b8a9-b8bb4b95bb3e\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893861, 1763893861),
(42, 'default', '{\"uuid\":\"1ba00664-d1b5-4aec-8169-9e225507dcae\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893861, 1763893861);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(43, 'default', '{\"uuid\":\"eb2a1a0f-8bc4-4f80-ac5a-379e7d25548f\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893861, 1763893861),
(44, 'default', '{\"uuid\":\"708c9ca8-8545-46c8-87ff-10973fbf2797\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893861, 1763893861),
(45, 'default', '{\"uuid\":\"4aa33100-7c5d-4dd0-8080-c94e9cce0a6a\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893875, 1763893875),
(46, 'default', '{\"uuid\":\"0f37d9f2-7b8c-45cd-9330-b531888abbe7\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893875, 1763893875),
(47, 'default', '{\"uuid\":\"900833e1-a89b-4e7c-ab2e-7d11972a6518\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893875, 1763893875),
(48, 'default', '{\"uuid\":\"3dcf4984-f68f-4056-bf9b-c1c8bfb45765\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893875, 1763893875),
(49, 'default', '{\"uuid\":\"0e46b141-cf9e-4413-a08a-6271a389c707\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893875, 1763893875),
(50, 'default', '{\"uuid\":\"e69511c9-a0de-42da-8803-de6b194188d4\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893875, 1763893875),
(51, 'default', '{\"uuid\":\"7e056540-48fe-4bd1-8764-77d1fc980b92\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893892, 1763893892),
(52, 'default', '{\"uuid\":\"69c14cc8-0871-4082-9239-86bd20060ffd\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893892, 1763893892),
(53, 'default', '{\"uuid\":\"2f20238f-f98a-47cb-954a-f761ea358dee\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893892, 1763893892),
(54, 'default', '{\"uuid\":\"b9432b34-ae82-4fdf-b1d3-5da200866698\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893892, 1763893892),
(55, 'default', '{\"uuid\":\"b2741039-c9ce-4de0-a09a-55945c0aa4e9\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893892, 1763893892),
(56, 'default', '{\"uuid\":\"fa76f8d6-8dbb-47c8-b63c-7debe523b4f4\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893892, 1763893892),
(57, 'default', '{\"uuid\":\"289227f3-9e5a-4ca2-8a21-5b5820804148\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893919, 1763893919),
(58, 'default', '{\"uuid\":\"af70face-901e-4e4d-8a5d-d9bfbcff1c78\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893919, 1763893919),
(59, 'default', '{\"uuid\":\"6f2eb5ec-0110-4ea1-96b3-9735a90d1ef9\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893919, 1763893919),
(60, 'default', '{\"uuid\":\"130c50f5-9c3a-4ec6-8ea3-5b503c803d83\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893919, 1763893919),
(61, 'default', '{\"uuid\":\"3b975104-7c81-4378-be97-f4e53200bb22\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893919, 1763893919),
(62, 'default', '{\"uuid\":\"c8e355f3-a990-4647-bdcb-23ade93cd635\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893919, 1763893919),
(63, 'default', '{\"uuid\":\"d63617ca-db77-41e4-9eb5-78aa1f669cbc\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893919, 1763893919),
(64, 'default', '{\"uuid\":\"8caabf35-aeaf-4548-ab34-de000363ad96\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893919, 1763893919),
(65, 'default', '{\"uuid\":\"8dd0fa09-4047-4f0a-9418-d4e86b60d9ed\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893943, 1763893943),
(66, 'default', '{\"uuid\":\"19ce7586-28a5-4e94-938a-d1543be53797\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893976, 1763893976),
(67, 'default', '{\"uuid\":\"b148894d-5321-4ede-a335-8bb2b382c7dc\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893981, 1763893981),
(68, 'default', '{\"uuid\":\"fba390ef-6b45-4526-b698-973dcd0c983f\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763893991, 1763893991),
(69, 'default', '{\"uuid\":\"0dbee334-c06b-4590-9e4d-0c41a110a8be\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894024, 1763894024),
(70, 'default', '{\"uuid\":\"ff3d7547-28c6-4553-94fa-0f8be77bf424\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894024, 1763894024),
(71, 'default', '{\"uuid\":\"b426a84b-f6ff-4b56-b6ff-168baf0ec8f0\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894046, 1763894046),
(72, 'default', '{\"uuid\":\"3035b310-f6be-4a76-b303-6514012ae0a5\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894046, 1763894046),
(73, 'default', '{\"uuid\":\"ebda8c89-9426-43ec-993b-1100141b56c2\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894046, 1763894046),
(74, 'default', '{\"uuid\":\"6e721821-dd5f-4bf6-a670-f26265287d30\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894066, 1763894066),
(75, 'default', '{\"uuid\":\"daf8951b-7f54-4be0-9279-23207cc45e9a\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894066, 1763894066),
(76, 'default', '{\"uuid\":\"64cf7cdf-0846-4d4c-8be1-e0fd6458c173\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894066, 1763894066),
(77, 'default', '{\"uuid\":\"87d6c7f0-d49c-4c04-a516-5fedd55da03d\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894066, 1763894066),
(78, 'default', '{\"uuid\":\"1dedc12d-ed9a-4d4d-b604-744367db3f38\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894101, 1763894101),
(79, 'default', '{\"uuid\":\"d282a09d-4e70-4ba0-a39c-1566d5eb6a45\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894101, 1763894101),
(80, 'default', '{\"uuid\":\"4432cd0f-d029-4781-92eb-5a5c6936f210\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894101, 1763894101),
(81, 'default', '{\"uuid\":\"d24bae26-5ab8-4c85-a14e-e4bce9826292\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894101, 1763894101),
(82, 'default', '{\"uuid\":\"d4a7ed22-9d9f-4215-8d0c-168a78c71995\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894101, 1763894101),
(83, 'default', '{\"uuid\":\"7edce23b-81c1-431e-bbbe-25a08bc34d23\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894225, 1763894225),
(84, 'default', '{\"uuid\":\"e9d5fbec-ce53-487a-a7fd-d8fd85b0d537\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894232, 1763894232);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(85, 'default', '{\"uuid\":\"924cee42-03af-45d4-8b77-66ce3e034674\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894238, 1763894238),
(86, 'default', '{\"uuid\":\"c1d93432-127d-4510-b60c-77fc7b5ac5f5\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894276, 1763894276),
(87, 'default', '{\"uuid\":\"ba3e8857-544a-4e13-a963-57cd4e287dc6\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894303, 1763894303),
(88, 'default', '{\"uuid\":\"52b84d82-b758-4c96-a4e2-a1cfbc6f9f56\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894309, 1763894309),
(89, 'default', '{\"uuid\":\"6e470aa2-e4ba-44bb-a5c3-372fcb0d25be\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894315, 1763894315),
(90, 'default', '{\"uuid\":\"fc85ba7c-8672-4f4a-86a2-93e64cae26fb\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894340, 1763894340),
(91, 'default', '{\"uuid\":\"b13410ba-b0a4-4f2e-a08b-a7622160ef1e\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894397, 1763894397),
(92, 'default', '{\"uuid\":\"b6a1c635-f0ee-4b75-8fc8-943595e465dc\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894409, 1763894409),
(93, 'default', '{\"uuid\":\"03d7d036-6568-4002-8009-e4eb28341b40\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894409, 1763894409),
(94, 'default', '{\"uuid\":\"cc8bbd37-ed2d-4b92-a639-94e02c38fff2\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894545, 1763894545),
(95, 'default', '{\"uuid\":\"94e7b109-1d55-4f3b-ad66-0a27dbe8af88\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894545, 1763894545),
(96, 'default', '{\"uuid\":\"811f50d9-92f3-4557-89e5-c738a50fc96d\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894554, 1763894554),
(97, 'default', '{\"uuid\":\"da997eae-7d00-4ed0-8a87-67e2c58c7f34\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894558, 1763894558),
(98, 'default', '{\"uuid\":\"41e63f5c-944a-4a0e-94eb-985ba473c8fc\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894575, 1763894575),
(99, 'default', '{\"uuid\":\"0f16978b-c40c-4b24-9de4-61c485f4e326\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894588, 1763894588),
(100, 'default', '{\"uuid\":\"f6f2545b-d32e-4f9c-8e9a-550d966d52ef\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894612, 1763894612),
(101, 'default', '{\"uuid\":\"b4b3e614-08fd-4ed0-a0dc-0ea200a80115\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763894974, 1763894974),
(102, 'default', '{\"uuid\":\"0783648f-576e-4ec4-9880-0a72765bd360\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895032, 1763895032),
(103, 'default', '{\"uuid\":\"3824250a-c65f-4e93-9652-c7044b7e8d16\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895032, 1763895032),
(104, 'default', '{\"uuid\":\"eb7eab6d-1677-4c51-97cc-edeff20f949c\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895037, 1763895037),
(105, 'default', '{\"uuid\":\"8297840c-00d5-4b1e-97b5-fdf62cd95f76\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895038, 1763895038),
(106, 'default', '{\"uuid\":\"fbb982f8-e2ed-40d6-a5b3-9dad2c211f83\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895057, 1763895057),
(107, 'default', '{\"uuid\":\"17dbf101-ef03-4b87-8520-62004bba7feb\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895057, 1763895057),
(108, 'default', '{\"uuid\":\"38e48a1b-11ed-49f1-a947-46b75151fbce\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895100, 1763895100),
(109, 'default', '{\"uuid\":\"e8238dd9-77df-43d2-9964-accb9ad52629\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895100, 1763895100),
(110, 'default', '{\"uuid\":\"da29678b-7b39-4956-90a9-431c3994ee16\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895100, 1763895100),
(111, 'default', '{\"uuid\":\"001cb641-4ffe-404f-96f3-dd1a03c2d0a2\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895105, 1763895105),
(112, 'default', '{\"uuid\":\"635a733b-99c2-492a-b0d0-c2438a68d6b2\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895105, 1763895105),
(113, 'default', '{\"uuid\":\"b291941f-2679-4c67-b354-2e68b0dc80b2\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895105, 1763895105),
(114, 'default', '{\"uuid\":\"670aa045-7a4d-4411-a5e0-19fbb9c257de\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895134, 1763895134),
(115, 'default', '{\"uuid\":\"2e519de5-6e3e-4e44-a1e7-720297dec559\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895134, 1763895134),
(116, 'default', '{\"uuid\":\"a4a00797-5374-445e-8219-0d08d2c96c43\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895134, 1763895134),
(117, 'default', '{\"uuid\":\"bbf33887-f5be-4ca5-bc10-36f2488811b0\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763895223, 1763895223),
(118, 'default', '{\"uuid\":\"380b5b70-0892-4c0f-b6f1-14b33cd68cbc\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898023, 1763898023),
(119, 'default', '{\"uuid\":\"387f2868-9510-405b-a308-e97db649b59a\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898095, 1763898095),
(120, 'default', '{\"uuid\":\"a4d6c601-c019-4006-bb04-2f611b6677a2\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898118, 1763898118),
(121, 'default', '{\"uuid\":\"582c2174-9fcf-45cb-8dc1-db6f71fdafb3\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898282, 1763898282),
(122, 'default', '{\"uuid\":\"415f942a-8cef-4225-8a70-dc41915fc104\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898317, 1763898317),
(123, 'default', '{\"uuid\":\"7648e505-598b-4ca5-b1c0-ca1940e9521a\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898589, 1763898589),
(124, 'default', '{\"uuid\":\"a87a1175-a87d-46e0-bc8e-f9abf5abaeeb\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898608, 1763898608),
(125, 'default', '{\"uuid\":\"e6b2e71f-bf4a-4aa0-89e1-e079b5677b8a\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898638, 1763898638),
(126, 'default', '{\"uuid\":\"d379683a-acf0-4e43-83d7-ddcb995686db\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898685, 1763898685);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(127, 'default', '{\"uuid\":\"269e411b-113d-4e30-aa5f-3537eee0462a\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898741, 1763898741),
(128, 'default', '{\"uuid\":\"c177e248-ef64-49cb-8fa4-3915115fd4ed\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898752, 1763898752),
(129, 'default', '{\"uuid\":\"8e99f63b-c1fa-445b-b2e9-a18416b2167e\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898773, 1763898773),
(130, 'default', '{\"uuid\":\"b86d7d47-a3e9-43a2-89f0-0f917d586547\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898786, 1763898786),
(131, 'default', '{\"uuid\":\"4ce4d22b-dac7-4989-bfb7-7ae2c8a9c068\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898792, 1763898792),
(132, 'default', '{\"uuid\":\"35acbc2c-2134-4a27-ba80-e4402b06411b\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898798, 1763898798),
(133, 'default', '{\"uuid\":\"d50137f8-d94a-49c9-b8ca-346c96aa2f40\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763898810, 1763898810),
(134, 'default', '{\"uuid\":\"4ce98973-3cde-44e6-af84-52517faf81e1\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1763904006, 1763904006),
(135, 'default', '{\"uuid\":\"091668c4-69cb-4cb7-b2a6-f98bb8f85a40\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1764006147, 1764006147),
(136, 'default', '{\"uuid\":\"ad6ea8ea-3ac3-4d3c-a333-0e70ecf7ba4c\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1764006163, 1764006163),
(137, 'default', '{\"uuid\":\"3bce2cd1-82cd-4230-a39c-aeb32f6887cb\",\"displayName\":\"App\\\\Events\\\\DriverLocationUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:32:\\\"App\\\\Events\\\\DriverLocationUpdated\\\":1:{s:3:\\\"loc\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Distributor\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1764006163, 1764006163);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_10_175014_create_drivers_table', 2),
(5, '2025_11_10_175600_create_personal_access_tokens_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Driver', 2, 'driver_token', 'b41d72034348125730c88ee1c3ca260f8379b1f90a9375edcc35c1c36518a419', '[\"*\"]', NULL, NULL, '2025-11-10 18:34:35', '2025-11-10 18:34:35'),
(41, 'App\\Models\\Distributor', 1, 'distributor_token', '44ecb1e63cae691f253f6e7d7103cf36b3711409102a3b38c3ea2d8b41a78500', '[\"*\"]', NULL, NULL, '2025-11-18 09:58:14', '2025-11-18 09:58:14'),
(42, 'App\\Models\\Distributor', 1, 'distributor_token', 'ad51b52a01cc21a9eb9c5ff54300c1fde8c1e0b69ad6b8955a171ae4b0a47071', '[\"*\"]', NULL, NULL, '2025-11-18 10:06:28', '2025-11-18 10:06:28'),
(43, 'App\\Models\\Distributor', 1, 'distributor_token', '2176f332c5a36947d811efacd38fef5a7bdd66ed90fd41120ada676684f9548b', '[\"*\"]', NULL, NULL, '2025-11-20 19:03:41', '2025-11-20 19:03:41'),
(44, 'App\\Models\\Distributor', 1, 'distributor_token', '96006e1e80503905f663fb5e19155b4d55ac2a93420b8ed8dd0c993019b1c59f', '[\"*\"]', NULL, NULL, '2025-11-20 19:03:46', '2025-11-20 19:03:46'),
(45, 'App\\Models\\Distributor', 1, 'distributor_token', '76e9e8dd036458b1db098b78e6d0a3d4b2fdb6a98759921db2833a43f8b3abd5', '[\"*\"]', NULL, NULL, '2025-11-20 19:05:11', '2025-11-20 19:05:11'),
(46, 'App\\Models\\Distributor', 1, 'distributor_token', '95c1575ef2141850dbf1419ba364d74fd760ababa3077c8d5ae5b00784fbb06b', '[\"*\"]', NULL, NULL, '2025-11-20 19:09:10', '2025-11-20 19:09:10'),
(47, 'App\\Models\\Distributor', 1, 'distributor_token', '227998f6beab31014874f4246d9aa8d16ff1ecdda204a5366487220f8a1f0310', '[\"*\"]', NULL, NULL, '2025-11-21 16:38:47', '2025-11-21 16:38:47'),
(48, 'App\\Models\\Distributor', 1, 'distributor_token', '0654e5bc2ff8bf958638429d252afd0fbd98449fbe915c2985b5ec7eadc5a2fe', '[\"*\"]', NULL, NULL, '2025-11-21 17:03:52', '2025-11-21 17:03:52'),
(49, 'App\\Models\\Distributor', 1, 'distributor_token', '4234f11b6e067fc21599ca8f1805d3d15b16388979c572753977b839974f454e', '[\"*\"]', NULL, NULL, '2025-11-22 11:23:54', '2025-11-22 11:23:54'),
(50, 'App\\Models\\Distributor', 1, 'distributor_token', '58503121d03a989d985a0383127c457bceb443854649f86752897e5307ad7c4a', '[\"*\"]', NULL, NULL, '2025-11-22 11:26:29', '2025-11-22 11:26:29'),
(51, 'App\\Models\\Distributor', 1, 'distributor_token', '429b2ec8c86e9d4bb72d7a4967b6ca979e539270965071e453cd8978b18aa1ff', '[\"*\"]', NULL, NULL, '2025-11-22 12:31:29', '2025-11-22 12:31:29'),
(52, 'App\\Models\\Distributor', 1, 'distributor_token', '8dfea8745cb67320e5dd3410679ceb17cd18ade2a1625ca2e8d47adfb1ad3fce', '[\"*\"]', NULL, NULL, '2025-11-22 12:37:03', '2025-11-22 12:37:03'),
(53, 'App\\Models\\Distributor', 1, 'distributor_token', '974046b7d32c8e13f42fe5971f59e5e30ef682ecfd639573d5e8d1b9c2e96d2d', '[\"*\"]', NULL, NULL, '2025-11-22 12:39:44', '2025-11-22 12:39:44'),
(54, 'App\\Models\\Distributor', 1, 'distributor_token', 'c3b91553feb444a0d0f0227630a566c6a500aacb8c5600f7aaad23007d673b52', '[\"*\"]', NULL, NULL, '2025-11-22 12:44:37', '2025-11-22 12:44:37'),
(55, 'App\\Models\\Distributor', 1, 'distributor_token', '824d887a4dabe2df9ce7a08382a0c71039e2114801167dbab3119f9a78b10c55', '[\"*\"]', NULL, NULL, '2025-11-22 12:55:30', '2025-11-22 12:55:30'),
(56, 'App\\Models\\Distributor', 1, 'distributor_token', '1aff47a53d639946c09fb649b356d9c18d3b2bd34587b7fcc5eacae905f56600', '[\"*\"]', NULL, NULL, '2025-11-22 12:59:14', '2025-11-22 12:59:14'),
(57, 'App\\Models\\Distributor', 1, 'distributor_token', '4b062f67ed952cbd60b4408764039831438eff185ae7b04ebbcb86b775d98eaa', '[\"*\"]', NULL, NULL, '2025-11-22 14:09:38', '2025-11-22 14:09:38'),
(58, 'App\\Models\\Distributor', 1, 'distributor_token', '4fb5c3441f30f8935175f40ebfacc4b5f0efe76c45bed204b0191c9911c4d196', '[\"*\"]', NULL, NULL, '2025-11-23 08:42:04', '2025-11-23 08:42:04'),
(59, 'App\\Models\\Distributor', 1, 'distributor_token', '024a17e2fca2073716ede425a557ab70bf1aeca9aea046b57f005e48957e2570', '[\"*\"]', NULL, NULL, '2025-11-23 08:49:14', '2025-11-23 08:49:14'),
(60, 'App\\Models\\Distributor', 1, 'distributor_token', 'cbdcb154ef975c9b8af0c3cfb24a9ff62bfc3fcd38df74208dcdd4bb646742ac', '[\"*\"]', '2025-11-23 09:16:52', NULL, '2025-11-23 09:16:47', '2025-11-23 09:16:52'),
(61, 'App\\Models\\Distributor', 1, 'distributor_token', '910f0f6e6d8e6b6e04902e24476b1f67fcedadfb1170a4f7d8a86a4db8a1a3db', '[\"*\"]', '2025-11-23 10:10:58', NULL, '2025-11-23 09:23:05', '2025-11-23 10:10:58'),
(62, 'App\\Models\\Distributor', 1, 'distributor_token', '68f61b457e8a71609d7dab3e7e9ecd42810bc6c5fe1fd82aed2d03da84f71348', '[\"*\"]', '2025-11-23 10:31:59', NULL, '2025-11-23 10:26:08', '2025-11-23 10:31:59'),
(63, 'App\\Models\\Distributor', 1, 'distributor_token', 'bc04a0a7b05dbc3685bf6f1d5313a9d0b47dbe6b71fe146818b13e96d53d8c30', '[\"*\"]', '2025-11-23 10:40:09', NULL, '2025-11-23 10:32:21', '2025-11-23 10:40:09'),
(64, 'App\\Models\\Distributor', 1, 'distributor_token', 'fd7c623f1f904a7a9691f2ab63f31add40a44d9f28735a080e9d2f4d081793ab', '[\"*\"]', '2025-11-23 10:52:14', NULL, '2025-11-23 10:42:12', '2025-11-23 10:52:14'),
(65, 'App\\Models\\Distributor', 1, 'distributor_token', 'ba4eb851c7c7cf570ed5be2744d034044d288207f32f4af167dce6fc8288508a', '[\"*\"]', '2025-11-27 14:13:32', NULL, '2025-11-23 10:49:47', '2025-11-27 14:13:32'),
(66, 'App\\Models\\Distributor', 1, 'distributor_token', '93966c4b391768b19a739ff83dbec6705723b78ebf5b24845d946256cfd9ba42', '[\"*\"]', '2025-11-27 10:27:24', NULL, '2025-11-23 11:44:37', '2025-11-27 10:27:24'),
(67, 'App\\Models\\Distributor', 2, 'distributor_token', '6f00e0d17890af088c0d576bb9abde5be0167ac764500c309314d46a93083fbd', '[\"*\"]', NULL, NULL, '2025-11-23 11:47:18', '2025-11-23 11:47:18'),
(68, 'App\\Models\\Distributor', 4, 'distributor_token', '917205f74ea3850f0266fdbdbddaf2b8606b9b47d7b80629566e9d704d99d9cf', '[\"*\"]', '2025-11-27 10:27:24', NULL, '2025-11-27 10:27:15', '2025-11-27 10:27:24'),
(69, 'App\\Models\\Distributor', 4, 'distributor_token', '35368c816ae9f122f1e8f353bcf61f63d310408e38c280ee3eafd260a32774cc', '[\"*\"]', '2025-12-04 11:20:17', NULL, '2025-11-27 14:15:36', '2025-12-04 11:20:17'),
(70, 'App\\Models\\Distributor', 1, 'distributor_token', '59ab2fd51a37174b9fd68eac93534a8ff67f262c6ffd21d58641dc0a8bbf60cf', '[\"*\"]', '2025-12-07 08:56:26', NULL, '2025-12-02 20:02:30', '2025-12-07 08:56:26'),
(71, 'App\\Models\\Distributor', 6, 'distributor_token', 'a1925db0797bb6af8256489c76712f8a1083016ac8922787d87e91a9ff4c1eca', '[\"*\"]', '2025-12-15 10:10:13', NULL, '2025-12-14 08:01:17', '2025-12-15 10:10:13'),
(72, 'App\\Models\\Distributor', 6, 'distributor_token', '188bad04f4338a065ea21ad85e12b4465078525cbc024a87115fb21d47d60064', '[\"*\"]', NULL, NULL, '2025-12-15 09:23:00', '2025-12-15 09:23:00'),
(73, 'App\\Models\\Distributor', 11, 'distributor_token', 'ab669190760128bdf5498f88da4717ce0874b25dd14554f79387ce8c2c3f9682', '[\"*\"]', '2025-12-20 11:35:58', NULL, '2025-12-18 14:33:45', '2025-12-20 11:35:58'),
(74, 'App\\Models\\Distributor', 11, 'distributor_token', '627d47c13242ae02c35553de2594e20797cb535b673bbe19c76c45f7e509b2ec', '[\"*\"]', '2025-12-18 14:39:29', NULL, '2025-12-18 14:37:34', '2025-12-18 14:39:29'),
(75, 'App\\Models\\Distributor', 12, 'distributor_token', '30bcca37a506aa03980cf24b8b538cb462c60132b673fcae8ce401ef47719316', '[\"*\"]', '2025-12-18 14:42:41', NULL, '2025-12-18 14:42:39', '2025-12-18 14:42:41'),
(76, 'App\\Models\\Distributor', 6, 'distributor_token', '5275f829c915aee7870749dfc3481c7a8b2b9e9c2cac1f1f21a3fe708d4ef743', '[\"*\"]', '2025-12-18 14:48:26', NULL, '2025-12-18 14:48:22', '2025-12-18 14:48:26'),
(77, 'App\\Models\\Distributor', 6, 'distributor_token', '3066d42759f819a908483dfc9d4e9f0bc6a8fab0092db66c7e4d680ae9957a41', '[\"*\"]', '2025-12-20 11:05:03', NULL, '2025-12-18 14:48:37', '2025-12-20 11:05:03'),
(78, 'App\\Models\\Distributor', 6, 'distributor_token', '41428907db49f22f4d6444fa15a83d3610bb591ca6ede1f5a26763de9838c3a0', '[\"*\"]', '2025-12-20 12:04:18', NULL, '2025-12-20 11:15:40', '2025-12-20 12:04:18'),
(79, 'App\\Models\\Distributor', 11, 'distributor_token', 'f062877027e61112d1a6e02e58de1b6a3f027869a49b80302df4478b0c1ff5a3', '[\"*\"]', '2025-12-20 12:03:51', NULL, '2025-12-20 11:36:30', '2025-12-20 12:03:51'),
(80, 'App\\Models\\Distributor', 11, 'distributor_token', '173e8c89a2db577cd4c6f35b33762081cd0130cdb2c1ee4c937bbe2949ab6b02', '[\"*\"]', '2025-12-20 12:08:52', NULL, '2025-12-20 12:04:18', '2025-12-20 12:08:52'),
(81, 'App\\Models\\Distributor', 6, 'distributor_token', '1f384957a016a6763b22c5f3813f0e9ef08eea383920a6c183dbec4b4459495e', '[\"*\"]', '2025-12-20 13:07:31', NULL, '2025-12-20 12:05:26', '2025-12-20 13:07:31'),
(82, 'App\\Models\\Distributor', 11, 'distributor_token', '1bc511de23b6b07f1d0ec897ad78b2575d73a07dfc1cbf9affc937605aaed7b3', '[\"*\"]', '2025-12-20 13:09:33', NULL, '2025-12-20 13:09:02', '2025-12-20 13:09:33'),
(83, 'App\\Models\\Distributor', 11, 'distributor_token', '4f59d1779a989f83da763cfb1383a5a3b3ded18b121853a8666344a68cc3a293', '[\"*\"]', '2025-12-20 13:28:09', NULL, '2025-12-20 13:28:05', '2025-12-20 13:28:09'),
(84, 'App\\Models\\Distributor', 6, 'distributor_token', '821596afe019ebea31410a096edaf0a5db8d5b4181e692f3c7c5898ff785fba5', '[\"*\"]', '2025-12-21 12:21:56', NULL, '2025-12-20 13:29:45', '2025-12-21 12:21:56'),
(85, 'App\\Models\\Distributor', 11, 'distributor_token', 'e80224d0de6bc30e0499d96a4036bd1ded96031fdb9dcb50fa8fcbc404edcbc9', '[\"*\"]', '2025-12-20 13:37:18', NULL, '2025-12-20 13:30:44', '2025-12-20 13:37:18'),
(86, 'App\\Models\\Distributor', 13, 'distributor_token', '12e5e03904152c22217903385c717cf6ebbca6446b66dc17694125a306b82248', '[\"*\"]', '2025-12-23 17:12:12', NULL, '2025-12-21 18:43:09', '2025-12-23 17:12:12'),
(87, 'App\\Models\\Distributor', 13, 'distributor_token', '3214202321bcc3a5581085e2ae23dc4ecc7748d019a55ef39673a041bfc15007', '[\"*\"]', '2025-12-23 14:08:12', NULL, '2025-12-22 06:43:29', '2025-12-23 14:08:12'),
(88, 'App\\Models\\Distributor', 14, 'distributor_token', '397134f61e3bdd84a7eaa5a105a2fe6469c5d8a40236806b7716b503ac200811', '[\"*\"]', '2025-12-23 07:46:52', NULL, '2025-12-23 07:42:52', '2025-12-23 07:46:52'),
(89, 'App\\Models\\Distributor', 14, 'distributor_token', '24c8632b7e9d5dc1f209f8c2dd76fdee4d997808e623698b815c5da3c93589f4', '[\"*\"]', '2025-12-23 14:56:40', NULL, '2025-12-23 07:46:26', '2025-12-23 14:56:40'),
(90, 'App\\Models\\Distributor', 14, 'distributor_token', '051afd4f48b3ca9ce05fda8295d512bb3353d6ecf794517e30c6dfcb764d593e', '[\"*\"]', '2025-12-23 14:56:40', NULL, '2025-12-23 14:47:03', '2025-12-23 14:56:40'),
(91, 'App\\Models\\Distributor', 14, 'distributor_token', 'f80d96e1d4d3268a2bb17f07030a9e09dba3bae021c88d55d1a949c849be9580', '[\"*\"]', '2025-12-23 14:56:40', NULL, '2025-12-23 14:49:44', '2025-12-23 14:56:40'),
(92, 'App\\Models\\Distributor', 14, 'distributor_token', '1a2a0d189d859dad213d8b6227a5cd15285a3087dedd817a4cec936598ecf3e1', '[\"*\"]', '2025-12-23 15:19:42', NULL, '2025-12-23 14:50:40', '2025-12-23 15:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1AEX7gxsfBsIn2QXiDs9nRthqvz67QjIyAWpdlpM', NULL, '13.221.224.219', 'okhttp/5.3.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2FVSTVjMnlpbWNHZzJLVmpuMXB4Q0dFRVFZaHRsS2QwNzRrNFo5RCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764007342),
('A1xIx7CTGlfkWenHi3ELjJdwZU9vUfh3UWKvdjpn', NULL, '197.43.63.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiemFuRFVDTmdJWG5tVTZpZ2ZmajB3T2hnMUNpalRYVlk2QkdkU3kxdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlL2RyaXZlcnMtbWFwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1NToibG9naW5fYmFja3BhY2tfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjI6InBhc3N3b3JkX2hhc2hfYmFja3BhY2siO3M6NjA6IiQyeSQxMiRCalZiRUIvaTQyVlE5QkhkOEo2Vnd1YlVBdVNxdHM1bzJzUlFYSjk4VlNma3FPQzRZQ253UyI7fQ==', 1764071054),
('gacwFwkBgY7H6KthdXWo98HUwehOC91Ra8vWgJJ4', NULL, '197.43.63.201', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHdJSlEzdWFGYUlVMzkyc05aNTNjaXNiZWxqN25BM2tyc2VPRGdxVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlL2FkbWluL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764070776),
('mWFeHPiorXvXlsC7ORK5gUpxUXtcp6PdwAJ6UlxL', NULL, '84.242.58.125', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiOElOSXFnSU5IYWtoak5pSFFieENVTmlKYzhZNTRKZVNLM3BQUENhcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlL2FkbWluL2Rpc3RyaWJ1dG9yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTU6ImxvZ2luX2JhY2twYWNrXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIyOiJwYXNzd29yZF9oYXNoX2JhY2twYWNrIjtzOjYwOiIkMnkkMTIkQmpWYkVCL2k0MlZROUJIZDhKNlZ3dWJVQXVTcXRzNW8yc1JRWEo5OFZTZmtxT0M0WUNud1MiO30=', 1764009681),
('NOEGcPmVn7VVSajoeecfkYEXiIpmUNH2zFuu1xUU', NULL, '74.7.241.2', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.3; +https://openai.com/gptbot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWhkRGtrd2FGZFV4UmpyOEVYYXBzeWhrMVR4VU8wYm5TMEdoTjhHUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764074682),
('rim1s4w17FjgLg99AOeuW1UsAGfHxrSlZpjwVjIG', NULL, '188.161.61.22', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidlkzVGhEdnZWdmRJTDI0Nmdpd0hrRjI5OWhWWFlsTWNrWXZHTWhZcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlL2RyaXZlcnMtbWFwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764058888),
('rKLSXVEkeIN9RxSau4nCWmeKd868F6CpQJFpLUgt', NULL, '46.60.53.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiZEliejN0SGtyNFk3N1BsUHY1dnIxUXNqN0kwTHJQT1o5czBiTWF6SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlL2FkbWluL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjU1OiJsb2dpbl9iYWNrcGFja181OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMjoicGFzc3dvcmRfaGFzaF9iYWNrcGFjayI7czo2MDoiJDJ5JDEyJEJqVmJFQi9pNDJWUTlCSGQ4SjZWd3ViVUF1U3F0czVvMnNSUVhKOThWU2ZrcU9DNFlDbndTIjtzOjY6ImNyZWF0ZSI7YToxOntzOjEwOiJzYXZlQWN0aW9uIjtzOjEzOiJzYXZlX2FuZF9iYWNrIjt9fQ==', 1764011849),
('Ro1zSzpqbfjqkYWDzOqjXrHOeumMHSNKlWUr5qT8', NULL, '213.6.31.113', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzU0Z2hJYnVEUmEydmJJVmNqRnhvc1E4QjVmcFhrTmRpVEZKdklIMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlL2FkbWluL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764070758),
('Xg0hOOlno43b0Y37nKUCx115OcFSgd7mBBTUCkmL', NULL, '213.6.31.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVlpWRVdHY2J6UVJQY1FYN0VSRkhuNjdMS0JpWTdpNjNtMTMyNUFXRSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ1OiJodHRwczovL2VsaXlhYS5iYWl0cGFpdC5zcGFjZS9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU1OiJsb2dpbl9iYWNrcGFja181OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMjoicGFzc3dvcmRfaGFzaF9iYWNrcGFjayI7czo2MDoiJDJ5JDEyJEJqVmJFQi9pNDJWUTlCSGQ4SjZWd3ViVUF1U3F0czVvMnNSUVhKOThWU2ZrcU9DNFlDbndTIjt9', 1764144921),
('XoaGFc7yGnee1rzCcChiqtZ2E5OSwEfyp1kZYQhL', NULL, '213.6.31.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMWFIMjB4TnJXRldhR0xwSTBqMVZ4MzNRZ2lBeUlhdzRYNVBhZURmQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlL2FkbWluL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTU6ImxvZ2luX2JhY2twYWNrXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIyOiJwYXNzd29yZF9oYXNoX2JhY2twYWNrIjtzOjYwOiIkMnkkMTIkQmpWYkVCL2k0MlZROUJIZDhKNlZ3dWJVQXVTcXRzNW8yc1JRWEo5OFZTZmtxT0M0WUNud1MiO30=', 1764070861),
('Yo7DJeDaUaXCzoywO7bYgLVq55UDwMyemxeuvemq', NULL, '54.144.223.42', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/138.0.7204.23 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlk1V2FpbTFPS2dFdnNFS3A3am1KV3o5c044cXdzRll0cmxpTkk5eSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vZWxpeWFhLmJhaXRwYWl0LnNwYWNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764007380),
('YTYjQNIRmJlfd9IuI7aZDjLcNWE4pcw2wFqS47UP', NULL, '213.6.31.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidUVHRGRXNVF3aVdsaUxzUHRDV3lnbkVUTFU3aVl6ekFZMGhFeml3ZSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ1OiJodHRwczovL2VsaXlhYS5iYWl0cGFpdC5zcGFjZS9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU1OiJsb2dpbl9iYWNrcGFja181OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMjoicGFzc3dvcmRfaGFzaF9iYWNrcGFjayI7czo2MDoiJDJ5JDEyJEJqVmJFQi9pNDJWUTlCSGQ4SjZWd3ViVUF1U3F0czVvMnNSUVhKOThWU2ZrcU9DNFlDbndTIjt9', 1764147709);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_statuses`
--

CREATE TABLE `subscription_statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_statuses`
--

INSERT INTO `subscription_statuses` (`id`, `status_name`, `created_at`, `updated_at`) VALUES
(1, 'نشط', '2025-11-11 15:59:10', '2025-11-11 15:59:10'),
(2, 'ملغي من قبل العميل', '2025-11-11 15:59:10', '2025-11-11 15:59:10'),
(3, 'منتهي', '2025-11-11 15:59:10', '2025-11-11 15:59:10'),
(4, 'أحيل إلى المحامي', '2025-11-11 15:59:10', '2025-11-11 15:59:10'),
(5, 'أنهي بواسطة الشركة', '2025-11-11 15:59:10', '2025-11-11 15:59:10'),
(6, 'معلق مؤقتا', '2025-11-11 15:59:10', '2025-11-11 15:59:10'),
(9, 'مشترك جديد', '2025-12-15 12:42:01', '2025-12-15 12:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_types`
--

CREATE TABLE `subscription_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `distribution_days` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_types`
--

INSERT INTO `subscription_types` (`id`, `type_name`, `description`, `distribution_days`, `created_at`, `updated_at`) VALUES
(4, 'اشتراك شهري', 'اشتراك شهري', 30, '2025-12-09 09:20:27', '2025-12-14 08:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$BjVbEB/i42VQ9BHd8J6VwubUAuSqts5o2sRQXJ98VSfkqOC4YCnwS', NULL, '2025-11-05 19:57:11', '2025-11-06 19:16:49');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_clients_delivery_overview`
-- (See below for the actual view)
--
CREATE TABLE `v_clients_delivery_overview` (
`client_id` int(11)
,`contract_no` varchar(11)
,`client_name` varchar(255)
,`phone_one` varchar(50)
,`phone_two` varchar(50)
,`city_id` int(11)
,`latitude` decimal(10,7)
,`longitude` decimal(10,7)
,`address` varchar(500)
,`subscription_status_id` int(11)
,`subscription_status_name` varchar(100)
,`subscription_type_name` varchar(255)
,`distribution_days` int(11)
,`subscription_start_date` date
,`subscription_months` int(6)
,`last_delivery_date` date
,`total_deliveries` bigint(21)
,`days_since_last_delivery` int(7)
,`bottle_balance_stored` int(11)
,`total_bottle_received` decimal(32,0)
,`total_bottle_empty` decimal(32,0)
,`bottle_on_hand_calculated` decimal(34,0)
,`percentage_delivery_rate` int(1)
,`client_status_name` varchar(50)
,`last_delivery_id` int(11)
,`paymant` int(11)
,`distributor_id` int(11)
,`distributor_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_clients_due_by_type_days_ids`
-- (See below for the actual view)
--
CREATE TABLE `v_clients_due_by_type_days_ids` (
`client_id` int(11)
,`contract_no` varchar(11)
,`client_name` varchar(255)
,`phone_one` varchar(50)
,`phone_two` varchar(50)
,`city_id` int(11)
,`subscription_status_id` int(11)
,`subscription_status_name` varchar(100)
,`subscription_type_name` varchar(255)
,`distribution_days` int(11)
,`subscription_start_date` date
,`subscription_months` int(6)
,`last_delivery_date` date
,`total_deliveries` bigint(21)
,`days_since_last_delivery` int(7)
,`latitude` decimal(10,7)
,`longitude` decimal(10,7)
,`address` varchar(500)
,`notes` text
,`bottle_balance_stored` int(11)
,`total_bottle_received` decimal(32,0)
,`total_bottle_empty` decimal(32,0)
,`bottle_on_hand_calculated` decimal(34,0)
,`percentage_delivery_rate` decimal(26,2)
,`client_status_name` varchar(50)
,`client_image` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_clients_due_fixed_25_ids`
-- (See below for the actual view)
--
CREATE TABLE `v_clients_due_fixed_25_ids` (
`client_id` int(11)
,`contract_no` varchar(11)
,`name` varchar(255)
,`phone_one` varchar(50)
,`city_id` int(11)
,`subscription_status_id` int(11)
,`subscription_type_id` int(11)
,`fixed_days_threshold` int(2)
,`last_delivery_date` date
,`days_since_last_delivery` int(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_client_delivery_percentage`
-- (See below for the actual view)
--
CREATE TABLE `v_client_delivery_percentage` (
`client_id` int(11)
,`client_name` varchar(255)
,`subscription_start_date` date
,`subscription_type_id` int(11)
,`subscription_type_name` varchar(255)
,`distribution_days` int(11)
,`days_active` int(7)
,`expected_deliveries` int(8)
,`actual_deliveries` bigint(21)
,`percentage_delivery_rate` decimal(26,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_client_delivery_status`
-- (See below for the actual view)
--
CREATE TABLE `v_client_delivery_status` (
`client_id` int(11)
,`client_name` varchar(255)
,`subscription_start_date` date
,`subscription_type_id` int(11)
,`subscription_type_name` varchar(255)
,`distribution_days` int(11)
,`days_active` int(7)
,`expected_deliveries` int(8)
,`actual_deliveries` bigint(21)
,`percentage_delivery_rate` decimal(26,2)
,`client_commitment_segment` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_client_full_overview`
-- (See below for the actual view)
--
CREATE TABLE `v_client_full_overview` (
`client_id` int(11)
,`contract_no` varchar(11)
,`client_name` varchar(255)
,`phone_one` varchar(50)
,`phone_two` varchar(50)
,`address` varchar(500)
,`subscription_start_date` date
,`city_name` varchar(255)
,`city_id` int(11)
,`client_type` int(11)
,`subscription_type_name` varchar(255)
,`distribution_days` int(11)
,`subscription_status_name` varchar(100)
,`last_delivery_date` date
,`days_since_last_delivery` int(7)
,`total_full_delivered` decimal(32,0)
,`total_empty_collected` decimal(32,0)
,`bottle_balance_from_delivery` decimal(33,0)
,`expected_deliveries` int(8)
,`actual_deliveries` bigint(21)
,`percentage_delivery_rate` decimal(26,2)
,`client_commitment_segment` varchar(50)
,`longitude` decimal(10,7)
,`latitude` decimal(10,7)
,`notes` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_client_last_delivery`
-- (See below for the actual view)
--
CREATE TABLE `v_client_last_delivery` (
`client_id` int(11)
,`last_delivery_date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_delivery_full_details`
-- (See below for the actual view)
--
CREATE TABLE `v_delivery_full_details` (
`delivery_id` int(11)
,`delivery_date` date
,`delivery_day_name` varchar(9)
,`delivery_year_month` varchar(7)
,`client_id` int(11)
,`contract_no` varchar(11)
,`client_name` varchar(255)
,`phone_one` varchar(50)
,`phone_two` varchar(50)
,`address` varchar(500)
,`city_id` int(11)
,`city_name` varchar(255)
,`subscription_type_id` int(11)
,`subscription_type_name` varchar(255)
,`distribution_days` int(11)
,`subscription_status_id` int(11)
,`subscription_status_name` varchar(100)
,`distributor_id` int(11)
,`distributor_name` varchar(255)
,`bottle_received` int(11)
,`bottle_empty` int(11)
,`bottle_net_delta` bigint(12)
,`client_cum_full_delivered` decimal(32,0)
,`client_cum_empty_collected` decimal(32,0)
,`client_running_bottle_delta` decimal(33,0)
,`client_total_deliveries` bigint(21)
,`client_last_delivery_date` date
,`days_since_this_delivery` int(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_distributor_balance`
-- (See below for the actual view)
--
CREATE TABLE `v_distributor_balance` (
`distributor_id` int(11)
,`total_payments` decimal(32,0)
,`total_withdraws` decimal(32,0)
,`balance` decimal(33,0)
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cash_withdraws`
--
ALTER TABLE `cash_withdraws`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distributor_id` (`distributor_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_subscription_start` (`subscription_start_date`);

--
-- Indexes for table `client_statuses`
--
ALTER TABLE `client_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_percentage_range` (`min_percentage`,`max_percentage`);

--
-- Indexes for table `client_types`
--
ALTER TABLE `client_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_client_date` (`client_id`,`delivery_date`);

--
-- Indexes for table `distributors`
--
ALTER TABLE `distributors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscription_statuses`
--
ALTER TABLE `subscription_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_types`
--
ALTER TABLE `subscription_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cash_withdraws`
--
ALTER TABLE `cash_withdraws`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `client_statuses`
--
ALTER TABLE `client_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `client_types`
--
ALTER TABLE `client_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=416;

--
-- AUTO_INCREMENT for table `distributors`
--
ALTER TABLE `distributors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `subscription_statuses`
--
ALTER TABLE `subscription_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subscription_types`
--
ALTER TABLE `subscription_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------

--
-- Structure for view `v_clients_delivery_overview`
--
DROP TABLE IF EXISTS `v_clients_delivery_overview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_clients_delivery_overview`  AS WITH bals AS (SELECT `d`.`client_id` AS `client_id`, sum(`d`.`bottle_received`) AS `total_bottle_received`, sum(`d`.`bottle_empty`) AS `total_bottle_empty`, sum(`d`.`bottle_received` - `d`.`bottle_empty`) AS `net_bottles_delta` FROM `delivery` AS `d` GROUP BY `d`.`client_id`), status_map AS (SELECT `c`.`id` AS `client_id`, 0 AS `percentage_delivery_rate` FROM `clients` AS `c`), last_delivery AS (SELECT `d1`.`client_id` AS `client_id`, `d1`.`distributor_id` AS `distributor_id`, `d1`.`paymant` AS `paymant` FROM (`delivery` `d1` join (select `delivery`.`client_id` AS `client_id`,max(`delivery`.`delivery_date`) AS `max_date` from `delivery` group by `delivery`.`client_id`) `d2` on(`d1`.`client_id` = `d2`.`client_id` and `d1`.`delivery_date` = `d2`.`max_date`))) SELECT `c`.`id` AS `client_id`, `c`.`contract_no` AS `contract_no`, `c`.`name` AS `client_name`, `c`.`phone_one` AS `phone_one`, `c`.`phone_two` AS `phone_two`, `c`.`city_id` AS `city_id`, `c`.`latitude` AS `latitude`, `c`.`longitude` AS `longitude`, `c`.`address` AS `address`, `c`.`subscription_status_id` AS `subscription_status_id`, `ss`.`status_name` AS `subscription_status_name`, `st`.`type_name` AS `subscription_type_name`, `st`.`distribution_days` AS `distribution_days`, `c`.`subscription_start_date` AS `subscription_start_date`, period_diff(date_format(curdate(),'%Y%m'),date_format(`c`.`subscription_start_date`,'%Y%m')) AS `subscription_months`, max(`d`.`delivery_date`) AS `last_delivery_date`, count(`d`.`id`) AS `total_deliveries`, to_days(curdate()) - to_days(max(`d`.`delivery_date`)) AS `days_since_last_delivery`, coalesce(`c`.`bottle_balance`,0) AS `bottle_balance_stored`, coalesce(`b`.`total_bottle_received`,0) AS `total_bottle_received`, coalesce(`b`.`total_bottle_empty`,0) AS `total_bottle_empty`, coalesce(`c`.`bottle_balance`,0) + coalesce(`b`.`net_bottles_delta`,0) AS `bottle_on_hand_calculated`, `sm`.`percentage_delivery_rate` AS `percentage_delivery_rate`, `cs`.`status_name` AS `client_status_name`, max(`d`.`id`) AS `last_delivery_id`, `ld`.`paymant` AS `paymant`, `ld`.`distributor_id` AS `distributor_id`, `dist`.`name` AS `distributor_name` FROM ((((((((`clients` `c` left join `delivery` `d` on(`d`.`client_id` = `c`.`id`)) left join `bals` `b` on(`b`.`client_id` = `c`.`id`)) left join `status_map` `sm` on(`sm`.`client_id` = `c`.`id`)) left join `subscription_types` `st` on(`st`.`id` = `c`.`subscription_type_id`)) left join `subscription_statuses` `ss` on(`ss`.`id` = `c`.`subscription_status_id`)) left join `client_statuses` `cs` on(`sm`.`percentage_delivery_rate` between `cs`.`min_percentage` and `cs`.`max_percentage`)) left join `last_delivery` `ld` on(`ld`.`client_id` = `c`.`id`)) left join `distributors` `dist` on(`dist`.`id` = `ld`.`distributor_id`)) GROUP BY `c`.`id`, `c`.`contract_no`, `c`.`name`, `c`.`address`, `c`.`phone_one`, `c`.`phone_two`, `c`.`city_id`, `c`.`latitude`, `c`.`longitude`, `c`.`subscription_status_id`, `ss`.`status_name`, `st`.`type_name`, `st`.`distribution_days`, `c`.`subscription_start_date`, `c`.`bottle_balance`, `b`.`total_bottle_received`, `b`.`total_bottle_empty`, `b`.`net_bottles_delta`, `sm`.`percentage_delivery_rate`, `cs`.`status_name`, `ld`.`distributor_id`, `ld`.`paymant`, `dist`.`name`  ;

-- --------------------------------------------------------

--
-- Structure for view `v_clients_due_by_type_days_ids`
--
DROP TABLE IF EXISTS `v_clients_due_by_type_days_ids`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_clients_due_by_type_days_ids`  AS WITH bals AS (SELECT `d`.`client_id` AS `client_id`, sum(`d`.`bottle_received`) AS `total_bottle_received`, sum(`d`.`bottle_empty`) AS `total_bottle_empty`, sum(`d`.`bottle_received` - `d`.`bottle_empty`) AS `net_bottles_delta` FROM `delivery` AS `d` GROUP BY `d`.`client_id`), month_deliveries AS (SELECT `d`.`client_id` AS `client_id`, count(0) AS `deliveries_this_month` FROM `delivery` AS `d` WHERE `d`.`delivery_date` >= date_format(curdate(),'%Y-%m-01') AND `d`.`delivery_date` < date_format(curdate() + interval 1 month,'%Y-%m-01') GROUP BY `d`.`client_id`), status_map AS (SELECT `c`.`id` AS `client_id`, round(case when `st`.`distribution_days` > 0 then 100.0 * coalesce(`md`.`deliveries_this_month`,0) / `st`.`distribution_days` else 0 end,2) AS `percentage_delivery_rate` FROM ((`clients` `c` left join `subscription_types` `st` on(`st`.`id` = `c`.`subscription_type_id`)) left join `month_deliveries` `md` on(`md`.`client_id` = `c`.`id`))) SELECT `c`.`id` AS `client_id`, `c`.`contract_no` AS `contract_no`, `c`.`name` AS `client_name`, `c`.`phone_one` AS `phone_one`, `c`.`phone_two` AS `phone_two`, `c`.`city_id` AS `city_id`, `c`.`subscription_status_id` AS `subscription_status_id`, `ss`.`status_name` AS `subscription_status_name`, `st`.`type_name` AS `subscription_type_name`, `st`.`distribution_days` AS `distribution_days`, `c`.`subscription_start_date` AS `subscription_start_date`, period_diff(date_format(curdate(),'%Y%m'),date_format(`c`.`subscription_start_date`,'%Y%m')) AS `subscription_months`, max(`d`.`delivery_date`) AS `last_delivery_date`, count(`d`.`id`) AS `total_deliveries`, to_days(curdate()) - to_days(max(`d`.`delivery_date`)) AS `days_since_last_delivery`, `c`.`latitude` AS `latitude`, `c`.`longitude` AS `longitude`, `c`.`address` AS `address`, `c`.`notes` AS `notes`, coalesce(`c`.`bottle_balance`,0) AS `bottle_balance_stored`, coalesce(`b`.`total_bottle_received`,0) AS `total_bottle_received`, coalesce(`b`.`total_bottle_empty`,0) AS `total_bottle_empty`, coalesce(`c`.`bottle_balance`,0) + coalesce(`b`.`net_bottles_delta`,0) AS `bottle_on_hand_calculated`, `sm`.`percentage_delivery_rate` AS `percentage_delivery_rate`, `cs`.`status_name` AS `client_status_name`, `c`.`image` AS `client_image` FROM ((((((`clients` `c` join `delivery` `d` on(`d`.`client_id` = `c`.`id`)) left join `bals` `b` on(`b`.`client_id` = `c`.`id`)) left join `status_map` `sm` on(`sm`.`client_id` = `c`.`id`)) left join `subscription_types` `st` on(`st`.`id` = `c`.`subscription_type_id`)) left join `subscription_statuses` `ss` on(`ss`.`id` = `c`.`subscription_status_id`)) left join `client_statuses` `cs` on(`sm`.`percentage_delivery_rate` between `cs`.`min_percentage` and `cs`.`max_percentage`)) WHERE `c`.`subscription_status_id` = 1 GROUP BY `c`.`id`, `c`.`contract_no`, `c`.`name`, `c`.`phone_one`, `c`.`phone_two`, `c`.`city_id`, `c`.`subscription_status_id`, `ss`.`status_name`, `st`.`type_name`, `st`.`distribution_days`, `c`.`subscription_start_date`, `c`.`latitude`, `c`.`longitude`, `c`.`address`, `c`.`notes`, `c`.`bottle_balance`, `b`.`total_bottle_received`, `b`.`total_bottle_empty`, `b`.`net_bottles_delta`, `sm`.`percentage_delivery_rate`, `cs`.`status_name`, `c`.`image` HAVING `days_since_last_delivery` >= `st`.`distribution_days`  ;

-- --------------------------------------------------------

--
-- Structure for view `v_clients_due_fixed_25_ids`
--
DROP TABLE IF EXISTS `v_clients_due_fixed_25_ids`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `v_clients_due_fixed_25_ids`  AS SELECT `c`.`id` AS `client_id`, `c`.`contract_no` AS `contract_no`, `c`.`name` AS `name`, `c`.`phone_one` AS `phone_one`, `c`.`city_id` AS `city_id`, `c`.`subscription_status_id` AS `subscription_status_id`, `c`.`subscription_type_id` AS `subscription_type_id`, 25 AS `fixed_days_threshold`, `v`.`last_delivery_date` AS `last_delivery_date`, to_days(curdate()) - to_days(`v`.`last_delivery_date`) AS `days_since_last_delivery` FROM (`clients` `c` join `v_client_last_delivery` `v` on(`v`.`client_id` = `c`.`id`)) WHERE `v`.`last_delivery_date` is null OR to_days(curdate()) - to_days(`v`.`last_delivery_date`) >= 25 ORDER BY `v`.`last_delivery_date` is null DESC, to_days(curdate()) - to_days(`v`.`last_delivery_date`) DESC ;

-- --------------------------------------------------------

--
-- Structure for view `v_client_delivery_percentage`
--
DROP TABLE IF EXISTS `v_client_delivery_percentage`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `v_client_delivery_percentage`  AS SELECT `c`.`id` AS `client_id`, `c`.`name` AS `client_name`, `c`.`subscription_start_date` AS `subscription_start_date`, `st`.`id` AS `subscription_type_id`, `st`.`type_name` AS `subscription_type_name`, `st`.`distribution_days` AS `distribution_days`, CASE WHEN `c`.`subscription_start_date` is null THEN NULL ELSE to_days(curdate()) - to_days(`c`.`subscription_start_date`) END AS `days_active`, CASE WHEN `c`.`subscription_start_date` is null OR `st`.`distribution_days` <= 0 THEN NULL ELSE floor((to_days(curdate()) - to_days(`c`.`subscription_start_date`)) / `st`.`distribution_days`) END AS `expected_deliveries`, (select count(0) from `delivery` `d` where `d`.`client_id` = `c`.`id`) AS `actual_deliveries`, round((select count(0) from `delivery` `d` where `d`.`client_id` = `c`.`id`) / nullif(case when `c`.`subscription_start_date` is null or `st`.`distribution_days` <= 0 then NULL else floor((to_days(curdate()) - to_days(`c`.`subscription_start_date`)) / `st`.`distribution_days`) end,0) * 100,2) AS `percentage_delivery_rate` FROM (`clients` `c` left join `subscription_types` `st` on(`st`.`id` = `c`.`subscription_type_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_client_delivery_status`
--
DROP TABLE IF EXISTS `v_client_delivery_status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `v_client_delivery_status`  AS SELECT `v`.`client_id` AS `client_id`, `v`.`client_name` AS `client_name`, `v`.`subscription_start_date` AS `subscription_start_date`, `v`.`subscription_type_id` AS `subscription_type_id`, `v`.`subscription_type_name` AS `subscription_type_name`, `v`.`distribution_days` AS `distribution_days`, `v`.`days_active` AS `days_active`, `v`.`expected_deliveries` AS `expected_deliveries`, `v`.`actual_deliveries` AS `actual_deliveries`, `v`.`percentage_delivery_rate` AS `percentage_delivery_rate`, `cs`.`status_name` AS `client_commitment_segment` FROM (`v_client_delivery_percentage` `v` left join `client_statuses` `cs` on(`v`.`percentage_delivery_rate` between `cs`.`min_percentage` and `cs`.`max_percentage`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_client_full_overview`
--
DROP TABLE IF EXISTS `v_client_full_overview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `v_client_full_overview`  AS SELECT `c`.`id` AS `client_id`, `c`.`contract_no` AS `contract_no`, `c`.`name` AS `client_name`, `c`.`phone_one` AS `phone_one`, `c`.`phone_two` AS `phone_two`, `c`.`address` AS `address`, `c`.`subscription_start_date` AS `subscription_start_date`, `ci`.`city_name` AS `city_name`, `c`.`city_id` AS `city_id`, `c`.`client_type` AS `client_type`, `st`.`type_name` AS `subscription_type_name`, `st`.`distribution_days` AS `distribution_days`, `ss`.`status_name` AS `subscription_status_name`, `ld`.`last_delivery_date` AS `last_delivery_date`, CASE WHEN `ld`.`last_delivery_date` is null THEN NULL ELSE to_days(curdate()) - to_days(`ld`.`last_delivery_date`) END AS `days_since_last_delivery`, coalesce(`stats`.`total_full_delivered`,0) AS `total_full_delivered`, coalesce(`stats`.`total_empty_collected`,0) AS `total_empty_collected`, coalesce(`stats`.`net_bottles_delta`,0) AS `bottle_balance_from_delivery`, `perc`.`expected_deliveries` AS `expected_deliveries`, `perc`.`actual_deliveries` AS `actual_deliveries`, `perc`.`percentage_delivery_rate` AS `percentage_delivery_rate`, `cs`.`status_name` AS `client_commitment_segment`, `c`.`longitude` AS `longitude`, `c`.`latitude` AS `latitude`, `c`.`notes` AS `notes` FROM (((((((`clients` `c` left join `cities` `ci` on(`ci`.`id` = `c`.`city_id`)) left join `subscription_types` `st` on(`st`.`id` = `c`.`subscription_type_id`)) left join `subscription_statuses` `ss` on(`ss`.`id` = `c`.`subscription_status_id`)) left join `v_client_last_delivery` `ld` on(`ld`.`client_id` = `c`.`id`)) left join `v_client_delivery_percentage` `perc` on(`perc`.`client_id` = `c`.`id`)) left join `client_statuses` `cs` on(`perc`.`percentage_delivery_rate` between `cs`.`min_percentage` and `cs`.`max_percentage`)) left join (select `delivery`.`client_id` AS `client_id`,sum(`delivery`.`bottle_received`) AS `total_full_delivered`,sum(`delivery`.`bottle_empty`) AS `total_empty_collected`,sum(`delivery`.`bottle_received` - `delivery`.`bottle_empty`) AS `net_bottles_delta` from `delivery` group by `delivery`.`client_id`) `stats` on(`stats`.`client_id` = `c`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_client_last_delivery`
--
DROP TABLE IF EXISTS `v_client_last_delivery`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `v_client_last_delivery`  AS SELECT `c`.`id` AS `client_id`, max(`d`.`delivery_date`) AS `last_delivery_date` FROM (`clients` `c` left join `delivery` `d` on(`d`.`client_id` = `c`.`id`)) GROUP BY `c`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_delivery_full_details`
--
DROP TABLE IF EXISTS `v_delivery_full_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `v_delivery_full_details`  AS SELECT `d`.`id` AS `delivery_id`, `d`.`delivery_date` AS `delivery_date`, dayname(`d`.`delivery_date`) AS `delivery_day_name`, date_format(`d`.`delivery_date`,'%Y-%m') AS `delivery_year_month`, `c`.`id` AS `client_id`, `c`.`contract_no` AS `contract_no`, `c`.`name` AS `client_name`, `c`.`phone_one` AS `phone_one`, `c`.`phone_two` AS `phone_two`, `c`.`address` AS `address`, `c`.`city_id` AS `city_id`, `ci`.`city_name` AS `city_name`, `c`.`subscription_type_id` AS `subscription_type_id`, `st`.`type_name` AS `subscription_type_name`, `st`.`distribution_days` AS `distribution_days`, `c`.`subscription_status_id` AS `subscription_status_id`, `ss`.`status_name` AS `subscription_status_name`, `d`.`distributor_id` AS `distributor_id`, `dist`.`name` AS `distributor_name`, `d`.`bottle_received` AS `bottle_received`, `d`.`bottle_empty` AS `bottle_empty`, `d`.`bottle_received`- `d`.`bottle_empty` AS `bottle_net_delta`, sum(`d`.`bottle_received`) over ( partition by `d`.`client_id` order by `d`.`delivery_date`,`d`.`id` rows between  unbounded  preceding and  current row ) AS `client_cum_full_delivered`, sum(`d`.`bottle_empty`) over ( partition by `d`.`client_id` order by `d`.`delivery_date`,`d`.`id` rows between  unbounded  preceding and  current row ) AS `client_cum_empty_collected`, sum(`d`.`bottle_received` - `d`.`bottle_empty`) over ( partition by `d`.`client_id` order by `d`.`delivery_date`,`d`.`id` rows between  unbounded  preceding and  current row ) AS `client_running_bottle_delta`, count(0) over ( partition by `d`.`client_id`) AS `client_total_deliveries`, max(`d`.`delivery_date`) over ( partition by `d`.`client_id`) AS `client_last_delivery_date`, to_days(curdate()) - to_days(`d`.`delivery_date`) AS `days_since_this_delivery` FROM (((((`delivery` `d` join `clients` `c` on(`c`.`id` = `d`.`client_id`)) left join `cities` `ci` on(`ci`.`id` = `c`.`city_id`)) left join `subscription_types` `st` on(`st`.`id` = `c`.`subscription_type_id`)) left join `subscription_statuses` `ss` on(`ss`.`id` = `c`.`subscription_status_id`)) left join `distributors` `dist` on(`dist`.`id` = `d`.`distributor_id`)) ORDER BY `d`.`delivery_date` DESC, `d`.`id` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `v_distributor_balance`
--
DROP TABLE IF EXISTS `v_distributor_balance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_distributor_balance`  AS WITH delivery_payments AS (SELECT `d`.`distributor_id` AS `distributor_id`, sum(`d`.`paymant`) AS `total_payments` FROM `delivery` AS `d` WHERE `d`.`distributor_id` <> 0 GROUP BY `d`.`distributor_id`), cash_withdraws_sum AS (SELECT `cw`.`distributor_id` AS `distributor_id`, sum(`cw`.`total_amount`) AS `total_withdraws` FROM `cash_withdraws` AS `cw` WHERE `cw`.`distributor_id` <> 0 GROUP BY `cw`.`distributor_id`), distributors_map AS (SELECT `delivery`.`distributor_id` AS `distributor_id` FROM `delivery` WHERE `delivery`.`distributor_id` is not null AND `delivery`.`distributor_id` <> 0 UNION SELECT `cash_withdraws`.`distributor_id` AS `distributor_id` FROM `cash_withdraws` WHERE `cash_withdraws`.`distributor_id` is not null AND `cash_withdraws`.`distributor_id` <> 0)  SELECT `dm`.`distributor_id` AS `distributor_id`, coalesce(`dp`.`total_payments`,0) AS `total_payments`, coalesce(`cw`.`total_withdraws`,0) AS `total_withdraws`, coalesce(`dp`.`total_payments`,0) - coalesce(`cw`.`total_withdraws`,0) AS `balance` FROM ((`distributors_map` `dm` left join `delivery_payments` `dp` on(`dp`.`distributor_id` = `dm`.`distributor_id`)) left join `cash_withdraws_sum` `cw` on(`cw`.`distributor_id` = `dm`.`distributor_id`))  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
