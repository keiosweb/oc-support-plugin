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
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterFirstTicket($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.ticket.first', $vars);
    }

    /**
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterTicketCreated($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.ticket.create', $vars);

    }

    /**
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterTicketUpdated($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.ticket.update', $vars);

    }

    /**
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterTicketClosed($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.ticket.close', $vars);

    }

    /**
     * @param string $email
     * @param array  $vars
     */
    public function sendAfterCodeRecoveryRequest($email, $vars)
    {
        Mail::sendTo($email, 'keios.support::mail.account.code_recovery', $vars);

    }

}