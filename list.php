<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar File Upload</title>
</head>
<body>
    <h2>📁 Daftar File yang Sudah Diupload</h2>
    <a href="index.html">← Kembali ke Form Upload</a><br><br>

    <?php
    $dir = __DIR__ . "/uploads/"; // pastikan ambil full path absolut
    $web_dir = "uploads/"; // untuk ditampilkan di link

    if (is_dir($dir)) {
        $files = scandir($dir);
        $files = array_diff($files, array('.', '..'));

        if (count($files) > 0) {
            echo "<ul>";
            foreach ($files as $file) {
                $safeName = htmlspecialchars($file);
                $urlName = urlencode($file);
                echo "<li>$safeName - 
                    <a href='{$web_dir}$urlName' download>Download</a> | 
                    <a href='delete.php?file=$urlName' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                </li>";
            }
            echo "</ul>";
        } else {
            echo "<p><i>Tidak ada file dalam folder uploads.</i></p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Folder uploads tidak ditemukan!</p>";
    }
    ?>
</body>
</html>