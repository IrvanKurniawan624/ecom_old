<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterKategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_kategori', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_package_id');
            $table->integer('index');
            $table->string('kategori');
            $table->text('url_image');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('master_package_id')->references('id')->on('master_package')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_kategori');
    }
}
