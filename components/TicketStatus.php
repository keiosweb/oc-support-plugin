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
     * Loads ticket selected with page slug
     */
    public function onRun()
    {
        $hash = $this->property('slug');
        $creator = \Auth::getUser();
        if ($hash) {
            $ticket = Ticket::where('hash_id', $hash)->where('creator_id', $creator->id)->first();
            $this->page['user_email'] = $ticket->creator->email;
            $this->page['user_code'] = $ticket->creator->code;
            $this->page['ticket'] = $ticket;
        } else {
            $this->page['ask_number'] = true;
        }
    }

    /**
     * Adds comment to the ticket
     *
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
        $author = $ticket->creator->first_name.' '.$ticket->creator->last_name;
        $authorEmail = ' ('.$ticket->creator->email.')';
        $commentContent = $this->purifyComment($data['comment_content']);

        $comment = new TicketComment(
            [
                'author'     => $author.$authorEmail,
                'is_support' => 0,
                'content'    => $commentContent,
            ]
        );

        $ticket->comments()->save($comment);

        $comment->save();

        $this->page['ticket'] = $ticket;
    }

    /**
     * Validates comment
     *
     * @param array $data
     *
     * @throws \ValidationException
     */
    private function validateComment($data)
    {
        $rules = [
            'comment_content' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new \ValidationException($validator);
        }
    }

    /**
     * Purifies comment from bad html
     *
     * @param string $comment
     *
     * @return string
     */
    private function purifyComment($comment)
    {
        $purifierConfig = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($purifierConfig);

        return $purifier->purify($comment);
    }


}