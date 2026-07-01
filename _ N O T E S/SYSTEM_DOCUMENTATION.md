# TÀI LIỆU PHÂN TÍCH, THIẾT KẾ VÀ PHÁT TRIỂN HỆ THỐNG GEARX (MVC)

Tài liệu này cung cấp cái nhìn toàn diện về kiến trúc hệ thống, cơ sở dữ liệu, quy trình nghiệp vụ và hướng dẫn vận hành cho dự án **GearX - Website Thời trang (PHP thuần MVC)**.

---

## 1. TỔNG QUAN HỆ THỐNG
Dự án **GearX** là một nền tảng thương mại điện tử chuyên biệt dành cho thời trang. Hệ thống được xây dựng trên nền tảng **PHP thuần (PHP Native)** tuân thủ nghiêm ngặt mô hình kiến trúc **MVC (Model-View-Controller)**, giúp mã nguồn có tính mô-đun cao, dễ dàng mở rộng và bảo trì mà không cần phụ thuộc vào các framework cồng kềnh.

### Công nghệ cốt lõi
*   **Backend:** PHP (hỗ trợ PHP 7.4 đến PHP 8.x).
*   **Database:** MySQL / MariaDB (Kết nối an toàn qua PDO).
*   **Quản lý thư viện:** Composer (tự động nạp lớp qua Autoload PSR-4).
*   **Frontend:** HTML5, CSS3 (Giao diện Glassmorphism hiện đại, Responsive đa thiết bị) và Javascript thuần (Vanilla JS).
*   **Bảo mật:** Lưu cấu hình qua tệp môi trường `.env`, mã hóa mật khẩu bằng `password_hash`, cơ chế CAPTCHA chống spam tự động, và kiểm soát lỗi hiển thị.

---

## 2. PHÂN TÍCH HỆ THỐNG (SYSTEM ANALYSIS)

### Đối tượng sử dụng (Actors)
1.  **Khách hàng (Client):** 
    *   Xem sản phẩm, lọc theo kích thước (Size), màu sắc, danh mục (Nam, Nữ, Phụ kiện, Sale, BST).
    *   Quản lý giỏ hàng cá nhân (Thêm, sửa số lượng, xóa).
    *   Đăng ký, đăng nhập (bằng Email, SĐT, hoặc Username) và khôi phục mật khẩu qua Email.
    *   Đặt hàng và theo dõi lịch sử đơn hàng.
2.  **Quản trị viên (Admin):**
    *   Đăng nhập quản trị bắt buộc sử dụng Email.
    *   Quản lý danh mục sản phẩm, danh sách sản phẩm và các biến thể sản phẩm (màu sắc, kích cỡ, tồn kho).
    *   Quản lý đơn hàng của khách hàng.
    *   Cấu hình thông tin hệ thống, quản lý tài khoản khách hàng, phân quyền vai trò.

### Quy trình nghiệp vụ cốt lõi (Key Workflows)

#### A. Luồng Đăng nhập & Đăng ký
*   **Xác thực đa năng:** Khách hàng có thể đăng nhập bằng một trong ba thông tin: Email, Số điện thoại hoặc Tên đăng nhập.
*   **Bảo vệ Spam (CAPTCHA):** Khi người dùng nhập sai mật khẩu quá 3 lần liên tiếp, hệ thống tự động kích hoạt mã CAPTCHA hình ảnh động để ngăn chặn các cuộc tấn công Brute-force.
*   **Khôi phục mật khẩu:** Sử dụng thư viện PHPMailer gửi Token khôi phục mật khẩu thời hạn động qua email của khách hàng.

#### B. Luồng Lọc Sản phẩm & Quản lý Biến thể (Variants)
*   **Cấu trúc dữ liệu động:** Mỗi sản phẩm có thể có nhiều biến thể dựa trên cặp thuộc tính `Màu sắc (Color)` và `Kích cỡ (Size)`.
*   **Kiểm tra tồn kho thời gian thực:** Khi khách hàng chọn một cặp Màu/Size trên giao diện chi tiết sản phẩm, Javascript sẽ tự động tra cứu ID biến thể (`product_variant_id`) và số lượng hàng tồn kho (`stock`). Nếu hết hàng, nút mua sẽ tự động chuyển sang trạng thái vô hiệu hóa (**HẾT HÀNG**).

---

## 3. THIẾT KẾ HỆ THỐNG (SYSTEM DESIGN)

### Cấu trúc Thư mục (Role-First Structure)
Dự án được tổ chức theo cấu trúc phân định rõ ràng giữa Client (Người dùng) và Admin (Quản trị) nhằm nâng cao tính bảo mật và độc lập phát triển:

```text
LAP_TRING_WEB_010412103103/
├── .env                  # Cấu hình bảo mật (Database, SMTP Email, Cloudinary)
├── composer.json         # Khai báo thư viện phụ thuộc (PHPMailer, v.v.)
├── index.php             # Điểm vào duy nhất của ứng dụng (Front Controller)
├── config/
│   └── database.php      # Khởi tạo kết nối PDO đến cơ sở dữ liệu
├── core/                 # Nhân hệ thống (Core Engine)
│   ├── App.php           # Bộ định tuyến tự động (Routing)
│   ├── Controller.php    # Controller cha hỗ trợ truyền dữ liệu sang View
│   ├── Model.php         # Model cha kết nối Database qua biến toàn cục PDO
│   └── helpers.php       # Các hàm tiện ích dùng chung (env, asset, url, slug...)
├── controllers/          # Lớp điều khiển
│   ├── admin/            # Quản trị (Dashboard, Products, Orders, Categories...)
│   └── client/           # Khách hàng (Home, Products, Cart, Auth, User...)
├── models/               # Lớp mô hình dữ liệu (Tương tác trực tiếp DB)
│   ├── Product/          # Quản lý Product, ProductVariant, ProductCategory...
│   ├── User.php          # Quản lý tài khoản và phân quyền
│   ├── Order.php         # Quản lý đơn hàng
│   └── Cart.php          # Quản lý giỏ hàng
├── views/                # Lớp giao diện hiển thị
│   ├── admin/            # Layouts & Pages cho Quản trị viên
│   ├── client/           # Layouts & Pages cho Khách hàng
│   └── utils/            # Các trang tiện ích dùng chung (ví dụ: CAPTCHA)
└── public/               # Tài nguyên tĩnh công khai (CSS, JS, Images)
```

