<?php namespace Keios\Support\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTicketCategoriesTable
 * @package Keios\Support\Updates
 */
class CreateTicketCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create(
            'keios_support_ticket_categories',
            function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('keios_support_ticket_categories');
    }

}
