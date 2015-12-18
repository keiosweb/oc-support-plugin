<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Keios\Support\Classes\SupportHelpers;
use Keios\Support\Classes\SupportMailer;
use Keios\Support\Models\Settings;
use Keios\Support\Models\Ticket;
use Keios\Support\Models\TicketCategory;
use Keios\Support\Models\TicketCreator;


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
     *
     */
    public function onRun()
    {
        $categories = TicketCategory::lists('id', 'name');
        $this->page['categories'] = $categories;
    }

    /**
     *
     */
    public function onTicketCreate()
    {
        $data = post();
        $this->helpers->validateTicket($data);
        $creator = $this->checkCreator($data['name'], $data['email']);
        $redirectPage = $this->property('ticketPage');

        $ticket = new Ticket();
        $ticket->hash_id = 'temp';
        $ticket->category_id = $data['category'];
        $ticket->creator_id = $creator->id;
        $ticket->email = $creator->email;
        $ticket->website = $data['website'];
        $ticket->topic = $data['topic'];
        $ticket->content = $data['content'];
        $ticket->status = 'New';
        $ticket->code = $creator->code;
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

        return \Redirect::to($redirectPage.'/'.$hashId);
    }


    /**
     * @param $name
     * @param $email
     *
     * @return TicketCreator
     */
    private function checkCreator($name, $email)
    {
        $creator = TicketCreator::where('email', $email)->first();

        if (!$creator) {
            $creator = $this->createCreator($name, $email);
        }

        return $creator;
    }

    /**
     * @param $name
     * @param $email
     *
     * @return TicketCreator
     */
    private function createCreator($name, $email)
    {
        $creator = new TicketCreator();
        $creator->name = $name;
        $creator->email = $email;
        $creator->code = 'temp';
        $creator->save();
        $creator->code = $this->helpers->generateCode($creator->id);
        $creator->save();

        $mailer = new SupportMailer();
        $vars = [
            'account_name' => $creator->name,
            'account_code' => $creator->code,
        ];

        $mailer->sendAfterFirstTicket($creator->email, $vars);

        return $creator;
    }

}