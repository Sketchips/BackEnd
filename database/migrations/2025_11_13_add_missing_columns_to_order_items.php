<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add missing columns to order_items if they don't exist
        if (!Schema::hasColumn('order_items', 'product_id')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->foreignId('product_id')->nullable()->constrained('products');
            });
        }
        
        if (!Schema::hasColumn('order_items', 'ticket_id')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->foreignId('ticket_id')->nullable()->constrained('tikets');
            });
        }

        if (!Schema::hasColumn('order_items', 'type')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->enum('type', ['product', 'ticket'])->nullable();
            });
        }
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeignIdFor('Addproduct');
            $table->dropColumn('product_id');
            $table->dropForeignIdFor('Tiket');
            $table->dropColumn('ticket_id');
            $table->dropColumn('type');
        });
    }
};
