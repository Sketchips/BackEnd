# 🧪 API TESTING GUIDE - SOFT DELETE PRODUCTS & TIKETS

## Prerequisites

Sebelum melakukan testing, pastikan:
1. ✅ Laravel server sudah berjalan: `php artisan serve`
2. ✅ Database sudah ter-migrate: `php artisan migrate`
3. ✅ Anda memiliki Postman atau REST Client lainnya
4. ✅ Ada data user dan store di database (minimal user_id = 1)

---

## Quick Start Testing

### Option 1: Testing via CLI Script (Recommended)

```bash
# Jalankan testing script otomatis
php test_soft_delete_cli.php
```

Output akan menampilkan:
- ✅ All tests pass
- ✅ Soft delete berfungsi
- ✅ withTrashed() bekerja
- ✅ Restore functionality aktif

---

### Option 2: Testing via Artisan Tinker

```bash
php artisan tinker
```

**Command-by-command:**

```php
# 1. Buat produk test
$p = \App\Models\Addproduct::create([
    'namaProduk' => 'Laptop Gaming',
    'kodeProduk' => 'LG-001',
    'kategori' => 'Electronics',
    'stok' => 10,
    'hargaJual' => 15000000,
    'user_id' => 1
]);
echo "Product ID: {$p->id}\n";

# 2. Hapus produk (soft delete)
$p->delete();
echo "Product soft deleted\n";

# 3. Cek dengan find() - harus NULL
\App\Models\Addproduct::find($p->id);
// Output: null

# 4. Cek dengan withTrashed() - harus ada
\App\Models\Addproduct::withTrashed()->find($p->id);
// Output: App\Models\Addproduct object

# 5. Cek kolom deleted_at
$deleted = \App\Models\Addproduct::withTrashed()->find($p->id);
echo "Deleted at: {$deleted->deleted_at}\n";

# 6. Restore produk
$deleted->restore();
echo "Product restored\n";

# 7. Verifikasi restore
\App\Models\Addproduct::find($p->id);
// Output: App\Models\Addproduct object (dengan deleted_at = null)
```

---

### Option 3: Testing via Postman

#### Test Case 1: Delete Product API

**Endpoint:**
```
DELETE http://127.0.0.1:8000/api/products/1
```

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Expected Response (200 OK):**
```json
{
    "message": "Produk berhasil dihapus"
}
```

**Database Verification:**
```sql
SELECT id, namaProduk, deleted_at FROM products WHERE id = 1;
-- Output: deleted_at column akan berisi timestamp
```

---

#### Test Case 2: Delete Tiket API

**Endpoint:**
```
DELETE http://127.0.0.1:8000/api/tikets/1
```

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Expected Response (200 OK):**
```json
{
    "message": "Tiket berhasil dihapus"
}
```

**Database Verification:**
```sql
SELECT id, namaTiket, deleted_at FROM tikets WHERE id = 1;
-- Output: deleted_at column akan berisi timestamp
```

---

#### Test Case 3: Get Products List (Soft Deleted Hidden)

**Endpoint:**
```
GET http://127.0.0.1:8000/api/products
```

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Expected Response:**
```json
[
    {
        "id": 2,
        "namaProduk": "Product 2",
        "kodeProduk": "P-002",
        "kategori": "Electronics",
        "stok": 5,
        "hargaJual": "1000000.00",
        "keterangan": null,
        "image": null,
        "user_id": 1,
        "store_id": null,
        "created_at": "2025-11-13T10:00:00.000000Z",
        "updated_at": "2025-11-13T10:00:00.000000Z",
        "deleted_at": null
    }
]
```

**Note:** Product dengan deleted_at yang berisi value tidak akan muncul di list ini (Laravel default behavior)

---

#### Test Case 4: Get Orders dengan Relation ke Soft Deleted Product

**Endpoint:**
```
GET http://127.0.0.1:8000/api/orders/1
```

**Expected Behavior:**
- Order Items masih bisa menampilkan nama product/tiket yang sudah dihapus
- Hal ini karena relasi menggunakan `withTrashed()`

**Contoh Response:**
```json
{
    "id": 1,
    "user_id": 1,
    "customer": "John Doe",
    "time": "2025-11-13 10:00:00",
    "payment_method": "credit_card",
    "total": "50000.00",
    "created_at": "2025-11-13T10:00:00.000000Z",
    "updated_at": "2025-11-13T10:00:00.000000Z",
    "items": [
        {
            "id": 1,
            "order_id": 1,
            "product_id": 1,
            "ticket_id": null,
            "name": "Laptop Gaming",
            "quantity": 1,
            "price": "15000000.00",
            "total_item_price": "15000000.00",
            "type": "product",
            "created_at": "2025-11-13T10:00:00.000000Z",
            "updated_at": "2025-11-13T10:00:00.000000Z",
            "product": {
                "id": 1,
                "namaProduk": "Laptop Gaming",
                "kodeProduk": "LG-001",
                "deleted_at": "2025-11-13T10:30:45.000000Z"
            }
        }
    ]
}
```

**⭐ PENTING:** Kolom `product` (dari relasi) masih menampilkan data product yang sudah dihapus!

---

## 📊 Database Verification Queries

### 1. Lihat struktur tabel setelah migration

```sql
-- Check products table
DESC products;
-- Verifikasi: Ada kolom "deleted_at" dengan type "timestamp"

-- Check tikets table
DESC tikets;
-- Verifikasi: Ada kolom "deleted_at" dengan type "timestamp"
```

