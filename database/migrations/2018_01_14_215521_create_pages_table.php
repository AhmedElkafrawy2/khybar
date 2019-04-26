<?php

use App\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Page::create([
            'title' => 'اتصل بنا',
            'content' => 1,
            'slug' => 'contact-us'
        ]);

        Page::create([
            'title' => 'المقالات',
            'content' => 1,
            'slug' => 'essays'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
