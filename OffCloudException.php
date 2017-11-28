<?php
/**
 * Created by PhpStorm.
 * User: patriot
 * Date: 11/25/17
 * Time: 12:20 PM
 */

namespace PHPOffCloud;


class OffCloudException extends \Exception
{
    public function __construct($message, $code)
    {
        throw new \Exception($message, $code);
    }

}