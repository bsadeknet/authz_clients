# Authz Client

`authz_client` adalah PHP library ringan yang dirancang untuk memvalidasi dan mengubah token akses Laravel Passport (atau token otorisasi lainnya) menjadi claims terstruktur melalui komunikasi dengan server Authorization (Authz).

## Fitur Utama

* **Validasi Token Dinamis:** Mendukung verifikasi token secara real-time ke Authz Server eksternal.
* **Konfigurasi Berbasis Metadata:** Pengaturan fleksibel melalui array konfigurasi (URL, method, timeout, dll).
* **Penanganan Error Kustom:** Menyediakan exception kustom (`AuthzException`) untuk menangani status HTTP atau kegagalan koneksi secara presisi.
* **Ringan & Minimalis:** Dibangun tanpa ketergantungan berlebih agar mudah diintegrasikan ke berbagai arsitektur backend.

---

### instalasi
```bash
#instal via Composer di project Laravel
composer require bsadeknet/authz-client
```

### publish konfigurasi
```bash
#ketik perintah ini di terminal project Laravel
php artisan vendor:publish --tag=authz-config
```