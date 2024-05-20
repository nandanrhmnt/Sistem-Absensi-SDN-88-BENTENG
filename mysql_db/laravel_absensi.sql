-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2024 at 04:17 PM
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
-- Database: `laravel_absensi`
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

--
-- Dumping data for table `kehadiran`
--

INSERT INTO `kehadiran` (`id_kehadiran`, `id_pegawai`, `kehadiran`, `created_at`, `updated_at`) VALUES
(1, 5, 'Hadir', '2024-05-20 05:36:21', '2024-05-20 05:36:21');

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

--
-- Dumping data for table `presensi_guru`
--

INSERT INTO `presensi_guru` (`id_presensi`, `id_pegawai`, `id_kehadiran`, `tanggal`, `jam_masuk`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2024-05-20', '12:35:00', '2024-05-20 05:36:21', '2024-05-20 05:36:21');

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
(1, '196705251988032000', 'guru', 'Helendra, M.Pd', 'Perempuan', '085288507676', NULL, NULL),
(2, '196602091989121001', 'guru', 'Suyoto, S.Pd', 'Laki-laki', '081762830881', NULL, NULL),
(3, '196805121994052001', 'guru', 'Nuryati Siallagan, S.Pd', 'Perempuan', '080986246788', NULL, NULL),
(4, '196807011994032006', 'guru', 'Indarmawati, S.Pd', 'Perempuan', '085298734224', NULL, NULL),
(5, '196906171997032002', 'guru', 'Rosdalina, S.Pd', 'Perempuan', '085876434578', NULL, NULL),
(6, '196908141992062001', 'guru', 'Poniem, S.Pd', 'Perempuan', '085287653256', NULL, NULL),
(7, '197105201996062001', 'guru', 'Purnamawati, S.Pd', 'Perempuan', '081357897458', NULL, NULL),
(8, '198203052014022002', 'guru', 'Fitri Handayani, S.Pd', 'Perempuan', '088896421122', NULL, NULL),
(9, '198711142019032002', 'guru', 'Endah Permana Sari, S.Pd.I', 'Perempuan', '081346909952', NULL, NULL),
(10, '', 'honorer', 'Tika Oktaviani, S.Pd', 'Perempuan', '081346909952', NULL, NULL),
(11, '', 'honorer', 'Agung Setia Budi, S.Pd', 'Laki-laki', '081346909952', NULL, NULL),
(12, '', 'honorer', 'Dewi Kurniati, S.E', 'Perempuan', '081346909952', NULL, NULL),
(13, '', 'honorer', 'Sukamto', 'Laki-laki', '081346909952', NULL, NULL),
(14, '', 'honorer', 'Bainah', 'Perempuan', '081346909952', NULL, NULL),
(15, '', 'honorer', 'Nur Hasanah', 'Perempuan', '081346909952', NULL, NULL);

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
(1, 'admin', 'admin@gmail.com', '$2y$10$ByLPJbC3k8nuUrhDyp66uukQcMToiHsTIb6aTyPDL6ng/Y.8q4aXK', 'Admin', 'HthitA7EwNsj9t93Z3lasZc9URayep5DtTQ3DVJZeB0brizQFBcSCAH1OLWu', NULL, NULL);

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
  MODIFY `id_kehadiran` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `presensi_guru`
--
ALTER TABLE `presensi_guru`
  MODIFY `id_presensi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  MODIFY `id_pegawai` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
  ADD CONSTRAINT `kehadiran_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `tb_pegawai` (`id_pegawai`);

--
-- Constraints for table `presensi_guru`
--
ALTER TABLE `presensi_guru`
  ADD CONSTRAINT `presensi_guru_id_kehadiran_foreign` FOREIGN KEY (`id_kehadiran`) REFERENCES `kehadiran` (`id_kehadiran`),
  ADD CONSTRAINT `presensi_guru_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `tb_pegawai` (`id_pegawai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;