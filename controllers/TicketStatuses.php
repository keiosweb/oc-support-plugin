<?php namespace Keios\Support\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Lang;

/**
 * Ticket Statuses Back-end Controller
 */
class TicketStatuses extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Keios.Support', 'support', 'ticketstatuses');
    }

    /**
     * Deleted checked ticketstatuses.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $ticketstatusId) {
                if (!$ticketstatus = TicketStatus::find($ticketstatusId)) continue;
                $ticketstatus->delete();
            }

            Flash::success(Lang::get('keios.support::lang.ticketstatuses.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('keios.support::lang.ticketstatuses.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}