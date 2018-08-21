<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $titleLen = config('app.admin.articleTitleLength');
            $keywordLen = config('app.admin.articleKeywordLength');

            $table->increments('id');

            $table->string('title', $titleLen);
            $table->text('content');
            $table->text('text');
            $table->string('keyword', $keywordLen);
            $table->integer('author');
            $table->integer('category');
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
        Schema::dropIfExists('articles');
    }
}
