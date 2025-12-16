<?php
// admin/kategori_crud.php
include_once("../config.php");
protect_page();

$pesan = '';

// Proses CREATE dan UPDATE
if (isset($_POST['submit_kategori'])) {
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama_kategori']);
    $id = isset($_POST['id_kategori']) ? (int)$_POST['id_kategori'] : 0;

    if ($id > 0) {
        // Update
        $query = "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori=$id";
        $pesan = 'Kategori berhasil diperbarui!';
    } else {
        // Create
        $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";
        $pesan = 'Kategori berhasil ditambahkan!';
    }
    
    if (mysqli_query($mysqli, $query)) {
        header("Location: kategori_crud.php?success=" . urlencode($pesan));
        exit();
    } else {
        $pesan = "Gagal memproses data: " . mysqli_error($mysqli);
    }
}

// Proses DELETE
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    
    // PERINGATAN: Jika kategori ini memiliki relasi ke resep, Anda mungkin perlu menangani
    // error FOREIGN KEY jika setingannya adalah RESTRICT. Karena Anda menggunakan
    // ON DELETE SET NULL, proses ini seharusnya aman.
    
    $query = "DELETE FROM kategori WHERE id_kategori=$id";
    if (mysqli_query($mysqli, $query)) {
        header("Location: kategori_crud.php?success=" . urlencode("Kategori berhasil dihapus."));
        exit();
    } else {
        $pesan = "Gagal menghapus kategori: " . mysqli_error($mysqli);
    }
}

// Proses READ (Fetch semua kategori)
$kategori_list = get_kategori($mysqli);

// Proses Fetch untuk Edit (jika ada parameter edit_id)
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $id = (int)$_GET['edit_id'];
    $result = mysqli_query($mysqli, "SELECT * FROM kategori WHERE id_kategori=$id");
    $edit_data = mysqli_fetch_assoc($result);
}

// Tampilkan pesan sukses dari redirect
if (isset($_GET['success'])) {
    $pesan = htmlspecialchars($_GET['success']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Kelola Kategori Resep</h2>
        
        <div class="mb-4">
            <a href="dashboard.php" class="btn btn-secondary btn-sm me-2">
                <i class="bi bi-speedometer"></i> Dashboard
            </a>
            <a href="resep_index.php" class="btn btn-info btn-sm text-white">
                <i class="bi bi-journal-text"></i> Kelola Resep
            </a>
        </div>
        <hr>
        
        <?php if ($pesan): ?>
            <div class="alert alert-<?php echo strpos($pesan, 'Gagal') !== false ? 'danger' : 'success'; ?> alert-dismissible fade show" role="alert">
                <?php echo $pesan; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?php echo $edit_data ? 'Edit Kategori' : 'Tambah Kategori Baru'; ?></h5>
            </div>
            <div class="card-body">
                <form method="post" action="kategori_crud.php" class="d-flex align-items-center">
                    <input type="hidden" name="id_kategori" value="<?php echo $edit_data ? $edit_data['id_kategori'] : ''; ?>">
                    
                    <div class="me-3 flex-grow-1">
                        <label for="nama_kategori" class="form-label visually-hidden">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" 
                               value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama_kategori']) : ''; ?>" 
                               placeholder="Masukkan Nama Kategori Baru" required>
                    </div>

                    <button type="submit" name="submit_kategori" class="btn btn-<?php echo $edit_data ? 'warning text-white' : 'success'; ?>">
                        <i class="bi bi-check-circle"></i> <?php echo $edit_data ? 'Update' : 'Simpan'; ?>
                    </button>
                    
                    <?php if ($edit_data): ?>
                        <a href="kategori_crud.php" class="btn btn-secondary ms-2">Batal Edit</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        
        <h3 class="mt-5 mb-3">Daftar Kategori</h3>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th>Nama Kategori</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kategori_list)): ?>
                        <tr><td colspan="3" class="text-center text-muted">Belum ada data kategori.</td></tr>
                    <?php else: ?>
                        <?php foreach ($kategori_list as $k): ?>
                            <tr>
                                <td><?php echo $k['id_kategori']; ?></td>
                                <td><?php echo htmlspecialchars($k['nama_kategori']); ?></td>
                                <td>
                                    <a href="kategori_crud.php?edit_id=<?php echo $k['id_kategori']; ?>" class="btn btn-sm btn-warning me-2 text-white">Edit</a>
                                    <a href="kategori_crud.php?delete_id=<?php echo $k['id_kategori']; ?>" 
                                       onclick="return confirm('Menghapus kategori akan membuat resep yang terhubung menjadi Tidak Terkategori. Yakin ingin menghapus?');" 
                                       class="btn btn-sm btn-danger">Hapus</a>
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
