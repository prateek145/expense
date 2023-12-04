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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('expense_id');
            $table->string('ex_date');
            $table->string('breakfast')->nullable();            
            $table->string('lunch')->nullable();
            $table->string('dinner')->nullable();
            $table->string('invoice_file')->nullable();           
            $table->string('breakfast_tag')->nullable();
            $table->string('lunch_tag')->nullable();            
            $table->string('dinner_tag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};