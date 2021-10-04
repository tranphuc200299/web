<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRoleLevelMsRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_roles', function (Blueprint $table) {
            $table->tinyInteger('level')->default(\Modules\Auth\Constants\AuthConst::ROLE_LEVEL_IT_ADMIN)->after('name');
            $table->string('display_name', 40)->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_roles', function (Blueprint $table) {
            $table->dropColumn(['level', 'display_name']);
        });
    }
}
