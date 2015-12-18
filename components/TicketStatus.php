<?php namespace Keios\Support\Components;

use Cms\Classes\ComponentBase;
use Keios\Support\Models\Ticket;
use Keios\Support\Models\TicketComment;
use Validator;

/**
 * Class TicketStatus
 * @package Keios\Support\Components
 */
class TicketStatus extends ComponentBase
{

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'keios.support::lang.components.ticketstatus.name',
            'description' => 'keios.support::lang.components.ticketstatus.description',
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'keios.support::lang.app.hash',
                'description' => 'keios.support::lang.app.hash_desc',
                'default'     => '{{ :hash }}',
                'type'        => 'string',
            ],
        ];
    }

    /**
     *
     */
    public function onRun()
    {
        $this->page['authorize_access'] = true;
        $hash = $this->property('slug');
        $getData = get();
        if (array_key_exists('email', $getData)) {
            $this->page['ticket_email'] = $getData['email'];
        }
        if (array_key_exists('code', $getData)) {
            $this->page['ticket_code'] = $getData['code'];
        }

        if (count($getData) == 2) {
            $this->authorizeClient($hash, $getData);
        }

        if ($hash) {
            $ticket = Ticket::where('hash_id', $hash)->first();

            $isAuthorized = \Session::get($ticket->hash_id);
            if ($isAuthorized == 'authorized') {
                $this->page['authorize_access'] = false;
                $this->page['user_email'] = $ticket->creator->email;
                $this->page['user_code'] = $ticket->creator->code;
                $this->page['ticket'] = $ticket;
            }
        } else {
            $this->page['ask_number'] = true;
        }

        return null;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \ValidationException
     */
    public function onCredentialsCheck()
    {
        $data = post();
        $hash = $this->property('slug');
        if (!$hash && array_key_exists('ticket_number', $data)) {
            $hash = $data['ticket_number'];
        }
        $this->authorizeClient($hash, $data);
    }

    /**
     * @throws \ValidationException
     */
    public function onAddComment()
    {
        $data = post();
        $this->validateComment($data);
        $hash = $this->property('slug');
        if (!$hash && array_key_exists('ticket_number', $data)) {
            $hash = $data['ticket_number'];
        }

        $ticket = Ticket::where('hash_id', $hash)->first();
        $author = $ticket->creator;

        $comment = new TicketComment(
            [
                'author'     => $data['comment_author'].' ('.$author->email.')',
                'is_support' => 0,
                'content'    => $data['comment_content'],
            ]
        );

        $ticket->comments()->save($comment);

        $comment->save();

        $this->page['ticket'] = $ticket;
    }

    /**
     * @param string $hash
     * @param array  $data
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \ValidationException
     */
    private function authorizeClient($hash, $data)
    {
        $ticket = Ticket::where('hash_id', $hash)->first();

        $this->validateCredentials($ticket, $data);
        $sessionKey = $ticket->hash_id;
        \Session::put($sessionKey, 'authorized');

        return \Redirect::back();
    }

    /**
     * @param Ticket $ticket
     * @param array  $data
     *
     * @throws \ValidationException
     * @throws \Exception
     */
    private function validateCredentials($ticket, $data)
    {
        $rules = [
            'email' => 'required',
            'code'  => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new \ValidationException($validator);
        }

        if ($ticket->code != $data['code'] || $ticket->creator->email != $data['email']) {
            throw new \Exception(trans('keios.support::lang.errors.invalid_credentials'));
        }
    }

    /**
     * @param array $data
     *
     * @throws \ValidationException
     */
    private function validateComment($data)
    {
        $rules = [
            'comment_author'  => 'required',
            'comment_content' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new \ValidationException($validator);
        }

    }


}