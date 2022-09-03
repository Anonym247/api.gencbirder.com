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
        Schema::create('form_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('title');
            $table->string('type');
            $table->string('agreement_title')->nullable();
            $table->text('agreement_content')->nullable();
            $table->string('acceptance_title')->nullable();
            $table->string('donation_title')->nullable();
            $table->boolean('is_fixed_donation_price')->default(0);
            $table->integer('fixed_donation_price')->nullable();
            $table->string('donation_price_checking_api_url')->nullable();
            $table->json('donation_price_checking_attributes')->nullable();

            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_sections');
    }
};
