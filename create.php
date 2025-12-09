<?php
header("Content-Type: application/json");
include 'koneksi.php';

$nama_depan    = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$email         = $_POST['email'] ?? '';
$username      = $_POST['username'] ?? '';
$password      = $_POST['password'] ?? '';

$foto_path = "";
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
    
    $file_name = time() . "_" . basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . $file_name;
    
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $foto_path = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . $target_file;
    }
}

try {
    if(empty($username) || empty($email)) {
        echo json_encode(["status" => "error", "message" => "Username dan Email wajib diisi"]);
        exit();
    }

    $sql = "INSERT INTO users (nama_depan, nama_belakang, email, username, password, photo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nama_depan, $nama_belakang, $email, $username, $password, $foto_path]);

    echo json_encode(["status" => "success", "message" => "Data berhasil ditambahkan"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
