<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. MENGAMBIL DATA
if ($action == 'get') {
    $sql = "SELECT * FROM jamaah ORDER BY id DESC";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        // Ubah format teks dokumen menjadi array kembali agar terbaca oleh JS
        $row['files'] = !empty($row['dokumen']) ? json_decode($row['dokumen'], true) : [];
        $data[] = $row;
    }
    echo json_encode($data);
}

// 2. MENYIMPAN / MENGEDIT DATA
elseif ($action == 'save') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $nama = $_POST['nama']; $nik = $_POST['nik']; $paspor = $_POST['paspor'];
    
    // Cegah error tanggal kosong
    $exp_paspor = !empty($_POST['expPaspor']) ? $_POST['expPaspor'] : null;
    $tgl_lahir = !empty($_POST['tglLahir']) ? $_POST['tglLahir'] : null;
    $berangkat = !empty($_POST['berangkat']) ? $_POST['berangkat'] : null;
    
    $kelamin = $_POST['kelamin']; $hp = $_POST['hp']; $email = $_POST['email']; 
    $paket = $_POST['paket']; $status = $_POST['status'];
    $mahram = $_POST['mahram']; $alamat = $_POST['alamat'];
    
    // Tanda Tangan Base64
    $ttd = isset($_POST['ttd']) ? $_POST['ttd'] : '';

    // Proses Upload File Fisik
    $uploaded_files = [];
    $upload_dir = 'uploads/';
    
    if(isset($_FILES['files'])) {
        foreach($_FILES['files']['name'] as $key => $filename) {
            if($_FILES['files']['error'][$key] == 0) {
                $tmp_name = $_FILES['files']['tmp_name'][$key];
                // Ganti nama file agar tidak ada spasi dan double
                $new_name = time() . '_' . str_replace(" ", "_", $filename);
                if(move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
                    // Simpan nama file baru beserta ukurannya untuk UI
                    $size = round($_FILES['files']['size'][$key] / 1024, 1) . ' KB';
                    $uploaded_files[] = $new_name . '__' . $size;
                }
            }
        }
    }

    $dokumen_json = json_encode($uploaded_files);

    if ($id) {
        // Proses Update: Gabungkan file lama dengan file baru
        $cek = $conn->query("SELECT dokumen FROM jamaah WHERE id='$id'")->fetch_assoc();
        $file_lama = !empty($cek['dokumen']) ? json_decode($cek['dokumen'], true) : [];
        $file_gabung = array_merge($file_lama, $uploaded_files);
        $dokumen_json = json_encode($file_gabung);

        $stmt = $conn->prepare("UPDATE jamaah SET nama=?, nik=?, paspor=?, exp_paspor=?, kelamin=?, tgl_lahir=?, hp=?, email=?, paket=?, berangkat=?, status=?, mahram=?, alamat=?, ttd=?, dokumen=? WHERE id=?");
        $stmt->bind_param("sssssssssssssssi", $nama, $nik, $paspor, $exp_paspor, $kelamin, $tgl_lahir, $hp, $email, $paket, $berangkat, $status, $mahram, $alamat, $ttd, $dokumen_json, $id);
    } else {
        // Proses Insert
        $stmt = $conn->prepare("INSERT INTO jamaah (nama, nik, paspor, exp_paspor, kelamin, tgl_lahir, hp, email, paket, berangkat, status, mahram, alamat, ttd, dokumen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssss", $nama, $nik, $paspor, $exp_paspor, $kelamin, $tgl_lahir, $hp, $email, $paket, $berangkat, $status, $mahram, $alamat, $ttd, $dokumen_json);
    }
    
    if ($stmt->execute()) { echo json_encode(["status" => "success"]); } 
    else { echo json_encode(["status" => "error", "message" => $stmt->error]); }
}

// 3. MENGHAPUS DATA
elseif ($action == 'delete') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $stmt = $conn->prepare("DELETE FROM jamaah WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) echo json_encode(["status" => "success"]);
}
?>