<?php
/**
 * Created by PhpStorm.
 * User: Oscar Alencar
 * Date: 2019-04-18
 * Time: 21:52
 */

namespace App\Classes;


abstract class Message
{

    abstract protected function getRecipient();

    abstract protected function setRecipient($recipient): void;

    abstract protected function getBody();

    abstract protected function setBody($body): void;

}
