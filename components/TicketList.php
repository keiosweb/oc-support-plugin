<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;

class TicketList extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'keios.support::lang.components.ticketlist.name',
            'description' => 'keios.support::lang.components.ticketlist.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

}