<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->bigIncrements('id');
            $table->integer('user_id')->unique();
            $table->string('name')->nullable();
            $table->string('age')->nullable();
            $table->string('city')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->string('height')->nullable();
            $table->string('hair')->nullable();
            $table->string('body')->nullable();
            $table->string('skin')->nullable();
            $table->string('eyes')->nullable();
            $table->string('marital_status')->nullable();
            $table->boolean('children')->nullable();
            $table->string('profession')->nullable();
            $table->string('smoking')->nullable();
            $table->string('alcohol')->nullable();
            $table->string('languages')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_attributes');
    }
}
