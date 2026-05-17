<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable()->index();
            $table->enum('status', [
                'incomplete', 'incomplete_expired', 'active', 'past_due',
                'canceled', 'unpaid', 'paused',
            ])->default('incomplete');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly');
            $table->string('country_key')->nullable(); // pk, ae, sa, global
            $table->decimal('vat_rate', 6, 3)->default(0);
            $table->decimal('base_amount_usd', 10, 2)->default(0);
            $table->decimal('vat_amount_usd', 10, 2)->default(0);
            $table->decimal('total_amount_usd', 10, 2)->default(0);
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
