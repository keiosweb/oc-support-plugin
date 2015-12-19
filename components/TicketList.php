<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;
use Keios\Support\Models\Ticket;

/**
 * Class TicketList
 * @package Keios\Support\Components
 */
class TicketList extends ComponentBase
{

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'keios.support::lang.components.ticketlist.name',
            'description' => 'keios.support::lang.components.ticketlist.description',
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
     * Loads users tickets
     */
    public function onRun()
    {
        $creator = \Auth::getUser();
        $tickets = Ticket::where('creator_id', $creator->id)->get();

        $this->page['ticket_page'] = $this->property('ticketPage');
        $this->page['tickets'] = $tickets;
    }


}