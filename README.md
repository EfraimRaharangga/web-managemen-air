# 💧 Web Manajemen Air

Sistem informasi manajemen air berbasis web yang dibangun menggunakan **HTML**, **Bootstrap 5**, **PHP Native**, **jQuery**, dan **MySQL**. Sistem ini dirancang untuk mempermudah pengelolaan penggunaan dan pembayaran air oleh masyarakat dengan fitur akses khusus berdasarkan jenis pengguna.

## 🔐 Jenis Pengguna

- **Admin**

  - Mengelola data pengguna (admin, bendahara, warga, petugas)
  - Monitoring aktivitas sistem

- **Bendahara**

  - Mengelola data tagihan dan pembayaran
  - Membuat laporan keuangan terkait air

- **Petugas**

  - Mencatat meteran air bulanan warga
  - Input data pemakaian air ke sistem

- **Warga**
  - Melihat tagihan air
  - Melakukan pembayaran air

## 🧰 Teknologi yang Digunakan

- **Frontend**: HTML5, Bootstrap 5, jQuery
- **Backend**: PHP Native
- **Database**: MySQL

## 🚀 Fitur Utama

- Login multi-user dengan akses berbeda-beda
- Manajemen data meteran air dan tagihan
- Pencatatan pembayaran dan transaksi
- Dashboard interaktif untuk masing-masing pengguna
- Riwayat penggunaan dan laporan keuangan

## 🛠️ Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/nama-projek.git
   ```
2. **Import Database**
   file import database & table berada di file database

## 📁 Struktur File

├── README.md
├── index.php
├── login/
│ ├── dashboard.php
│ └── logout.php
├── assets/
│ ├── demo/
│ ├── chart-area-demo.js
│ ├── chart-bar-demo.js
│ ├── chart-pie-demo.js
│ ├── datatables-demo.js
│ ├── img/
│ ├── error-404-monochorme.svg
└── wave.png
│ ├── css/
└── styles.php
│ ├── js/
│ ├── air.js
│ ├── datatables-simple-demo.js
│ ├── jquery-3.7.1.js
└── scripts.js
│ └── function.php
├── database/
│ └── air.sql
