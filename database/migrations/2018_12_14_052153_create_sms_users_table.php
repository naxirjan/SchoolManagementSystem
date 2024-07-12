<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sms_qualification_id')->unsigned()->nullable();
            $table->integer('sms_role_user_id')->unsigned()->nullable();
            $table->string('first_name',30);
            $table->string('middle_name',30)->nullable();
            $table->string('last_name',30);
            $table->string('email',100);
            $table->text('password');
            $table->string('contact_number',15);
            $table->string('gender',6);
            $table->text('address');
            $table->string('profile_image');
            $table->rememberToken();
            $table->timestamps();
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_users');
    }
}
