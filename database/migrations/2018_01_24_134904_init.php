<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create 'album' table
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->integer('creator');
            $table->string('preview_img_id', 255)->nullable();
            $table->boolean('shared')->default(0);
            $table->string('description', 255)->nullable();
            $table->string('preview_img', 255)->nullable();
            $table->integer('photo_num')->default(0);
            $table->dateTime('updated_at');
            $table->dateTime('created_at');
            $table->index('preview_img');
        });

        //Create 'images' table
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('album');
            $table->string('image_id', 255);
            $table->string('image_url', 255);
            $table->string('preview_img_url', 255);
            $table->string('peoples', 255);
            $table->string('place', 255);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->date('createdAt');
            $table->text('tags')->nullable();
            $table->index('image_id');
        });

        //Create 'tags' table
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->integer('photos_num')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->index('name');
        });

        //Create 'users' table
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 255);
            $table->integer('family_id')->default(NULL);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('old_password', 255);
            $table->string('api_key', 255);
            $table->string('api_secret', 255);
            $table->string('cloud_name', 255);
            $table->dateTime('updated_at');
            $table->dateTime('created_at');
            $table->string('remember_token', 255)->nullable();
            $table->index('email');
        });

        //Create 'password_resets' table
        Schema::create('password_resets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255);
            $table->string('token', 255);
            $table->dateTime('created_at');
            $table->index('email');
        });
    }

    public function down()
    {
        Schema::drop('albums');
        Schema::drop('images');
        Schema::drop('tags');
        Schema::drop('users');
        Schema::drop('password_resets');
    }
}
