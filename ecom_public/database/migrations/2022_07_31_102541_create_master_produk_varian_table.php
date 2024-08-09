<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterProdukVarianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_produk_varian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_produk_id');
            $table->text('url_image');
            $table->integer('sku')->nullable();
            $table->integer('minimal_order')->nullable();
            $table->integer('diskon')->nullable();
            $table->integer('berat')->nullable();
            $table->integer('harga_beli')->nullable();
            $table->integer('harga_jual_b2c')->nullable();
            $table->integer('harga_jual_b2b')->nullable();
            $table->integer('harga_coret_b2c')->nullable();
            $table->integer('harga_coret_b2b')->nullable();
            $table->integer('stock')->nullable();
            $table->char('is_publish',1)->nullable();
            $table->char('is_ready_stock',1)->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onUpdate('cascade');

            $table->foreign('master_produk_id')->references('id')->on('master_produk')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_produk_varian');
    }
}
