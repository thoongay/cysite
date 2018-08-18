<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $permissionLen = config('app.admin.permissionLen');

            $table->increments('id');
            $table->string('user', 100);
            $table->string('password', 64)->comment('60 char is enough.');
            $table->string('name', 100);

            // 20 char of zero or one
            $table->string('permission', $permissionLen)
                ->comment('20 char of zero or one');

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
