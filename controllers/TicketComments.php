<?php namespace Keios\Support\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Lang;

/**
 * Ticket Comments Back-end Controller
 */
class TicketComments extends Controller
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

        BackendMenu::setContext('Keios.Support', 'support', 'ticketcomments');
    }

    /**
     * Deleted checked ticketcomments.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $ticketcommentId) {
                if (!$ticketcomment = TicketComment::find($ticketcommentId)) continue;
                $ticketcomment->delete();
            }

            Flash::success(Lang::get('keios.support::lang.ticketcomments.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('keios.support::lang.ticketcomments.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}