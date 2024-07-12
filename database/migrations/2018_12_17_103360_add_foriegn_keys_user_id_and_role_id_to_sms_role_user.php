<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForiegnKeysUserIdAndRoleIdToSmsRoleUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_role_user', function (Blueprint $table) {
            //

            $table->foreign('sms_user_id')->references('id')->on('sms_users')->onDelete('cascade');
            $table->foreign('sms_role_id')->references('id')->on('sms_roles')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_role_user', function (Blueprint $table) {
            //
            $table->dropForeign('sms_role_user_sms_user_id_foreign');
            $table->dropForeign('sms_role_user_sms_role_id_foreign');
        });
    }
}
