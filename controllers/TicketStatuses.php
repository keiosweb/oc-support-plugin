<?php namespace Keios\Support\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Keios\Support\Models\TicketStatus;
use Lang;

/**
 * Ticket Statuses Back-end Controller
 */
class TicketStatuses extends Controller
{
    /**
     * @var array
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    /**
     * @var string
     */
    public $formConfig = 'config_form.yaml';
    /**
     * @var string
     */
    public $listConfig = 'config_list.yaml';

    /**
     * TicketStatuses constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Keios.Support', 'support', 'ticketstatuses');
    }

    /**
     * Deletes checked ticket statuses.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $ticketstatusId) {
                if (!$ticketstatus = TicketStatus::find($ticketstatusId)) {
                    continue;
                }
                $ticketstatus->delete();
            }

            Flash::success(Lang::get('keios.support::lang.ticketstatuses.delete_selected_success'));
        } else {
            Flash::error(Lang::get('keios.support::lang.ticketstatuses.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}