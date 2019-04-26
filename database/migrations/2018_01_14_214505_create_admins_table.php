<?php

use App\Admin;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('image_id')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('add_news')->default(0);
            $table->boolean('add_essays')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        Admin::create([
            'name' => 'محمد',
            'email' => 'admin@khaybar.com',
            'password' => bcrypt('password'),
            'add_news' => 1,
            'add_essays' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
