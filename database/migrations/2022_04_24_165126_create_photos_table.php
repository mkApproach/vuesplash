<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedInteger('user_id');
            $table->string('filename');
            $table->string('major_id', 10);             // 大分類id
            $table->string('middle_id', 10);            // 中分類ID
            $table->string('subcategory_id', 10);       // 小分類ID
            $table->string('productname_j', 80);        // 商品名（日本語）
            $table->integer('price');                   // 価格 -2147483647 〜 2147483647 まで
            $table->timestamps();

     //       $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
