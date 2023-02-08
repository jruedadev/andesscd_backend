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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            $table->enum('type_document', ['CC', 'CE', 'NIT', 'OTRO']);
            $table->string('document', 20);
            $table->string('first_name', 50);
            $table->string('middle_name', 50);
            $table->string('last_name', 50);

            $table->string('address', 250);
            $table->string('phone', 20);
            $table->string('city', 100);

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
        Schema::dropIfExists('drivers');
    }
};
