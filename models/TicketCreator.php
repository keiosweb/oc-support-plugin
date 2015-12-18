<?php namespace Keios\Support\Models;

use Model;

/**
 * TicketCreator Model
 */
class TicketCreator extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'keios_support_ticket_creators';

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
    public $hasOne = [];
    public $hasMany = [
        'tickets' => 'Keios\Support\Models\Ticket'
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}