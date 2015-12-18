<?php namespace Keios\Support\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTicketsTable
 * @package Keios\Support\Updates
 */
class CreateTicketsTable extends Migration
{

    public function up()
    {
        Schema::create(
            'keios_support_tickets',
            function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('hash_id');
                $table->integer('category_id');
                $table->integer('creator_id');
                $table->string('email')->index();
                $table->string('topic');
                $table->longText('content');
                $table->string('status');
                $table->string('code');
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('keios_support_tickets');
    }

}
