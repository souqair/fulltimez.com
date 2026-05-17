<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('source_type'); // subscription | ats_cv_purchase
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable()->index();
            $table->string('stripe_charge_id')->nullable();
            $table->string('stripe_invoice_id')->nullable();
            $table->decimal('base_amount_usd', 10, 2)->default(0);
            $table->decimal('vat_amount_usd', 10, 2)->default(0);
            $table->decimal('total_amount_usd', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->string('country_key')->nullable();
            $table->enum('status', ['pending', 'succeeded', 'failed', 'refunded', 'partial_refund'])->default('pending');
            $table->text('failure_reason')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['source_type', 'source_id']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
