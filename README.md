# 🚗 Glo Repair Car

**Glo Repair Car** adalah sistem informasi bengkel otomotif berbasis web yang dikembangkan menggunakan metode **Agile Scrum**. Proyek ini bertujuan untuk mendigitalisasi proses manual seperti pencatatan servis, laporan keuangan, dan komunikasi dengan pelanggan.

## ✨ Fitur Utama

- Company profile bengkel
- Autentikasi admin
- Cek progres perbaikan kendaraan
- Manajemen entri servis
- Chat real-time pelanggan-admin
- Feedback & rating
- Info lokasi dan kontak bengkel
- Laporan keuangan otomatis & manual
- Estimasi servis berikutnya

## ⚙️ Teknologi

- HTML, CSS, JS
- PHP & MySQL
- Metodologi: Agile Scrum
- Pengujian: Black Box Testing

## 🚀 Cara Menjalankan

1. **Clone repositori**
   ```bash
   git clone https://github.com/adlifarizi/glo-repair-car.git
   cd glo-repair-car
   ```

2. **Install dependensi**
    ```bash
    composer install
    npm install
    ```

3. **Konfigurasi file `.env`**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Jalankan migrasi database**
    ```bash
    php artisan migrate --seed
    ```

4. **Jalankan Aplikasi**
    ```bash
    npm run dev
    php artisan serve
    ```
Aplikasi akan berjalan di `http://localhost:8000`.

## 👥 Tim
- Glorian Beda – Scrum Master
- Adli Farizi – Developer
- Icha Maulidya – System Analyst
- Cynthia O. P. Salma – UI/UX Designer
