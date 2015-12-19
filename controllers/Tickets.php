<?php namespace Keios\Support\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Keios\Support\Models\Ticket;
use Lang;

/**
 * Tickets Back-end Controller
 */
class Tickets extends Controller
{
    /**
     * @var array
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
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
     * @var string
     */
    public $relationConfig = 'config_relation.yaml';


    /**
     * Tickets constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Keios.Support', 'support', 'tickets');
    }

    /**
     * Deletes checked tickets.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $ticketId) {
                if (!$ticket = Ticket::find($ticketId)) {
                    continue;
                }
                $ticket->delete();
            }

            Flash::success(Lang::get('keios.support::lang.tickets.delete_selected_success'));
        } else {
            Flash::error(Lang::get('keios.support::lang.tickets.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}