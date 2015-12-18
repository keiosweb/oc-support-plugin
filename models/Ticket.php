<?php namespace Keios\Support\Models;

use Model;

/**
 * Ticket Model
 */
class Ticket extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'keios_support_tickets';

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
    public $belongsTo = [
        'category' => 'Keios\Support\Models\TicketCategory',
        'creator' => 'Keios\Support\Models\TicketCreator'
    ];

    /**
     * @var array Relations
     */
    public $attachOne = [];
    /**
     * @var array Relations
     */
    public $attachMany = [];

}