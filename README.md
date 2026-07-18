# Perpustakaan App

Aplikasi manajemen perpustakaan berbasis Laravel untuk mengelola anggota, koleksi buku, dan peminjaman.

## Deskripsi
Aplikasi Perpustakaan App ini dibuat untuk memenuhi technical test.
Perpustakaan App adalah aplikasi CRUD sederhana yang dibangun dengan Laravel 12. Aplikasi ini menyediakan:

- Manajemen anggota perpustakaan (member)
- Manajemen koleksi buku
- Pencatatan peminjaman dan pengembalian buku
- Pengurangan dan penambahan stok buku otomatis saat meminjam dan mengembalikan
- Dashboard ringkas untuk melihat aktivitas peminjaman
- Autentikasi pengguna dan halaman profil bawaan Laravel

## Fitur Utama

- `members`: tambah, edit, hapus, daftar anggota
- `books`: tambah, edit, hapus, daftar buku
- `borrowings`: catat peminjaman, catat pengembalian, tampilkan riwayat
- Otomatis menurunkan stok buku saat dipinjam dan menaikkannya saat dikembalikan
- Halaman dashboard dengan grafik aktivitas peminjaman 7 hari terakhir
- Proteksi route dengan middleware `auth`

## Teknologi

- PHP 8.2
- Laravel 12
- Laravel Breeze (autentikasi)
- Tailwind CSS
- Vite
- Alpine.js
- MySQL / database relasional apa pun yang didukung Laravel

## Struktur Database

Terdapat tiga model utama:

- `Member` dengan `member_no`, `name`, `date_of_birth`
- `Book` dengan `title`, `publisher`, `dimension`, `stock`
- `Borrowing` dengan `member_id`, `book_id`, `borrow_date`, `return_date`

Relasi:

- Member hasMany Borrowing
- Book hasMany Borrowing
- Borrowing belongsTo Member
- Borrowing belongsTo Book

## Installasi

1. Clone repository
    ```bash
    git clone [https://github.com/luxur1a/perpustakaan-app.git]
    cd perpustakaan-app
    ```
2. Salin file environment:
    ```bash
    cp .env.example .env
    ```
3. Pasang dependensi PHP:
    ```bash
    composer install
    ```
4. Buat key aplikasi:
    ```bash
    php artisan key:generate
    ```
5. Konfigurasi koneksi database di `.env`
6. Jalankan migrasi:
    ```bash
    php artisan migrate
    ```
7. Pasang dependensi frontend:
    ```bash
    npm install
    ```
8. Bangun asset frontend:
    ```bash
    npm run build
    ```

## Menjalankan Aplikasi

```bash
php artisan serve
npm run dev
```

Kemudian buka: `http://127.0.0.1:8000`

## Testing

```bash
php artisan test
```

## Routes Utama

- `/` - halaman depan
- `/dashboard` - ringkasan aktivitas peminjaman (login diperlukan)
- `/members` - manajemen anggota
- `/books` - manajemen buku
- `/borrowings` - manajemen peminjaman

