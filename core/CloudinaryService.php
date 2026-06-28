<?php
namespace Core;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryService
{
    private static $initialized = false;

    private static function init()
    {
        if (!self::$initialized) {
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => env('CLOUD_NAME'), 
                    'api_key'    => env('CLOUD_KEY'), 
                    'api_secret' => env('CLOUD_SECRET')
                ],
                'url' => [
                    'secure' => true
                ]
            ]);
            self::$initialized = true;
        }
    }

    /**
     * Upload một file ảnh lên Cloudinary
     * 
     * @param string $filePath Đường dẫn file thật trên server (ví dụ: $_FILES['image']['tmp_name'])
     * @param string $folder Thư mục lưu trên Cloudinary (mặc định: 'gearx')
     * @return string|false URL an toàn của ảnh sau khi upload hoặc false nếu lỗi
     */

    
    public static function upload($filePath, $folder = 'gearx')
    {
        self::init();

        try {
            $uploadApi = new UploadApi();
            $response = $uploadApi->upload($filePath, [
                'folder' => $folder
            ]);

            return $response['secure_url'];
        } catch (\Exception $e) {
            error_log("Cloudinary Upload Error: " . $e->getMessage());
            return false;
        }
    }
}
