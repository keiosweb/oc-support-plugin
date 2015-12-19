<?php namespace Keios\Support;

use System\Classes\PluginBase;
use Backend;

/**
 * Support Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * @var array
     */
    public $require = [
        'Keios.ProUser',
        'RainLab.Translate',
    ];

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
     * Registers settings
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Support Settings',
                'description' => 'Setup Ticket System',
                'icon'        => 'icon-life-ring',
                'class'       => 'Keios\Support\Models\Settings',
                'keywords'    => 'support, tickets',
                'permissions' => ['keios.support.settings'],
                'order'       => 600,
            ],
        ];
    }

    /**
     * Registers components
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Keios\Support\Components\TicketForm'   => 'ticket_form',
            'Keios\Support\Components\TicketList'   => 'ticket_list',
            'Keios\Support\Components\TicketStatus' => 'ticket_status',
            'Keios\Support\Components\Upload'       => 'ticket_attach',
        ];
    }

    /**
     * Registers mail templates
     *
     * @return array
     */
    public function registerMailTemplates()
    {
        return [
            'keios.support::mail.ticket.first'  => trans(
                'keios.support::lang.mailer.first'
            ),
            'keios.support::mail.ticket.create' => trans(
                'keios.support::lang.mailer.create'
            ),
            'keios.support::mail.ticket.update' => trans(
                'keios.support::lang.mailer.update'
            ),
            'keios.support::mail.ticket.close'  => trans(
                'keios.support::lang.mailer.close'
            ),
        ];
    }

    /**
     * Registers backend navigation
     *
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
                        'label'       => 'keios.support::lang.app.tickets',
                        'url'         => Backend::url('keios/support/tickets'),
                        'permissions' => ['keios.support.tickets'],
                        'icon'        => 'icon-ticket',
                    ],
                    'ticketattachments'   => [
                        'label'       => 'keios.support::lang.app.ticketattachments',
                        'url'         => Backend::url('keios/support/ticketattachments'),
                        'permissions' => ['keios.support.statuses'],
                        'icon'        => 'icon-file',
                    ],
                    'ticketcategories' => [
                        'label'       => 'keios.support::lang.app.ticketcategories',
                        'url'         => Backend::url('keios/support/ticketcategories'),
                        'permissions' => ['keios.support.categories'],
                        'icon'        => 'icon-folder',
                    ],
                    'ticketstatuses'   => [
                        'label'       => 'keios.support::lang.app.ticketstatuses',
                        'url'         => Backend::url('keios/support/ticketstatuses'),
                        'permissions' => ['keios.support.statuses'],
                        'icon'        => 'icon-flag',
                    ],
                    'ticketpriorities' => [
                        'label'       => 'keios.support::lang.app.ticketpriorities',
                        'url'         => Backend::url('keios/support/ticketpriorities'),
                        'permissions' => ['keios.support.priorities'],
                        'icon'        => 'icon-star',
                    ],
                ],
            ],
        ];
    }

    /**
     * Registers permissions
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'keios.support.tickets'    => [
                'tab'   => 'keios.support::lang.plugin.name',
                'label' => 'keios.support::lang.permissions.tickets',
            ],
            'keios.support.categories' => [
                'tab'   => 'keios.support::lang.plugin.name',
                'label' => 'keios.support::lang.permissions.categories',
            ],
            'keios.support.statuses'   => [
                'tab'   => 'keios.support::lang.plugin.name',
                'label' => 'keios.support::lang.permissions.statuses',
            ],
            'keios.support.priorities' => [
                'tab'   => 'keios.support::lang.plugin.name',
                'label' => 'keios.support::lang.permissions.priorities',
            ],
            'keios.support.settings'   => [
                'tab'   => 'keios.support::lang.plugin.name',
                'label' => 'keios.support::lang.permissions.settings',
            ],
        ];
    }

}


