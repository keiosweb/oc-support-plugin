<?php namespace Keios\Support\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Keios\Support\Models\TicketCategory;
use Lang;

/**
 * Ticket Categories Back-end Controller
 */
class TicketCategories extends Controller
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
     * TicketCategories constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Keios.Support', 'support', 'ticketcategories');
    }

    /**
     * Deletes checked ticket categories.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $ticketcategoryId) {
                if (!$ticketcategory = TicketCategory::find($ticketcategoryId)) {
                    continue;
                }
                $ticketcategory->delete();
            }

            Flash::success(Lang::get('keios.support::lang.ticketcategories.delete_selected_success'));
        } else {
            Flash::error(Lang::get('keios.support::lang.ticketcategories.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}