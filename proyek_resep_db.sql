-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Des 2025 pada 16.03
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyek_resep_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Berkuah'),
(3, 'Kering'),
(4, 'Kue/Camilan Tradisional'),
(5, 'Minuman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resep`
--

CREATE TABLE `resep` (
  `id_resep` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `bahan` text DEFAULT NULL,
  `langkah` text DEFAULT NULL,
  `gambar_path` varchar(255) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `resep`
--

INSERT INTO `resep` (`id_resep`, `judul`, `deskripsi`, `bahan`, `langkah`, `gambar_path`, `kategori_id`, `created_at`) VALUES
(1, 'Soto Ayam Kuah Kuning', 'Soto Ayam Kuah Kuning adalah sup kaldu ayam yang kaya rasa, berwarna kuning cerah dari kunyit, dan dihidangkan bersama suwiran ayam, soun, tauge, kentang, dan taburan bawang goreng serta daun seledri. Hidangan ini sempurna disajikan hangat dengan nasi, sambal, dan perasan jeruk nipis.', 'A. Bahan Utama & Kuah\r\n- 1/2 ekor ayam (potong sesuai selera)\r\n- 2 liter air\r\n- 2 lembar daun salam\r\n- 3 lembar daun jeruk\r\n- 2 batang serai (memarkan)\r\n- 2 cm lengkuas (memarkan)\r\n\r\nB. Bumbu Halus\r\n- 8 siung bawang merah\r\n- 5 siung bawang putih\r\n- 3 cm kunyit (bakar sebentar)\r\n- 2 cm jahe\r\n- 1 sdt merica butiran\r\n- 1 sdt ketumbar butiran\r\n- Garam dan gula secukupnya\r\n\r\nC. Bahan Pelengkap\r\n- 100 gr soun (rendam air panas)\r\n- 100 gr tauge (seduh air panas)\r\n- 2 buah kentang (iris tipis, goreng kering)\r\n- 2 butir telur rebus (belah dua)\r\n- Bawang goreng, irisan daun seledri, dan daun bawang\r\n- Jeruk nipis dan sambal (dari cabai rawit rebus yang dihaluskan)', 'A. Membuat Kaldu dan Memasak Ayam\r\n- Rebus ayam dalam 2 liter air hingga mendidih dan mengeluarkan kaldu. Angkat ayam, sisihkan air kaldunya.\r\n- Goreng ayam yang sudah direbus sebentar hingga berwarna kecoklatan. Suwir-suwir dagingnya, sisihkan.\r\n- Tumis bumbu halus hingga harum. Masukkan serai, daun salam, daun jeruk, dan lengkuas. Tumis hingga matang dan bumbu tanak.\r\n- Masukkan bumbu yang sudah ditumis ke dalam air kaldu. Didihkan kembali. Tambahkan garam dan gula. Koreksi rasa. Biarkan mendidih dengan api kecil agar bumbu meresap sempurna.\r\n\r\nB. Penyelesaian dan Penyajian\r\n- Siapkan mangkuk saji. Tata soun, tauge, irisan kentang goreng, dan telur rebus.\r\n- Tambahkan suwiran ayam di atasnya.\r\n- Siram dengan kuah soto panas hingga semua bahan terendam.\r\n- Taburi dengan irisan daun seledri, daun bawang, dan bawang goreng.\r\n- Sajikan soto dengan nasi hangat, perasan air jeruk nipis, dan sambal rawit.', '692da15ee73e4-Gambar WhatsApp 2025-12-01 pukul 22.05.51_03bf41d3.jpg', 1, '2025-12-01 22:08:30'),
(2, 'Nasi Goreng Kampung Pedas', 'Nasi Goreng Kampung adalah nasi yang digoreng dengan bumbu ulek khas yang terdiri dari bawang merah, bawang putih, dan cabai, serta sedikit terasi (opsional) untuk aroma yang lebih kuat. Hidangan ini cepat dibuat dan sangat memuaskan, disajikan bersama telur mata sapi dan kerupuk.', 'A. Bahan Utama\r\n- 2 piring nasi putih dingin (nasi sisa semalam lebih baik)\r\n- 1 butir telur\r\n- 50 gr udang atau irisan bakso/sosis (opsional)\r\n- 1 ikat sawi hijau (potong-potong)\r\n- 1 sdm kecap manis\r\n- 1/2 sdt garam\r\n\r\nB. Bumbu Halus/Ulek\r\n- 6 buah bawang merah\r\n- 3 siung bawang putih\r\n- 8 - 10 buah cabai rawit merah (sesuai selera)\r\n- 1/2 sdt terasi matang (opsional, untuk aroma khas)\r\n\r\nC. Bahan Pelengkap\r\n- Kerupuk\r\n- Acar timun dan wortel\r\n- Irisan tomat dan mentimun', 'A. Menumis dan Menggoreng\r\n- Siapkan Bumbu: Haluskan bawang merah, bawang putih, cabai rawit, dan terasi (jika menggunakan) hingga benar-benar halus.\r\n- Tumis: Panaskan sedikit minyak dalam wajan. Tumis bumbu halus hingga harum dan matang.\r\n- Protein: Masukkan udang/bakso, aduk hingga matang. Sisihkan bahan tumisan ke pinggir wajan.\r\n- Telur: Pecahkan telur di tengah wajan, orak-arik hingga matang. Campurkan dengan tumisan bumbu dan protein.\r\n\r\nB. Memasak Nasi\r\n- Masukkan nasi putih dingin ke dalam wajan. Besarkan api.\r\n- Aduk nasi dengan cepat dan merata bersama semua bumbu di wajan hingga nasi terpisah-pisah dan tidak menggumpal.\r\n- Tambahkan kecap manis dan garam. Aduk terus hingga warna merata dan nasi terlapisi bumbu.\r\n- Masukkan potongan sawi hijau. Masak sebentar hingga sawi layu, jangan terlalu lama. Koreksi rasa.\r\n\r\nC. Penyajian\r\n- Pindahkan Nasi Goreng ke piring saji.\r\n- Sajikan dengan telur mata sapi (jika suka), kerupuk, dan bahan pelengkap seperti acar serta irisan tomat/mentimun.', '692da295aa2bf-Gambar WhatsApp 2025-12-01 pukul 21.50.02_71e324bf.jpg', 3, '2025-12-01 22:13:41'),
(3, 'Klepon Pandan Gula Merah', 'Klepon adalah jajanan pasar berbentuk bola-bola kecil berwarna hijau dengan tekstur kenyal. Ketika digigit, gula merah di dalamnya akan meleleh di mulut, memberikan sensasi manis yang berpadu sempurna dengan gurihnya parutan kelapa. Kue ini dibuat dengan pewarna alami dari daun suji/pandan, menjadikannya camilan yang autentik dan menarik.', 'A. Bahan Adonan Klepon\r\n- 250 gr tepung ketan putih\r\n- 50 gr tepung beras\r\n- 150 ml air hangat\r\n- 50 ml air perasan daun suji/pandan (atau 1 sdt pasta pandan)\r\n- 1/2 sdt air kapur sirih (opsional, untuk tekstur lebih kenyal)\r\n- Sedikit garam\r\n\r\nB. Bahan Isi dan Balutan\r\n- 100 gr gula merah/gula aren (sisir halus)\r\n- 1/2 butir kelapa parut (yang agak muda)\r\n- 1/4 sdt garam (untuk dicampur ke kelapa parut)\r\n- 1 lembar daun pandan', 'A. Menyiapkan Kelapa Parut\r\n- Campurkan kelapa parut dengan 1/4 sendok teh garam.\r\n- Kukus kelapa parut bersama selembar daun pandan selama 15-20 menit. Hal ini dilakukan agar kelapa tidak cepat basi dan lebih gurih. Angkat dan sisihkan.\r\n\r\nB. Membuat Adonan dan Mencetak\r\n- Campurkan tepung ketan, tepung beras, dan garam dalam wadah besar. Aduk rata.\r\n- Campurkan air hangat, air pandan, dan air kapur sirih (jika menggunakan).\r\n- Tuang campuran cairan sedikit demi sedikit ke dalam adonan tepung sambil diuleni hingga adonan kalis dan bisa dibentuk, serta tidak lengket di tangan.\r\n- Ambil sedikit adonan (seukuran kelereng besar). Pipihkan, isi dengan gula merah sisir secukupnya. Tutup adonan hingga rapat dan bentuk menjadi bola. Lakukan hingga adonan habis.\r\n\r\nC. Memasak dan Menyajikan\r\n- Didihkan air dalam panci.\r\n- Masukkan bola-bola klepon ke dalam air mendidih.\r\n- Masak klepon hingga matang. Tanda klepon matang adalah ketika bola-bola klepon mengapung di permukaan air.\r\n- Angkat klepon yang sudah mengapung, tiriskan sebentar.\r\n- Gulingkan klepon selagi masih hangat di atas kelapa parut kukus hingga seluruh permukaannya tertutup rata.\r\n- Klepon siap disajikan.', '692da3b3c70b2-Gambar WhatsApp 2025-12-01 pukul 22.06.25_5fcc44c7.jpg', 4, '2025-12-01 22:18:27'),
(4, 'Es Cendol Gula Merah Santan', 'Es Cendol adalah minuman pencuci mulut yang sangat populer, menyajikan perpaduan rasa manis alami dari sirup gula merah, gurih dan creamy dari santan, serta kesegaran dari es batu. Butiran cendol yang kenyal berwarna hijau alami (dari daun suji/pandan) membuat minuman ini tidak hanya lezat tetapi juga cantik.', 'A. Bahan Cendol\r\n- 100 gr tepung beras\r\n- 50 gr tepung sagu (atau tepung hunkwe)\r\n- 600 ml air\r\n- 50 ml air perasan daun suji dan pandan (atau 1 sdt pasta pandan)\r\n- 1/2 sdt garam\r\n- Air es dan es batu dalam baskom besar (untuk mencetak)\r\n\r\nB. Bahan Santan Gurih\r\n- 500 ml santan kental (dari 1/2 butir kelapa)\r\n- 1/2 sdt garam\r\n- 1 lembar daun pandan (ikat simpul)\r\n\r\nC. Bahan Sirup Gula Merah\r\n- 250 gr gula merah/gula aren (sisir halus)\r\n- 100 ml air\r\n- 1 lembar daun pandan (ikat simpul)', 'A. Membuat Cendol Hijau\r\n- Campurkan tepung beras, tepung sagu, air, air pandan, dan garam dalam panci. Aduk rata.\r\n- Masak adonan di atas api sedang sambil terus diaduk cepat menggunakan spatula kayu. Masak hingga adonan mengental, meletup-letup, dan berwarna hijau pekat.\r\n- Siapkan baskom berisi air es dan es batu. Letakkan cetakan cendol (atau saringan besar berlubang) di atas baskom.\r\n- Tuang adonan panas ke dalam cetakan. Tekan-tekan adonan hingga keluar dan jatuh ke air es, membentuk buliran-buliran cendol yang panjang.\r\n- Diamkan cendol di air es hingga benar-benar dingin dan mengeras. Tiriskan.\r\n\r\nB. Membuat Santan dan Sirup Gula\r\n- Santan: Campurkan santan kental, garam, dan daun pandan dalam panci kecil. Masak di atas api kecil sambil terus diaduk agar santan tidak pecah. Begitu mulai mendidih, angkat dan dinginkan.\r\n- Sirup Gula Merah: Campurkan gula merah sisir, air, dan daun pandan dalam panci. Masak hingga gula larut dan cairan mengental. Saring dan dinginkan.\r\n\r\nC. Penyelesaian dan Penyajian\r\n- Siapkan gelas saji yang tinggi.\r\n- Masukkan sirup gula merah secukupnya di dasar gelas.\r\n- Tambahkan cendol hijau yang sudah ditiriskan.\r\n- Tambahkan es batu atau es serut hingga penuh.\r\n- Terakhir, siram dengan santan gurih di atas es.\r\n- Es Cendol Gula Merah Santan siap dinikmati!', '692da51ce009e-Gambar WhatsApp 2025-12-01 pukul 22.07.32_19a27fb8.jpg', 5, '2025-12-01 22:24:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'contributor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$tfklAw.B68xiLnFzy9qTu.GqfiiAyT7pml.S5zD9kQuj87E8LHCxO', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indeks untuk tabel `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`id_resep`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `resep`
--
ALTER TABLE `resep`
  MODIFY `id_resep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `resep`
--
ALTER TABLE `resep`
  ADD CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
