# CAPSTONE PROJECT Fullstack#5 Kelompok 5

## Langkah-langkah Penggunaan

Berikut adalah langkah-langkah untuk mengkloning dan menjalankan proyek ini secara lokal.

1. **Persiapkan Tools:**

    - Pastikan XAMPP/Laragon dan Composer sudah terinstal.

2. **Clone Proyek dari GitHub:**
    ```bash
    git clone https://github.com/FS5Gamelab/Capstone_Kelompok5.git
    ```
3. **Masuk ke direktori project**
    ```bash
    cd Capstone_Kelompok5
    ```
4. **Instal Dependensi Composer**
    ```bash
    composer install
    ```
5. **Buat salinan .env**
    - Duplikat file .env.example dan ubah namanya menjadi .env
    - Kemudian, konfigurasi file .env sesuai kebutuhan, seperti konfigurasi database.
6. **Generate Key Aplikasi**
    ```bash
    php artisan key:generate
    ```
7. **Jalankan Migrasi Database**
    ```bash
    php artisan migrate --seed
    ```
8. **Jalankan Server Lokal**

-   Pada terminal jalankan :
    ```
    php artisan serve
    ```
