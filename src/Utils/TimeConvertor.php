<?php
declare(strict_types=1);

namespace XackiGiFF\MDayBonus\Utils;

use XackiGiFF\MDayBonus\Main;

class TimeConvertor{
/* Добавление Конвертера времени */

public static function ConvertSecToWord($sec){
    $mes = '';
    $SecOnYear   = 31536000;
    $SecOnMonth  = 2592000;
    $SecOnWeek   = 604800;
    $SecOnDay    = 86400;
    $SecOnHour   = 3600;
    $SecOnMin    = 60;
    if (intval($sec / $SecOnYear) > 0){
        $year = intval($sec / $SecOnYear);
        $sec  = $sec - ($year * $SecOnYear);
        $mes  = self::CorrectString($year,'year');
    }
    if (intval($sec / $SecOnMonth) > 0){
        $month = intval($sec / $SecOnMonth);
        $sec   = $sec - ($month * $SecOnMonth);
        $mes  .= self::CorrectString($month,'month');
    }
    if (intval($sec / $SecOnWeek) > 0){
        $week = intval($sec / $SecOnWeek);
        $sec  = $sec - ($week * $SecOnWeek);
        $mes .= self::CorrectString($week,'week');
    }
    if (intval($sec / $SecOnDay) > 0){
        $day  = intval($sec / $SecOnDay);
        $sec  = $sec - ($day * $SecOnDay);
        $mes .= self::CorrectString($day,'day');
    }
    if (intval($sec / $SecOnHour) > 0){
        $hour = intval($sec / $SecOnHour);
        $sec  = $sec - ($hour * $SecOnHour);
        $mes .= self::CorrectString($hour,'hour');
    }
    if (intval($sec / $SecOnMin) > 0){
        $min = intval($sec / $SecOnMin);
        $sec  = $sec - ($min * $SecOnMin);
        $mes .= self::CorrectString($min,'min');
    }

    if ($sec > 0) $mes .= self::CorrectString($sec,'sec');
    return $mes;    
}

public static function CorrectString($number, $type){
    $word = array('year'  => array('год'    ,'года'    ,'лет'   ),
                  'month' => array('месяц'  ,'месяца' ,'месяцев'),
                  'week'  => array('неделю' ,'недели' ,'недель' ),
                  'day'   => array('день'   ,'дня'    ,'дней'   ),
                  'hour'  => array('час'    ,'часа'   ,'часов'  ),
                  'min'   => array('минуту,' ,'минуты,' ,'минут,'  ),
                  'sec'   => array('секунду','секунды','секунд' ));
    $number = (string) $number;
    if (strlen($number) > 1){
        if ($number[strlen($number)-2].$number[strlen($number)-1] == '11'){
            $LastNum = '10';
        }else{
            $LastNum = $number[strlen($number)-1];
        }
    }else{
        $LastNum = $number[strlen($number)-1];
    }
    if ($LastNum == 1){
        $str = 0;
    }elseif($LastNum == 2 || $LastNum == 3 || $LastNum == 4){
        $str = 1;
    }else{
        $str = 2;
    }
    return ($number.' '.$word[$type][$str].' ');
}

/* Конец добавления конвертера времени */
}