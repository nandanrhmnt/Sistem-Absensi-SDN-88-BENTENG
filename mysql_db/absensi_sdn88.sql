-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2024 at 02:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_sdn88`
--

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id_kehadiran` bigint UNSIGNED NOT NULL,
  `id_pegawai` bigint UNSIGNED NOT NULL,
  `kehadiran` enum('Hadir','Sakit','Izin','Tanpa keterangan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_05_01_000000_create_users_table', 1),
(2, '2024_05_01_001140_create_tb_pegawai_table', 1),
(3, '2024_05_01_022724_create_kehadiran_table', 1),
(4, '2024_05_01_033528_create_presensi_guru_table', 1),
(5, '2024_05_01_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presensi_guru`
--

CREATE TABLE `presensi_guru` (
  `id_presensi` bigint UNSIGNED NOT NULL,
  `id_pegawai` bigint UNSIGNED NOT NULL,
  `id_kehadiran` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `id_pegawai` bigint UNSIGNED NOT NULL,
  `NIP` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` enum('guru','honorer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nama` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `No_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`id_pegawai`, `NIP`, `keterangan`, `Nama`, `jenis_kelamin`, `No_hp`, `created_at`, `updated_at`) VALUES
(16, '196705251988032000', 'guru', 'Helendra, M.Pd.', 'Perempuan', '085288507676', NULL, '2024-05-25 11:57:51'),
(17, '196602091989121001', 'guru', 'Suyoto, S.Pd.', 'Laki-laki', '085267491054', NULL, NULL),
(18, '196805121994052001', 'guru', 'Nuryati Siallagan, S.Pd.', 'Perempuan', '085368375149', NULL, NULL),
(19, '196807011994032006', 'guru', 'Indarmawati, S.Pd.', 'Perempuan', '081210485860', NULL, NULL),
(20, '196906171997032002', 'guru', 'Rosdalina, S.Pd.', 'Perempuan', '082289583162', NULL, NULL),
(21, '196908141992062001', 'guru', 'Poniem, S.Pd.', 'Perempuan', '082175673369', NULL, NULL),
(22, '197105201996062001', 'guru', 'Purnamawati, S.Pd.', 'Perempuan', '089507961451', NULL, NULL),
(23, '198203052014022002', 'guru', 'Fitri Handayani, S.Pd.', 'Perempuan', '085286185708', NULL, NULL),
(24, '198711142019032002', 'guru', 'Endah Permana Sari, S.Pd.I', 'Perempuan', '085381303300', NULL, NULL),
(25, '', 'honorer', 'Tika Oktaviani, S.Pd.', 'Perempuan', '081366365929', NULL, NULL),
(26, '', 'honorer', 'Agung Setia Budi, S.Pd.', 'Laki-laki', '082281728813', NULL, NULL),
(27, '', 'honorer', 'Dewi Kurniati, S.E.', 'Perempuan', '082306605617', NULL, NULL),
(28, '', 'honorer', 'Sukamto', 'Laki-laki', '082384609347', NULL, NULL),
(29, '', 'honorer', 'Bainah', 'Perempuan', '082384609347', NULL, NULL),
(30, NULL, 'honorer', 'Nur Hasanah', 'Perempuan', '083176801924', NULL, '2024-05-25 11:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akses` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `akses`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$ypcN9nJwuuRbNZH3WE9H/e0klWf3h5oKMJ8Zniag.d/.5YPIrwkrm', 'Admin', 'Izgn9NqWpo0ROkFeQeltEUtco8RudJ0A99nRCZvI5AJ6pQxpZFKVQTZU05Co', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id_kehadiran`),
  ADD KEY `kehadiran_id_pegawai_foreign` (`id_pegawai`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `presensi_guru`
--
ALTER TABLE `presensi_guru`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `presensi_guru_id_pegawai_foreign` (`id_pegawai`),
  ADD KEY `presensi_guru_id_kehadiran_foreign` (`id_kehadiran`);

--
-- Indexes for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id_kehadiran` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `presensi_guru`
--
ALTER TABLE `presensi_guru`
  MODIFY `id_presensi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  MODIFY `id_pegawai` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `tb_pegawai` (`id_pegawai`) ON DELETE CASCADE;

--
-- Constraints for table `presensi_guru`
--
ALTER TABLE `presensi_guru`
  ADD CONSTRAINT `presensi_guru_id_kehadiran_foreign` FOREIGN KEY (`id_kehadiran`) REFERENCES `kehadiran` (`id_kehadiran`) ON DELETE CASCADE,
  ADD CONSTRAINT `presensi_guru_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `tb_pegawai` (`id_pegawai`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
