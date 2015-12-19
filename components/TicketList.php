<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;
use Keios\Support\Models\Settings;
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
        return [];
    }


    /**
     * Loads users tickets
     */
    public function onRun()
    {
        $creator = \Auth::getUser();
        $url = Settings::get('address');
        $tickets = Ticket::where('creator_id', $creator->id)->get();

        $this->page['ticket_page'] = $url;
        $this->page['tickets'] = $tickets;
    }


}