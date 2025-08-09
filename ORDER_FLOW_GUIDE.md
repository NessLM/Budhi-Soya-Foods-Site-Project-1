# Panduan Alur Pemesanan - Budhi Soya Foods

## Alur Pemesanan yang Sudah Diperbaiki

### 1. Pembeli Membeli Produk
- Pembeli membuka halaman produk (`/product`)
- Memilih beberapa produk dengan menekan tombol "Tambah ke Pilihan"
- Produk akan muncul di sidebar kanan dengan ringkasan pesanan

### 2. Mengisi Form Pemesanan
- Setelah memilih produk, pembeli menekan "Lanjut Pesan"
- Modal form pemesanan akan muncul dengan:
  - **Informasi Pemesan**: Nama, alamat lengkap, kode pos, provinsi
  - **Ringkasan Pesanan**: Daftar produk, total item, total pembayaran
- Form wajib diisi lengkap sebelum bisa disubmit

### 3. Proses Pemesanan
- Setelah submit, sistem akan:
  - ✅ Validasi data input
  - ✅ Cek stok produk
  - ✅ Buat record di tabel `orders`
  - ✅ Buat record di tabel `order_items`
  - ✅ Update stok produk (decrement)
  - ✅ Redirect ke halaman orders

### 4. Halaman Orders (Pesanan)
- Pembeli diarahkan ke `/orders` untuk melihat semua pesanan
- Menampilkan status pesanan dan pembayaran
- Bisa melihat detail pesanan dengan klik pada pesanan

### 5. Detail Pesanan & Pembayaran
- Halaman detail pesanan (`/orders/{id}`) menampilkan:
  - **Status Pesanan**: pending, processing, shipped, delivered, cancelled
  - **Status Pembayaran**: pending, waiting_verification, paid, failed
  - **Informasi Produk**: Daftar produk yang dipesan
  - **Informasi Pengiriman**: Alamat lengkap penerima

### 6. Metode Pembayaran

#### A. QRIS Payment
- Pembeli memilih "Bayar dengan QRIS"
- Modal QRIS akan muncul dengan QR code
- Pembeli scan QRIS dengan e-wallet/mobile banking
- Setelah bayar, pembeli konfirmasi pembayaran

#### B. Transfer Manual
- Pembeli memilih "Transfer Manual"
- Form upload bukti pembayaran akan muncul
- Pembeli upload foto bukti transfer
- Isi informasi: nama pengirim, bank, jumlah transfer
- Submit bukti pembayaran

### 7. Status Pembayaran
- **Pending**: Belum ada pembayaran
- **Waiting Verification**: Bukti pembayaran sudah diupload, menunggu verifikasi admin
- **Paid**: Pembayaran sudah diverifikasi admin
- **Failed**: Pembayaran ditolak

## Perbaikan yang Telah Diterapkan

### ✅ Masalah Buffering
- **CSRF Token**: Ditambahkan meta tag CSRF di halaman product
- **JavaScript Timeout**: Ditambahkan timeout 15 detik untuk request
- **Error Handling**: Perbaikan error handling dengan pesan yang jelas
- **Loading State**: Indikator loading yang lebih baik

### ✅ Database Consistency
- **Field Name**: Perbaikan field `stok` → `jumlah_produk`
- **Payment Method**: Ditambahkan `manual_transfer` dan `qris`
- **Payment Proof**: Field untuk upload bukti pembayaran

### ✅ UI/UX Improvements
- **QRIS Integration**: Modal QRIS payment
- **Payment Methods**: Pilihan QRIS atau transfer manual
- **Status Indicators**: Badge status yang jelas
- **Responsive Design**: Tampilan yang responsif

### ✅ Server-side Optimizations
- **Logging**: Log untuk debugging
- **Exception Handling**: Custom exception handler
- **Performance Headers**: Middleware untuk optimasi
- **Cache Configuration**: Apache dan PHP optimizations

## File yang Dimodifikasi

### Controllers
- `app/Http/Controllers/OrderController.php` - Perbaikan create method
- `app/Http/Controllers/CheckoutController.php` - Recreate file

### Views
- `resources/views/product.blade.php` - Tambah CSRF token
- `resources/views/orders/show.blade.php` - QRIS integration

### JavaScript
- `public/assets/js/product.js` - Perbaikan submit order
- `public/assets/css/product.css` - Loading spinner

### Configuration
- `public/.htaccess` - Apache optimizations
- `public/php.ini` - PHP configuration
- `app/Http/Middleware/PreventBackHistory.php` - Performance headers
- `app/Exceptions/Handler.php` - Custom exception handler

## Testing Checklist

### ✅ Pemesanan
- [ ] Bisa memilih produk dari halaman product
- [ ] Form pemesanan muncul dengan data yang benar
- [ ] Submit order berhasil tanpa buffering
- [ ] Redirect ke halaman orders setelah berhasil

### ✅ Database
- [ ] Record tersimpan di tabel `orders`
- [ ] Record tersimpan di tabel `order_items`
- [ ] Stok produk berkurang sesuai quantity
- [ ] Order number generate dengan benar

### ✅ Pembayaran
- [ ] Modal QRIS muncul saat pilih QRIS
- [ ] Form upload bukti muncul saat pilih transfer manual
- [ ] Upload bukti pembayaran berhasil
- [ ] Status pembayaran berubah sesuai aksi

### ✅ Error Handling
- [ ] Error message muncul jika ada masalah
- [ ] Timeout handling berfungsi
- [ ] Log error tersimpan dengan detail

## Monitoring

### Log Files
- `storage/logs/laravel.log` - Semua error dan info log
- Browser Console - JavaScript errors
- Network Tab - Request/response details

### Database
- Tabel `orders` - Semua pesanan
- Tabel `order_items` - Item dalam pesanan
- Tabel `payment_logs` - Log pembayaran

## Next Steps

### QRIS Integration
1. Integrasi dengan payment gateway QRIS
2. Generate QR code dinamis
3. Webhook untuk callback payment
4. Auto-update status pembayaran

### Admin Panel
1. Dashboard untuk monitoring pesanan
2. Verifikasi pembayaran manual
3. Update status pesanan
4. Export laporan penjualan

### Notifications
1. Email notification untuk pembeli
2. WhatsApp notification
3. SMS notification
4. Push notification

## Troubleshooting

### Jika Masih Ada Error "Terjadi kesalahan saat memproses pesanan!"
1. Cek log di `storage/logs/laravel.log`
2. Pastikan database connection berfungsi
3. Cek apakah ada error di browser console
4. Pastikan semua migration sudah dijalankan

### Jika QRIS Tidak Muncul
1. Pastikan JavaScript tidak error
2. Cek apakah modal CSS sudah benar
3. Pastikan FontAwesome icons ter-load

### Jika Upload Bukti Pembayaran Gagal
1. Cek folder `public/uploads/payments/` sudah ada
2. Pastikan permission folder write
3. Cek ukuran file tidak melebihi 2MB
4. Pastikan format file adalah image 