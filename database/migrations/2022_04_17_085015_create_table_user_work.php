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
        Schema::create('table_user_work', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('company');
            $table->integer('industry_id');
            $table->string('position');
            $table->integer('work_type_id');
            $table->timestamps();
        });

        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('industry_name');
        });

        Schema::create('work_types', function (Blueprint $table) {
            $table->id();
            $table->string('work_type_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_user_work');
        Schema::dropIfExists('industries');
        Schema::dropIfExists('work_types');
    }
};
