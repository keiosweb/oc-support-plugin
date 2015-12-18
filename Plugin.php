<?php namespace Keios\Support;

use System\Classes\PluginBase;
use Backend;

/**
 * Support Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'keios.support::lang.plugin.name',
            'description' => 'keios.support::lang.plugin.description',
            'author'      => 'keios',
            'icon'        => 'icon-leaf',
        ];
    }


    /**
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Keios\Support\Components\TicketForm'   => 'ticket_form',
            'Keios\Support\Components\TicketList'   => 'ticket_list',
            'Keios\Support\Components\TicketStatus' => 'ticket_status',

        ];
    }

    /**
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'support' => [
                'label'    => 'Support',
                'url'      => Backend::url('keios/support/tickets'),
                'icon'     => 'icon-help',
                'order'    => 500,
                'sideMenu' => [
                    'tickets'          => [
                        'label' => 'keios.support::lang.app.tickets',
                        'url'   => Backend::url('keios/support/tickets'),
                        'icon'  => 'icon-globe',
                    ],
                    'ticketcategories' => [
                        'label' => 'keios.support::lang.app.ticketcategories',
                        'url'   => Backend::url('keios/support/ticketcategories'),
                        'icon'  => 'icon-globe',
                    ],
                    'ticketcreators'   => [
                        'label' => 'keios.support::lang.app.ticketcreators',
                        'url'   => Backend::url('keios/support/ticketcreators'),
                        'icon'  => 'icon-users',
                    ],
                ],
            ],
        ];
    }

}


