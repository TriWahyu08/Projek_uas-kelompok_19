<?php
// admin/resep_index.php
include_once("../config.php");
protect_page();

// Proses DELETE
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    
    // 1. Ambil path gambar
    $result = mysqli_query($mysqli, "SELECT gambar_path FROM resep WHERE id_resep=$id");
    $resep = mysqli_fetch_assoc($result);
    // Pastikan path relatif benar
    $file_to_delete = '../uploads/' . $resep['gambar_path']; 

    // 2. Hapus data dari database
    $query = "DELETE FROM resep WHERE id_resep=$id";
    
    if (mysqli_query($mysqli, $query)) {
        // 3. Hapus file gambar dari server
        if (file_exists($file_to_delete) && is_file($file_to_delete)) {
            unlink($file_to_delete);
        }
        header("Location: resep_index.php?success=" . urlencode("Resep berhasil dihapus."));
        exit();
    } else {
        $pesan = "Gagal menghapus resep: " . mysqli_error($mysqli);
    }
}

// Proses READ (Fetch semua resep dengan nama kategori menggunakan LEFT JOIN)
$query = "SELECT r.*, k.nama_kategori 
          FROM resep r 
          LEFT JOIN kategori k ON r.kategori_id = k.id_kategori 
          ORDER BY r.created_at DESC";
$result = mysqli_query($mysqli, $query);

$resep_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $resep_list[] = $row;
}

// Menangani pesan sukses/error dari redirect
$pesan = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
$error_msg = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Kelola Resep Masakan</h2>
        
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <a href="dashboard.php" class="btn btn-secondary me-2">Dashboard</a>
                <a href="kategori_crud.php" class="btn btn-info text-white">Kelola Kategori</a>
            </div>
            <a href="resep_add.php" class="btn btn-primary">Tambah Resep Baru</a>
        </div>
        <hr>
        
        <?php if ($pesan): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $pesan; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($error_msg): ?>
            <div class="alert alert-danger" role="alert"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Judul Resep</th>
                        <th>Kategori</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($resep_list)): ?>
                        <tr><td colspan="5" class="text-center">Belum ada data resep.</td></tr>
                    <?php else: ?>
                        <?php foreach ($resep_list as $r): ?>
                            <tr>
                                <td><?php echo $r['id_resep']; ?></td>
                                <td>
                                    <?php if ($r['gambar_path']): ?>
                                        <img src="../uploads/<?php echo $r['gambar_path']; ?>" width="70" class="img-thumbnail">
                                    <?php else: ?>
                                        <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($r['judul']); ?></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($r['nama_kategori'] ?? 'Tidak Terkategori'); ?></span></td>
                                <td>
                                    <a href="resep_edit.php?id=<?php echo $r['id_resep']; ?>" class="btn btn-warning btn-sm text-white me-2">Edit</a>
                                    <a href="resep_index.php?delete_id=<?php echo $r['id_resep']; ?>" 
                                       onclick="return confirm('ANDA YAKIN MENGHAPUS RESEP INI? Tindakan ini permanen!');" 
                                       class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
