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
            $table->boolean('canAddUser');
            $table->boolean('canDeleteUser');
            $table->boolean('canChangeStatus');
            $table->boolean('canManageRoles');
            $table->timestamps();
        });

         // Insert some stuff
        DB::table('roles')->insert(
            array(
                'roleName' => 'Admin',
                'canAddUser' => True,
                'canDeleteUser' => True,
                'canChangeStatus' => True,
                'canManageRoles' => True
            )
        );

        DB::table('roles')->insert(
            array(
                'roleName' => 'Manager',
                'canAddUser' => False,
                'canDeleteUser' => True,
                'canChangeStatus' => True,
                'canManageRoles' => False
            )
        );

        DB::table('roles')->insert(
            array(
                'roleName' => 'User',
                'canAddUser' => False,
                'canDeleteUser' => False,
                'canChangeStatus' => False,
                'canManageRoles' => False
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
