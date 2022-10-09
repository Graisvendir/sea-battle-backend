<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('length');
            $table->integer('max_count');
        });

        DB::table('ships')->insert([
            ['length' => 1, 'max_count' => 4],
            ['length' => 2, 'max_count' => 3],
            ['length' => 3, 'max_count' => 2],
            ['length' => 4, 'max_count' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ships');
    }
}
