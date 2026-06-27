Để tạo cơ sở dữ liệu từ nội dung bạn đã cung cấp, bạn có thể sử dụng các câu lệnh SQL để chạy trên hệ quản trị cơ sở dữ liệu (ví dụ: MySQL, MariaDB, phpMyAdmin).

Dưới đây là cấu trúc SQL hoàn chỉnh để bạn tạo và nạp dữ liệu. Bạn có thể sao chép đoạn mã dưới đây vào trình chạy SQL của bạn.

```sql
-- 1. Tạo Database (nếu chưa có)
CREATE DATABASE IF NOT EXISTS gearx_db;
USE gearx_db;

-- 2. Tắt kiểm tra khóa ngoại để nạp dữ liệu dễ dàng
SET FOREIGN_KEY_CHECKS=0;

-- 3. Tạo các bảng và nạp dữ liệu
-- Bảng product_categories
CREATE TABLE IF NOT EXISTS `product_categories` (
  `_id` VARCHAR(50) PRIMARY KEY,
  `title` VARCHAR(255),
  `description` TEXT,
  `thumbnail` VARCHAR(255),
  `status` VARCHAR(50),
  `position` INT,
  `slug` VARCHAR(255),
  `deleted` TINYINT(1),
  `deletedAt` DATETIME,
  `createdAt` DATETIME,
  `updatedAt` DATETIME
);

INSERT INTO `product_categories` VALUES
('cat_6a3e260d4b061', 'NAM', NULL, 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782465195/gearx/categories/niyhhhvjulo4cjv6ppm1.jpg', 'active', '1', 'nam', '0', NULL, '2026-06-26 14:11:09', '2026-06-26 16:13:15'),
('cat_6a3e260d4c8e2', 'NỮ', NULL, 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782465198/gearx/categories/mdvjos7eoqs11556pgiv.jpg', 'active', '2', 'nu', '0', NULL, '2026-06-26 14:11:09', '2026-06-26 16:13:18'),
('cat_6a3e260d4d641', 'PHỤ KIỆN', NULL, 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782465200/gearx/categories/q1ky3dascbagya7dbfnq.jpg', 'active', '3', 'phu-kien', '0', NULL, '2026-06-26 14:11:09', '2026-06-26 16:13:20'),
('cat_6a3e260d4e9c3', 'BỘ SƯU TẬP', NULL, 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782465317/gearx/categories/ol6xyqhj0wrbfjogl43i.png', 'active', '4', 'bo-suu-tap', '0', NULL, '2026-06-26 14:11:09', '2026-06-26 16:15:17'),
('cat_6a3e260d4f91f', 'SALE', NULL, 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782465203/gearx/categories/efz6u35dspkclzbibms6.jpg', 'active', '5', 'sale', '0', NULL, '2026-06-26 14:11:09', '2026-06-26 16:13:24');

-- Bảng products
CREATE TABLE IF NOT EXISTS `products` (
  `_id` VARCHAR(50) PRIMARY KEY,
  `title` VARCHAR(255),
  `product_category_id` VARCHAR(50),
  `description` TEXT,
  `price` DECIMAL(15, 2),
  `discountPercentage` INT,
  `thumbnail` VARCHAR(255),
  `brand` VARCHAR(255),
  `gender` VARCHAR(50),
  `material` VARCHAR(255),
  `status` VARCHAR(50),
  `featured` VARCHAR(10),
  `slug` VARCHAR(255),
  `rating_avg` FLOAT,
  `rating_count` INT,
  `deleted` TINYINT(1),
  `createdAt` DATETIME,
  `updatedAt` DATETIME
);

INSERT INTO `products` VALUES
('prod_001', 'Áo Thun Polo Cao Cấp', 'cat_6a3e260d4b061', NULL, '250000', '0', 'anh_bia.jpg', 'Routine', 'nam', 'Cotton 100%', 'active', 'no', NULL, '0', '0', '0', '2026-06-19 17:39:11', '2026-06-26 14:25:14'),
('prod_6a3e2174c2ec2', 'Áo Polo Basic', 'cat_6a3e260d4b061', NULL, '299000', '0', 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782456695/gearx/q4ugscpqxrubwduxmqjw.jpg', NULL, 'unisex', NULL, 'active', 'yes', NULL, '0', '0', '0', '2026-06-26 13:51:35', '2026-06-26 14:25:14'),
('prod_6a3e2174c2ecd', 'Áo Thun Nữ Oversize', 'cat_6a3e260d4c8e2', NULL, '259000', '0', 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782456698/gearx/jx9y9btklg7pjhd5c1wv.jpg', NULL, 'unisex', NULL, 'active', 'yes', NULL, '0', '0', '0', '2026-06-26 13:51:38', '2026-06-26 14:25:14'),
('prod_6a3e2174c2ece', 'Áo Thun Nam Basic', 'cat_6a3e260d4b061', NULL, '269000', '0', 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782456700/gearx/upefwxdrxyi3ekomju8h.jpg', NULL, 'unisex', NULL, 'active', 'yes', NULL, '0', '0', '0', '2026-06-26 13:51:40', '2026-06-26 14:25:14'),
('prod_6a3e2174c2ecf', 'Sơ Mi Nữ Tay Dài', 'cat_6a3e260d4c8e2', NULL, '329000', '0', 'https://res.cloudinary.com/dfzgowb54/image/upload/v1782456703/gearx/htdqu1z2mawobj0lvu2j.jpg', NULL, 'unisex', NULL, 'active', 'yes', NULL, '0', '0', '0', '2026-06-26 13:51:43', '2026-06-26 14:25:14');

-- Bảng product_images
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` INT PRIMARY KEY,
  `product_id` VARCHAR(50),
  `image_url` VARCHAR(255)
);

