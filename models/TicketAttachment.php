<?php namespace Keios\Support\Models;

use Model;
use Backend\Models\User;

/**
 * Class File
 * @package Keios\Support\Models
 */
class TicketAttachment extends Model
{

    /**
     * @var string
     */
    public $table = 'keios_support_ticket_attachments';

    /**
     * Relations
     *
     * @var array
     */
    public $belongsTo = [
        'user'   => ['Backend\Models\User'],
        'ticket' => ['Keios\Support\Models\Ticket'],
    ];

    /**
     * @param User $user
     *
     * @return bool
     */
    public function canEdit(User $user)
    {
        return ($this->user_id == $user->id) || $user->hasAnyAccess(['keios.support.access_uploaded_files']);
    }
}
