<?php

use App\Models\{Lead, Technician};
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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lead::class);
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('post_code');
            $table->foreignIdFor(Technician::class);
            $table->text('job_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
