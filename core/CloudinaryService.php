<?php

namespace Core;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Exception;

class CloudinaryService
{
    private static $initialized = false;

    /**
     * Khởi tạo cấu hình kết nối Cloudinary.
     * Tự động gọi trước mỗi thao tác gọi API.
     */
    private static function init()
    {
        if (!self::$initialized) {
            // Cấu hình dựa trên biến môi trường từ file .env
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'] ?? '',
                    'api_key'    => $_ENV['CLOUDINARY_API_KEY'] ?? '',
                    'api_secret' => $_ENV['CLOUDINARY_API_SECRET'] ?? '',
                ],
                'url' => [
                    'secure' => true // Luôn sử dụng HTTPS
                ]
            ]);
            self::$initialized = true;
        }
    }

    /**
     * Tải file lên Cloudinary
     * * @param string $filePath Đường dẫn file tạm (thường là $_FILES['image']['tmp_name'])
     * @param string $folder   Thư mục đích trên Cloudinary (Mặc định: 'gearx/products')
     * @param array  $options  Các tùy chọn bổ sung (VD: gắn tag, upload_preset...)
     * * @return array|false     Trả về mảng chứa URL và Public ID nếu thành công, false nếu lỗi
     */
    public static function upload($filePath, $folder = 'gearx/products', $options = [])
    {
        self::init();

        try {
            // Các thiết lập mặc định (Best Practice)
            $defaultOptions = [
                'folder' => $folder,
                'use_filename' => true,      // Giữ tên file gốc
                'unique_filename' => true,   // Thêm chuỗi ngẫu nhiên để tránh trùng lặp
                'overwrite' => true,         // Ghi đè nếu public_id đã tồn tại
                'resource_type' => 'auto'    // Tự động nhận diện ảnh/video
                
                // 'upload_preset' => 'gearx_preset' // Bỏ comment nếu bạn đã tạo Preset trên Dashboard
            ];

            // Gộp các thiết lập mặc định với các thiết lập truyền từ Controller
            $finalOptions = array_merge($defaultOptions, $options);

            $uploadApi = new UploadApi();
            $response = $uploadApi->upload($filePath, $finalOptions);

            // Trả về dữ liệu quan trọng để lưu vào Database
            return [
                'secure_url' => $response['secure_url'], // URL để hiển thị ảnh
                'public_id'  => $response['public_id'],  // Định danh dùng để xóa/sửa sau này
                'format'     => $response['format'],     // Định dạng ảnh (jpg, png, webp...)
                'bytes'      => $response['bytes']       // Dung lượng ảnh
            ];

        } catch (Exception $e) {
            // Ghi log lỗi để dễ dàng debug
            error_log("Cloudinary Upload Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa ảnh khỏi hệ thống Cloudinary (Garbage Collection)
     * Thường gọi trong Controller khi người dùng đổi ảnh mới hoặc xóa sản phẩm.
     * * @param string $publicId Mã định danh Public ID của ảnh trên Cloudinary
     * @return bool            True nếu xóa thành công, False nếu thất bại
     */
    public static function delete($publicId)
    {
        self::init();

        // Không xử lý nếu không có publicId hợp lệ
        if (empty($publicId)) {
            return false;
        }

        try {
            $uploadApi = new UploadApi();
            $response = $uploadApi->destroy($publicId);
            
            // Cloudinary trả về 'ok' nếu xóa thành công, hoặc 'not found' nếu ảnh đã bị xóa từ trước
            return (isset($response['result']) && in_array($response['result'], ['ok', 'not found']));

        } catch (Exception $e) {
            error_log("Cloudinary Delete Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Kiểm tra cấu hình kết nối Cloudinary có hoạt động chính xác không
     * 
     * @return array Trả về mảng ['success' => true/false, 'message' => '...']
     */
    public static function ping()
    {
        self::init();
        
        $config = Configuration::instance();
        if (empty($config->cloud->cloudName) || empty($config->cloud->apiKey) || empty($config->cloud->apiSecret)) {
            return [
                'success' => false,
                'message' => 'Cấu hình thiếu thông tin Cloudinary (Cloud Name, API Key hoặc API Secret).'
            ];
        }

        try {
            // Sử dụng Admin API của Cloudinary để ping kiểm tra kết nối
            $adminApi = new \Cloudinary\Api\Admin\AdminApi();
            $adminApi->ping();
            
            return [
                'success' => true,
                'message' => 'Kết nối Cloudinary thành công!'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi kết nối Cloudinary: ' . $e->getMessage()
            ];
        }
    }
}