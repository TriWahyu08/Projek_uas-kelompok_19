<?php
// admin/resep_add.php
include_once("../config.php");
protect_page();

$error = '';
// Memastikan $mysqli tersedia di sini (dari config.php)
$kategori_list = get_kategori($mysqli); // Ambil list kategori

if (isset($_POST['submit_resep'])) {
    // Pengecekan dan Sanitasi Input
    $judul = mysqli_real_escape_string($mysqli, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($mysqli, $_POST['deskripsi']);
    $bahan = mysqli_real_escape_string($mysqli, $_POST['bahan']);
    $langkah = mysqli_real_escape_string($mysqli, $_POST['langkah']);
    $kategori_id = (int)$_POST['kategori_id'];
    $gambar_path = '';

    // Proses Upload File (Bagian ini tidak berubah, hanya perlu memastikan path dan izin)
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['gambar']['tmp_name'];
        // Menggunakan uniqid() untuk nama file unik
        $file_name = uniqid() . '-' . basename($_FILES['gambar']['name']); 
        $upload_dir = '../uploads/';
        
        if (!is_dir($upload_dir)) { 
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            $gambar_path = mysqli_real_escape_string($mysqli, $file_name);
        } else {
            $error = 'Gagal upload file gambar.';
        }
    } else {
        // Jika file required tapi gagal upload (error selain OK)
        if ($_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
             $error = 'Terjadi kesalahan saat upload file.';
        }
    }
    
    if (!$error) {
        // Query INSERT
        $query = "INSERT INTO resep (judul, deskripsi, bahan, langkah, kategori_id, gambar_path) 
                  VALUES ('$judul', '$deskripsi', '$bahan', '$langkah', '$kategori_id', '$gambar_path')";

        if (mysqli_query($mysqli, $query)) {
            header("Location: resep_index.php?success=" . urlencode("Resep **$judul** berhasil ditambahkan."));
            exit();
        } else {
            $error = "Gagal menyimpan resep: " . mysqli_error($mysqli);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Resep Baru</h2>
        
        <a href="resep_index.php" class="btn btn-secondary mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Resep
        </a>
        
        <?php if ($error) echo "<div class='alert alert-danger' role='alert'>$error</div>"; ?>

        <form method="post" action="resep_add.php" enctype="multipart/form-data">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Resep <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="kategori_id" name="kategori_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori_list as $k): ?>
                                <option value="<?php echo $k['id_kategori']; ?>"><?php echo $k['nama_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Resep <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" required>
                        <div class="form-text">Maks. ukuran file 2MB, format JPG/PNG.</div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">

            <div class="mb-3">
                <label for="bahan" class="form-label">Bahan-bahan <span class="text-danger">*</span></label>
                <textarea class="form-control" id="bahan" name="bahan" rows="7" required></textarea>
            </div>

            <div class="mb-3">
                <label for="langkah" class="form-label">Langkah-langkah Memasak<span class="text-danger">*</span></label>
                <textarea class="form-control" id="langkah" name="langkah" rows="10" required></textarea>
            </div>
            
            <button type="submit" name="submit_resep" class="btn btn-success btn-lg mt-3">
                <i class="bi bi-save"></i> Simpan Resep
            </button>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
