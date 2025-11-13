<?php
require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = DB::select("DESCRIBE products");
echo "=== STRUKTUR TABEL PRODUCTS ===\n";
foreach ($columns as $col) {
    echo $col->Field . " | " . $col->Type . " | " . ($col->Null == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
}

echo "\n=== STRUKTUR TABEL TIKETS ===\n";
$columns = DB::select("DESCRIBE tikets");
foreach ($columns as $col) {
    echo $col->Field . " | " . $col->Type . " | " . ($col->Null == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
}
?>
