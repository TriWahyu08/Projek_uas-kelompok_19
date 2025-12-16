<?php
// admin/dashboard.php
include_once("../config.php");
protect_page(); // Panggil fungsi proteksi

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body class="bg-light">
    
    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard Administrator</h2>
            <a href="../auth/logout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
        
        <hr class="my-3 border-primary border-2">

        <div class="card shadow-sm mb-5 border-0" style="background-color: #ffdcedff;">
            <div class="card-body">
                <h5 class="card-title">Selamat datang, <?php echo htmlspecialchars($username); ?>! 👋</h5>
                <p class="card-text text-muted">Role Anda saat ini: <span class="badge bg-primary"><?php echo htmlspecialchars($role); ?></span></p>
                <p class="mb-0">Pilih menu di bawah untuk mulai mengelola konten resep Anda.</p>
            </div>
        </div>
        
        <h3>Menu Utama</h3>
        <hr>

        <div class="row g-4">
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-info border-3 border-start">
                    <div class="card-body">
                        <h5 class="card-title text-info">Kelola Resep</h5>
                        <p class="card-text">Tambah, Edit, dan Hapus data Resep Masakan. Selamat mengelola resep Anda.</p>
                        <a href="resep_index.php" class="btn btn-info text-white w-100">
                            <i class="bi bi-journal-text"></i> Buka Kelola Resep
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-warning border-3 border-start">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Kelola Kategori</h5>
                        <p class="card-text">Kelola kategori Anda untuk mengelompokkan resep (misalnya: Nusantara, Berkuah, Kering, Minuman, dll).</p>
                        <a href="kategori_crud.php" class="btn btn-warning text-white w-100">
                            <i class="bi bi-tags"></i> Buka Kelola Kategori
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-secondary border-3 border-start">
                    <div class="card-body">
                        <h5 class="card-title text-secondary">Lihat Beranda</h5>
                        <p class="card-text">Lihat tampilan publik aplikasi resep Anda Untuk Memilih Menu.</p>
                        <a href="../index.php" class="btn btn-secondary w-100" target="_blank">
                            <i class="bi bi-house"></i> Kunjungi Beranda
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        
        <h3 class="mt-5">Informasi Sistem</h3>
        <hr>
        <div class="alert alert-info" role="alert">
            Area ini adalah area yang dilindungi (protected area). Akses hanya diberikan setelah proses login berhasil.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
