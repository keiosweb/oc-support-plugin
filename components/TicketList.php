<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;
use Keios\Support\Models\Ticket;
use Keios\Support\Models\TicketCreator;
use Validator;

/**
 * Class TicketList
 * @package Keios\Support\Components
 */
class TicketList extends ComponentBase
{

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'keios.support::lang.components.ticketlist.name',
            'description' => 'keios.support::lang.components.ticketlist.description',
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'ticketPage' => [
                'title'       => 'keios.support::lang.app.ticket_page',
                'description' => 'keios.support::lang.app.ticket_page_desc',
                'default'     => '/ticket',
            ],
        ];
    }


    /**
     *
     */
    public function onRun()
    {
        $this->page['authorize_access'] = true;
        $getData = get();

        if (array_key_exists('email', $getData) && array_key_exists('code', $getData)) {
            $this->page['user_email'] = $getData['email'];
            $this->page['user_code'] = $getData['code'];
            $isAuthorized = \Session::get($getData['email']);
            if ($isAuthorized == 'authorized') {
                $creatorCode = TicketCreator::where('email', $getData['email'])->first()->code;
                $tickets = Ticket::where('code', $creatorCode)->get();
                $this->page['authorize_access'] = false;
                $this->page['ticket_page'] = $this->property('ticketPage');
                $this->page['tickets'] = $tickets;

            }
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \ValidationException
     */
    public function onCredentialsCheck()
    {
        $data = post();
        $email = $data['email'];

        $this->authorizeClient($email, $data);

        $isAuthorized = \Session::get($email);
        if ($isAuthorized == 'authorized') {
            $this->page['authorize_access'] = false;
        }
    }

    /**
     * @param string $email
     * @param array  $data
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \ValidationException
     */
    private function authorizeClient($email, $data)
    {
        $creator = TicketCreator::where('email', $email)->first();

        $this->validateCredentials($creator, $data);
        $sessionKey = $creator->email;
        \Session::put($sessionKey, 'authorized');

        return \Redirect::back();
    }

    /**
     * @param TicketCreator $creator
     * @param array         $data
     *
     * @throws \ValidationException
     * @throws \Exception
     */
    private function validateCredentials($creator, $data)
    {
        $rules = [
            'email' => 'required',
            'code'  => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new \ValidationException($validator);
        }

        if ($creator->code != $data['code'] || $creator->email != $data['email']) {
            throw new \Exception(trans('keios.support::lang.errors.invalid_credentials'));
        }
    }
}