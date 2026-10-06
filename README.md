# MAYAPALATools (AlatMYP) — Aplikasi Peminjaman Alat Dengan Framework CodeIgniter 3 & Template SB Admin 2

Aplikasi web untuk mengelola peminjaman alat (contohnya alat panjat tebing / outdoor: sling prusik, karmantel, jummar, flysheet, dan lain-lain) di Sekretariat MAYAPALA. Anggota bisa mengajukan peminjaman secara online, sedangkan admin (bagian kerumahtanggaan) mengelola stok alat, data peminjam, dan menyetujui, menolak, atau negosiasi pengajuan.

Dibangun dengan CodeIgniter 3, PHP, MySQL, dan template SB Admin 2.

**Kenapa saya membuat aplikasi ini?**

Ini merupakan aplikasi yang akan saya jadikan sebagai project skrispi saya. Sebenarnya saya sudah banyak membuat aplikasi berbasis web, namun saya lupa membackupnya. Jadi saya harus mengulang lagi dari awal demi portfolio.

**Untuk siapa sih aplikasi ini?**

Untuk yang butuh inspirasi tentang aplikasi berbasis web, terutama yang menggunakan PHP dan MySQL.

**Boleh ga memodifikasi aplikasi ini?**

**boleh** Tapi tetap sertakan siapa yang membuat aplikasi ini.


**Fiturnya apa saja sih?**

**Halaman Publik**

1. **Modul Autentikasi**

   - Login peminjam di `/login` dan login admin di `/admin/login` (halaman terpisah).
   - Registrasi peminjam di `/register`. Pendaftaran **wajib menggunakan kode undangan** yang dibuat oleh admin.
   - Akun yang baru mendaftar berstatus **non-aktif** sampai diaktifkan admin.
   - Password disimpan dalam bentuk hash (`password_hash` / `password_verify`).
   - Sesi otomatis berakhir setelah **30 menit** tidak ada aktivitas.

**Role User (Peminjam)**

2. **Dashboard Peminjam**

   Ringkasan jumlah total peminjaman, sedang dipinjam, menunggu persetujuan, menunggu konfirmasi, jumlah alat yang tersedia, dan 5 riwayat terbaru. Tersedia juga kontak admin lewat WhatsApp.

3. **Modul Daftar Alat**

   Melihat daftar alat yang berkondisi **Baik**, lengkap dengan pencarian dan pagination.

4. **Modul Peminjaman**

   - Mengajukan peminjaman (pilih alat, jumlah, tanggal pinjam, dan tanggal kembali).
   - Sistem mengecek ketersediaan stok pada rentang tanggal yang dipilih.
   - Melihat riwayat peminjaman (dengan pencarian dan pagination).
   - Membatalkan pengajuan yang masih berstatus *Menunggu* atau *Disetujui*.
   - Menyetujui atau membatalkan hasil negosiasi dari admin (status *Menunggu Konfirmasi User*).

5. **Modul Akun**

   Mengganti password. Jika password masih sementara (hasil reset admin), user wajib menggantinya saat login pertama.

**Role Admin**

6. **Dashboard Admin**

   Statistik pengajuan menunggu, alat sedang dipinjam, total alat, dan daftar alat dengan stok menipis (jumlah ≤ 3 dan kondisi Baik), serta 5 peminjaman terbaru. Admin juga bisa mengubah username dan password akunnya sendiri.

7. **Modul Data Alat**

   Melihat, menambah, mengubah, menghapus, mencari, dan **mengekspor data alat ke Excel** (`Laporan_Alat.xls`). Kode alat bersifat unik.

8. **Modul Data Peminjam**

   - Melihat, mengubah, menghapus (beserta akun login-nya), dan mencari data peminjam.
   - Mengaktifkan dan menonaktifkan akun peminjam.
   - Reset password peminjam menjadi password sementara (format `MYP` + 4 angka).
   - Membuat dan mengelola **kode undangan** pendaftaran (8 karakter, sekali pakai).

9. **Modul Data Peminjaman**

   - Melihat semua pengajuan (dengan pencarian dan pagination).
   - Memproses pengajuan baru: **setujui langsung**, **tolak** (wajib alasan), atau **nego** (mengubah tanggal / jumlah, wajib alasan).
   - Memperbarui status menjadi **Dipinjam** dan **Dikembalikan** beserta tanggalnya.
   - **Mengekspor data peminjaman ke Excel** (`Laporan_Peminjaman.xls`).


**Aturan stok:**

- Stok alat berkurang ketika peminjaman berstatus **Disetujui** (langsung oleh admin, atau setelah user menyetujui hasil nego).
- Stok bertambah kembali ketika status diubah menjadi **Dikembalikan**.
- Saat user mengajukan peminjaman, sistem menghitung stok tersedia dengan memperhitungkan peminjaman berstatus *Disetujui* / *Dipinjam* yang tanggalnya beririsan.

**Role**

Terdapat dua role, yaitu `Admin` dan `User` (peminjam).

**Teknologi**

- PHP (minimal 5.5 karena memakai `password_hash`) dan MySQL / MariaDB
- CodeIgniter 3
- Template SB Admin 2 (folder `sb-admin/`)
- Dompdf (via Composer, tersedia juga di `application/third_party/dompdf`)

File SQL: `database/db_inventaris.sql` (nama database: `db_inventaris`)

**Instalasi & Konfigurasi**

1. Download, lalu letakkan di folder web server kalian (misalnya `htdocs` pada XAMPP). Nama foldernya `AlatMYP`.
2. Masuk ke folder project, lalu buka terminal dan jalankan `composer install`.
3. Buka file `application/config/config.php`, lalu ubah `$config['base_url']` menjadi `http://localhost/namafolder/`.
4. Jika nama folder kalian bukan `AlatMYP`, ubah juga `RewriteBase /AlatMYP/` di file `.htaccess` menjadi `RewriteBase /namafolder/`.
5. Pastikan modul `mod_rewrite` Apache aktif (aplikasi memakai URL tanpa `index.php`).
6. Buat database bernama `db_inventaris`, lalu import file `database/db_inventaris.sql`.
7. Sesuaikan koneksi database di `application/config/database.php` (bawaan: host `localhost`, user `root`, password kosong, database `db_inventaris`).
8. Jalankan aplikasi di `http://localhost/namafolder/`.

**Akun untuk Login**
Admin : 
		Username : admin
		Password : admin

Peminjam : 
		Username : wadar
		Password : wadar

**Catatan:** Jika login admin gagal, jalankan `z/update_admin.php` lewat browser untuk mereset password admin menjadi `admin`. Script bantu di folder `z/` (`update_admin.php` dan `cek_password.php`) hanya untuk keperluan development, jadi **hapus folder `z/` sebelum aplikasi dipublikasikan**.

Untuk membuat akun peminjam baru: login sebagai admin, buka menu **Kode Undangan**, buat kode baru, lalu daftarkan akun lewat `/register` dan aktifkan akunnya dari menu **Data Peminjam**.


**Tentang Saya**

Anjani Kikan Putri Hermawan, Mahasiswi Universitas Amikom Yogyakarta jurusan Sistem Informasi. https://www.instagram.com/anjaniihr/
