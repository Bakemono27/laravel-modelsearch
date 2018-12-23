<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateExampleModelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('examplemodel', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('examplemodel');
    }
}