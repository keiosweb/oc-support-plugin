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
                $table->string('name')->nullable();
                $table->string('hash_id');
                $table->integer('category_id');
                $table->integer('creator_id');
                $table->integer('user_id')->nullable();
                $table->string('email')->index();
                $table->string('website')->nullable();
                $table->string('topic');
                $table->longText('content');
                $table->integer('status_id')->default(1);
                $table->integer('priority_id')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            'keios_support_ticket_ticket_comment',
            function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->integer('ticket_id')->unsigned();
                $table->integer('comment_id')->unsigned();
                $table->primary(['ticket_id', 'comment_id']);
            }
        );
    }



    public function down()
    {
        Schema::dropIfExists('keios_support_tickets');
        Schema::dropIfExists('keios_support_ticket_ticket_comment');
    }

}
