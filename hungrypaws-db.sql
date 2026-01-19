-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2025 at 07:35 PM
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
-- Database: `hungrypaws`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `address`, `contact_number`) VALUES
(1, 'The Hungry Paws PH - Batangas City', '2nd Floor, Millorey Bldg., Pallocan West, Batangas City, Batangas, Philippines', '0969-647-2653'),
(2, 'The Hungry Paws PH - Congressional Ave, QC ', '3 San Beda St. cor Congressional Ave. Project 6, Quezon City, Quezon City, Philippines', '0995-712-3315'),
(3, 'The Hungry Paws PH - La Loma, QC', '71 CP-5 Calavite St., Paang Bundok, Quezon City, Philippines', '0906-467-7939'),
(4, 'The Hungry Paws PH - Molino, Cavite', 'Ace Building, Avenida Rizal, Bahayang Pagasa, Molino III, City of Bacoor, Cavite, Philippines', '0945-249-2087');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`) VALUES
(1, 'Dog Food'),
(2, 'Cat Food'),
(3, 'Grooming'),
(4, 'Accessories'),
(5, 'Cat Supplies'),
(6, 'Treats'),
(7, 'Equipment'),
(8, 'Bedding'),
(9, 'Health'),
(10, 'Toys'),
(11, 'Cage');

-- --------------------------------------------------------

--
-- Table structure for table `grooming_service`
--

CREATE TABLE `grooming_service` (
  `service_id` varchar(13) NOT NULL,
  `order_id` varchar(13) NOT NULL,
  `groomer_id` varchar(11) NOT NULL,
  `pet_type` varchar(50) NOT NULL,
  `pet_size` varchar(20) NOT NULL,
  `schedule_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grooming_service`
--

INSERT INTO `grooming_service` (`service_id`, `order_id`, `groomer_id`, `pet_type`, `pet_size`, `schedule_date`) VALUES
('4801199241635', '4805516783706', '10000', 'Dog', 'Small', '2025-11-27'),
('4801298806076', '4803494658441', '10000', 'Dog', 'Small', '2025-11-28'),
('4801919825116', '4808384079613', '10000', 'Cat', 'Small', '2025-11-28'),
('4802946081314', '4802966225000', '10002', 'Dog', 'Small', '2025-11-26'),
('4803614571314', '4805233985224', '10000', 'Cat', 'Small', '2025-11-14'),
('4804444543234', '4805792169442', '10000', 'Cat', 'Small', '2025-11-26'),
('4804660648074', '4808890774173', '10000', 'Cat', 'Small', '2025-11-29'),
('4804859840542', '4804870346722', '10001', '200', 'Small', '2025-11-28'),
('4804972628720', '4801803311921', '10003', 'Cat', 'Small', '2025-11-26'),
('4805591455931', '4804354183129', '10002', 'Dog', 'Small', '2025-11-28'),
('4805962003078', '4807407462085', '10003', 'Dog', 'Small', '2025-11-27'),
('4806260420127', '4807134552613', '10000', 'Cat', 'Small', '2025-11-29'),
('4806264535459', '4800327354576', '10002', 'Dog', 'Small', '2025-11-25'),
('4807362700495', '4804559526253', '10001', 'Dog', 'Small', '2025-11-28'),
('4808000075611', '4806921733235', '10001', 'Cat', 'Small', '2025-11-21'),
('4808891524108', '4802893758709', '10000', 'Cat', 'Small', '2025-11-14'),
('4809166128128', '4809224568008', '10002', 'Dog', 'Small', '2025-11-27'),
('4809492314536', '4808448388229', '10000', 'Cat', 'Small', '2025-11-26'),
('4809639306398', '4808393995167', '10000', 'Cat', 'Small', '2025-11-26'),
('4809699156504', '4807590976626', '10003', 'Dog', 'Small', '2025-11-26'),
('4809926329816', '4804239957068', '10000', 'Cat', 'Small', '2025-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` varchar(13) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `product_id` varchar(13) NOT NULL,
  `stock_level` int(11) NOT NULL,
  `reorder_point` int(11) NOT NULL,
  `last_update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `branch_id`, `product_id`, `stock_level`, `reorder_point`, `last_update_date`, `expiry_date`) VALUES
('4801234564444', 1, '4801234567890', 48, 15, '2025-11-03 22:30:45', '2025-11-30'),
('4801234567444', 1, '4801234567891', 79, 15, '2025-11-10 22:30:16', '2025-11-30'),
('4801234567445', 1, '4801234567892', 0, 10, '2025-11-10 10:06:26', '2025-11-30'),
('4801234567446', 1, '4801234567894', 0, 15, '2025-11-10 10:14:58', '2025-11-30'),
('4801234567447', 1, '4801234567893', 15, 15, '2025-11-10 10:13:52', '2025-11-30'),
('4802142258308', 1, '4801234567908', 199, 10, '2025-11-10 19:08:16', '2025-12-02'),
('4802349118791', 1, '4801234567900', 98, 20, '2025-11-10 19:16:52', '2025-11-19'),
('4802823380076', 1, '4801234567907', 49, 15, '2025-11-10 19:04:04', '2025-12-06'),
('4805346357593', 1, '4801234567897', 195, 30, '2025-11-10 19:09:23', '2025-11-27'),
('4805480016018', 1, '4801234567895', 98, 20, '2025-11-10 19:03:07', '2025-12-06'),
('4807207193128', 1, '4807940152486', 99, 20, '2025-11-11 22:16:46', '2025-11-28'),
('4808852064267', 1, '4806898607615', 197, 30, '2025-11-10 19:09:53', '2025-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_id` varchar(13) NOT NULL,
  `order_id` varchar(13) NOT NULL,
  `product_id` varchar(13) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `unit_price_at_sale` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `product_id`, `quantity_sold`, `unit_price_at_sale`) VALUES
