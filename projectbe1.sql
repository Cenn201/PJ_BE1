-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 08, 2023 at 06:41 PM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectbe1`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'Basas'),
(2, 'Vintas'),
(3, 'Urbas'),
(4, 'Pattas'),
(5, 'Creas'),
(6, 'Track 6');

-- --------------------------------------------------------

--
-- Table structure for table `oder`
--

DROP TABLE IF EXISTS `oder`;
CREATE TABLE IF NOT EXISTS `oder` (
  `oder_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_price` int NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay` int NOT NULL DEFAULT '0',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`oder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oder`
--

INSERT INTO `oder` (`oder_id`, `user_id`, `total_price`, `address`, `phone`, `pay`, `note`, `status`) VALUES
(8, 2, 1400000, 'Cao Bằng', '0986868686', 1, 'Giao lên núi giúp mình nha, quăng mẹ nó xuống', 1),
(9, 2, 1949000, 'Cầu Đen, An Phú, Thành phố Thủ Đức', '123456789', 1, 'Hàng nhiều nước, vui lòng cẩn thận', 2),
(10, 3, 5990000, 'Phố Vọng Hà Nội', '0978787878', 1, 'không có ghi chú', 1),
(11, 4, 6500000, 'Hồ Chí Minh', '123456789', 1, 'giao giờ hành chánh', 4),
(12, 2, 610000, 'Phố Vọng Hà Nội', '0978787878', 2, 'không có ghi chú', 4),
(14, 3, 4760000, 'Tuy Hoà', '1234567891', 3, 'không có ghi chú', 4),
(15, 3, 650000, 'Hội An', '0978787878', 3, 'không có ghi chú', 0),
(21, 2, 650000, 'Gò Công', '1', 2, '1', 4),
(22, 2, 599000, 'null', '1', 2, 'null', 0),
(23, 2, 599000, 'null', '1', 3, 'null', 0),
(24, 2, 650000, 'null', '1', 1, 'null', 0);

-- --------------------------------------------------------

--
-- Table structure for table `oder_detail`
--

DROP TABLE IF EXISTS `oder_detail`;
CREATE TABLE IF NOT EXISTS `oder_detail` (
  `id_oder` int NOT NULL,
  `id_product` int NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oder_detail`
--

INSERT INTO `oder_detail` (`id_oder`, `id_product`, `quantity`, `price`) VALUES
(9, 3, 1, 650000),
(9, 1, 1, 700000),
(8, 1, 2, 700000),
(9, 10, 1, 599000),
(10, 10, 10, 599000),
(11, 3, 10, 650000),
(12, 19, 1, 610000),
(14, 8, 4, 1190000),
(15, 3, 1, 650000),
(18, 1, 1, 599000),
(18, 1, 1, 599000),
(19, 1, 1, 599000),
(21, 3, 1, 650000),
(22, 1, 1, 599000),
(23, 1, 1, 599000),
(24, 3, 1, 650000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` int NOT NULL,
  `product_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_view` int NOT NULL DEFAULT '0',
  `product_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_like` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `product_price`, `product_photo`, `product_view`, `product_code`, `product_status`, `product_like`) VALUES
