<?php
// admin/resep_edit.php
include_once("../config.php");
protect_page();

$error = '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$kategori_list = get_kategori($mysqli);

// 1. Fetch data lama untuk ditampilkan di form
$result = mysqli_query($mysqli, "SELECT * FROM resep WHERE id_resep=$id");
$resep_data = mysqli_fetch_assoc($result);

if (!$resep_data) {
    header("Location: resep_index.php?error=" . urlencode("Resep tidak ditemukan."));
    exit();
}

// 2. Proses UPDATE (jika form disubmit)
if (isset($_POST['update_resep'])) {
    $judul = mysqli_real_escape_string($mysqli, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($mysqli, $_POST['deskripsi']);
    $bahan = mysqli_real_escape_string($mysqli, $_POST['bahan']);
    $langkah = mysqli_real_escape_string($mysqli, $_POST['langkah']);
    $kategori_id = (int)$_POST['kategori_id'];
    $gambar_path = $resep_data['gambar_path']; // Pertahankan gambar lama

    $update_gambar_query = '';

    // Proses Upload File Baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        // Logika upload file baru
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_name = uniqid() . '-' . basename($_FILES['gambar']['name']);
        $upload_dir = '../uploads/';
        
        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            // Hapus gambar lama jika ada
            $old_file = '../uploads/' . $resep_data['gambar_path'];
            if (file_exists($old_file) && is_file($old_file) && !empty($resep_data['gambar_path'])) {
                unlink($old_file);
            }
            $gambar_path = mysqli_real_escape_string($mysqli, $file_name);
            $update_gambar_query = ", gambar_path='$gambar_path'";
        } else {
            $error = 'Gagal upload file gambar baru.';
        }
    }
    
    if (!$error) {
        // Query UPDATE
        $query = "UPDATE resep SET 
                  judul='$judul', 
                  deskripsi='$deskripsi', 
                  bahan='$bahan', 
                  langkah='$langkah', 
                  kategori_id='$kategori_id'
                  $update_gambar_query
                  WHERE id_resep=$id";

        if (mysqli_query($mysqli, $query)) {
            header("Location: resep_index.php?success=" . urlencode("Resep **$judul** berhasil diperbarui."));
            exit();
        } else {
            $error = "Gagal memperbarui resep: " . mysqli_error($mysqli);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Resep: <?php echo htmlspecialchars($resep_data['judul']); ?></h2>
        
        <a href="resep_index.php" class="btn btn-secondary mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Resep
        </a>
        <hr>
        
        <?php if ($error) echo "<div class='alert alert-danger' role='alert'>$error</div>"; ?>

        <form method="post" action="resep_edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Resep <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($resep_data['judul']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="kategori_id" name="kategori_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori_list as $k): ?>
                                <option value="<?php echo $k['id_kategori']; ?>" <?php echo $k['id_kategori'] == $resep_data['kategori_id'] ? 'selected' : ''; ?>>
                                    <?php echo $k['nama_kategori']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo htmlspecialchars($resep_data['deskripsi']); ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label>
                        <div class="p-2 border rounded text-center">
                            <?php if ($resep_data['gambar_path']): ?>
                                <img src="../uploads/<?php echo $resep_data['gambar_path']; ?>" class="img-fluid rounded" style="max-height: 200px;" alt="Gambar Resep"><br>
                                <small class="text-muted">File: <?php echo htmlspecialchars($resep_data['gambar_path']); ?></small>
                            <?php else: ?>
                                <p class="text-muted mb-0">Tidak ada gambar saat ini.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Ganti Gambar</label>
                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengganti gambar.</div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">

            <div class="mb-3">
                <label for="bahan" class="form-label">Bahan-bahan (Pisahkan per baris) <span class="text-danger">*</span></label>
                <textarea class="form-control" id="bahan" name="bahan" rows="7" required><?php echo htmlspecialchars($resep_data['bahan']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="langkah" class="form-label">Langkah-langkah Memasak (Pisahkan per baris) <span class="text-danger">*</span></label>
                <textarea class="form-control" id="langkah" name="langkah" rows="10" required><?php echo htmlspecialchars($resep_data['langkah']); ?></textarea>
            </div>
            
            <button type="submit" name="update_resep" class="btn btn-warning btn-lg mt-3 text-white">
                <i class="bi bi-arrow-clockwise"></i> Update Resep
            </button>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