### 2. Lihat data yang sudah dihapus

```sql
-- Lihat semua product yang sudah soft deleted
SELECT id, namaProduk, deleted_at 
FROM products 
WHERE deleted_at IS NOT NULL;

-- Lihat semua tiket yang sudah soft deleted
SELECT id, namaTiket, deleted_at 
FROM tikets 
WHERE deleted_at IS NOT NULL;
```

### 3. Lihat data yang masih aktif

```sql
-- Lihat hanya product yang aktif
SELECT id, namaProduk, deleted_at 
FROM products 
WHERE deleted_at IS NULL;

-- Lihat hanya tiket yang aktif
SELECT id, namaTiket, deleted_at 
FROM tikets 
WHERE deleted_at IS NULL;
```

### 4. Lihat semua data (termasuk yang dihapus)

```sql
-- Lihat SEMUA product (termasuk soft deleted)
SELECT * FROM products;

-- Lihat SEMUA tiket (termasuk soft deleted)
SELECT * FROM tikets;
```

### 5. Verifikasi relasi OrderItem

```sql
-- Lihat order items yang referensi soft deleted products
SELECT oi.id, oi.product_id, oi.name, p.namaProduk, p.deleted_at
FROM order_items oi
LEFT JOIN products p ON oi.product_id = p.id
WHERE p.deleted_at IS NOT NULL;

-- Lihat order items yang referensi soft deleted tikets
SELECT oi.id, oi.ticket_id, oi.name, t.namaTiket, t.deleted_at
FROM order_items oi
LEFT JOIN tikets t ON oi.ticket_id = t.id
WHERE t.deleted_at IS NOT NULL;
```

---

## 🔄 Full Workflow Test Scenario

### Scenario: Produk yang sudah terjual tidak bisa dihapus (Sebelum Fix)

**SEBELUM SOFT DELETE:**
```
1. Admin buat produk "Laptop Gaming" (ID: 1)
2. Customer beli produk tersebut → Order item ter-create
3. Admin coba hapus produk
4. ❌ MASALAH: Data hilang, riwayat penjualan rusak
```

**SESUDAH SOFT DELETE:**
```
1. Admin buat produk "Laptop Gaming" (ID: 1)
2. Customer beli produk tersebut → Order item ter-create
3. Admin coba hapus produk
4. ✅ BERHASIL: Data tetap ada (deleted_at diisi)
5. ✅ Riwayat penjualan tetap bisa menampilkan nama produk
6. ✅ Admin bisa restore produk jika diperlukan
```

### Full Test Commands

```bash
# Step 1: Jalankan server
php artisan serve

# Step 2: (Di terminal baru) Jalankan testing script
php test_soft_delete_cli.php

# Step 3: Atau manual testing dengan Tinker
php artisan tinker
# ... eksekusi commands di atas

# Step 4: Verifikasi database
# Buka database client (MySQL, DBeaver, etc)
SELECT * FROM products WHERE deleted_at IS NOT NULL;
```

---

## ✅ Verification Checklist

Setelah menjalankan test, pastikan:

- [ ] Kolom `deleted_at` ada di tabel `products`
- [ ] Kolom `deleted_at` ada di tabel `tikets`
- [ ] `Addproduct::find($id)` return null untuk data yang dihapus
- [ ] `Addproduct::withTrashed()->find($id)` return data yang dihapus
- [ ] `deleted_at` column terisi dengan timestamp saat data dihapus
- [ ] `OrderItem->product()` masih bisa akses product yang dihapus
- [ ] `OrderItem->ticket()` masih bisa akses tiket yang dihapus
- [ ] `$model->restore()` berhasil mengembalikan data yang dihapus
- [ ] API response tetap konsisten (status 200/201)
- [ ] Tidak ada error di application logs

---

## 🐛 Troubleshooting

### Problem: `deleted_at` column tidak ada

**Solution:**
```bash
php artisan migrate
# atau
php artisan migrate --path=database/migrations/2025_11_13_000001_add_soft_delete_to_products_table.php
```

### Problem: Data masih muncul di API list padahal sudah dihapus

**Solution:** Ini adalah expected behavior! Soft deleted data tidak muncul di query default. Jika ingin melihatnya:
```php
// Use withTrashed()
Addproduct::withTrashed()->get();
```

### Problem: Relasi product/ticket di OrderItem return null

**Solution:** Pastikan OrderItem relation sudah menggunakan `withTrashed()`:
```php
public function product()
{
    return $this->belongsTo(Addproduct::class, 'product_id')->withTrashed();
}
```

### Problem: forceDelete() tidak bekerja

**Solution:** Pastikan menggunakan `withTrashed()` terlebih dahulu:
```php
// ❌ SALAH
Addproduct::find($id)->forceDelete();

// ✅ BENAR
Addproduct::withTrashed()->find($id)->forceDelete();
```

---

## 📚 References

- Laravel Soft Deletes: https://laravel.com/docs/eloquent#soft-deleting
- Eloquent Relationships: https://laravel.com/docs/eloquent-relationships

---

## 🎉 Conclusion

Soft Delete sudah siap untuk digunakan! Anda dapat menghapus produk dan tiket tanpa khawatir menghancurkan riwayat penjualan. Semua test case sudah tersedia dan bisa dijalankan dengan mudah.

**Happy Testing! 🚀**
