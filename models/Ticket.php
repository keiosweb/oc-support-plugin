<?php namespace Keios\Support\Models;

use Backend\Models\User;
use Keios\Support\Classes\SupportMailer;
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
        'priority' => 'Keios\Support\Models\TicketPriority',
        'status'   => 'Keios\Support\Models\TicketStatus',
        'creator'  => 'Keios\ProUser\Models\User',
        'user'     => 'Backend\Models\User',
    ];

    /**
     * @var array Relations
     */
    public $attachOne = [];

    /**
     * @var array Relations
     */
    public $attachMany = [
        'files' => ['System\Models\File'],
    ];

    /**
     * @var array
     */
    public $belongsToMany = [
        'comments' => [
            'Keios\Support\Models\TicketComment',
            'table'    => 'keios_support_ticket_ticket_comment',
            'key'      => 'ticket_id',
            'otherKey' => 'comment_id',
        ],
    ];

    /**
     * Provides user list for assignation purposes.
     *
     * @return array
     */
    public function getUserOptions()
    {
        $user = User::lists('email', 'id');

        return $user;
    }

    /**
     * After Update method
     *
     * Changes "New" to "Assigned" if user is assigned.
     *
     * Triggers mail sender on update.
     */
    public function afterUpdate()
    {
        $user = $this->user_id;
        $statusId = $this->status->id;
        $newStatus = TicketStatus::where('name', 'New')->first()->id;
        $assignedStatus = TicketStatus::where('name', 'Assigned')->first()->id;

        if ($user != null && $statusId == $newStatus) {
            $this->status_id = $assignedStatus;
        }


        $mailer = new SupportMailer();
        $email = $this->creator->email;
        $address = Settings::get('address');
        $vars = [
            'ticket_number' => $this->hash_id,
            'ticket_link'   => $address.'/'.$this->hash_id,
            'ticket_status' => $this->status->name,
        ];

        if ($this->status == 'Closed' || $this->status == 'Resolved') {
            $mailer->sendAfterTicketClosed($email, $vars);
        } else {
            if ($this->is_support == 1) {
                $mailer->sendAfterTicketUpdated($email, $vars);
            }
        }
    }

}