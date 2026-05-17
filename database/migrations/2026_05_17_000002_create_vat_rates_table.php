<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vat_rates', function (Blueprint $table) {
            $table->id();
            $table->string('country_key')->unique(); // pk, ae, sa, global
            $table->string('country_name');
            $table->string('label')->default('VAT'); // VAT, GST, Sales Tax
            $table->decimal('rate', 6, 3)->default(0); // e.g. 5.000, 18.000
            $table->string('stripe_tax_rate_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vat_rates');
    }
};
