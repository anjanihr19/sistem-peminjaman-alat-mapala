-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Apr 2026 pada 01.07
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventaris`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alat`
--

CREATE TABLE `alat` (
  `id_alat` int(11) NOT NULL,
  `kode_alat` varchar(20) NOT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `warna` varchar(30) DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 0,
  `kondisi` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alat`
--

INSERT INTO `alat` (`id_alat`, `kode_alat`, `nama_alat`, `merk`, `warna`, `jumlah`, `kondisi`, `keterangan`) VALUES
(1, 'abcds', 'CDNS', 'Petzl', 'abu', 2, 'Rusak', 'lecet'),
(3, 'AL001', 'Sling Prusik', 'no merk', 'ungu', 0, 'Baik', ''),
(4, 'AL002', 'FO8', 'Camp', 'Hitam', 3, 'Baik', ''),
(5, 'AL003', 'Jummar', 'Petzl', 'Gold', 3, 'Baik', ''),
(6, 'AL004', 'CONS', 'Eiger', 'Silver', 5, 'Baik', ''),
(7, 'AL005', 'Karmantel Statis', 'No merk', 'Creme', 4, 'Baik', ''),
(8, 'AL006', 'Karmantel Dinamis', 'no merk', 'biru', 4, 'Baik', ''),
(9, 'AL007', 'MR Oval', 'no merk', 'bronze', 2, 'Baik', ''),
(12, 'AL008', 'Flysheet', 'Kalimanjaro', 'Biru', 0, 'Baik', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kode_undangan`
--

CREATE TABLE `kode_undangan` (
  `id_kode` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `id_users` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `used_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kode_undangan`
--

INSERT INTO `kode_undangan` (`id_kode`, `kode`, `is_used`, `id_users`, `created_at`, `used_at`) VALUES
(1, '754ADAE6', 1, 9, '2026-04-01 17:29:12', '2026-04-01 17:34:30'),
(2, '7AC49979', 1, 10, '2026-04-02 08:15:14', '2026-04-05 13:38:52'),
(3, '8A1BD61B', 0, NULL, '2026-04-06 03:05:49', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjam`
--

CREATE TABLE `peminjam` (
  `id_peminjam` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `institusi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjam`
--

INSERT INTO `peminjam` (`id_peminjam`, `id_users`, `nama_peminjam`, `alamat`, `no_hp`, `institusi`) VALUES
(4, 6, 'jasmine', 'manado', '034304394', 'UNSRAT'),
(6, 9, 'kikan', 'concat', '089694836173', 'MAYAPALA'),
(7, 10, 'Wadar', 'concat', '089694836173', 'MAYAPALA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_peminjam` int(11) NOT NULL,
  `id_alat` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `tgl_realisasi_kembali` date DEFAULT NULL,
  `alasan_perubahan` text DEFAULT NULL,
  `jml_alat` int(11) NOT NULL,
  `status` enum('Menunggu','Menunggu Konfirmasi User','Disetujui','Ditolak','Dipinjam','Dikembalikan','Dibatalkan') NOT NULL DEFAULT 'Menunggu',
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_peminjam`, `id_alat`, `tgl_pinjam`, `tgl_kembali`, `tgl_realisasi_kembali`, `alasan_perubahan`, `jml_alat`, `status`, `id_admin`) VALUES
(3, 4, 3, '2026-03-06', '2026-03-10', '2026-03-05', NULL, 1, 'Dikembalikan', NULL),
(5, 4, 8, '2026-03-10', '2026-03-15', '2026-03-14', NULL, 2, 'Dikembalikan', NULL),
(9, 4, 5, '2026-04-04', '2026-04-06', '2026-04-05', NULL, 3, 'Dikembalikan', 7),
(11, 6, 4, '2026-04-02', '2026-04-04', '2026-04-10', 'sdasda', 4, 'Dikembalikan', 7),
(12, 7, 4, '2026-04-06', '2026-04-08', '2026-04-08', NULL, 6, 'Dikembalikan', 7),
(13, 7, 4, '2026-04-07', '2026-04-09', NULL, '3 untuk internal', 3, 'Disetujui', 7),
(14, 7, 9, '2026-04-08', '2026-04-11', NULL, NULL, 2, 'Menunggu', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `nomor_induk` varchar(50) DEFAULT NULL,
  `status_akun` enum('aktif','non-aktif') NOT NULL DEFAULT 'non-aktif',
  `is_temporary_password` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('Admin','User') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `nama_user`, `nomor_induk`, `status_akun`, `is_temporary_password`, `role`) VALUES
(6, 'jasmine', '$2y$10$/NJAYcYI5uMgP2vbsjFcnemzQTg4/lszK/VIFa.i.r34uE9f3NeBK', 'jasmine', NULL, 'aktif', 0, 'User'),
(7, 'admin', '$2y$10$h4N7IsW312GtIsjDNaRF0O9bFGwC5zd0xhdfkMw8e3kfvaSJObjR.', 'kerumahtanggaan', NULL, 'aktif', 0, 'Admin'),
(9, 'kikan', '$2y$10$J0elu/UeI8L3BJTsWrkj6.s472aT9OaUMkfTVSKxnPZaMQNCRSgY.', 'kikan', '2343432', 'aktif', 0, 'User'),
(10, 'wadar', '$2y$10$FOXdW6asv7q/48TfljaSW.MuCEfajqaTPlu.H1MIFx6WktoH01FPi', 'Wadar', '328', 'aktif', 0, 'User');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id_alat`),
  ADD UNIQUE KEY `kode_alat` (`kode_alat`);

--
-- Indeks untuk tabel `kode_undangan`
--
ALTER TABLE `kode_undangan`
  ADD PRIMARY KEY (`id_kode`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `id_users` (`id_users`);

--
-- Indeks untuk tabel `peminjam`
--
ALTER TABLE `peminjam`
  ADD PRIMARY KEY (`id_peminjam`),
  ADD KEY `fk_peminjam_user` (`id_users`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `fk_peminjaman_peminjam` (`id_peminjam`),
  ADD KEY `fk_peminjaman_alat` (`id_alat`),
  ADD KEY `fk_peminjaman_admin` (`id_admin`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alat`
--
ALTER TABLE `alat`
  MODIFY `id_alat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kode_undangan`
--
ALTER TABLE `kode_undangan`
  MODIFY `id_kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peminjam`
--
ALTER TABLE `peminjam`
  MODIFY `id_peminjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kode_undangan`
--
ALTER TABLE `kode_undangan`
  ADD CONSTRAINT `kode_undangan_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `peminjam`
--
ALTER TABLE `peminjam`
  ADD CONSTRAINT `fk_peminjam_user` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_peminjaman_admin` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_users`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_peminjaman_alat` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id_alat`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_peminjam` FOREIGN KEY (`id_peminjam`) REFERENCES `peminjam` (`id_peminjam`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
