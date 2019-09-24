-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2018 at 01:25 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `i_persediaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `is_barang`
--

CREATE TABLE `is_barang` (
  `id_barang` varchar(16) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT '0',
  `created_user` smallint(6) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` smallint(6) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_barang`
--

INSERT INTO `is_barang` (`id_barang`, `nama_barang`, `id_jenis`, `id_satuan`, `stok`, `created_user`, `created_date`, `updated_user`, `updated_date`) VALUES
('B000003', 'Penghapus', 5, 8, 26, 1, '2018-10-29 06:55:23', 1, '2018-11-19 06:18:19'),
('B000004', 'Kertas A4', 14, 10, 23, 1, '2018-11-08 13:31:18', 1, '2018-11-08 13:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `is_barang_keluar`
--

CREATE TABLE `is_barang_keluar` (
  `id_barang_keluar` varchar(15) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `id_barang` varchar(7) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `created_user` smallint(6) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_barang_keluar`
--

INSERT INTO `is_barang_keluar` (`id_barang_keluar`, `tanggal_keluar`, `id_barang`, `jumlah_keluar`, `created_user`, `created_date`) VALUES
('TK-2018-0000001', '2018-11-08', 'B000003', 20, 1, '2018-11-08 13:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `is_barang_masuk`
--

CREATE TABLE `is_barang_masuk` (
  `id_barang_masuk` int(15) NOT NULL,
  `id_barang` varchar(16) NOT NULL,
  `id_nota` varchar(15) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `harga_barang` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_barang_masuk`
--

INSERT INTO `is_barang_masuk` (`id_barang_masuk`, `id_barang`, `id_nota`, `jumlah_masuk`, `harga_barang`) VALUES
(29, 'B000003', 'TM-2018-0000004', 1, 2000),
(31, 'B000003', 'TM-2018-0000005', 1, 5000),
(32, 'B000003', 'TM-2018-0000006', 23, 15000),
(33, 'B000004', 'TM-2018-0000006', 23, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `is_jenis_barang`
--

CREATE TABLE `is_jenis_barang` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(50) NOT NULL,
  `created_user` smallint(6) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` smallint(6) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_jenis_barang`
--

INSERT INTO `is_jenis_barang` (`id_jenis`, `nama_jenis`, `created_user`, `created_date`, `updated_user`, `updated_date`) VALUES
(1, 'Kertas HVS', 3, '2017-03-12 02:59:45', 1, '2018-05-22 12:54:07'),
(2, 'Barang Percetakan', 3, '2017-03-12 02:59:58', 1, '2018-05-22 12:53:38'),
(3, 'Alat Perekat', 3, '2017-03-12 03:00:08', 1, '2018-05-22 12:53:28'),
(4, 'Ordner / Map', 3, '2017-03-12 03:00:19', 1, '2018-05-22 12:53:19'),
(5, 'Penghapus / Korektor', 3, '2017-03-12 03:00:29', 1, '2018-05-22 12:53:10'),
(6, 'Penjepit Kertas', 3, '2017-03-12 03:00:39', 1, '2018-05-22 12:53:00'),
(7, 'Alat Tulis', 3, '2017-03-12 03:00:49', 1, '2018-05-22 12:52:51'),
(8, 'Kertas HVS', 1, '2018-05-22 12:54:42', 1, '2018-05-22 12:54:42'),
(9, 'Amplop', 1, '2018-05-22 12:54:51', 1, '2018-05-22 12:54:51'),
(10, 'Tinta / toner Printer', 1, '2018-05-22 12:55:01', 1, '2018-05-22 12:55:01'),
(11, 'USB / Flashdisk', 1, '2018-05-22 12:55:16', 1, '2018-05-22 12:55:16'),
(12, 'CD / DVD', 1, '2018-05-22 12:55:23', 1, '2018-05-22 12:55:23'),
(13, 'Tinta Tulis, Tinta Stempel', 1, '2018-09-08 09:56:12', 1, '2018-09-08 09:56:12'),
(14, 'Lainnya', 1, '2018-11-07 10:27:02', 1, '2018-11-07 10:27:02');

-- --------------------------------------------------------

--
-- Table structure for table `is_nota`
--

CREATE TABLE `is_nota` (
  `id_nota` varchar(15) NOT NULL,
  `tanggal_nota` date NOT NULL,
  `harga_total` int(20) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `created_user` smallint(6) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_nota`
--

INSERT INTO `is_nota` (`id_nota`, `tanggal_nota`, `harga_total`, `foto`, `created_user`, `nama_pegawai`) VALUES
('TM-2018-0000004', '2018-11-06', 2000, '../../images/barang_masuk/uniform.png', 1, 'Rizky Ramadan'),
('TM-2018-0000005', '2018-11-07', 15000, '../../images/barang_masuk/undip.png', 1, 'Satya'),
('TM-2018-0000006', '2018-11-08', 19000, '../../images/barang_masuk/undip2.png', 1, 'Budi');

-- --------------------------------------------------------

--
-- Table structure for table `is_satuan`
--

CREATE TABLE `is_satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(30) NOT NULL,
  `created_user` smallint(6) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` smallint(6) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_satuan`
--

INSERT INTO `is_satuan` (`id_satuan`, `nama_satuan`, `created_user`, `created_date`, `updated_user`, `updated_date`) VALUES
(1, 'Rim', 3, '2017-03-12 02:57:35', 1, '2018-05-22 12:57:09'),
(2, 'Dus', 3, '2017-03-12 02:58:07', 1, '2018-05-22 12:57:04'),
(8, 'Buah', 1, '2018-05-22 12:56:52', 1, '2018-05-22 12:56:52'),
(9, 'Lembar', 1, '2018-05-22 12:56:57', 1, '2018-05-22 12:56:57'),
(10, 'Pack', 1, '2018-05-22 12:57:14', 1, '2018-05-22 12:57:14'),
(11, 'Bungkus', 1, '2018-11-07 10:27:32', 1, '2018-11-07 10:27:32'),
(12, 'Box', 1, '2018-11-08 13:33:11', 1, '2018-11-08 13:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `is_users`
--

CREATE TABLE `is_users` (
  `id_user` smallint(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telepon` varchar(13) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `hak_akses` enum('Admin','Kasubbag','SubAdmin') NOT NULL,
  `status` enum('aktif','blokir') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_users`
--

INSERT INTO `is_users` (`id_user`, `username`, `nama_user`, `password`, `email`, `telepon`, `foto`, `hak_akses`, `status`, `created_at`, `updated_at`) VALUES
(1, 'satya', 'Satya Kenandi', '202cb962ac59075b964b07152d234b70', 'skenandi@gmail.com', '081317571125', 'undip.png', 'Admin', 'aktif', '2016-05-01 08:42:53', '2018-11-08 13:41:42'),
(3, 'bagianprogram', 'Sub Bagian Program', '202cb962ac59075b964b07152d234b70', 'kiki@gmail.com', '08512345678', '1469574162_users-15.png', 'SubAdmin', 'aktif', '2017-03-11 14:41:46', '2018-11-05 11:02:25'),
(8, 'kasubbag', 'Kasubbag', '202cb962ac59075b964b07152d234b70', '', '', NULL, 'Kasubbag', 'aktif', '2018-11-05 10:51:17', '2018-11-20 09:04:58'),
(9, 'bagianhumas', 'Sub Bagian Humas', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 'SubAdmin', 'aktif', '2018-11-08 13:41:01', '2018-11-21 06:01:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `is_barang`
--
ALTER TABLE `is_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_jenis` (`id_jenis`),
  ADD KEY `id_satuan` (`id_satuan`),
  ADD KEY `created_user` (`created_user`),
  ADD KEY `updated_user` (`updated_user`);

--
-- Indexes for table `is_barang_keluar`
--
ALTER TABLE `is_barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `created_user` (`created_user`);

--
-- Indexes for table `is_barang_masuk`
--
ALTER TABLE `is_barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_nota` (`id_nota`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `is_jenis_barang`
--
ALTER TABLE `is_jenis_barang`
  ADD PRIMARY KEY (`id_jenis`),
  ADD KEY `created_user` (`created_user`),
  ADD KEY `updated_user` (`updated_user`);

--
-- Indexes for table `is_nota`
--
ALTER TABLE `is_nota`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `created_user` (`created_user`);

--
-- Indexes for table `is_satuan`
--
ALTER TABLE `is_satuan`
  ADD PRIMARY KEY (`id_satuan`),
  ADD KEY `created_user` (`created_user`),
  ADD KEY `updated_user` (`updated_user`);

--
-- Indexes for table `is_users`
--
ALTER TABLE `is_users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `hak_akses` (`hak_akses`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `is_barang_masuk`
--
ALTER TABLE `is_barang_masuk`
  MODIFY `id_barang_masuk` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `is_jenis_barang`
--
ALTER TABLE `is_jenis_barang`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `is_satuan`
--
ALTER TABLE `is_satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `is_users`
--
ALTER TABLE `is_users`
  MODIFY `id_user` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `is_barang`
--
ALTER TABLE `is_barang`
  ADD CONSTRAINT `is_barang_ibfk_1` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_barang_ibfk_2` FOREIGN KEY (`updated_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_barang_ibfk_3` FOREIGN KEY (`id_satuan`) REFERENCES `is_satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_barang_ibfk_4` FOREIGN KEY (`id_jenis`) REFERENCES `is_jenis_barang` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `is_barang_keluar`
--
ALTER TABLE `is_barang_keluar`
  ADD CONSTRAINT `is_barang_keluar_ibfk_1` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_barang_keluar_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `is_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `is_barang_masuk`
--
ALTER TABLE `is_barang_masuk`
  ADD CONSTRAINT `retyu` FOREIGN KEY (`id_nota`) REFERENCES `is_nota` (`id_nota`) ON DELETE CASCADE,
  ADD CONSTRAINT `xcvbnm` FOREIGN KEY (`id_barang`) REFERENCES `is_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `is_jenis_barang`
--
ALTER TABLE `is_jenis_barang`
  ADD CONSTRAINT `is_jenis_barang_ibfk_1` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_jenis_barang_ibfk_2` FOREIGN KEY (`updated_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `is_satuan`
--
ALTER TABLE `is_satuan`
  ADD CONSTRAINT `is_satuan_ibfk_1` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_satuan_ibfk_2` FOREIGN KEY (`updated_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
