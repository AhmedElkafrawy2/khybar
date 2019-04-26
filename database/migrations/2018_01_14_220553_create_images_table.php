<?php

use App\Image;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('filesize');
            $table->string('filetype');
            $table->timestamps();
        });

        Image::create([
            'filename' => 'p6Zlqcivpl1WeOIgz9F3kshTKRI5KWUnhreXDkm1.png',
            'filesize' => '33854',
            'filetype' => 'image/png',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