('4800146907096', '4809976839595', '4801234567890', 1, 250.00),
('4800291012963', '4802026981542', '4801234567891', 1, 260.00),
('4800349019606', '4800331619965', '4801234567895', 2, 120.00),
('4800488587771', '4805196860537', '4801234567890', 1, 250.00),
('4800714864495', '4800331619965', '4806898607615', 2, 160.00),
('4800885076161', '4806080681487', '4801234567891', 1, 260.00),
('4800939085222', '4807633732478', '4801234567891', 4, 260.00),
('4800976851717', '4806770545651', '4801234567890', 2, 250.00),
('4801039834171', '4803663703837', '4801234567890', 3, 250.00),
('4801204242712', '4808878428610', '4801234567897', 1, 300.00),
('4801394394866', '4800127748963', '4807940152486', 1, 50.00),
('4801495748339', '4807292702116', '4801234567891', 20, 260.00),
('4801547769959', '4800127748963', '4806898607615', 1, 160.00),
('4801935824742', '4804214527197', '4801234567891', 1, 260.00),
('4802179648039', '4800331619965', '4801234567897', 2, 300.00),
('4802205163127', '4809224568008', '4801234567891', 1, 260.00),
('4802412313439', '4802769760352', '4801234567891', 1, 260.00),
('4802662397195', '4805575570148', '4801234567890', 1, 250.00),
('4802988699590', '4808148747858', '4801234567890', 1, 250.00),
('4803546774014', '4805516783706', '4801234567890', 1, 250.00),
('4803647010667', '4806316569072', '4801234567890', 1, 250.00),
('4804061837177', '4809703935689', '4801234567890', 2, 250.00),
('4804099217661', '4802040809467', '4801234567890', 1, 250.00),
('4804617224717', '4805763880688', '4801234567890', 2, 250.00),
('4804789786897', '4808980248218', '4801234567891', 1, 260.00),
('4804858415722', '4804340443887', '4801234567890', 1, 250.00),
('4804915922675', '4804214527197', '4801234567890', 1, 250.00),
('4805315103669', '4800127748963', '4801234567897', 1, 300.00),
('4805518438039', '4804351039389', '4801234567890', 1, 250.00),
('4805765674223', '4804870346722', '4801234567890', 1, 250.00),
('4805876276757', '4801558279933', '4801234567890', 1, 250.00),
('4806359998178', '4805792169442', '4801234567890', 1, 250.00),
('4806685564472', '4807292702116', '4801234567890', 1, 250.00),
('4806751267090', '4802893758709', '4801234567890', 1, 250.00),
('4806906089557', '4802308922598', '4801234567891', 1, 260.00),
('4807122812504', '4802462640742', '4801234567890', 3, 250.00),
('4807428846172', '4802175034541', '4801234567890', 1, 250.00),
('4807473223929', '4802877454557', '4801234567890', 2, 250.00),
('4807628136754', '4808980248218', '4801234567890', 1, 250.00),
('4807669352446', '4800331619965', '4801234567907', 1, 110.00),
('4807828346201', '4804214527197', '4801234567897', 1, 300.00),
('4807972553538', '4804331072139', '4801234567890', 2, 250.00),
('4808000375537', '4804340443887', '4801234567891', 10, 260.00),
('4808175470916', '4808448388229', '4801234567890', 1, 250.00),
('4808215287411', '4802992497796', '4801234567890', 2, 250.00),
('4808301389752', '4800331619965', '4801234567900', 2, 1200.00),
('4808334639041', '4803494658441', '4801234567890', 1, 250.00),
('4808596036969', '4808890774173', '4801234567890', 1, 250.00),
('4808617835112', '4804875292997', '4801234567890', 1, 250.00),
('4808714030207', '4809418892535', '4801234567890', 1, 250.00),
('4808851174129', '4808776800184', '4801234567890', 2, 250.00),
('4808900180383', '4800331619965', '4801234567908', 1, 400.00),
('4808949500088', '4804535323139', '4801234567891', 3, 260.00),
('4808952627220', '4806921733235', '4801234567890', 2, 250.00),
('4809021464225', '4808286115807', '4801234567890', 1, 250.00),
('4809060940687', '4801239124577', '4801234567891', 9, 260.00),
('4809089146210', '4800863929313', '4801234567890', 1, 250.00),
('4809218509365', '4808150888289', '4801234567890', 1, 250.00),
('4809492919961', '4801686984234', '4801234567890', 1, 250.00),
('4809523161727', '4805597142765', '4801234567891', 8, 260.00),
('4809665820049', '4806080681487', '4801234567890', 1, 250.00),
('4809798905069', '4806813770310', '4801234567890', 1, 250.00),
('4809830693067', '4804354183129', '4801234567890', 1, 250.00),
('4809882413435', '4802308922598', '4801234567890', 1, 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `reset_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`reset_id`, `email`, `token`, `time_stamp`) VALUES
(7, 'johndoe@gmail.com', '94668bc080b7750b76b0003ea6d9519711887852782e394379100b6796a3d9e0', '2025-11-21 05:14:17'),
(22, 'zoalyt.1@gmail.com', '4eebdc82d162d23aa411a0687263fd49724fae0949c6135668caa1bc9303c80e', '2025-11-21 12:18:45');

-- --------------------------------------------------------

--
-- Table structure for table `pet_hotel_booking`
--

CREATE TABLE `pet_hotel_booking` (
  `booking_id` varchar(13) NOT NULL,
  `order_id` varchar(13) NOT NULL,
  `pet_type` varchar(50) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_hotel_booking`
--

INSERT INTO `pet_hotel_booking` (`booking_id`, `order_id`, `pet_type`, `room_type`, `check_in_date`, `check_out_date`) VALUES
('4800756957649', '4804559526253', 'Dog', 'Large', '2025-11-29', '2025-11-30'),
('4802144311359', '4803494658441', 'Cat', 'XS', '2025-11-26', '2025-11-27'),
('4802410472618', '4804455256897', 'Dog', 'XS', '2025-11-26', '2025-11-27'),
('4803160953397', '4807407462085', 'Cat', 'XS', '2025-11-25', '2025-11-26'),
('4804916805478', '4806224254885', 'Dog', 'XS', '2025-11-18', '2025-11-19'),
('4805075000854', '4808890774173', 'Cat', 'Small', '2025-11-30', '2025-11-30'),
('4805745608106', '4809418892535', 'Cat', 'Small', '2025-11-22', '2025-11-28'),
('4807939603835', '4803650616231', 'Cat', 'XS', '2025-11-26', '2025-11-27'),
('4807961080112', '4804239957068', 'Cat', 'Small', '2025-11-23', '2025-11-25'),
('4807991802639', '4802175034541', 'Dog', 'XS', '2025-11-18', '2025-11-19'),
('4808364412790', '4805792169442', 'Cat', 'Small', '2025-11-26', '2025-11-27'),
('4808529627886', '4802308922598', 'Dog', 'XS', '2025-11-13', '2025-11-17'),
('4808632369301', '4807633732478', 'Dog', 'Small', '2025-11-23', '2025-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` varchar(13) NOT NULL,
  `supplier_id` varchar(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `supplier_id`, `product_name`, `barcode`, `category`, `unit_cost`, `selling_price`, `archived`) VALUES
('4801234567890', '101', 'Pedigree Adult Beef & Vegetables 1kg', '4801234567890', 'Dog Food', 180.00, 250.00, 0),
('4801234567891', '101', 'Whiskas Tuna Flavored Cat Food 1.2kg', '4801234567891', 'Cat Food', 190.00, 260.00, 0),
('4801234567892', '102', 'SmartHeart Puppy Milk Formula 1kg', '4801234567892', 'Dog Food', 230.00, 320.00, 0),
('4801234567893', '103', 'Pet Express Dog Shampoo (Aloe Vera) 250ml', '4801234567893', 'Grooming', 95.00, 150.00, 0),
('4801234567894', '103', 'FurryFresh Cat Shampoo (Anti-Flea) 250ml', '4801234567894', 'Grooming', 100.00, 160.00, 0),
('4801234567895', '104', 'Pet Paws Adjustable Collar (Medium, Blue)', '4801234567895', 'Accessories', 70.00, 120.00, 0),
('4801234567896', '104', 'Hungry Paws Leash Nylon 1.5m', '4801234567896', 'Accessories', 85.00, 140.00, 0),
('4801234567897', '105', 'Cat Litter (Lavender Scent) 10L', '4801234567897', 'Cat Supplies', 210.00, 300.00, 0),
('4801234567898', '106', 'Dog Treats – Chicken Jerky 100g', '4801234567898', 'Treats', 75.00, 120.00, 0),
('4801234567899', '107', 'Stainless Pet Bowl (Large)', '4801234567899', 'Accessories', 120.00, 200.00, 0),
('4801234567900', '108', 'Pet Cage Medium (Foldable)', '4801234567900', 'Equipment', 850.00, 1200.00, 0),
('4801234567901', '109', 'Hungry Paws Grooming Comb Set', '4801234567901', 'Grooming', 180.00, 270.00, 0),
('4801234567902', '110', 'Cat Scratching Post (Small)', '4801234567902', 'Accessories', 400.00, 600.00, 0),
('4801234567903', '111', 'Dog Bed Cushion Round (Large)', '4801234567903', 'Bedding', 550.00, 800.00, 0),
('4801234567904', '112', 'Flea & Tick Spray for Dogs 150ml', '4801234567904', 'Health', 140.00, 210.00, 0),
('4801234567905', '113', 'Vitamin Boost for Puppies 120ml', '4801234567905', 'Health', 130.00, 190.00, 0),
('4801234567906', '114', 'Hungry Paws Dog Snack Box (Assorted)', '4801234567906', 'Treats', 300.00, 450.00, 0),
('4801234567907', '115', 'Catnip Toy Mouse (Pack of 2)', '4801234567907', 'Toys', 70.00, 110.00, 0),
('4801234567908', '116', 'Grooming Scissors Stainless', '4801234567908', 'Grooming', 250.00, 400.00, 0),
('4801234567909', '117', 'Refillable Water Bottle Feeder 500ml', '4801234567909', 'Accessories', 120.00, 190.00, 0),
('4803729299823', '115', 'Test Product', '4803729299823', 'Toys', 100.00, 120.00, 0),
('4803732186037', '101', 'San Marino Corned Tuna (Large)', '4803732186037', 'Cat Food', 50.00, 55.00, 0),
('4806898607615', '114', 'Whiskas Tuna Cat Food 1kg', '4806898607615', 'Cat Food', 120.00, 160.00, 0),
('4807940152486', '114', 'Century Tuna 1kg', '4807940152486', 'Dog Food', 40.00, 50.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_order`
--

CREATE TABLE `sale_order` (
  `order_id` varchar(13) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `cashier_id` varchar(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `is_service` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_order`
--

INSERT INTO `sale_order` (`order_id`, `branch_id`, `cashier_id`, `order_date`, `total_amount`, `payment_method`, `is_service`) VALUES
('4800127748963', 1, '10001', '2025-11-12 15:01:12', 510.00, 'Cash', 0),
('4800327354576', 1, '10001', '2025-11-07 19:29:15', 550.00, 'Cash', 1),
('4800331619965', 1, '10001', '2025-11-11 22:12:56', 4070.00, 'Gcash', 0),
('4800863929313', 1, '10001', '2025-11-07 13:25:48', 250.00, 'Maya', 0),
('4801239124577', 1, '10001', '2025-11-07 23:30:38', 2340.00, 'Cash', 0),
('4801558279933', 1, '10001', '2025-11-09 15:04:29', 250.00, 'Cash', 0),
('4801686984234', 1, '10001', '2025-11-07 13:54:00', 250.00, 'Cash', 0),
('4801803311921', 1, '10001', '2025-11-07 13:42:50', 500.00, 'Cash', 1),
('4802026981542', 1, '10001', '2025-11-07 23:41:22', 260.00, 'Cash', 0),
('4802040809467', 1, '10001', '2025-11-09 00:12:09', 250.00, 'Cash', 0),
('4802175034541', 1, '10001', '2025-11-07 15:16:46', 1450.00, 'Gcash', 1),
('4802308922598', 1, '10001', '2025-11-07 16:04:04', 2010.00, 'Cash', 1),
('4802462640742', 1, '10001', '2025-11-09 14:11:12', 750.00, 'Cash', 0),
('4802769760352', 1, '10001', '2025-11-07 16:10:53', 260.00, 'Maya', 0),
('4802877454557', 1, '10001', '2025-11-07 13:29:54', 500.00, 'Gcash', 0),
('4802893758709', 1, '10001', '2025-11-07 13:49:02', 390.00, 'Cash', 1),
('4802966225000', 1, '10001', '2025-11-07 13:45:34', 0.00, 'Cash', 1),
('4802992497796', 1, '10001', '2025-11-07 13:34:15', 500.00, 'Gcash', 0),
('4803494658441', 1, '10001', '2025-11-08 22:53:16', 1250.00, 'Cash', 1),
('4803650616231', 1, '10001', '2025-11-07 03:29:41', 444.00, 'Gcash', 1),
('4803663703837', 1, '10001', '2025-11-09 00:06:30', 750.00, 'Cash', 0),
('4804214527197', 1, '10001', '2025-11-22 02:05:54', 810.00, 'Cash', 0),
('4804239957068', 1, '10001', '2025-11-07 16:12:05', 2000.00, 'Gcash', 1),
('4804331072139', 1, '10001', '2025-11-09 14:38:33', 500.00, 'Cash', 0),
('4804340443887', 1, '10001', '2025-11-07 03:52:48', 2850.00, 'Gcash', 0),
('4804351039389', 1, '10001', '2025-11-07 03:56:07', 250.00, 'Gcash', 0),
('4804354183129', 1, '10001', '2025-11-07 16:07:48', 1255.00, 'Cash', 1),
('4804455256897', 1, '10001', '2025-11-07 19:30:31', 600.00, 'Cash', 1),
('4804535323139', 1, '10001', '2025-11-07 19:42:48', 780.00, 'Cash', 0),
('4804559526253', 1, '10001', '2025-11-07 19:34:26', 1200.00, 'Cash', 1),
('4804870346722', 1, '10001', '2025-11-07 16:10:22', 1450.00, 'Cash', 1),
('4804875292997', 1, '10001', '2025-11-09 14:06:41', 250.00, 'Cash', 0),
('4805196860537', 1, '10001', '2025-11-09 00:13:42', 250.00, 'Cash', 0),
('4805233985224', 1, '10001', '2025-11-07 13:48:23', 120.00, 'Cash', 1),
('4805516783706', 1, '10001', '2025-11-08 22:59:46', 1250.00, 'Cash', 1),
('4805575570148', 1, '10001', '2025-11-07 14:35:23', 250.00, 'Cash', 0),
('4805597142765', 1, '10001', '2025-11-07 23:18:58', 2080.00, 'Cash', 0),
('4805763880688', 1, '10001', '2025-11-09 00:08:01', 500.00, 'Gcash', 0),
('4805792169442', 1, '10001', '2025-11-08 22:56:17', 1250.00, 'Cash', 1),
('4806080681487', 1, '10001', '2025-11-07 13:50:19', 510.00, 'Cash', 0),
('4806224254885', 1, '10001', '2025-11-07 14:56:16', 1450.00, 'Gcash', 1),
('4806316569072', 1, '10001', '2025-11-07 11:34:22', 250.00, 'Maya', 0),
('4806770545651', 1, '10001', '2025-11-09 00:02:42', 500.00, 'Cash', 0),
('4806813770310', 1, '10001', '2025-11-09 14:38:21', 250.00, 'Cash', 0),
('4806921733235', 1, '10001', '2025-11-07 13:49:51', 650.00, 'Cash', 1),
('4807134552613', 1, '10001', '2025-11-07 13:53:11', 100.00, 'Cash', 1),
('4807292702116', 1, '10001', '2025-11-22 02:21:15', 5450.00, 'Maya', 0),
('4807407462085', 1, '10001', '2025-11-07 13:36:58', 1000.00, 'Cash', 1),
('4807590976626', 1, '10001', '2025-11-07 03:33:05', 999.00, 'Maya', 1),
('4807633732478', 1, '10001', '2025-11-07 19:31:09', 1640.00, 'Bank Transfer', 1),
('4808148747858', 1, '10001', '2025-11-09 00:01:39', 250.00, 'Cash', 0),
('4808150888289', 1, '10001', '2025-11-08 23:13:37', 250.00, 'Cash', 0),
('4808286115807', 1, '10001', '2025-11-07 13:28:36', 250.00, 'Cash', 0),
('4808384079613', 1, '10001', '2025-11-07 13:51:55', 220.00, 'Gcash', 1),
('4808393995167', 1, '10001', '2025-11-07 03:09:50', 500.00, 'Cash', 1),
('4808448388229', 1, '10001', '2025-11-07 14:38:52', 1250.00, 'Cash', 1),
('4808776800184', 1, '10001', '2025-11-09 14:10:43', 500.00, 'Cash', 0),
('4808878428610', 1, '10001', '2025-11-21 23:24:22', 300.00, 'Cash', 0),
('4808890774173', 1, '10001', '2025-11-07 19:35:27', 1450.00, 'Maya', 1),
('4808980248218', 1, '10001', '2025-11-07 13:18:57', 510.00, 'Cash', 0),
('4809224568008', 1, '10001', '2025-11-07 19:30:08', 810.00, 'Gcash', 1),
('4809418892535', 1, '10001', '2025-11-07 16:11:26', 694.00, 'Bank Transfer', 1),
('4809703935689', 1, '10001', '2025-11-09 00:14:06', 500.00, 'Gcash', 0),
('4809976839595', 1, '10001', '2025-11-07 14:55:37', 250.00, 'Cash', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `transfer_id` varchar(13) NOT NULL,
  `product_id` varchar(13) NOT NULL,
  `sending_branch_id` int(11) NOT NULL,
  `receiving_branch_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transfer_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`transfer_id`, `product_id`, `sending_branch_id`, `receiving_branch_id`, `quantity`, `transfer_date`, `status`) VALUES
('4801066073954', '4801234567891', 2, 1, 1, '2025-11-10 01:07:32', 'Cancelled'),
('4802778132931', '4801234567907', 2, 1, 50, '2025-11-20 07:31:54', 'Requested'),
('4803550703470', '4801234567908', 2, 1, 100, '2025-11-16 21:50:39', 'Cancelled'),
('4803612744314', '4801234567895', 2, 1, 55, '2025-11-15 12:38:06', 'Completed'),
('4803768492261', '4801234567907', 2, 1, 100, '2025-11-16 21:35:36', 'Cancelled'),
('4803876422989', '4801234567894', 2, 1, 100, '2025-11-20 07:27:52', 'Requested'),
('4804057959121', '4801234567894', 2, 1, 50, '2025-11-10 01:14:07', 'Completed'),
('4804667653735', '4801234567907', 2, 1, 100, '2025-11-16 21:47:52', 'Cancelled'),
('4805276058920', '4801234567897', 2, 1, 100, '2025-11-16 22:30:36', 'Cancelled'),
('4805827730401', '4801234567897', 2, 1, 100, '2025-11-17 10:52:28', 'Cancelled'),
('4805987212568', '4801234567907', 2, 1, 100, '2025-11-16 22:31:54', 'Completed'),
('4806107225654', '4807940152486', 2, 1, 1000, '2025-11-16 21:53:44', 'Cancelled'),
('4808153101516', '4807940152486', 2, 1, 100, '2025-11-15 12:36:14', 'Completed'),
('4808155344875', '4801234567895', 2, 1, 150, '2025-11-10 01:13:22', 'Completed'),
('4808409531238', '4801234567892', 2, 1, 100, '2025-11-20 00:38:35', 'Requested'),
('4808930789580', '4801234567908', 2, 1, 1000, '2025-11-15 12:36:59', 'Completed'),
('4809074191784', '4801234567892', 2, 1, 100, '2025-11-15 12:37:49', 'Completed'),
('4809871341077', '4801234567891', 2, 1, 2, '2025-11-10 01:16:08', 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` varchar(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `contact_person`, `email`, `phone`) VALUES
('02343437139', 'Mercury Pet Shop', 'Juan Doe', 'juandoe@mercury.com', '0911-222-3333'),
('101', 'Mars Petcare Philippines', 'Anna Reyes', 'anna.reyes@marsph.com', '0917-523-4567'),
('102', 'Perfect Companion Group', 'Mark Santos', 'mark.santos@perfectcompanion.ph', '0998-234-1123'),
('103', 'Pet Express Distributors', 'Jenny Lim', 'jenny.lim@petexpress.com.ph', '0927-445-6690'),
('104', 'FurLife Accessories Co.', 'Leo Garcia', 'leo.garcia@furlifeph.com', '0906-778-9901'),
('105', 'Catcomfort Supplies Inc.', 'Diana Cruz', 'diana.cruz@catcomfort.ph', '0935-812-6632'),
('106', 'Treaty Bites Trading', 'Carlo Dizon', 'carlo.dizon@treatybites.com', '0951-667-2305'),
('107', 'MetalBowl Manufacturing', 'Kim Go', 'kim.go@metalbowlmfg.ph', '0918-889-2201'),
('108', 'SafePaws Kennel Works', 'Rachel Tan', 'rachel.tan@safepaws.com', '0997-331-7409'),
('109', 'GroomPro Essentials', 'Nicole Uy', 'nicole.uy@groomproph.com', '0917-532-1180'),
('110', 'FurPlay Cat Products', 'Alex Dela Cruz', 'alex.delacruz@furplayph.com', '0908-765-4432'),
('111', 'ComfyPet Bedding Co.', 'Ella Ramos', 'ella.ramos@comfypet.ph', '0995-998-5531'),
('112', 'VetShield Pet Health', 'John Bautista', 'john.bautista@vetshield.com', '0912-445-3200'),
('113', 'NutriPaw Pet Vitamins', 'Paula Torres', 'paula.torres@nutripaw.com', '0921-776-3309'),
('114', 'Hungry Paws PH', 'Mika Vergara', 'mika.vergara@hungrypaws.ph', '0999-223-4117'),
('115', 'WhiskerWorld Toys', 'Benjie Ong', 'benjie.ong@whiskerworld.com', '0938-221-4582'),
('116', 'SharpEdge Grooming Tools', 'Carla Dee', 'carla.dee@sharpedge.ph', '0919-302-7721'),
('117', 'HydroPet Supplies', 'Ivan Chua', 'ivan.chua@hydropet.ph', '0917-774-5529');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default-profile.png',
  `is_disabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `branch_id`, `username`, `password`, `role`, `first_name`, `last_name`, `email`, `image`, `is_disabled`) VALUES
('03721556364', 2, 'juandelacruz', '$2y$10$vfdDC71ODt.YrOiY4jXJ5eV72bKiLjR8Jc4ZjmojOcEJSrFHWxgBG', 'Admin', 'Juan', 'Dela Cruz', 'zoalyt.1@gmail.com', 'default-profile.png', 0),
('10000', 1, 'admin1', '$2y$10$iFzbmLm.lUnTppn4ubJUr.roKIuzbL8p6nQZUU8b1kTikfl.HRPp6', 'Admin', 'John', 'Doe', 'johndoe@gmail.com', 'img_10000_1763435845.jpg', 0),
('10001', 1, 'cashier1', '$2y$10$Z8FU5OkrS5PYA1VjJ4BHVui4P06GUL5ze8oMZcDkO3cBMd2.hyKSC', 'Cashier', 'James', 'Robert', 'cashierdoe@gmail.com', 'img_10001_1763562485.jpg', 0),
('10002', 1, 'manager1', '$2y$10$Xl71/YvAc/wEsSASHgETheEZsR1/AHGRsINGkN3sDsaVGR0n8tpN6', 'Manager', 'Mister', 'Pickles', 'mrpickles@gmail.com', 'img_10002_1763568202.jpg', 0),
('10003', 1, 'staff1', '$2y$10$g3drJTNVZQCpwvI1fzDUFeoMF1b2kFntlRtm8mLezviLndt4NaA4e', 'Inventory Staff', 'Patricia', 'Jennifer', 'patrijen@gmail.com', 'img_10003_1763569594.jpg', 0),
('24157753976', 2, 'mariamaria', '$2y$10$JKGq.tYSxKoHCQM5fGWtpeS8twm4AbUl5Gm3HS5HoISQKVXX/uEs6', 'Cashier', 'Maria', 'Clara', 'mariaclara@gmail.com', 'default-profile.png', 0),
('68501584882', 2, 'manager2', '$2y$10$5ZdGOkv2NOQydBFyuqU/hudpinJLOtNKAQtP4gCH7Uqifnscu6s2e', 'Manager', 'Mister', 'Doe', 'misterdoe@gmail.com', 'default-profile.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `grooming_service`
--
ALTER TABLE `grooming_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `groomer_order` (`order_id`),
  ADD KEY `groomer_service` (`groomer_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `branch_inventory` (`branch_id`),
  ADD KEY `product_inventory` (`product_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `product_order` (`product_id`),
  ADD KEY `order_detail` (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `pet_hotel_booking`
--
ALTER TABLE `pet_hotel_booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `order_hotel` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `supplier_product` (`supplier_id`);

--
-- Indexes for table `sale_order`
--
ALTER TABLE `sale_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `branch_order` (`branch_id`),
  ADD KEY `cashier_order` (`cashier_id`);

--
-- Indexes for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `sending_branch` (`sending_branch_id`),
  ADD KEY `receiving_branch` (`receiving_branch_id`),
  ADD KEY `product_branch` (`product_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_branch` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grooming_service`
--
ALTER TABLE `grooming_service`
  ADD CONSTRAINT `groomer_order` FOREIGN KEY (`order_id`) REFERENCES `sale_order` (`order_id`),
  ADD CONSTRAINT `groomer_service` FOREIGN KEY (`groomer_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `branch_inventory` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `product_inventory` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail` FOREIGN KEY (`order_id`) REFERENCES `sale_order` (`order_id`),
  ADD CONSTRAINT `product_order` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `pet_hotel_booking`
--
ALTER TABLE `pet_hotel_booking`
  ADD CONSTRAINT `order_hotel` FOREIGN KEY (`order_id`) REFERENCES `sale_order` (`order_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `supplier_product` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Constraints for table `sale_order`
--
ALTER TABLE `sale_order`
  ADD CONSTRAINT `branch_order` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `cashier_order` FOREIGN KEY (`cashier_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD CONSTRAINT `product_branch` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `receiving_branch` FOREIGN KEY (`receiving_branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `sending_branch` FOREIGN KEY (`sending_branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_branch` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
