<?php

use App\Models\Appointment;
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
        Schema::create('sub_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('job_total')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('closing')->nullable();
            $table->integer('technician_materials_cost')->default(0);
            $table->integer('company_materials_cost')->default(0);
            $table->integer('technician_profit')->nullable();
            $table->integer('technician_balance')->nullable();
            $table->integer('company_balance')->nullable();
            $table->integer('technician_share_percentage');
            $table->integer('company_share_percentage');
            $table->foreignIdFor(Appointment::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_reports');
    }
};
