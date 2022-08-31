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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->enum('type', ['info', 'form', 'team', 'reports', 'banner']);
            $table->string('slug');
            $table->string('title');
            $table->string('photo')->nullable();
            $table->text('content')->nullable();
            $table->string('video')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['menu_id', 'slug', 'deleted_at']);
            $table->foreign('menu_id')->references('id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
