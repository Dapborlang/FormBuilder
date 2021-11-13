<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("header")->unique();
            $table->string("table_name");
            $table->json("exclude")->nullable();
            $table->string("model");
            $table->string("route");
            $table->string("role");
            $table->json("foreign_keys")->nullable();
            $table->json("attribute")->nullable();
            $table->timestamps();
        });

        DB::table('form_masters')->insert(
            array(
            [
                'header' => 'Roles Name',
                'table_name' => 'form_role_names',
                'exclude'=>'[]',
                'model' => 'Rdmarwein\Formbuilder\FormRoleName',
                'route' => 'formbuilder',
                'role' => 'ADM',
                'foreign_keys'=>null,
                'attribute'=>null
            ],

                [
                    'header' => 'Roles',
                    'table_name' => 'form_roles',
                    'exclude'=>'[]',
                    'model' => 'Rdmarwein\Formbuilder\FormRole',
                    'route' => 'formbuilder',
                    'role' => 'ADM',
                    'foreign_keys'=>'{
                        "App\\\User": [
                            "user_id",
                            "id",
                            "email"
                        ],
                        "Rdmarwein\\\Formbuilder\\\FormRoleName": [
                            "role",
                            "role",
                            "detail"
                        ]
                    }',
                    'attribute'=>null
                ],
                [
                    'header' => 'Form Master',
                    'table_name' => 'form_masters',
                    'exclude'=>'[]',
                    'model' => 'Rdmarwein\Formbuilder\FormMaster',
                    'route' => 'formbuilder',
                    'role' => 'ADM',
                    'foreign_keys'=>'{
                        "Rdmarwein\\\Formbuilder\\\FormRoleName": [
                            "role",
                            "role",
                            "detail"
                        ]
                    }',
                    'attribute'=>'{ 
                        "type": 
                        { 
                            "attribute":"textarea", 
                            "foreign_keys":"textarea", 
                            "master_keys":"textarea" 
                        } 
                    }'
                ]
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
        Schema::dropIfExists('form_masters');
    }
}
