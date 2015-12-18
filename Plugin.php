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
    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Support Settings',
                'description' => 'Setup Ticket System',
                'icon' => 'icon-life-ring',
                'class' => 'Keios\Support\Models\Settings',
                'order' => 600
            ]
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
    public function registerMailTemplates()
    {
        return [
            'keios.support::mail.ticket.first'          => trans(
                'keios.support::lang.mailer.first'
            ),
            'keios.support::mail.ticket.create'         => trans(
                'keios.support::lang.mailer.create'
            ),
            'keios.support::mail.ticket.update'         => trans(
                'keios.support::lang.mailer.update'
            ),
            'keios.support::mail.ticket.close'          => trans(
                'keios.support::lang.mailer.close'
            ),
            'keios.support::mail.account.code_recovery' => trans(
                'keios.support::lang.mailer.code_recover'
            ),
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
                'icon'     => 'icon-life-ring',
                'order'    => 500,
                'sideMenu' => [
                    'tickets'          => [
                        'label' => 'keios.support::lang.app.tickets',
                        'url'   => Backend::url('keios/support/tickets'),
                        'icon'  => 'icon-ticket',
                    ],
                    'ticketcategories' => [
                        'label' => 'keios.support::lang.app.ticketcategories',
                        'url'   => Backend::url('keios/support/ticketcategories'),
                        'icon'  => 'icon-folder-o',
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


