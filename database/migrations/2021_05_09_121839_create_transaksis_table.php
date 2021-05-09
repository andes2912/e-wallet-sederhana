<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->integer('user_tujuan_id')->nullable();
            $table->string('no_transaksi');
            $table->integer('amount');
            $table->enum('type_transfer',['Bank','VA']);
            $table->enum('jenis_transfer',['Withdraw','Topup','Transfer']);
            $table->enum('status',['Pending','Success','Reject','Cancel'])->default('Pending');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
