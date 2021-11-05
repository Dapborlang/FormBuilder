<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormRoleNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_role_names', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role');
            $table->string('detail');
            $table->timestamps();
        });

        DB::table('form_role_names')->insert(
            array(
                'role' => 'ADM',
                'detail' => 'ADMIN'
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
        Schema::dropIfExists('form_role_names');
    }
}
