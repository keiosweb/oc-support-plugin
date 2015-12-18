<?php namespace Keios\Support\Models;

use Backend\Facades\BackendAuth;
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
    protected $fillable = ['author', 'is_support', 'content'];


    /**
     * @var array
     */
    public $belongsTo = [
        'ticket' => 'Keios\Support\Models\Ticket',
    ];

    /**
     * @return array
     */
    public function getAuthorOptions()
    {
        $user = BackendAuth::getUser();
        $userEntry = $user->first_name.' '.$user->last_name.' ('.$user->email.')';

        return [$userEntry => $userEntry];
    }
}