<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. MENGAMBIL DATA (READ)
if ($action == 'get') {
    $sql = "SELECT * FROM paket ORDER BY id DESC";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

// 2. MENYIMPAN / MENGEDIT DATA (CREATE & UPDATE)
elseif ($action == 'save') {
    // Karena form paket tidak ada upload gambar/file fisik, kita pakai php://input biasa
    $data = json_decode(file_get_contents("php://input"), true);
    
    $id = isset($data['id']) ? $data['id'] : '';
    $nama = $data['nama'];
    $durasi = (int)$data['durasi'];
    $hMakkah = $data['hMakkah'];
    $bMakkah = $data['bMakkah'];
    $hMadinah = $data['hMadinah'];
    $maskapai = $data['maskapai'];
    $harga = (int)$data['harga'];
    $kuota = (int)$data['kuota'];
    $berangkat = !empty($data['berangkat']) ? $data['berangkat'] : null;
    $status = $data['status'];
    $fasilitas = $data['fasilitas'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE paket SET nama=?, durasi=?, hMakkah=?, bMakkah=?, hMadinah=?, maskapai=?, harga=?, kuota=?, berangkat=?, status=?, fasilitas=? WHERE id=?");
        $stmt->bind_param("sisssssiissi", $nama, $durasi, $hMakkah, $bMakkah, $hMadinah, $maskapai, $harga, $kuota, $berangkat, $status, $fasilitas, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO paket (nama, durasi, hMakkah, bMakkah, hMadinah, maskapai, harga, kuota, berangkat, status, fasilitas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssssiiss", $nama, $durasi, $hMakkah, $bMakkah, $hMadinah, $maskapai, $harga, $kuota, $berangkat, $status, $fasilitas);
    }
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
}

// 3. MENGHAPUS DATA (DELETE)
elseif ($action == 'delete') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    
    $stmt = $conn->prepare("DELETE FROM paket WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    }
}
?>