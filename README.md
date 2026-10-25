# SIM-Barang
Sistem Informasi Manajemen Inventaris Barang Jurusan — Praktikum Pemrograman Web, Politeknik Negeri Sriwijaya.

## Konsep HTTP Request & Response
1. Browser (client) mengirim **HTTP Request** ke server: berisi method (GET/POST), URL, header, dan body (untuk POST).
2. Server (Apache via Laragon/XAMPP) menjalankan PHP, mengakses MySQL bila perlu.
3. Server mengirim **HTTP Response**: status code (200 OK, 302 redirect, 404, dst), header, dan body (HTML).
4. Browser merender HTML/CSS/JS dari response tersebut.

## Gambaran Proyek
Aplikasi pencatatan aset/barang laboratorium & jurusan: login, tabel inventaris dari MySQL, tambah barang, pencarian cepat, dan ringkasan nilai aset.

## Menjalankan
1. Salin folder ke `C:\laragon\www\sim-barang` (atau `htdocs` pada XAMPP).
2. Import `sim_barang.sql` lewat phpMyAdmin.
3. Buka `http://localhost/sim-barang/login.php` — akun: `admin` / `password123`.

## Perintah Git (Pertemuan 1)
```bash
git init
git add .
git commit -m "P1: inisialisasi repositori"
git branch -M main
git remote add origin https://github.com/USERNAME/sim-barang-NIM.git
git push -u origin main
git remote -v