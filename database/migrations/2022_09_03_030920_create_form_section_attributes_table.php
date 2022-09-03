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
        Schema::create('form_section_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_section_id');
            $table->string('name');
            $table->string('type');
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(true);
            $table->boolean('is_email')->default(false);
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->string('reference_api_url')->nullable();
            $table->string('reference_attribute_id')->nullable();
            $table->string('reference_attribute_name')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('form_section_id')->references('id')->on('form_sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_section_attributes');
    }
};
