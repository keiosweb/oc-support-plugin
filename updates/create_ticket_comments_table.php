<?php namespace Keios\Support\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTicketCommentsTable
 * @package Keios\Support\Updates
 */
class CreateTicketCommentsTable extends Migration
{

    public function up()
    {
        Schema::create('keios_support_ticket_comments', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->longText('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keios_support_ticket_comments');
    }

}
