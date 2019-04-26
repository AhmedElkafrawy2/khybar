<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type'); // 1 - news, 2 - essays
            $table->string('title');
            $table->text('content');
            $table->text('description');
            $table->string('slug')->unique();
            $table->integer('category_id')->nullable();
            $table->integer('writer_id')->nullable();
            $table->integer('image_id');
            $table->boolean('comments');
            $table->boolean('breakingnews')->default(0);
            $table->boolean('slide')->default(0);
            $table->integer('views')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
