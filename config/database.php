<?php
$host = "localhost";
$port = "3306";               
$dbname = "GearX";            
$username = "root";           
$password = "";   //Loc25251325#

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}

echo "<script>console.log('Kết nối cơ sở dữ liệu thành công!');</script>";
?>