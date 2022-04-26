<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoryclassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategoryclasses', function (Blueprint $table) {
            $table->string('major_id', 10)->nullable();
            $table->string('middle_id', 10)->nullable();
            $table->string('subcategory_id', 10)->nullable();
            $table->string('name', 40)->nullable();
            $table->timestamps();

            $table->primary(['major_id', 'middle_id', 'subcategory_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategoryclasses');
    }
}