INSERT INTO `product_images` VALUES
('1', 'prod_001', 'anh_mat_truoc.jpg'),
('2', 'prod_001', 'anh_mat_sau.jpg');

-- Bảng product_variants
CREATE TABLE IF NOT EXISTS `product_variants` (
  `_id` VARCHAR(50) PRIMARY KEY,
  `product_id` VARCHAR(50),
  `color` VARCHAR(50),
  `size` VARCHAR(50),
  `stock` INT,
  `sku` VARCHAR(100)
);

INSERT INTO `product_variants` VALUES
('var_001', 'prod_001', 'Đen', 'M', '50', NULL),
('var_002', 'prod_001', 'Đen', 'L', '10', NULL),
('var_003', 'prod_001', 'Trắng', 'M', '0', NULL),
('var_6a3e463e0a56b', 'prod_6a3e2174c2ecf', 'Mặc định', 'Freesize', '100', ''),
('var_6a3e4661cf308', 'prod_6a3e2174c2ece', 'Mặc định', 'Freesize', '100', 'SKU_6a3e4661cf31b'),
('var_6a3e4661cff4c', 'prod_6a3e2174c2ecd', 'Mặc định', 'Freesize', '100', 'SKU_6a3e4661cff53'),
('var_6a3e4661d0d51', 'prod_6a3e2174c2ec2', 'Mặc định', 'Freesize', '100', 'SKU_6a3e4661d0d5b');

-- 4. Bật lại kiểm tra khóa ngoại
SET FOREIGN_KEY_CHECKS=1;

```

### Các bước thực hiện:

1. **Mở công cụ quản lý cơ sở dữ liệu**: Bạn có thể dùng **phpMyAdmin**, **MySQL Workbench**, hoặc **DBeaver**.
2. **Tạo database**: Chạy lệnh `CREATE DATABASE gearx_db;`.
3. **Chạy script**: Mở tab "SQL" (hoặc Query), dán toàn bộ đoạn mã trên vào và nhấn **Execute** (hoặc Run).
4. **Kiểm tra**: Các bảng `product_categories`, `products`, `product_images`, và `product_variants` sẽ được tạo và dữ liệu sẽ được điền vào.

Bạn có cần hỗ trợ thêm về việc tạo quan hệ (Foreign Key) giữa các bảng này không?
