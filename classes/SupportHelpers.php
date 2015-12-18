<?php
/**
 * Created by Keios Solutions
 * User: Jakub Zych
 * Date: 12/18/15
 * Time: 3:07 PM
 */

namespace Keios\Support\Classes;

use Hashids\Hashids;
use Validator;
use October\Rain\Support\Facades\Config;

/**
 * Class SupportHelpers
 * @package Keios\Support\Classes
 */
class SupportHelpers
{
    /**
     * @param array $data
     *
     * @throws \ValidationException
     */
    public function validateTicket($data)
    {
        $rules = [
            'name'    => 'required',
            'email'   => 'required',
            'topic'   => 'required',
            'content' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new \ValidationException($validator);
        }

    }

    /**
     * @return Hashids
     */
    public function generateCode($id)
    {
        $code = new Hashids(Config::get('app.key'), 8, 'ABCDEFGHIJKLMNOPRSTUWXYZabcdefghijklmnoprstuwxyz123456789');

        return $code->encode($id);
    }

    /**
     * @return Hashids
     */
    public function generateHashId($id)
    {
        $code = new Hashids(Config::get('app.key'), 8, 'ABCDEF1234567890');

        return $code->encode($id);
    }

    /**
     * @param $hashId
     *
     * @return null
     */
    public function newTicketHandler($hashId)
    {
        return null;
    }
}