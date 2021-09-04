<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateREntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_entities', function (Blueprint $table) {
            $table->id();
            $table->string('module_name');
            $table->string('name')->unique();
            $table->string('namespace')->nullable();
            $table->text('config_json')->nullable();
            $table->text('migration_files_json')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_entities');
    }
}
