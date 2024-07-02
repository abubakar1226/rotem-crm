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
        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Table::class);
            $table->string('name');
            $table->string('title');
            $table->boolean('visible')->default(true);
            $table->boolean('orderable')->default(true);
            $table->boolean('searchable')->default(true);
            $table->string('width')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();

            $table->index(['table_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('columns');
    }
};
