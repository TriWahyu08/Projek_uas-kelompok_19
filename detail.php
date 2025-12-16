<?php
// detail.php
include_once("config.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    // Jika ID tidak valid, redirect ke beranda
    header("Location: index.php");
    exit();
}

// Proses READ detail resep
$query = "SELECT r.*, k.nama_kategori 
          FROM resep r 
          LEFT JOIN kategori k ON r.kategori_id = k.id_kategori 
          WHERE r.id_resep = $id";
$result = mysqli_query($mysqli, $query);
$resep = mysqli_fetch_assoc($result);

if (!$resep) {
    // Jika resep tidak ditemukan
    header("Location: index.php?error=Resep tidak ditemukan.");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($resep['judul']); ?> - Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">Web Resep Masakan</a>
            <div class="ms-auto">
                <a href="auth/login.php" class="btn btn-outline-light btn-sm">Login Admin</a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5 mb-5">
        
        <a href="index.php" class="btn btn-outline-secondary mb-4">
            &laquo; Kembali ke Daftar Resep
        </a>
        
        <div class="card shadow-lg border-0">
            <div class="row g-0">
                
                <div class="col-md-5">
                    <?php if ($resep['gambar_path']): ?>
                        <img src="uploads/<?php echo $resep['gambar_path']; ?>" 
                             class="img-fluid rounded-start" 
                             alt="<?php echo htmlspecialchars($resep['judul']); ?>"
                             style="height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <div class="p-5 bg-secondary text-white text-center rounded-start" style="height: 100%;">
                            <h4 class="mt-5">Gambar Tidak Tersedia</h4>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-7">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="card-title mb-1"><?php echo htmlspecialchars($resep['judul']); ?></h1>
                        <span class="badge bg-info mb-4 fs-6"><?php echo htmlspecialchars($resep['nama_kategori'] ?? 'Lain-lain'); ?></span>
                        
                        <h5 class="mt-3 text-muted">Deskripsi Singkat</h5>
                        <p class="lead"><?php echo nl2br(htmlspecialchars($resep['deskripsi'])); ?></p>
                        
                        <hr class="my-4">

                        <h4 class="text-primary">Bahan-bahan</h4>
                        <ul class="list-group list-group-flush mb-4">
                            <?php 
                            // Memecah bahan-bahan per baris dan menampilkannya sebagai list
                            $bahan_array = explode("\n", $resep['bahan']);
                            foreach ($bahan_array as $bahan_item) {
                                $bahan_item = trim($bahan_item);
                                if (!empty($bahan_item)) {
                                    echo '<li class="list-group-item">' . htmlspecialchars($bahan_item) . '</li>';
                                }
                            }
                            ?>
                        </ul>
                        
                        <h4 class="text-success mt-4">Langkah-langkah Memasak</h4>
                        <div class="langkah-memasak-container">
                            <?php
                            // Menggunakan PREG_SPLIT untuk memecah langkah-langkah per baris 
                            // (lebih aman untuk menangani \r\n atau \n dari database)
                            $langkah_array = preg_split("/\r\n|\n/", $resep['langkah']);
                            $is_ul_open = false;
    
                            // Mulai dengan <ol> (list berurutan), dan gunakan class list-unstyled
                            // agar kita bisa mengatur styling list secara custom (tidak tergantung list-group-numbered yang bermasalah)
                            echo '<ol class="list-unstyled">'; 
    
                            foreach ($langkah_array as $baris) {
                            $baris = trim($baris); 
                            if (empty($baris)) continue; // Lewati baris kosong
                            
                            // Cek apakah baris ini adalah sub-poin (ditandai dengan '-')
                            if (strpos($baris, '-') === 0) {
                                if (!$is_ul_open) {
                                    // Buka sub-list (unordered list/bullet point)
                                    echo '<ul>'; 
                                    $is_ul_open = true;
                                }
                                // Tampilkan sebagai list item dari sub-list (dihilangkan tanda -)
                                echo '<li>' . trim(substr($baris, 1)) . '</li>';
                            } else {
                                // Jika ini adalah poin utama (A., B., C., dll)
                                if ($is_ul_open) {
                                    // Tutup sub-list jika sedang terbuka
                                    echo '</ul>'; 
                                    $is_ul_open = false;
                                }
                                // Tampilkan sebagai list item utama (diberi tag <strong> untuk menonjolkan)
                                echo '<li class="mt-2"><strong>' . $baris . '</strong></li>';
                            }
                        }
    
                        // Pastikan semua tag ditutup
                        if ($is_ul_open) {
                            echo '</ul>';
                        }
                        echo '</ol>';
                    ?>
                </div>
                        
                        <p class="text-end text-muted mt-4"><small>Diunggah pada: <?php echo date('d M Y', strtotime($resep['created_at'])); ?></small></p>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>