<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;
use Keios\Support\Classes\SupportHelpers;
use Keios\Support\Classes\SupportMailer;
use Keios\Support\Models\Settings;
use Keios\Support\Models\Ticket;
use Keios\Support\Models\TicketCategory;
use Keios\Support\Models\TicketStatus;


/**
 * Class TicketForm
 * @package Keios\Support\Components
 */
class TicketForm extends ComponentBase
{


    /**
     * @var SupportHelpers
     */
    private $helpers;

    /**
     * TicketForm constructor.
     *
     * @param \Cms\Classes\CodeBase $cmsObject
     * @param array                 $properties
     */
    public function __construct(\Cms\Classes\CodeBase $cmsObject = null, array $properties = [])
    {
        parent::__construct($cmsObject, $properties);
        $this->helpers = new SupportHelpers();
    }

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'keios.support::lang.components.ticketform.name',
            'description' => 'keios.support::lang.components.ticketform.description',
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'ticketPage' => [
                'title'       => 'keios.support::lang.app.ticket_page',
                'description' => 'keios.support::lang.app.ticket_page_desc',
                'default'     => '/ticket',
            ],
        ];
    }


    /**
     * Loads categories for ticket form
     */
    public function onRun()
    {
        $categories = TicketCategory::lists('id', 'name');
        $this->page['categories'] = $categories;
    }


    /**
     * Creates new Ticket and redirects to its page
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \ValidationException
     */
    public function onTicketCreate()
    {


        $data = post();
        $this->helpers->validateTicket($data);
        $creator = \Auth::getUser();
        $ticketPage = Settings::get('address');
        $newStatus = TicketStatus::where('name', 'New')->first()->id;

        $content = $this->purifyTicket($data['content']);

        $ticket = new Ticket();
        $ticket->hash_id = 'temp';
        $ticket->category_id = $data['category'];
        $ticket->creator_id = $creator->id;
        $ticket->email = $creator->email;
        $ticket->website = $data['website'];
        $ticket->topic = $data['topic'];
        $ticket->content = $content;
        $ticket->status = $newStatus;
        $ticket->save();

        $hashId = $this->helpers->generateHashId($ticket->id);
        $ticket->hash_id = $hashId;
        $ticket->save();

        $this->page['hash_id'] = $hashId;

        $this->helpers->newTicketHandler($hashId);

        $mailer = new SupportMailer();
        $address = Settings::get('address');
        $vars = [
            'ticket_number' => $ticket->hash_id,
            'ticket_link'   => $address.'/'.$ticket->hash_id,
        ];

        $mailer->sendAfterTicketCreated($creator->email, $vars);

        return \Redirect::to($ticketPage.$hashId);
    }

    /**
     * Purifies ticket content from bad html
     *
     * @param string $content
     *
     * @return string
     */
    private function purifyTicket($content)
    {
        $purifierConfig = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($purifierConfig);

        return $purifier->purify($content);
    }

}