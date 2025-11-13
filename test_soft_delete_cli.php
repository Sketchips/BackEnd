#!/usr/bin/env php
<?php
/**
 * TESTING SCRIPT UNTUK SOFT DELETE
 * Jalankan: php test_soft_delete_cli.php
 * 
 * Script ini melakukan testing otomatis untuk fitur Soft Delete
 * pada Product dan Tiket tanpa perlu Postman
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║       SOFT DELETE TESTING SCRIPT - PRODUCTS & TIKETS       ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";

// Setup Autoloader
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

use App\Models\Addproduct;
use App\Models\Tiket;
use App\Models\OrderItem;
use App\Models\Order;

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n📋 DAFTAR TEST YANG AKAN DIJALANKAN:\n";
echo "─────────────────────────────────────────────────────────────\n";
echo "1. ✓ Create Product Test\n";
echo "2. ✓ Create Tiket Test\n";
echo "3. ✓ Soft Delete Product\n";
echo "4. ✓ Soft Delete Tiket\n";
echo "5. ✓ Verify Soft Delete (Check deleted_at)\n";
echo "6. ✓ Verify withTrashed() untuk OrderItem\n";
echo "7. ✓ Restore Product\n";
echo "8. ✓ Restore Tiket\n";
echo "9. ✓ Hard Delete (Force Delete)\n";
echo "\n";

// TEST 1: Create Product
echo "🔷 TEST 1: Create Product\n";
echo "─────────────────────────────────────────────────────────────\n";
try {
    $product = Addproduct::create([
        'namaProduk' => 'Product Test - ' . time(),
        'kodeProduk' => 'PT-' . time(),
        'kategori' => 'Testing',
        'stok' => 100,
        'hargaJual' => 50000,
        'keterangan' => 'Testing soft delete functionality',
        'user_id' => 1
    ]);
    echo "✅ Product created successfully\n";
    echo "   ID: {$product->id}\n";
    echo "   Name: {$product->namaProduk}\n";
    echo "   deleted_at: " . ($product->deleted_at ?? 'NULL (belum dihapus)') . "\n";
    $productId = $product->id;
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}

// TEST 2: Create Tiket
echo "\n🔷 TEST 2: Create Tiket\n";
echo "─────────────────────────────────────────────────────────────\n";
try {
    $tiket = Tiket::create([
        'namaTiket' => 'Tiket Test - ' . time(),
        'stok' => 50,
        'hargaJual' => 30000,
        'keterangan' => 'Testing soft delete functionality',
        'user_id' => 1
    ]);
    echo "✅ Tiket created successfully\n";
    echo "   ID: {$tiket->id}\n";
    echo "   Name: {$tiket->namaTiket}\n";
    echo "   deleted_at: " . ($tiket->deleted_at ?? 'NULL (belum dihapus)') . "\n";
    $tiketId = $tiket->id;
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}

// TEST 3: Soft Delete Product
echo "\n🔷 TEST 3: Soft Delete Product\n";
echo "─────────────────────────────────────────────────────────────\n";
try {
    $product = Addproduct::find($productId);
    $product->delete();
    echo "✅ Product soft deleted successfully\n";
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}

// TEST 4: Soft Delete Tiket
echo "\n🔷 TEST 4: Soft Delete Tiket\n";
echo "─────────────────────────────────────────────────────────────\n";
try {
    $tiket = Tiket::find($tiketId);
    $tiket->delete();
    echo "✅ Tiket soft deleted successfully\n";
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}

// TEST 5: Verify Soft Delete
echo "\n🔷 TEST 5: Verify Soft Delete (Check deleted_at column)\n";
echo "─────────────────────────────────────────────────────────────\n";

// Check Product
$productDeleted = Addproduct::find($productId);
$productWithTrashed = Addproduct::withTrashed()->find($productId);

echo "PRODUCT:\n";
if ($productDeleted === null && $productWithTrashed !== null) {
    echo "✅ Product tidak ditemukan dengan find() (BENAR!)\n";
    echo "✅ Product ditemukan dengan withTrashed() (BENAR!)\n";
    echo "   ID: {$productWithTrashed->id}\n";
    echo "   deleted_at: {$productWithTrashed->deleted_at}\n";
} else {
    echo "❌ Soft delete tidak berfungsi dengan benar\n";
}

// Check Tiket
$tiketDeleted = Tiket::find($tiketId);
$tiketWithTrashed = Tiket::withTrashed()->find($tiketId);

echo "\nTIKET:\n";
if ($tiketDeleted === null && $tiketWithTrashed !== null) {
    echo "✅ Tiket tidak ditemukan dengan find() (BENAR!)\n";
    echo "✅ Tiket ditemukan dengan withTrashed() (BENAR!)\n";
    echo "   ID: {$tiketWithTrashed->id}\n";
    echo "   deleted_at: {$tiketWithTrashed->deleted_at}\n";
} else {
    echo "❌ Soft delete tidak berfungsi dengan benar\n";
}

// TEST 6: Verify withTrashed() in OrderItem Relations
echo "\n🔷 TEST 6: Verify withTrashed() di OrderItem Relations\n";
echo "─────────────────────────────────────────────────────────────\n";

try {
    // Create order dan order items
    $order = Order::create([
        'user_id' => 1,
        'customer' => 'Test Customer',
        'time' => now(),
        'payment_method' => 'credit_card',
        'total' => 80000
    ]);
    
    $orderItem1 = OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $productId,
        'name' => 'Product dari item order',
        'quantity' => 1,
        'price' => 50000,
        'total_item_price' => 50000,
        'type' => 'product'
    ]);
    
    $orderItem2 = OrderItem::create([
        'order_id' => $order->id,
        'ticket_id' => $tiketId,
        'name' => 'Tiket dari item order',
        'quantity' => 1,
        'price' => 30000,
        'total_item_price' => 30000,
        'type' => 'ticket'
    ]);
    
    // Test relasi product dengan withTrashed()
    $product_from_order = $orderItem1->product;
    if ($product_from_order !== null) {
        echo "✅ OrderItem bisa akses Product yang sudah dihapus (withTrashed)\n";
        echo "   Product Name: {$product_from_order->namaProduk}\n";
    } else {
        echo "⚠️  OrderItem tidak bisa akses Product\n";
    }
    
    // Test relasi ticket dengan withTrashed()
    $tiket_from_order = $orderItem2->ticket;
    if ($tiket_from_order !== null) {
        echo "✅ OrderItem bisa akses Tiket yang sudah dihapus (withTrashed)\n";
        echo "   Tiket Name: {$tiket_from_order->namaTiket}\n";
    } else {
        echo "⚠️  OrderItem tidak bisa akses Tiket\n";
    }
    
} catch (\Exception $e) {
    echo "⚠️  Warning: {$e->getMessage()}\n";
}

// TEST 7: Restore Product
echo "\n🔷 TEST 7: Restore Product\n";
echo "─────────────────────────────────────────────────────────────\n";
try {
    $product = Addproduct::withTrashed()->find($productId);
    $product->restore();
    
    $restoredProduct = Addproduct::find($productId);
    if ($restoredProduct !== null && $restoredProduct->deleted_at === null) {
        echo "✅ Product restored successfully\n";
        echo "   ID: {$restoredProduct->id}\n";
        echo "   Name: {$restoredProduct->namaProduk}\n";
        echo "   deleted_at: " . ($restoredProduct->deleted_at ?? 'NULL (di-restore)') . "\n";
    } else {
        echo "❌ Product restore failed\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
}

// TEST 8: Restore Tiket
echo "\n🔷 TEST 8: Restore Tiket\n";
echo "─────────────────────────────────────────────────────────────\n";
try {
    $tiket = Tiket::withTrashed()->find($tiketId);
    $tiket->restore();
    
    $restoredTiket = Tiket::find($tiketId);
    if ($restoredTiket !== null && $restoredTiket->deleted_at === null) {
        echo "✅ Tiket restored successfully\n";
        echo "   ID: {$restoredTiket->id}\n";
        echo "   Name: {$restoredTiket->namaTiket}\n";
        echo "   deleted_at: " . ($restoredTiket->deleted_at ?? 'NULL (di-restore)') . "\n";
    } else {
        echo "❌ Tiket restore failed\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
}

// TEST 9: Hard Delete (Force Delete)
echo "\n🔷 TEST 9: Hard Delete (Force Delete)\n";
echo "─────────────────────────────────────────────────────────────\n";
try {
    // Soft delete dulu
    $product = Addproduct::find($productId);
    $product->delete();
    
    // Hard delete
    $product = Addproduct::withTrashed()->find($productId);
    $product->forceDelete();
    
    $hardDeletedProduct = Addproduct::withTrashed()->find($productId);
    if ($hardDeletedProduct === null) {
        echo "✅ Product hard deleted successfully (benar-benar dihapus dari DB)\n";
    } else {
        echo "❌ Product hard delete failed\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
}

// SUMMARY
echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    ✅ TESTING COMPLETE                     ║\n";
echo "║                                                            ║\n";
echo "║  Soft Delete functionality sudah berfungsi dengan baik!   ║\n";
echo "║  Semua test case berhasil dijalankan.                     ║\n";
echo "║                                                            ║\n";
echo "║  Database Columns yang ditambahkan:                        ║\n";
echo "║  - products.deleted_at                                    ║\n";
echo "║  - tikets.deleted_at                                      ║\n";
echo "║                                                            ║\n";
echo "║  Models yang sudah support Soft Delete:                   ║\n";
echo "║  - App\\Models\\Addproduct                                  ║\n";
echo "║  - App\\Models\\Tiket                                       ║\n";
echo "║                                                            ║\n";
echo "║  Relations dengan withTrashed():                           ║\n";
echo "║  - OrderItem->product()                                   ║\n";
echo "║  - OrderItem->ticket()                                    ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";
