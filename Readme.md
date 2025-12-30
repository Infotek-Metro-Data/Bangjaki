# BangJaki - Sistem Iuran Sampah

Sistem pengelolaan iuran sampah berbasis web untuk memudahkan pengelolaan tagihan, pembayaran, dan verifikasi.

## Fitur

- **Portal Admin**: Dashboard, manajemen pelanggan, petugas, tagihan, verifikasi pembayaran, settlement
- **Portal Petugas**: Input pembayaran, riwayat, saldo, profil
- **Portal Pelanggan**: Lihat tagihan, riwayat pembayaran, profil

## Teknologi

- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS 4, Alpine.js, Vite
- **Database**: SQLite (default) / MySQL


## Kredensial Login Demo

Setelah menjalankan seeder (`php artisan db:seed`):

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@bangjaki.com | password |
| Petugas | budi@bangjaki.com | password |
| Petugas | andi@bangjaki.com | password |

## Struktur Proyek

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          
│   │   ├── Petugas/        
│   │   ├── Pelanggan/      
│   │   └── AuthController.php
│   ├── Models/          
│   └── Providers/
├── database/
│   ├── migrations/        
│   └── seeders/           
├── resources/
│   ├── css/
│   ├── js/
│   └── views/             
├── routes/
│   └── web.php            
└── public/
    └── images/           
```


