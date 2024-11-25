-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 25, 2024 lúc 03:04 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `baitap_tuan7`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Self-help books'),
(2, 'Fiction'),
(3, 'Non-fiction'),
(7, 'Biography'),
(11, 'Fantasy'),
(12, 'Romance'),
(13, 'Thriller'),
(14, 'Adventure'),
(15, 'Poetry');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `price` decimal(10,3) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `desc`, `price`, `image`, `category_id`) VALUES
(1, 'bla', 'Nothing is here!', 12.000, '1732157419_Screenshot 2024-11-12 104934.png', 1),
(2, 'Corgy', 'Puppy super cute!', 25.000, '1732198611_images (1).jpeg', 11),
(3, 'Mew', 'meomeo', 12.000, '1732198690_World-Furniture-Online_39.jpg', 2),
(5, 'Place', 'jjqwlsndfnl', 25.000, '1732200876_Square+Blog+600px-2.jpg', 3),
(7, 'Samsung Galaxy S23 Ultra', 'Flagship mới nhất từ Samsung với màn hình AMOLED 6.8 inch, độ phân giải 2K, camera chính 200MP, và chip Snapdragon 8 Gen 2. Pin 5000mAh hỗ trợ sạc nhanh 45W.\r\n', 15.000, '1732495815_S24Ultra-Color-Titanium_Grey_PC_0527_final.webp', 2),
(8, 'iPhone 15 Pro Max', 'Chiếc iPhone cao cấp nhất của Apple với khung viền titan siêu nhẹ, màn hình Super Retina XDR 6.7 inch, camera telephoto 5x zoom quang học, và chip A17 Pro hiệu năng mạnh mẽ.', 9999999.999, '1732496142_iphone-15-pro-max-natural-titanium-1-hhm.webp', 1),
(9, 'Xiaomi 13T Pro', ' Smartphone chụp ảnh đẹp với cụm camera Leica ấn tượng, màn hình OLED 144Hz, chip Dimensity 9200+, và pin 5000mAh hỗ trợ sạc siêu nhanh 120W.\r\n', 9999999.999, '1732496187_xiaomi-13t-pro-xanh-thumb-600x600.jpg', 1),
(10, 'Google Pixel 8 Pro', 'Điện thoại thông minh của Google với màn hình LTPO OLED 6.7 inch, chip Tensor G3 tùy biến, camera chính 50MP hỗ trợ AI mạnh mẽ, và Android thuần mượt mà.', 9999999.999, '1732496256_Google-Pixel-8-Pro-SonPixel.jpg', 1),
(11, 'OPPO Find X6 Pro', 'Sản phẩm cao cấp từ OPPO với màn hình AMOLED 1 tỷ màu, camera chính 50MP cảm biến Sony IMX989, và khả năng sạc siêu nhanh 100W.', 9999999.999, '1732496290_600_Oppo_find_x6_pro_green_xtmobile.webp', 1),
(12, 'Vivo X90 Pro+', 'Siêu phẩm với cảm biến camera lớn 1 inch từ Sony, màn hình AMOLED 6.78 inch hỗ trợ Dolby Vision, chip Snapdragon 8 Gen 2, và pin 4700mAh với sạc nhanh 80W.', 9999999.999, '1732496530_den.jpg', 1),
(13, 'OnePlus 11 Pro', 'Điện thoại cao cấp với màn hình Fluid AMOLED 6.7 inch, tần số quét 120Hz, chip Snapdragon 8 Gen 2, và hệ thống camera Hasselblad chuyên nghiệp.', 100000.000, '1732496557_thiet-ke-chua-co-ten-1-1.png', 1),
(14, 'Sony Xperia 1 V', ' Smartphone dành cho người yêu công nghệ với màn hình OLED 4K HDR 6.5 inch, cụm camera chuyên nghiệp, và khả năng quay video điện ảnh ấn tượng.', 100000.000, '1732496585_747_ProductPrimary_image.webp', 1),
(15, 'Realme GT 5 Pro', ' Điện thoại hiệu năng cao với chip Snapdragon 8 Gen 3, màn hình AMOLED 144Hz, pin 5400mAh và sạc nhanh 240W ấn tượng.', 9999999.999, '1732496615_realme-gt5-pro-cam_1702456479.jpg', 1),
(16, 'Asus ROG Phone 7 Ultimate', 'Smartphone gaming với màn hình AMOLED 165Hz, chip Snapdragon 8 Gen 2, hệ thống tản nhiệt chuyên dụng và pin 6000mAh giúp chơi game liên tục.', 1000000.000, '1732496646_images (2).jpeg', 1),
(17, 'Nokia XR21', 'Điện thoại bền bỉ đạt chuẩn quân đội MIL-STD-810H, màn hình Gorilla Glass Victus, pin 4800mAh, và khả năng kháng nước IP68 dành cho môi trường khắc nghiệt.', 9999999.999, '1732496669_product-316817-061023-015510-600x600.jpg', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
