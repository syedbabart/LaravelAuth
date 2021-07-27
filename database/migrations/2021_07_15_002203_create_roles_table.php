<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->text('roleName');
            $table->timestamps();
        });

         // Insert some stuff
        DB::table('roles')->insert(
            array(
                'roleName' => 'Admin'
            )
        );

        DB::table('roles')->insert(
            array(
                'roleName' => 'Manager'
            )
        );

        DB::table('roles')->insert(
            array(
                'roleName' => 'User'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
