<?php

class Config
{
    public static function dateTime()
    {
        $datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        return $datetime = $datetime->format('Y-m-d');
    }
}
