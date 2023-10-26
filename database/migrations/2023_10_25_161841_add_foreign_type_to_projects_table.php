<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable()->after('id'); //aggiungo una colonna alla tabella projects che si chiama type_id
            $table->foreign('type_id')->references('id')->on('types')->onDelete8('set null'); //aggiungo una chiave esterna alla tabella projects che si chiama type_id che fa riferimento alla colonna id della tabella types e se cancello un type_id da types lo setta a null in projects
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_type_id_foreign');// si scrive il nome della tabella principale + _ + il nome della colonna + _ + foreign e significa che si cancella la chiave esterna
            $table->dropcolumn('type_id');                // si cancella la colonna type_id
        });
    }
};
