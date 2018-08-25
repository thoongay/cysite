<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $settingNameLen = config('app.admin.settingNameLength');
            $settingOptLen = config('app.admin.settingOptionLength');

            $table->string('name', $settingNameLen);
            $table->string('type', $settingNameLen);
            $table->string('option', $settingOptLen)->nullable();

            // do not need to store in db
            // $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
