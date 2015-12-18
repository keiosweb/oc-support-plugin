<?php namespace Keios\Support\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTicketCreatorsTable
 * @package Keios\Support\Updates
 */
class CreateTicketCreatorsTable extends Migration
{

    public function up()
    {
        Schema::create('keios_support_ticket_creators', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('code');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keios_support_ticket_creators');
    }

}
