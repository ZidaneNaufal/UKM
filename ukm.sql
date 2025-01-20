-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jan 2025 pada 17.38
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `program_studi` varchar(100) NOT NULL,
  `ukm_id` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

--
-- Dumping data untuk tabel `registrations`
--

INSERT INTO `registrations` (`id`, `user_id`, `nama`, `nim`, `program_studi`, `ukm_id`, `alasan`, `created_at`, `status`) VALUES
(1, 1, 'zidane nauffal', '2330511002', 'Teknik Informatika', 1, 'saya ganteng', '2025-01-17 17:06:27', 'approved'),
(2, 9, 'Zidane Naufal Azzam', '2330511002', 'Teknik Informatika', 3, 'karena ingin jadi pro sepak bola', '2025-01-18 16:33:10', 'rejected'),
(3, 9, 'Zidane Naufal Azzam', '2330511002', 'Teknik Informatika', 5, 'ingin meningkatkan skill futsal', '2025-01-18 16:34:10', ''),
(4, 9, 'Zidane Naufal Azzam', '2330511002', 'Teknik Informatika', 8, 'saya ingin jadi pro tenis meja', '2025-01-18 16:37:43', 'approved');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ukm`
--

CREATE TABLE `ukm` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

--
-- Dumping data untuk tabel `ukm`
--

INSERT INTO `ukm` (`id`, `name`, `description`, `category`, `contact`, `foto`) VALUES
(1, 'Asmarandana', 'UKM seni dan budaya yang fokus pada pelestarian seni tradisional Indonesia.', 'Seni dan Budaya', 'asmarandana@ukm.com', 'http://localhost/ukm/images/Asmarandana.jpg'),
(2, 'Badminton', 'UKM olahraga untuk mahasiswa yang ingin mengembangkan keterampilan bermain bulu tangkis.', 'Olahraga', 'badminton@ukm.com', 'http://localhost/ukm/images/badminton.jpg'),
(3, 'Sepak Bola', 'UKM olahraga untuk mahasiswa yang ingin mengembangkan bakat dalam sepak bola.', 'Olahraga', 'sepakbola@ukm.com', 'http://localhost/ukm/images/bola.jpg'),
(4, 'Jurnalistik', 'UKM yang berfokus pada pelatihan jurnalistik dan publikasi berita.', 'Akademik', 'jurnalistik@ukm.com', 'http://localhost/ukm/images/foto.jpg'),
(5, 'Futsal', 'UKM olahraga futsal untuk mahasiswa yang menyukai permainan cepat dan dinamis.', 'Olahraga', 'futsal@ukm.com', 'http://localhost/ukm/images/futsal.jpeg'),
(6, 'Mapalu', 'UKM pecinta alam Universitas yang berfokus pada kegiatan eksplorasi dan konservasi lingkungan.', 'Lingkungan', 'mapalu@ukm.com', 'http://localhost/ukm/images/gunung.jpg'),
(7, 'LDK Al-UMM', 'Lembaga Dakwah Kampus untuk mahasiswa yang ingin memperdalam ilmu keislaman.', 'Keagamaan', 'ldk@ukm.com', 'http://localhost/ukm/images/masjid.jpeg'),
(8, 'Tenis Meja', 'UKM olahraga yang melatih mahasiswa dalam keterampilan bermain tenis meja.', 'Olahraga', 'tenismeja@ukm.com', 'http://localhost/ukm/images/tenis.jpg'),
(9, 'Voli', 'UKM olahraga voli yang mendorong keterampilan tim dan kekompakan.', 'Olahraga', 'voli@ukm.com', 'http://localhost/ukm/images/voli.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ukm_detail`
--

