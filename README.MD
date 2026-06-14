<div align="center">
  <img src="https://img.icons8.com/color/96/000000/mosque.png" alt="Mosque Icon"/>
  <h1>🕋 Al-Mabrur Travel Management System</h1>
  <p><i>Sistem Manajemen Perjalanan Umroh & Haji Terpercaya Terintegrasi secara Real-Time</i></p>
  
  [![Status](https://img.shields.io/badge/Status-Completed-success.svg?style=flat-square)]()
  [![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)]()
  [![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)]()
  [![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)]()
  [![PHP API](https://img.shields.io/badge/PHP_Native-777BB4?style=flat-square&logo=php&logoColor=white)]()
  [![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)]()
</div>

---

## 📖 Tentang Projek

**Al-Mabrur Travel** adalah aplikasi antarmuka web interaktif (berbasis AJAX) yang dirancang untuk mengelola data jamaah, paket keberangkatan, serta kelengkapan dokumen perjalanan umroh. Sistem ini dibangun dengan konsep antarmuka modern yang meminimalisir *reload* halaman, memberikan pengalaman pengguna (UX) yang mulus layaknya sebuah *Single Page Application* (SPA).

Projek ini merupakan implementasi nyata dari perpaduan UI/UX interaktif dengan fungsionalitas Backend mumpuni.

---

## ✨ Fitur Terselesaikan

Aplikasi ini telah dilengkapi dengan berbagai fitur inti yang sudah beroperasi 100%, di antaranya:

* 🗂️ **Manajemen Data & Dokumen (CRUD + Multiple Upload)**
    * Fungsionalitas Create, Read, Update, Delete untuk entitas Jamaah dan Paket Umroh secara *real-time* via Fetch API.
    * Dukungan **Upload Multiple File** secara bersamaan (KTP, Paspor, dll) dengan fitur *Drag & Drop* yang dikirim melalui `FormData`.
* 🔍 **Pencarian & Penyaringan Data**
    * Pencarian data instan terintegrasi, memudahkan admin menemukan data spesifik dari ribuan daftar jamaah atau paket perjalanan.
* 📊 **DataTables & Konversi Ekspor Data**
    * Penyajian tabel dinamis menggunakan library **DataTables**.
    * Dilengkapi fitur konversi otomatis untuk mengekspor data tabel langsung ke dalam format **PDF, Excel, CSV**, maupun **Print**.
* ✍️ **Tanda Tangan Digital (HTML5 Canvas)**
    * Integrasi `canvas` interaktif untuk keperluan penandatanganan kontrak secara digital.
    * Mendukung *mouse* desktop maupun layar sentuh (*touchscreen*), lengkap dengan opsi perubahan warna dan ketebalan tinta, serta konversi hasil menjadi *Base64/PNG*.
* 🎬 **Multimedia (Video Background & Animasi CSS)**
    * Estetika UI yang memanjakan mata menggunakan tata letak *aesthetic*.
    * Penerapan **Video Background Otomatis** (melalui YouTube iframe API) pada halaman *Dashboard* dengan *overlay* elegan, dipadukan dengan transisi mikro (animasi CSS) pada setiap komponen kartu dan tombol.
* 🪟 **Interaksi Dinamis via Modal Bootstrap**
    * Semua interaksi form (Tambah, Edit, Hapus, Canvas TTD, dan File Viewer) dibungkus secara elegan menggunakan komponen Modal, menjaga *flow* pengguna tetap fokus pada satu halaman tanpa interupsi.
* 🔐 **Sistem Autentikasi (Login)**
    * Halaman masuk (Login) dan Pendaftaran (Register) dengan UI terpisah *(toggle view)*.
    * Memanfaatkan penyimpanan kredensial pada skala sesi lokal *(Local Storage / Session)* untuk memvalidasi akses admin ke area *Dashboard*.

---

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi/Library |
| :--- | :--- |
| **Frontend Utama** | HTML5, CSS3 (Native Variables), Vanilla JavaScript |
| **Styling & Komponen** | Bootstrap 5.3, FontAwesome 6 |
| **Tabel Interaktif** | DataTables (berserta PDFMake & JSZip untuk ekspor) |
| **Backend & API** | PHP Native (REST API Concept) |
| **Database** | MySQL |
| **Transfer Data** | AJAX (JavaScript Fetch API), JSON, FormData |

---

## 🚀 Cara Menjalankan Projek (Instalasi Lokal)

Untuk menjalankan aplikasi ini secara fungsional di lingkungan lokal komputer Anda:

1.  **Persiapkan Server Lokal:** Pastikan aplikasi seperti XAMPP, Laragon, atau MAMP terinstal.
2.  **Kloning/Salin Repositori:** Letakkan folder projek ini ke dalam direktori server (contoh: `C:\xampp\htdocs\almabrur`).
3.  **Buat Database:**
    * Buka `phpMyAdmin` (biasanya di `localhost/phpmyadmin`).
    * Buat database baru dengan nama `db_almabrur`.
    * Jalankan *query* SQL yang dibutuhkan (Tabel `jamaah` dan `paket`) atau impor file `.sql` jika tersedia.
4.  **Siapkan Direktori Upload:** Buat folder kosong bernama `uploads` di dalam folder *root* projek ini.
5.  **Akses Aplikasi:** Buka browser dan kunjungi: `http://localhost/almabrur/login.html`

> **Note:** Gunakan kredensial demo `admin@almabrur.com` dengan password `admin123` untuk melihat *preview* langsung, atau lakukan pendaftaran akun baru.

---

<div align="center">
  <br>
  <p>Dikembangkan dengan ☕ dan ❤️ untuk efisiensi sistem biro perjalanan.</p>
</div>