<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBccondominiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bccondominios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_cliente');
            $table->string('nombre');
            $table->decimal('m2');
            $table->decimal('costo_m2');
            $table->string('calle');
            $table->string('numero');
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
        Schema::dropIfExists('bccondominios');
    }
}
