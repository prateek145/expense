<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_amounts', function (Blueprint $table) {
            $table->id();
            $table->string('ei_id');
            $table->string('amount');
            $table->string('invoice_file')->nullable();            
            $table->string('ei_type');
            $table->string('ei_info');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_amounts');
    }
};