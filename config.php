<?php
// config.php
$databaseHost = 'localhost';
$databaseName = 'proyek_resep_db';
$databaseUsername = 'root';
$databasePassword = '';

// Buat Koneksi
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

/**
 */
function protect_page() {
    // Memastikan session sudah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Pengecekan status login
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Arahkan ke halaman login (sesuaikan path jika perlu)
        header("Location: /proyek_resep/auth/login.php"); 
        exit();
    }
}

/**
 * Fungsi untuk menampilkan kategori dalam bentuk dropdown/select
 */
function get_kategori($mysqli) {
    $result = mysqli_query($mysqli, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
    $kategori = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kategori[] = $row;
    }
    return $kategori;
}
?>
