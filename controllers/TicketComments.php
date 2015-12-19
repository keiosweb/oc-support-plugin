<?php namespace Keios\Support\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Keios\Support\Models\TicketComment;
use Lang;

/**
 * Ticket Comments Back-end Controller
 */
class TicketComments extends Controller
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
     * TicketComments constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Keios.Support', 'support', 'ticketcomments');
    }

    /**
     * Deletes checked ticket comments.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $ticketcommentId) {
                if (!$ticketcomment = TicketComment::find($ticketcommentId)) {
                    continue;
                }
                $ticketcomment->delete();
            }

            Flash::success(Lang::get('keios.support::lang.ticketcomments.delete_selected_success'));
        } else {
            Flash::error(Lang::get('keios.support::lang.ticketcomments.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}