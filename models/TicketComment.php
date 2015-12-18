<?php namespace Keios\Support\Models;

use Model;

/**
 * TicketComment Model
 */
class TicketComment extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'keios_support_ticket_comments';

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
    public $hasMany = [];
    public $belongsTo = [
        'ticket' => 'Keios\Support\Models\Ticket'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}