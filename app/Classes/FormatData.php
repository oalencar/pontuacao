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
}
