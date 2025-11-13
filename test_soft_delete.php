<?php

// Script untuk testing Soft Delete functionality
// Jalankan: php tinker < test_soft_delete.php
// Atau jalankan setiap command di PHP Tinker

// ============ TEST 1: Buat produk test ============
echo "=== TEST 1: Buat Produk Test ===\n";
$product = \App\Models\Addproduct::create([
    'namaProduk' => 'Test Product Soft Delete',
    'kodeProduk' => 'TSP-' . time(),
    'kategori' => 'Test',
    'stok' => 100,
    'hargaJual' => 50000,
    'keterangan' => 'Testing soft delete',
    'user_id' => 1
]);
echo "Produk dibuat dengan ID: " . $product->id . "\n";
echo "Nama: " . $product->namaProduk . "\n";

// ============ TEST 2: Buat tiket test ============
echo "\n=== TEST 2: Buat Tiket Test ===\n";
$tiket = \App\Models\Tiket::create([
    'namaTiket' => 'Test Tiket Soft Delete',
    'stok' => 50,
    'hargaJual' => 30000,
    'keterangan' => 'Testing soft delete',
    'user_id' => 1
]);
echo "Tiket dibuat dengan ID: " . $tiket->id . "\n";
echo "Nama: " . $tiket->namaTiket . "\n";

// ============ TEST 3: Hapus produk (Soft Delete) ============
echo "\n=== TEST 3: Hapus Produk (Soft Delete) ===\n";
$productId = $product->id;
$product->delete();
echo "Produk dihapus (soft delete)\n";

// Coba ambil produk yang sudah dihapus
$deletedProduct = \App\Models\Addproduct::find($productId);
echo "Ambil dengan find(): " . ($deletedProduct ? "DITEMUKAN" : "TIDAK DITEMUKAN (BENAR!)") . "\n";

// Ambil dengan withTrashed
$trashedProduct = \App\Models\Addproduct::withTrashed()->find($productId);
echo "Ambil dengan withTrashed(): " . ($trashedProduct ? "DITEMUKAN (BENAR!)" : "TIDAK DITEMUKAN") . "\n";
echo "deleted_at value: " . ($trashedProduct->deleted_at ?? 'null') . "\n";

// ============ TEST 4: Hapus tiket (Soft Delete) ============
echo "\n=== TEST 4: Hapus Tiket (Soft Delete) ===\n";
$tiketId = $tiket->id;
$tiket->delete();
echo "Tiket dihapus (soft delete)\n";

// Coba ambil tiket yang sudah dihapus
$deletedTiket = \App\Models\Tiket::find($tiketId);
echo "Ambil dengan find(): " . ($deletedTiket ? "DITEMUKAN" : "TIDAK DITEMUKAN (BENAR!)") . "\n";

// Ambil dengan withTrashed
$trashedTiket = \App\Models\Tiket::withTrashed()->find($tiketId);
echo "Ambil dengan withTrashed(): " . ($trashedTiket ? "DITEMUKAN (BENAR!)" : "TIDAK DITEMUKAN") . "\n";
echo "deleted_at value: " . ($trashedTiket->deleted_at ?? 'null') . "\n";

// ============ TEST 5: Restore Produk ============
echo "\n=== TEST 5: Restore Produk ===\n";
\App\Models\Addproduct::withTrashed()->find($productId)->restore();
$restoredProduct = \App\Models\Addproduct::find($productId);
echo "Produk di-restore\n";
echo "Ambil dengan find(): " . ($restoredProduct ? "DITEMUKAN (BENAR!)" : "TIDAK DITEMUKAN") . "\n";
echo "deleted_at value: " . ($restoredProduct->deleted_at ?? 'null') . "\n";

// ============ TEST 6: Restore Tiket ============
echo "\n=== TEST 6: Restore Tiket ===\n";
\App\Models\Tiket::withTrashed()->find($tiketId)->restore();
$restoredTiket = \App\Models\Tiket::find($tiketId);
echo "Tiket di-restore\n";
echo "Ambil dengan find(): " . ($restoredTiket ? "DITEMUKAN (BENAR!)" : "TIDAK DITEMUKAN") . "\n";
echo "deleted_at value: " . ($restoredTiket->deleted_at ?? 'null') . "\n";

echo "\n=== TESTING SELESAI ===\n";