CREATE TABLE `ukm_detail` (
  `id` int(11) NOT NULL,
  `ukm_id` int(11) NOT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `prestasi` text DEFAULT NULL,
  `jadwal_latihan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

--
-- Dumping data untuk tabel `ukm_detail`
--

INSERT INTO `ukm_detail` (`id`, `ukm_id`, `visi`, `misi`, `prestasi`, `jadwal_latihan`) VALUES
(1, 1, 'Melestarikan seni tradisional Indonesia dan menjadikannya warisan yang tetap hidup di kalangan mahasiswa.', '1. Mengadakan pelatihan seni setiap minggu.\n2. Menyelenggarakan pertunjukan seni tradisional setiap semester.', 'Juara 1 Festival Seni Tradisional 2023; Juara 2 Kompetisi Tari Lokal 2022', 'Senin: 16.00-18.00; Kamis: 16.00-18.00'),
(2, 2, 'Menjadi UKM bulu tangkis terbaik di tingkat universitas dan nasional.', '1. Menyelenggarakan latihan rutin.\n2. Mengadakan kompetisi internal kampus.\n3. Mengirim anggota ke kompetisi tingkat nasional.', 'Juara 1 Kejuaraan Bulu Tangkis Antar Universitas 2023; Juara 2 Kompetisi Regional 2022', 'Selasa: 15.00-17.00; Kamis: 15.00-17.00'),
(3, 3, 'Menjadi UKM sepak bola yang kompetitif dan profesional di tingkat nasional.', '1. Membina tim yang solid melalui latihan intensif.\n2. Mengikuti kompetisi lokal dan nasional.\n3. Membentuk jiwa sportivitas dalam tim.', 'Juara 1 Liga Mahasiswa 2023; Juara 2 Kejuaraan Sepak Bola Kampus 2022', 'Rabu: 16.00-18.00; Jumat: 16.00-18.00'),
(4, 4, 'Menciptakan mahasiswa yang kritis, kreatif, dan memiliki kemampuan jurnalistik yang mumpuni.', '1. Mengadakan pelatihan jurnalistik mingguan.\n2. Menerbitkan majalah kampus secara berkala.\n3. Menyelenggarakan seminar dan workshop.', 'Terbitan Majalah Kampus Terbaik 2023; Juara 1 Lomba Artikel Mahasiswa 2022', 'Kamis: 14.00-16.00; Sabtu: 10.00-12.00'),
(5, 5, 'Menjadi UKM futsal terkemuka yang mencetak atlet berbakat di tingkat universitas.', '1. Melatih kerja sama tim dalam permainan futsal.\n2. Menyelenggarakan kompetisi futsal internal.\n3. Mengikuti turnamen antar universitas.', 'Juara 1 Turnamen Futsal Nasional 2023; Juara 3 Liga Kampus 2022', 'Senin: 17.00-19.00; Kamis: 17.00-19.00'),
(6, 6, 'Menjadi pelopor pelestarian lingkungan di kalangan mahasiswa.', '1. Mengadakan pendakian setiap bulan.\n2. Mengikuti kegiatan konservasi lingkungan.\n3. Menjalankan program edukasi lingkungan.', 'Penghargaan Konservasi Hutan Terbaik 2023; Juara 2 Lomba Kebersihan Kampus 2022', 'Minggu: 08.00-12.00'),
(7, 7, 'Membentuk mahasiswa yang berakhlak mulia dan berilmu pengetahuan islami.', '1. Menyelenggarakan kajian keislaman mingguan.\n2. Mengelola kegiatan dakwah di kampus.\n3. Menjalin hubungan dengan organisasi keislaman lainnya.', 'Peserta Lomba Debat Keislaman 2023; Penghargaan Dakwah Kampus 2022', 'Selasa: 17.00-19.00; Jumat: 17.00-19.00'),
(8, 8, 'Mencetak atlet tenis meja berkualitas di tingkat nasional.', '1. Mengadakan latihan intensif mingguan.\n2. Menyelenggarakan turnamen internal.\n3. Mendorong anggota mengikuti kompetisi eksternal.', 'Juara 1 Kejuaraan Tenis Meja Regional 2023; Juara 2 Kompetisi Kampus 2022', 'Rabu: 15.00-17.00; Jumat: 15.00-17.00'),
(9, 9, 'Menjadi UKM voli terbaik yang mencetak tim unggul di tingkat nasional.', '1. Melakukan latihan tim secara rutin.\n2. Mengadakan turnamen voli antar fakultas.\n3. Mengembangkan kemampuan individu dan tim.', 'Juara 1 Turnamen Voli Antar Fakultas 2023; Juara 2 Kompetisi Regional 2022', 'Senin: 14.00-16.00; Kamis: 14.00-16.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'bab', 'bab@gmail.com', '$2y$10$KJkKngkjL3Q44jTuQiNvFO/iJZOcfgqthA74zhcwjIAA45xB0ITfi', 'user', '2025-01-17 16:28:07'),
(7, 'user1', 'user1@ukm.com', '$2y$10$QbR/8cqXilwINJ1sFIlyjO.BJl7k3v5KJnN0Vim36heLOqtQoh3Si', 'user', '2025-01-17 17:21:28'),
(9, 'admin', 'admin@ukm.com', '$2y$10$P0xittcR4BRfYiLRyxMhguC0BYSQdpahjPyxHwrTgSaOjUswl5lYS', 'admin', '2025-01-17 17:25:59'),
(10, 'drian', 'drian@gmail.com', '$2y$10$KzrIJ2laX4qZs.s6bFcaXucfj5UhZE9lUQrNhOzvVW18fqPWZHyNK', 'user', '2025-01-18 07:55:35');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ukm_id` (`ukm_id`);

--
-- Indeks untuk tabel `ukm`
--
ALTER TABLE `ukm`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ukm_detail`
--
ALTER TABLE `ukm_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ukm_id` (`ukm_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ukm`
--
ALTER TABLE `ukm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `ukm_detail`
--
ALTER TABLE `ukm_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`ukm_id`) REFERENCES `ukm` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ukm_detail`
--
ALTER TABLE `ukm_detail`
  ADD CONSTRAINT `ukm_detail_ibfk_1` FOREIGN KEY (`ukm_id`) REFERENCES `ukm` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
