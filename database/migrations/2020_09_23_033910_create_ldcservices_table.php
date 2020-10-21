<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLdcservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ldcservices', function (Blueprint $table) {
            $table->id();
            $table->string('costcenter');
            $table->string('servicetype');
            $table->string('servicename');
            $table->string('serialno');
            $table->string('providername');
            $table->string('contactperson');
            $table->string('email');
            $table->string('phone');
            $table->date('lastrenew');
            $table->date('nextrenew');
            $table->string('renewalterms');
            $table->decimal('amount');
            $table->string('currency');
            $table->text('remarks');
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
        Schema::dropIfExists('ldcservices');
    }
}
