<?php

use App\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name');
            $table->string('meta_keywords');
            $table->text('meta_description');
            $table->integer('header_image_id');
            $table->integer('sidebar_slider_category_id')->nullable();
            $table->boolean('notes')->default(0);
            $table->boolean('slider')->default(0);
            $table->boolean('random_banners')->default(0);
            $table->boolean('social_in_header')->default(0);
            $table->boolean('social_in_footer')->default(0);
            $table->timestamps();
        });

        Setting::create([
            'name' => 'خيبر',
            'meta_keywords' => 'keyword',
            'meta_description' => 'some description',
            'header_image_id' => 1,
            'notes' => 1,
            'slider' => 1,
            'random_banners' => 0,
            'social_in_header' => 1,
            'social_in_footer' => 1,
        ]);
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
