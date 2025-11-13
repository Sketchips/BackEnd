# 📋 DOKUMENTASI IMPLEMENTASI SOFT DELETE

## Ringkasan Perubahan

Anda sekarang memiliki implementasi **Soft Delete** yang lengkap untuk produk dan tiket. Data yang "dihapus" akan tersimpan di database dengan kolom `deleted_at` terisi, dan riwayat penjualan tetap bisa mengakses nama produk/tiket tersebut.

---

## 1️⃣ File-File Yang Diubah

### A. Migrations (Database)
✅ **Ditambahkan:**
- `database/migrations/2025_11_13_000001_add_soft_delete_to_products_table.php`
- `database/migrations/2025_11_13_000002_add_soft_delete_to_tikets_table.php`

**Fungsi:** Menambahkan kolom `deleted_at` ke tabel `products` dan `tikets`

### B. Models
✅ **`app/Models/Addproduct.php`** - Tambah trait SoftDeletes
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Addproduct extends Model
{
    use HasFactory, SoftDeletes;
    // ... rest of code
}
```

✅ **`app/Models/Tiket.php`** - Tambah trait SoftDeletes
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Tiket extends Model
{
    use HasFactory, SoftDeletes;
    // ... rest of code
}
```

✅ **`app/Models/OrderItem.php`** - Tambah withTrashed() di relasi
```php
public function product()
{
    return $this->belongsTo(Addproduct::class, 'product_id')->withTrashed();
}

public function ticket()
{
    return $this->belongsTo(Tiket::class, 'ticket_id')->withTrashed();
}
```

### C. Controllers
✅ **Tidak ada perubahan** - `AddProductController` dan `TiketController` sudah kompatibel
- Fungsi `destroy()` akan otomatis menggunakan soft delete
- Response API tetap sama

---

## 2️⃣ Cara Kerja Soft Delete

### Sebelum Soft Delete:
```
DELETE produk ID 5 → Data hilang dari tabel → OrderItem referensi rusak
```

### Sesudah Soft Delete:
```
DELETE produk ID 5 → Set deleted_at = '2025-11-13 10:30:45' → Data masih ada
                   → OrderItem bisa akses nama produk via withTrashed()
```

---

## 3️⃣ Testing via Postman

### Setup Database Test

Buat data test dengan query:
```sql
-- Buat user test (jika belum ada)
INSERT INTO users (name, email, password) VALUES ('TestUser', 'test@example.com', 'hashed_password');

-- Buat store test
INSERT INTO stores (name, user_id) VALUES ('Test Store', 1);

-- Buat produk test
INSERT INTO products (namaProduk, kodeProduk, kategori, stok, hargaJual, user_id, store_id)
VALUES ('Test Product', 'TSP-001', 'Test', 100, 50000, 1, 1);

-- Buat tiket test
INSERT INTO tikets (namaTiket, stok, hargaJual, user_id, store_id)
VALUES ('Test Ticket', 50, 30000, 1, 1);

-- Buat order dengan order item yang referensi produk/tiket
INSERT INTO orders (user_id, customer, time, payment_method, total)
VALUES (1, 'John Doe', NOW(), 'credit_card', 50000);

INSERT INTO order_items (order_id, product_id, name, quantity, price, total_item_price, type)
VALUES (1, 1, 'Test Product', 1, 50000, 50000, 'product');

INSERT INTO order_items (order_id, ticket_id, name, quantity, price, total_item_price, type)
VALUES (1, 1, 'Test Ticket', 1, 30000, 30000, 'ticket');
```

### Test 1: Hapus Produk

**Request:**
```
DELETE http://127.0.0.1:8000/api/products/1
```

**Expected Response (Status 200):**
```json
{
    "message": "Produk berhasil dihapus"
}
```

**Verifikasi di Database:**
```sql
SELECT * FROM products WHERE id = 1;
-- Column "deleted_at" harus berisi timestamp, bukan NULL
```

### Test 2: Hapus Tiket

**Request:**
```
DELETE http://127.0.0.1:8000/api/tikets/1
```

**Expected Response (Status 200):**
```json
{
    "message": "Tiket berhasil dihapus"
}
```

**Verifikasi di Database:**
```sql
SELECT * FROM tikets WHERE id = 1;
-- Column "deleted_at" harus berisi timestamp, bukan NULL
```

### Test 3: Cek Riwayat Penjualan (OrderItem Masih Bisa Akses)

**Request:**
```
GET http://127.0.0.1:8000/api/orders/1
```

**Expected Response:**
- OrderItem masih bisa menampilkan nama produk/tiket yang sudah dihapus
- Relasi `product()` dan `ticket()` dengan `withTrashed()` akan mengambil data yang sudah dihapus
- Nama produk/tiket masih tersedia di kolom `name` di order_items

