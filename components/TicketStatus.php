<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;

class TicketStatus extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'keios.support::lang.components.ticketstatus.name',
            'description' => 'keios.support::lang.components.ticketstatus.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

}