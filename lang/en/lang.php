<?php

return [
    'plugin'           => [
        'name'        => 'Support',
        'description' => 'Very Simple Ticket System',
    ],
    'tickets'          => [
        'delete_selected_success' => 'Successfully deleted the selected tickets.',
        'delete_selected_empty'   => 'There are no selected :name to delete.',
        'menu_label'              => 'Tickets',
        'delete_confirm'          => 'Do you really want to delete this ticket?',
        'return_to_list'          => 'Return to Tickets',
        'delete_selected_confirm' => 'Delete the selected tickets?',
    ],
    'ticket'           => [
        'new'           => 'New Ticket',
        'list_title'    => 'Manage Tickets',
        'label'         => 'Ticket',
        'create_title'  => 'Create Ticket',
        'update_title'  => 'Edit Ticket',
        'preview_title' => 'Preview Ticket',
    ],
    'components'       => [
        'ticketform'   => [
            'name'        => 'TicketForm Component',
            'description' => 'Form for clients to create tickets',
        ],
        'ticketstatus' => [
            'name'        => 'TicketStatus Component',
            'description' => 'Component for clients to check ticket status and comments',
        ],
        'ticketlist'   => [
            'name'        => 'TicketList Component',
            'description' => 'Lists all tickets for given email and code',
        ],
    ],
    'ticketcategories' => [
        'menu_label'              => 'Ticket Categories',
        'delete_confirm'          => 'Do you really want to delete this ticket category?',
        'return_to_list'          => 'Return to Ticket Categories',
        'delete_selected_confirm' => 'Delete the selected ticket categories?',
        'delete_selected_success' => 'Successfully deleted the selected ticket categories.',
        'delete_selected_empty'   => 'There are no selected :name to delete.',
    ],
    'ticketcategory'   => [
        'new'           => 'New Ticket Category',
        'list_title'    => 'Manage Ticket Categories',
        'label'         => 'Ticket Category',
        'create_title'  => 'Create Ticket Category',
        'update_title'  => 'Edit Ticket Category',
        'preview_title' => 'Preview Ticket Category',
    ],
    'ticketcreators'   => [
        'menu_label'              => 'Ticket Creators',
        'delete_confirm'          => 'Do you really want to delete this ticket creator?',
        'return_to_list'          => 'Return to Ticket Creators',
        'delete_selected_confirm' => 'Delete the selected ticket creators?',
        'delete_selected_success' => 'Successfully deleted the selected ticket creators.',
        'delete_selected_empty'   => 'There are no selected :name to delete.',
    ],
    'ticketcreator'    => [
        'new'           => 'New Ticket Creator',
        'list_title'    => 'Manage Ticket Creators',
        'label'         => 'Ticket Creator',
        'create_title'  => 'Create Ticket Creator',
        'update_title'  => 'Edit Ticket Creator',
        'preview_title' => 'Preview Ticket Creator',
    ],
    'ticketcomments'   => [
        'menu_label'              => 'Ticket Comments',
        'delete_confirm'          => 'Do you really want to delete this ticket comment?',
        'return_to_list'          => 'Return to Ticket Comments',
        'delete_selected_confirm' => 'Delete the selected ticket comments?',
        'delete_selected_success' => 'Successfully deleted the selected ticket comments.',
        'delete_selected_empty'   => 'There are no selected :name to delete.',
    ],
    'ticketcomment'    => [
        'new'           => 'New Ticket Comment',
        'list_title'    => 'Manage Ticket Comments',
        'label'         => 'Ticket Comment',
        'create_title'  => 'Create Ticket Comment',
        'update_title'  => 'Edit Ticket Comment',
        'preview_title' => 'Preview Ticket Comment',
    ],
    'app'              => [
        'tickets'          => 'Tickets',
        'ticketcategories' => 'Categories',
        'ticketcreators'   => 'Creators',
    ],
];