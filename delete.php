<?php
// Cek apakah parameter 'file' ada di URL
if (isset($_GET['file'])) {
    $file = 'uploads/' . basename($_GET['file']); // Hindari path traversal

    // Cek apakah file benar-benar ada
    if (file_exists($file)) {
        // Hapus file
        if (unlink($file)) {
            echo "File <strong>" . htmlspecialchars($_GET['file']) . "</strong> berhasil dihapus.<br>";
        } else {
            echo "Terjadi kesalahan saat menghapus file.<br>";
        }
    } else {
        echo "File tidak ditemukan.<br>";
    }

    echo "<br><a href='index.html'>Kembali</a>";
} else {
    echo "Tidak ada file yang dipilih untuk dihapus.<br>";
    echo "<br><a href='index.html'>Kembali</a>";
}