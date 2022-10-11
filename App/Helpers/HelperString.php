<?php

namespace App\Helpers;

class HelperString
{
    const SIMBOLOS = ['-', '.', "(", ")"];

    public static function clearSymbolsString($str)
    {
        return str_replace(self::SIMBOLOS, '', $str);
    }

    public static function clearEmptySpaceString($str)
    {
        return preg_replace('/\s+/', "", $str);
    }

    public static function columnsStringQuery($params): string
    {
        return implode(',', array_keys($params));
    }

    public static function paramsStringQuery($params): string
    {
        return str_replace(',', '","', implode(',', $params));
    }

    public static function extersaoDoc($documento): string
    {
        return explode('.', $documento)[1];
    }

    public static function validData($date): string
    {

        if ((intval(date('Y')) - 26) < intval(explode('-', $date)[0])) {
            return false;
        }
        return true;
    }


}