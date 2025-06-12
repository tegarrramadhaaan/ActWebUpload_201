<?php
$target_dir = "uploads/";
if (!file_exists($target_dir)) mkdir($target_dir, 0755, true);

$fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
$newFileName = uniqid() . '.' . $fileType;
$target_file = $target_dir . $newFileName;
$uploadOk = 1;

// Validasi ukuran
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<p style='color:red;'>❌ File terlalu besar.</p>";
    $uploadOk = 0;
}

// Format yang diperbolehkan
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
if (!in_array($fileType, $allowed)) {
    echo "<p style='color:red;'>❌ Format tidak didukung.</p>";
    $uploadOk = 0;
}

// Validasi gambar hanya jika tipe gambar
if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
    if (getimagesize($_FILES["fileToUpload"]["tmp_name"]) === false) {
        echo "<p style='color:red;'>❌ File bukan gambar yang valid.</p>";
        $uploadOk = 0;
    }
}

if ($uploadOk && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "<p style='color:green;'>✅ File berhasil diunggah.</p>";
} elseif ($uploadOk) {
    echo "<p style='color:red;'>❌ Gagal mengunggah file.</p>";
} else {
    echo "<p style='color:red;'>❌ Unggah dibatalkan.</p>";
}

// Tampilkan daftar file
echo "<hr><h2 style='text-align:center;'>📂 File yang Telah Diunggah</h2>";
echo "<div style='display:flex;flex-wrap:wrap;gap:20px;justify-content:center;font-family:Segoe UI;'>";

$files = array_diff(scandir($target_dir), ['.', '..']);
foreach ($files as $file) {
    $filePath = $target_dir . $file;
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    echo "<div style='text-align:center;width:150px;padding:10px;border-radius:10px;background:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.1);'>";
    
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<img src='$filePath' style='width:100%;max-height:100px;object-fit:cover;border-radius:8px;'><br>";
    } elseif ($ext === 'pdf') {
        echo "<iframe src='$filePath' style='width:100%;height:100px;border:none;'></iframe><br>";
    } else {
        echo "<span>📄 $ext</span><br>";
    }

    echo "
        <small>$file</small><br><br>
        <a href='$filePath' download style='text-decoration:none;color:#28a745;'>⬇ Unduh</a> | 
        <a href='delete.php?file=" . urlencode($file) . "' onclick='return confirm(\"Yakin ingin menghapus?\")' style='text-decoration:none;color:#dc3545;'>🗑 Hapus</a>
    </div>";
}
echo "</div><br><div style='text-align:center;'><a href='index.html'>⬅ Kembali ke Form</a></div>";
?>
