<?php

use App\Models\Table;
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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->integer('pageLength')->default(25);
            $table->integer('fixedColumnsStart')->default(1);
            $table->integer('fixedColumnsEnd')->default(0);
            $table->string('scrollX')->default(true);
            $table->string('scrollY')->default('');
            $table->boolean('paging')->default(true);
            $table->boolean('ordering')->default(true);
            $table->boolean('searchable')->default(true);
            $table->boolean('include_action_buttons')->default(false);
            $table->foreignIdFor(Table::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
