<?php
header("Content-Type: application/json");
include 'koneksi.php';

$id = $_POST['id'] ?? null;

if(!$id) {
    echo json_encode(["status" => "error", "message" => "ID tidak ditemukan"]);
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["status" => "success", "message" => "Data berhasil dihapus"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