### Test 4: Restore Produk (Opsional)

Buat endpoint restore (jika diperlukan):
```php
// Tambah di ProductController jika ingin fitur restore
public function restore($id)
{
    $product = Addproduct::withTrashed()->find($id);
    
    if (!$product) {
        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }
    
    $product->restore();
    
    return response()->json(['message' => 'Produk berhasil dipulihkan', 'data' => $product], 200);
}

// Add route
Route::post('/products/{id}/restore', [ProductController::class, 'restore']);
```

**Request:**
```
POST http://127.0.0.1:8000/api/products/1/restore
```

**Verifikasi:**
```sql
SELECT * FROM products WHERE id = 1;
-- Column "deleted_at" harus NULL
```

---

## 4️⃣ Testing via Artisan Tinker

```php
php artisan tinker

// Test 1: Buat produk
$p = \App\Models\Addproduct::create([
    'namaProduk' => 'Test', 
    'kodeProduk' => 'T1', 
    'kategori' => 'Test', 
    'stok' => 10, 
    'hargaJual' => 1000, 
    'user_id' => 1
]);

// Test 2: Hapus produk (soft delete)
$p->delete();

// Test 3: Cek dengan find (tidak akan ditemukan)
\App\Models\Addproduct::find($p->id); // null

// Test 4: Cek dengan withTrashed (akan ditemukan)
\App\Models\Addproduct::withTrashed()->find($p->id); // Ada!

// Test 5: Restore
\App\Models\Addproduct::withTrashed()->find($p->id)->restore();

// Test 6: Cek lagi dengan find (akan ditemukan lagi)
\App\Models\Addproduct::find($p->id); // Ada!
```

---

## 5️⃣ SQL Queries untuk Verifikasi

### Lihat struktur tabel
```sql
DESCRIBE products;
DESCRIBE tikets;
-- Kolom "deleted_at" harus ada dengan tipe "timestamp" dan nullable
```

### Lihat produk yang dihapus
```sql
SELECT * FROM products WHERE deleted_at IS NOT NULL;
```

### Lihat produk yang aktif
```sql
SELECT * FROM products WHERE deleted_at IS NULL;
```

### Lihat semua produk (termasuk yang dihapus)
```sql
SELECT * FROM products;
```

---

## 6️⃣ Penjelasan Kenapa Masalah Terselesaikan

| Masalah | Solusi |
|---------|--------|
| Data dihapus permanen | ✅ Soft Delete menyimpan di `deleted_at`, data tetap ada |
| Riwayat penjualan tidak bisa akses nama produk/tiket yang dihapus | ✅ `withTrashed()` di OrderItem memungkinkan akses data yang sudah dihapus |
| Tidak bisa mengembalikan data yang sudah dihapus | ✅ Bisa menggunakan `restore()` untuk kembalikan data |
| Struktur API berubah | ✅ Response API tetap sama (hanya tambah kolom `deleted_at` di database) |

---

## 7️⃣ Fitur Tambahan (Opsional)

### Permanently Delete (Hard Delete)
```php
// Benar-benar hapus data dari database
Addproduct::withTrashed()->find($id)->forceDelete();
Tiket::withTrashed()->find($id)->forceDelete();
```

### Auto Restore Setelah X Hari
```php
// Di AppServiceProvider boot method
use Illuminate\Database\Eloquent\Model;

public function boot()
{
    // Restore soft deleted products older than 30 days
    Addproduct::onlyTrashed()
        ->where('deleted_at', '<', now()->subDays(30))
        ->restore();
}
```

### Exclude Soft Deleted dari API Index
```php
// AddProductController
public function index()
{
    // Hanya ambil data yang tidak dihapus
    $products = Addproduct::where('deleted_at', null)->get();
    // atau
    // $products = Addproduct::whereNull('deleted_at')->get();
    
    $products->each(function ($product) {
        $product->image = $this->getImageUrl($product->image);
    });
    
    return response()->json($products);
}
```

---

## 📝 Summary

✅ **Implementasi Soft Delete Complete!**
- Kolom `deleted_at` sudah ditambahkan ke tabel `products` dan `tikets`
- Model `Addproduct` dan `Tiket` sudah menggunakan trait `SoftDeletes`
- Relasi di `OrderItem` sudah menggunakan `withTrashed()` untuk akses data yang dihapus
- API response tetap sama, hanya tambahan kolom `deleted_at` di database
- Data yang dihapus bisa di-restore kapan saja

**Selamat! Masalah penghapusan produk dan tiket sudah terselesaikan dengan baik! 🎉**
