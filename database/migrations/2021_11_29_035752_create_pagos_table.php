<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string("cip");
            $table->string("amount");
            $table->string("cipUrl");
            $table->string("transactionCode");
            $table->string("paymentConcept");
            $table->string("additionalData");
            $table->string("userEmail");
            $table->string("userName");
            $table->string("userLastName");
            $table->string("userDocumentType");
            $table->string("userDocumentNumber");
            $table->string("userPhone");
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
        Schema::dropIfExists('pagos');
    }
}
