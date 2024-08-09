<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_kategori_id');
            $table->unsignedBigInteger('master_kategori_subkategori_id');
            $table->string('nama_produk');
            $table->string('nama_produk_odoo')->nullable();
            $table->text('url_image');
            $table->text('url_video');
            $table->text('deskripsi_produk');
            $table->string('satuan');
            $table->integer('sku')->nullable();
            $table->integer('minimal_order')->default('1');
            $table->integer('diskon')->nullable();
            $table->integer('berat');
            $table->integer('harga_beli');
            $table->integer('harga_jual_b2c');
            $table->integer('harga_jual_b2b');
            $table->integer('harga_coret_b2c')->nullable();
            $table->integer('harga_coret_b2b')->nullable();
            $table->integer('stock')->default('0');
            $table->char('is_publish',1)->default('0');
            $table->char('is_ready_stock',1)->default('0');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onUpdate('cascade');

            $table->foreign('master_kategori_id')->references('id')->on('master_kategori')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('master_kategori_subkategori_id')->references('id')->on('master_kategori_subkategori')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_produk');
    }
}
