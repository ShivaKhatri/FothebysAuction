<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('FirstName');
            $table->string('Surname');
            $table->string('title');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_no');
            $table->string('address');
            $table->integer('bank_no')->nullable();
            $table->integer('bidLimit')->nullable();
            $table->integer('bank_sort_no')->nullable();
            $table->string('Cstatus');
            $table->string('Astatus')->nullable();
            $table->integer('verified_by')->nullable();
            $table->integer('added_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}
