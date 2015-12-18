<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;

class TicketForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'keios.support::lang.components.ticketform.name',
            'description' => 'keios.support::lang.components.ticketform.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

}