### Cơ chế Định tuyến tự động (Routing Engine)
Tệp [App.php](file:///c:/xampp/htdocs/LAP_TRING_WEB_010412103103/core/App.php) tự động phân tích URL dạng thân thiện (Friendly URL) và định tuyến tới Controller/Action tương ứng:
*   **Đường dẫn mặc định:** `/[controller]/[action]/[params...]` $\rightarrow$ Map đến thư mục `controllers/client/`.
*   **Đường dẫn quản trị:** `/admin/[controller]/[action]/[params...]` $\rightarrow$ Map đến thư mục `controllers/admin/`.

---

## 4. SƠ ĐỒ CƠ SỞ DỮ LIỆU (DATABASE SCHEMA)

Dưới đây là thiết kế chi tiết cho cấu trúc dữ liệu cốt lõi phục vụ luồng sản phẩm và danh mục của hệ thống:

```sql
-- 1. Bảng Danh mục Sản phẩm
CREATE TABLE `product_categories` (
  `_id` VARCHAR(50) PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `thumbnail` VARCHAR(255),
  `status` VARCHAR(50) DEFAULT 'active',
  `position` INT DEFAULT 0,
  `slug` VARCHAR(255),
  `deleted` TINYINT(1) DEFAULT 0,
  `createdAt` DATETIME,
  `updatedAt` DATETIME
);

-- 2. Bảng Sản phẩm
CREATE TABLE `products` (
  `_id` VARCHAR(50) PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `product_category_id` VARCHAR(50),
  `description` TEXT,
  `price` DECIMAL(15, 2) NOT NULL,
  `discountPercentage` INT DEFAULT 0,
  `thumbnail` VARCHAR(255),
  `brand` VARCHAR(255),
  `gender` VARCHAR(50) DEFAULT 'unisex',
  `material` VARCHAR(255),
  `status` VARCHAR(50) DEFAULT 'active',
  `featured` VARCHAR(10) DEFAULT 'no',
  `slug` VARCHAR(255),
  `rating_avg` FLOAT DEFAULT 0,
  `rating_count` INT DEFAULT 0,
  `deleted` TINYINT(1) DEFAULT 0,
  `createdAt` DATETIME,
  `updatedAt` DATETIME,
  FOREIGN KEY (`product_category_id`) REFERENCES `product_categories`(`_id`) ON DELETE SET NULL
);

-- 3. Bảng Hình ảnh chi tiết Sản phẩm (Gallery)
CREATE TABLE `product_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` VARCHAR(50) NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`_id`) ON DELETE CASCADE
);

-- 4. Bảng Biến thể Sản phẩm (Size, Màu sắc & Kho hàng)
CREATE TABLE `product_variants` (
  `_id` VARCHAR(50) PRIMARY KEY,
  `product_id` VARCHAR(50) NOT NULL,
  `color` VARCHAR(50) NOT NULL,
  `size` VARCHAR(50) NOT NULL,
  `stock` INT DEFAULT 0,
  `sku` VARCHAR(100) UNIQUE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`_id`) ON DELETE CASCADE
);
```

---

## 5. HƯỚNG DẪN CÀI ĐẶT & VẬN HÀNH (DEVELOPMENT GUIDE)

### Bước 1: Cài đặt thư viện phụ thuộc
Mở terminal tại thư mục gốc dự án và chạy:
```bash
php composer.phar install
```
*(Nếu hệ thống của bạn đã cài đặt Composer toàn cục, bạn có thể chạy `composer install`)*.

### Bước 2: Cấu hình tệp môi trường
1. Sao chép tệp mẫu cấu hình:
   ```bash
   copy .env.example .env
   ```
2. Mở tệp `.env` vừa tạo và cập nhật các thông số kết nối cơ sở dữ liệu (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`) và tài khoản SMTP gửi mail phục vụ tính năng quên mật khẩu.

### Bước 3: Thiết lập Cơ sở dữ liệu
1. Tạo một cơ sở dữ liệu trống trong MySQL với bảng mã charset là `utf8mb4_unicode_ci` hoặc `utf8_general_ci`.
2. Chạy nội dung SQL từ tệp tài liệu [_ N O T E S/create_new_database.md](file:///c:/xampp/htdocs/LAP_TRING_WEB_010412103103/_%20N%20O%20T%20E%20S/create_new_database.md) để khởi tạo các bảng và nạp dữ liệu mẫu ban đầu.
3. Chạy thêm lệnh SQL cập nhật các cột khôi phục mật khẩu nếu bảng `users` chưa có:
   ```sql
   ALTER TABLE users ADD COLUMN reset_token VARCHAR(255) DEFAULT NULL;
   ALTER TABLE users ADD COLUMN reset_token_expires DATETIME DEFAULT NULL;
   ```

### Bước 4: Khởi chạy máy chủ phát triển
Bạn có thể chạy dự án thông qua XAMPP (Apache) hoặc chạy trực tiếp bằng PHP CLI Server tại cổng `8080`:
```bash
php -S localhost:8080
```
Truy cập ứng dụng tại địa chỉ: [http://localhost:8080](http://localhost:8080).
