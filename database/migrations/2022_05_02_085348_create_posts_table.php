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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('content');
            $table->string('slug');
            $table->string('image');
            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('category_id')
                    ->nullable()
                    ->constrained('categories')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->timestamps();

            $table->index('slug', 'SLUG_IDX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
