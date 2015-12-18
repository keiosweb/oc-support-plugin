<?php namespace Keios\Support\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Keios\Support\Models\TicketCreator;
use Lang;

/**
 * Ticket Creators Back-end Controller
 */
class TicketCreators extends Controller
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

        BackendMenu::setContext('Keios.Support', 'support', 'ticketcreators');
    }

    /**
     * Deleted checked ticketcreators.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $ticketcreatorId) {
                if (!$ticketcreator = TicketCreator::find($ticketcreatorId)) continue;
                $ticketcreator->delete();
            }

            Flash::success(Lang::get('keios.support::lang.ticketcreators.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('keios.support::lang.ticketcreators.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}