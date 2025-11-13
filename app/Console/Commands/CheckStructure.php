<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckStructure extends Command
{
    protected $signature = 'check:structure';
    protected $description = 'Check database structure for products and tikets';

    public function handle()
    {
        $this->output->writeln("\n=== STRUKTUR TABEL PRODUCTS ===\n");
        $columns = DB::select("DESCRIBE products");
        foreach ($columns as $col) {
            $null = $col->Null == 'YES' ? 'NULL' : 'NOT NULL';
            $this->output->writeln("{$col->Field} | {$col->Type} | {$null}");
        }

        $this->output->writeln("\n=== STRUKTUR TABEL TIKETS ===\n");
        $columns = DB::select("DESCRIBE tikets");
        foreach ($columns as $col) {
            $null = $col->Null == 'YES' ? 'NULL' : 'NOT NULL';
            $this->output->writeln("{$col->Field} | {$col->Type} | {$null}");
        }

        $this->output->writeln("\n=== STRUKTUR TABEL ORDER_ITEMS ===\n");
        $columns = DB::select("DESCRIBE order_items");
        foreach ($columns as $col) {
            $null = $col->Null == 'YES' ? 'NULL' : 'NOT NULL';
            $this->output->writeln("{$col->Field} | {$col->Type} | {$null}");
        }
    }
}
