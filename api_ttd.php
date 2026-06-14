<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. MENGAMBIL DAFTAR JAMAAH UNTUK DROPDOWN
if ($action == 'list') {
    $sql = "SELECT id, nama, paket FROM jamaah ORDER BY nama ASC";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

// 2. MENYIMPAN TANDA TANGAN BASE64 KE DATABASE
elseif ($action == 'save') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $id = isset($data['id']) ? $data['id'] : '';
    $ttd = isset($data['ttd']) ? $data['ttd'] : '';

    if ($id && $ttd) {
        $stmt = $conn->prepare("UPDATE jamaah SET ttd=? WHERE id=?");
        $stmt->bind_param("si", $ttd, $id);
        
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Data tidak lengkap."]);
    }
}
?>