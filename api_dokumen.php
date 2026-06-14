<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. MENGAMBIL DATA JAMAAH & DOKUMEN (READ)
if ($action == 'list') {
    $sql = "SELECT id, nama, dokumen FROM jamaah ORDER BY nama ASC";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        // Decode JSON dokumen dari database menjadi array
        $row['files'] = !empty($row['dokumen']) ? json_decode($row['dokumen'], true) : [];
        $data[] = $row;
    }
    echo json_encode($data);
}

// 2. MENGUNGGAH DOKUMEN BARU (UPLOAD)
elseif ($action == 'upload') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $upload_dir = 'uploads/';
    $uploaded_files = [];

    // Ambil data file lama dari database
    $cek = $conn->query("SELECT dokumen FROM jamaah WHERE id='$id'")->fetch_assoc();
    $file_lama = !empty($cek['dokumen']) ? json_decode($cek['dokumen'], true) : [];

    // Proses unggah file fisik
    if(isset($_FILES['files'])) {
        foreach($_FILES['files']['name'] as $key => $filename) {
            if($_FILES['files']['error'][$key] == 0) {
                $tmp_name = $_FILES['files']['tmp_name'][$key];
                
                // Buat nama file unik (Waktu + Nama Asli tanpa spasi)
                $new_name = time() . '_' . str_replace(" ", "_", $filename);
                
                if(move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
                    $size = round($_FILES['files']['size'][$key] / 1024, 1) . ' KB';
                    $jenis = $_POST['jenis'][$key]; // Ambil jenis dokumen dari JS
                    
                    // Format simpan: [Jenis] NamaFile__Ukuran
                    $uploaded_files[] = "[$jenis] " . $new_name . '__' . $size;
                }
            }
        }
    }

    // Gabungkan file lama dengan file yang baru diunggah
    $file_gabung = array_merge($file_lama, $uploaded_files);
    $dokumen_json = json_encode($file_gabung);

    // Update kolom dokumen di tabel jamaah
    $stmt = $conn->prepare("UPDATE jamaah SET dokumen=? WHERE id=?");
    $stmt->bind_param("si", $dokumen_json, $id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
}
?>