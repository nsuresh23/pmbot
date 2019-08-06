<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['AM', 'PM', "PE", "stakeholder"])->default('PM')->after('name');
            $table->string('designation')->after('role');
            $table->string('phone')->after('designation');
            $table->string('mobile')->after('phone');
            $table->boolean('is_active')->default(true)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('designation');
            $table->dropColumn('phone');
            $table->dropColumn('mobile');
            $table->dropColumn('is_active');
        });
    }
}
