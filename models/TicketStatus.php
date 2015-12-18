<?php namespace Keios\Support\Models;

use Model;

/**
 * TicketStatus Model
 */
class TicketStatus extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'keios_support_ticket_statuses';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'tickets' => 'Keios\Support\Models\Ticket',
    ];


}