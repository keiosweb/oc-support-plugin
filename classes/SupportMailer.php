<?php
/**
 * Created by Keios Solutions
 * User: Jakub Zych
 * Date: 12/18/15
 * Time: 9:30 PM
 */

namespace Keios\Support\Classes;

use Mail;

/**
 * Class SupportMailer
 * @package Keios\Support\Classes
 */
class SupportMailer
{

    /**
     * Emails the user if this is his first ticket.
     *
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterFirstTicket($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.ticket.first', $vars);
    }

    /**
     * Emails the user after he creates the ticket
     *
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterTicketCreated($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.ticket.create', $vars);
    }

    /**
     * Emails the user if his ticket is updated
     *
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterTicketUpdated($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.ticket.update', $vars);
    }

    /**
     * Emails the user if his ticket is closed or resolved
     *
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterTicketClosed($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.ticket.close', $vars);
    }

}