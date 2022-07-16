<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string("code_voucher",50);
            $table->timestamp("claim_expired_at")->nullable();
            $table->boolean('is_pending');
            $table->boolean("status_claim");
            $table->unsignedBigInteger("claim_by")->nullable();
            $table->foreign('claim_by')->references('id')->on('customers');
            $table->unsignedBigInteger("campaign_id");
            $table->foreign('campaign_id')->references('id')->on('campaign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};