(1, 'BASAS BUMPER GUM EXT NE - LOW TOP - BLACK/GUM', 'Bumper Gum EXT (Extension) NE là bản nâng cấp được xếp vào dòng sản phẩm Basas, nhưng lại gây ấn tượng với diện mạo phá đi sự an toàn thường thấy. Với cách sắp xếp logo hoán đổi đầy ý tứ và mảng miếng da lộn (Suede) xuất hiện hợp lí trên chất vải canvas NE bền bỉ dày dặn nhấn nhá thêm bằng những sắc Gum dẻo dai. Tất cả làm nên 01 bộ sản phẩm với thiết kế đầy thoải mái trong trải nghiệm, đủ thanh lịch trong dáng vẻ', 599000, 'item1.jpg', 15, 'AV00098', 'Còn hàng', 19),
(19, 'VINTAS TEMPERATE - HIGH TOP - DUSTY OLIVE', 'Má ngoài Suede (da lộn), má trong phủ vải canvas kèm theo các chi tiết phối trộn chất da Nappa nâu trầm điềm đạm là ý đồ sắp xếp làm nên Vintas Temperate Pack. Với tông màu cảm hứng từ cỏ cây cùng khí hậu dịu mát rõ nét của vùng Ôn Đới. Điểm chốt hạ thuyết phục cho những con người sâu sắc, mang tâm hồn yêu thiên nhiên vô bờ bến.', 610000, 'item11.jpg', 19, 'A61111', 'Còn hàng', 1),
(3, ' BASAS WORKADAY - HIGH TOP - BLACK', 'Gender: Unisex Size run: 35 – 46 Upper: Canvas NE Outsole: Rubber', 650000, 'item3.jpg', 11, 'AV00152', 'Còn hàng', 1),
(7, ' BASAS WORKADAY - HIGH TOP - BLACK', 'Gender: Unisex Size run: 35 – 46 Upper: Canvas NE Outsole: Rubber', 650000, 'item4.jpg', 1, 'AV00152', 'Còn hàng', 1),
(8, 'TRACK 6 CLASS E - LOW TOP - CRAFTSMAN BLUE', 'Track 6 Class E (Essential, Enthusiasm) là bộ sản phẩm mang trên mình những yếu tố cơ bản trong cuộc sống thường ngày. Được sử dụng những chất liệu thường có trên những đôi giày cao cấp với da Nappa nhẵn bóng, lưới mesh nhỏ mịn kết hợp Suede (da lộn) phủ màu tạo nên tổng thể vừa tinh tế, với màu sắc nhã nhặn. Điểm nhấn thú vị trên chi tiết màu “Craftsman Blue” thể hiện một phần yếu tố cần thiết, đại diện cho niềm đam mê chế tác của con người với những thú vui gắn cùng thiên nhiên. Track 6 Class E - Craftsman Blue xứng đáng là một must-have item đối với những ai yêu thích sáng tạo và mong muốn thể hiện cá tính độc lập.', 1190000, 'item5.jpg', 3, 'A6T009', 'Còn hàng', 3),
(12, 'VINTAS AUNTER - LOW TOP - BOTANICAL GARDEN', 'Kết hợp cùng diện mạo quai dán (hook\'n loop) mới mẻ, Aunter chính là một bản phối lạ lẫm nhưng đầy thú vị lần đầu tiên xuất hiện của dòng Vintas. Vẫn là chất vải Canvas thường gặp, đi cặp cùng các lựa chọn màu sắc phong phú nhưng vẫn ẩn sâu bên trong nét điềm đạm. Tất cả làm nên điểm nhấn chững chạc tổng thể, dễ dàng tôn lên nét thu hút cần thiết mọi lần lên chân.', 690000, 'item9.jpeg\r\n', 0, 'AV002121', 'Còn hàng', 0),
(9, 'PATTAS LIVING JOURNEY - HIGH TOP - VAPOROUS GRAY', 'Gender: Unisex Size run: 35 – 46 Upper: Twill Canvas Outsole: Rubber', 750000, 'item6.jpeg', 7, 'AV00133', 'Còn hàng', 1),
(10, 'URBAS SC - HIGH TOP - CORNSILK', 'Gender: Unisex Size run: 35 – 46 Upper: Canvas NE Outsole: Rubber', 599000, 'item8.jpg', 3, 'AV00192', 'Còn hàng', 0),
(11, 'VINTAS MONOGUSO - LOW TOP - MOONBEAM/GREEN', 'Thiết kế mới Vintas Monoguso mang đến âm hưởng của những nét đẹp cổ điển không tuổi. Sử dụng chất liệu Heavy Canvas sợi lớn dày dặn-nhân đôi, đặc biệt bền bỉ theo thời gian; viền giày được bọc lớp da “bề mặt” (Full Grain Leather) cho cảm giác cổ điển hơn. Điểm nhấn màu sắc từ chất liệu Suede (da lộn) tại lưỡi gà-gót giày tăng vẻ ấn tượng trên nền màu nhã nhặn tổng thể. Vintas Monoguso chính là lựa chọn sở hữu diện mạo đủ chất “cũ” nhưng đầy mới lạ khi lên chân.', 720000, 'item7.jpeg', 1, 'AV00119', 'Còn hàng', 0),
(14, ' VINTAS FLANNEL - HIGH TOP - CEMENT', 'Khoác lên thân giày một lớp áo mới theo đúng nghĩa đen với thiết kế đánh dấu sự xuất hiện lần đầu tiên của chất vải Flannel trên các dáng sản phẩm quen thuộc từ Ananas. Phát huy những ưu điểm thoải mái và bền bỉ từ chất vải Flannel “vạn người mê”, song hành cùng phối màu trầm ấm đặc trưng, Vintas Flannel Pack là lựa chọn thú vị dành cho những bạn trẻ ái mộ phong cách điềm đạm chững chạc nhưng vẫn đầy sức hút.', 720000, 'item10.jpg\r\n', 0, 'AV00118', 'Còn hàng', 0),
(25, 'anh ba sa đéc', 'Năm Trà Cú sinh ra Phú Yên báo quá báo gọi là Năm Trà Cú', 1, '318826831_894861648194738_3258905540491902112_n.jpg', 0, 'test', 'Còn hàng', 0),
(22, ' TRACK 6 TRIPLE WHITE - LOW TOP - WHITE', 'Với cảm hứng từ Retro Sneakers và âm nhạc giai đoạn 1970s, Ananas Track 6 ra đời với danh hiệu là mẫu giày Cold Cement đầu tiên của Ananas - một thương hiệu giày Vulcanized. Chất liệu Storm Leather đáng giá ', 990000, 'item12.jpg', 0, 'A6T002', 'Còn hàng', 0),
(26, '123', '123123', 123, '', 1, 'id', 'Còn hàng', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_categories`
--

DROP TABLE IF EXISTS `products_categories`;
CREATE TABLE IF NOT EXISTS `products_categories` (
  `product_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_categories`
--

INSERT INTO `products_categories` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(7, 1),
(8, 6),
(9, 4),
(10, 3),
(11, 2),
(12, 2),
(14, 2),
(19, 2),
(22, 6),
(24, 5);

-- --------------------------------------------------------

--
-- Table structure for table `products_users`
--

DROP TABLE IF EXISTS `products_users`;
CREATE TABLE IF NOT EXISTS `products_users` (
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`product_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_users`
--

INSERT INTO `products_users` (`product_id`, `user_id`) VALUES
(1, 1),
(1, 3),
(2, 3),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `username`, `password`) VALUES
(1, 'Admin\r\n', 'admin.baonanas@gmail.com', 'admin', '$2y$10$lyXhM34pymhUyMvUYLjfdeCqjsjDLh2621N5GrtanwhNp4QlW/Nqm');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
