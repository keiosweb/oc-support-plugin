<?php namespace Keios\Support\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTicketAttachmentsTable
 * @package Keios\Support\Updates
 */
class CreateTicketAttachmentsTable extends Migration
{

    public function up()
    {
        Schema::create(
            'keios_support_ticket_attachments',
            function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('ticket_id');
                $table->string('file_name');
                $table->string('file_path');
                $table->integer('file_size');
                $table->string('content_type');
                $table->integer('user_id')->unsigned()->nullable()->index();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('keios_support_ticket_attachments');
    }

}

