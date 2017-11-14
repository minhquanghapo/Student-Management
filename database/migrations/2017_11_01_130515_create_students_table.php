<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
                        $table->increments('id');
                        $table->string('name', 50);
                        $table->date('birthday');
                        $table->string('email')->unique();
                        $table->string('password');
                        $table->string('address', 100);
                        $table->string('class',20);
                        $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
}
