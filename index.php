<?php
// index.php
include_once("config.php");

// Proses READ untuk publik (menampilkan semua resep)
$query = "SELECT r.id_resep, r.judul, r.deskripsi, r.gambar_path, r.created_at, k.nama_kategori 
          FROM resep r 
          LEFT JOIN kategori k ON r.kategori_id = k.id_kategori 
          ORDER BY r.created_at DESC";
$result = mysqli_query($mysqli, $query);

$resep_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $resep_list[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kumpulan Resep Masakan</title>
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
    
    <div class="container mt-5">
        
        <h1 class="mb-4 text-center">Resep Terbaru Kami</h1>
        <hr class="mb-5">
        
        <?php if (empty($resep_list)): ?>
            <div class="alert alert-info text-center" role="alert">
                <h4 class="alert-heading">Ups!</h4>
                <p>Belum ada resep yang tersedia saat ini. Silakan cek lagi nanti.</p>
            </div>
        <?php else: ?>
            
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                
                <?php foreach ($resep_list as $r): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            
                            <?php if ($r['gambar_path']): ?>
                                <img src="uploads/<?php echo $r['gambar_path']; ?>" 
                                     class="card-img-top" alt="<?php echo htmlspecialchars($r['judul']); ?>" 
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="text-center p-5 bg-secondary text-white" style="height: 200px;">
                                    
                                </div>
                            <?php endif; ?>

                            <div class="card-body">
                                <span class="badge bg-info mb-2"><?php echo htmlspecialchars($r['nama_kategori'] ?? 'Lain-lain'); ?></span>
                                <h5 class="card-title"><?php echo htmlspecialchars($r['judul']); ?></h5>
                                
                                <p class="card-text text-muted">
                                    <?php 
                                        
                                        echo substr(htmlspecialchars($r['deskripsi']), 0, 100); 
                                        if (strlen($r['deskripsi']) > 100) echo '...';
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <a href="detail.php?id=<?php echo $r['id_resep']; ?>" class="btn btn-primary w-100">
                                    Lihat Resep Lengkap
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
            </div>
            
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
