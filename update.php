<?php
header("Content-Type: application/json");
include 'koneksi.php';

$id            = $_POST['id'] ?? null;
$nama_depan    = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';

if(!$id) {
    echo json_encode(["status" => "error", "message" => "ID tidak ditemukan"]);
    exit();
}

try {
    $sql = "UPDATE users SET nama_depan = ?, nama_belakang = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nama_depan, $nama_belakang, $id]);

    echo json_encode(["status" => "success", "message" => "Data berhasil diupdate"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
