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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('network_provider_id')->index()->nullable();
            $table->string('transaction_reference')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('request_type'); // debit, credit
            $table->string('transaction_type'); // airtime, fund_wallet
            $table->timestamp('transaction_date');
            $table->string('status'); // pending, approved, rejected, settled
            $table->string('recipient')->nullable();
            $table->string('payment_method')->nullable(); // cash, card, bank transfer
            $table->string('payment_status')->nullable(); // successful, failed, pending, refunded
            $table->text('notes')->nullable();
            $table->string('currency')->default('NGN'); // NGN, USD, EUR, GBP, JPY, etc.
            $table->decimal('exchange_rate', 15, 8)->nullable();
            $table->string('payment_gateway')->nullable(); // Paystack, Flutterwave, Stripe, etc.
            $table->string('payment_id')->nullable();
            $table->decimal('payment_amount', 15, 2)->nullable();
            $table->string('payment_currency')->nullable(); // USD, EUR, GBP, JPY, etc.
            $table->decimal('payment_fee', 15, 2)->nullable();
            $table->unsignedBigInteger('refund_id')->nullable()->index();
            $table->unsignedBigInteger('charge_id')->nullable()->index();
            $table->timestamps();

            // $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
