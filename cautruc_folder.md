# Tổ chức lại theo tiêu chuẩn PSR (PHP Standard Recommendations)

Dưới đây là cấu trúc thư mục được tối ưu hóa:

## Đề xuất cấu trúc thư mục mới

```text
LAP_TRING_WEB_010412103103/
├── app/                  # Chứa toàn bộ source code logic (thay vì để rời rạc)
│   ├── Controllers/      # Các Controller
│   ├── Models/           # Các Model
│   └── Core/             # Chứa App, Router, Database, Controller cơ sở (Base)
├── config/               # Cấu hình (DB, App settings)
├── public/               # Cửa ngõ duy nhất (Entry point)
│   ├── assets/           # CSS, JS, Images
│   └── index.php         # File duy nhất người dùng truy cập
├── routes/               # Chứa file định nghĩa route (web.php)
├── storage/              # Nơi chứa log, cache, file upload
├── views/                # Chứa các file giao diện
│   ├── layouts/          # Chứa giao diện khung chung (Header, Footer, CSS, JS nhúng)
│   └── pages/            # Chứa giao diện nội dung riêng của từng trang (ví dụ homePage.php)
├── vendor/               # Thư viện ngoài (do Composer tạo)
├── .env                  # Lưu thông tin nhạy cảm (DB_PASS, v.v.)
├── .gitignore            # Loại trừ vendor, .env, log...
└── composer.json

```

Người chơi hệ thuần khiết
