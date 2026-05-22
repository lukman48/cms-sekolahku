# CMS Sekolahku

**CMS Sekolahku** adalah sistem manajemen konten (CMS) dan Penerimaan Peserta Didik Baru (PPDB/PMB) berbasis web, gratis untuk sekolah SD/Sederajat, SMP/Sederajat, SMA/Sederajat, dan Perguruan Tinggi. Dibangun dengan CodeIgniter 3 dan MariaDB/MySQL.

## Fitur Unggulan

### Manajemen Akademik
- Manajemen siswa, alumni, dan rombongan belajar
- Kelola kelas, wali kelas, dan data induk
- Impor data siswa dan alumni
- Presensi siswa dengan status (Hadir, Tidak Hadir, Sakit, Izin)
- Agenda mengajar guru
- Cetak rekap presensi (PDF)

### PPDB / PMB Online
- Gelombung pendaftaran dan kuota penerimaan
- Jalur pendaftaran dan proses seleksi
- Manajemen pendaftar (diterima / tidak diterima)
- Cetak formulir pendaftaran (TCPDF)
- **Ujian Tes Tulis**: master gedung, ruang ujian, mata pelajaran ujian, jadwal, peserta, cetak kartu ujian (TCPDF)
- **Nilai Rapor**: master mata pelajaran, input nilai rapor calon siswa baru

### Manajemen Konten
- Tulisan, halaman, kategori, tag
- Galeri foto dan album
- Iklan (banner), polling, kuisioner
- Manajemen menu dan tema tampilan

### Data Induk
- Kebutuhan khusus, pendidikan, pekerjaan, status kepegawaian
- Pangkat/golongan, sumber gaji, keahlian laboratorium

### Pengguna & Hak Akses
- Multi-level user: super admin, administrator, guru/pegawai, siswa
- Modul dan hak akses per pengguna
- Profil pegawai dan siswa

### Lainnya
- Cetak dokumen PDF dengan TCPDF
- Backup database dan aplikasi
- Konfigurasi sekolah, media, sosial media, mail server
- Enkripsi session database

## Persyaratan Sistem

- PHP 7.4+
- MariaDB 10.5+ / MySQL 5.7+
- Mod Rewrite (Apache)
- Ekstensi PHP: mysqli, gd, zip

## Instalasi dengan Docker

```bash
docker-compose up -d
```

Akses `http://localhost:8080` dan ikuti proses instalasi.

### Konfigurasi Docker

| Service | Port | Keterangan |
|---------|------|------------|
| App | 8080:80 | PHP 7.4 Apache |
| DB | 3307:3306 | MariaDB 10.5 |

Database: `db_cms_sekolahku`  
User: `root`  
Password: `root`

## Instalasi Manual

1. Clone atau download repositori ini
2. Import `db/02-data.sql` ke database MariaDB/MySQL
3. Jalankan `db/03-upgrade.sql` untuk tabel tambahan
4. Sesuaikan `application/config/database.php`
5. Arahkan document root ke folder ini
6. Ikuti proses instalasi melalui browser

## Kontributor

**Anton Sofyan**  
Email : 4ntonsofyan@gmail.com  
Whatsapp : 0857 5988 8922  
Facebook : Anton Sofyan  
Website : https://sekolahku.web.id

## Lisensi

Hak Cipta (c) 2014-2023 Anton Sofyan.  
**CMS Sekolahku** dilindungi hak cipta. Dilarang memperjualbelikan atau menghapus kode sumber tanpa izin dari pengembang aplikasi.
