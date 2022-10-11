<?php

namespace App\Helpers;

class Logs
{
    public static function logMe($msg)
    {
        $fp = fopen("App/Storange/log.txt", "a");
        fwrite($fp, $msg . PHP_EOL);
        fclose($fp);
    }

}