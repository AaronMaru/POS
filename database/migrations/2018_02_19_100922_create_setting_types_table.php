<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name_en');
            $table->string('name_kh');
            $table->string('image')->default('default-name.jpg');
            $table->string('note')->nullable()->default(NULL);
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
        Schema::dropIfExists('setting_types');
    }
}