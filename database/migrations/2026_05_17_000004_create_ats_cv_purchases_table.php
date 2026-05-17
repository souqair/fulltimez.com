<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ats_cv_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained();
            $table->string('stripe_payment_intent_id')->nullable()->index();
            $table->string('stripe_checkout_session_id')->nullable();
            $table->string('source_cv_path')->nullable();
            $table->string('generated_cv_path')->nullable();
            $table->json('parsed_data')->nullable(); // from Affinda
            $table->json('rewrite_payload')->nullable(); // OpenAI output
            $table->unsignedTinyInteger('ats_score')->nullable();
            $table->enum('status', ['pending_payment', 'paid', 'generating', 'completed', 'failed', 'refunded'])->default('pending_payment');
            $table->string('country_key')->nullable();
            $table->decimal('vat_rate', 6, 3)->default(0);
            $table->decimal('base_amount_usd', 10, 2)->default(0);
            $table->decimal('vat_amount_usd', 10, 2)->default(0);
            $table->decimal('total_amount_usd', 10, 2)->default(0);
            $table->text('error_message')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ats_cv_purchases');
    }
};
