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
        'creator'  => 'Keios\Support\Models\TicketCreator',
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
    public $belongsToMany = [
        'comments' => [
            'Keios\Support\Models\TicketComment',
            'table'    => 'keios_support_ticket_ticket_comment',
            'key'      => 'ticket_id',
            'otherKey' => 'comment_id',
        ],
    ];

    /**
     * @return mixed
     */
    public function getUserOptions()
    {
        $user = User::lists('email', 'id');

        return $user;
    }

    public function afterUpdate()
    {
        $mailer = new SupportMailer();
        $email = $this->creator->email;
        $address = Settings::get('address');
        $vars = [
            'ticket_number' => $this->hash_id,
            'ticket_link'   => $address.'/'.$this->hash_id,
        ];

        if ($this->status == 'Closed') {
            $mailer->sendAfterTicketClosed($email, $vars);
        } else {
            if ($this->is_support == 1) {
                $mailer->sendAfterTicketUpdated($email, $vars);
            }
        }
    }

}