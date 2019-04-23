<?php

namespace App\Classes;


class FormatData
{

    /**
     * @param $string
     * @return mixed
     */
    public static function removeDotsOfString($string)
    {
        return str_replace('.', '', $string);
    }

    public static function cleanPhoneNumber($value)
    {
        return preg_replace("/[^0-9]/", "", $value );
    }
}
