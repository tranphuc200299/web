<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTenantIdMsUserDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_user_detail', function (Blueprint $table) {
            $table->uuid('tenant_id')->nullable()->after('user_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('ms_tenants')
                ->onDelete('cascade');
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
            $table->dropColumn(['tenant_id']);
        });
    }
}
