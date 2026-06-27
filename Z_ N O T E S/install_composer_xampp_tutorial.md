# Composer Installation Tutorial for XAMPP

## Mục tiêu
Hướng dẫn cài đặt **Composer** trên môi trường XAMPP (Windows) và sử dụng để cài đặt các phụ thuộc của dự án hiện tại.

---

## 1️⃣ Kiểm tra PHP của XAMPP
XAMPP đã đi kèm với PHP. Mở **PowerShell** và chạy:

```powershell
C:\xampp\php\php.exe -v
```

Nếu hiển thị phiên bản PHP, bạn đã có PHP trong hệ thống.

---

## 2️⃣ Tải và cài đặt Composer
### Bước 2.1: Tải script cài đặt
```powershell
C:\xampp\php\php.exe -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
```

### Bước 2.2: Kiểm tra hash (đảm bảo an toàn)
- Truy cập https://getcomposer.org/download/ để lấy **SHA‑384** mới nhất.
- Thay `<HASH>` trong lệnh dưới bằng giá trị vừa sao chép.
```powershell
$hash = '<HASH>'
if ((Get-FileHash composer-setup.php -Algorithm SHA384).Hash -eq $hash) { Write-Host 'Installer verified' } else { Write-Host 'Installer corrupt'; Remove-Item composer-setup.php; exit 1 }
```

### Bước 2.3: Cài đặt Composer toàn cục
```powershell
C:\xampp\php\php.exe composer-setup.php --install-dir=C:\xampp\php --filename=composer
```
Sau khi chạy, sẽ tạo file `composer.exe` trong thư mục PHP của XAMPP.

### Bước 2.4: Xóa script cài đặt
```powershell
Remove-Item composer-setup.php
```

---

## 3️⃣ Kiểm tra Composer
```powershell
C:\xampp\php\composer --version
```
Nếu hiển thị phiên bản, Composer đã sẵn sàng.

---

## 4️⃣ Thêm Composer vào PATH (tùy chọn, để gọi `composer` từ bất kỳ vị trí nào)
1. Mở **System Properties → Advanced → Environment Variables**.
2. Trong **System variables**, chọn `Path` → **Edit** → **New** và nhập:
   ```
   C:\xampp\php
   ```
3. Nhấn **OK** và mở lại PowerShell.
4. Kiểm tra lại:
   ```powershell
   composer --version
   ```

---

## 5️⃣ Cài đặt phụ thuộc dự án
Di chuyển tới thư mục dự án và chạy Composer:
```powershell
cd C:\xampp\htdocs\LAP_TRING_WEB_010412103103
composer install --no-interaction
```
Lệnh này sẽ tải các gói được liệt kê trong `composer.json` và tạo thư mục `vendor/`.

---

## 6️⃣ Kiểm tra dự án
Sau khi cài đặt thành công, bạn có thể khởi động XAMPP và truy cập dự án tại:
```
http://localhost/LAP_TRING_WEB_010412103103/
```

---

## 📌 Lưu ý
- Nếu bạn gặp lỗi "`composer` not recognized", chắc chắn rằng **PATH** đã được cập nhật và mở lại terminal.
- Khi nâng cấp XAMPP hoặc di chuyển thư mục PHP, cần cập nhật lại đường dẫn trong PATH.
- Đối với máy không có quyền admin, bạn có thể cài Composer **cục bộ** bằng cách bỏ `--install-dir` và dùng `php composer.phar` thay thế `composer`.

---

*File này được tạo tự động để hỗ trợ việc cài đặt Composer trên môi trường XAMPP.*
