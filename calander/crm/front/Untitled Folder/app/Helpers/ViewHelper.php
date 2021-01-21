<?php
/**
 * Created by PhpStorm.
 * User: zorro
 * Date: 5/20/2015
 * Time: 12:25 PM
 */

namespace App\Helpers;


class ViewHelper
{

    public static function limit_words($string, $word_limit)
    {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    public static function word_limit($string, $limit)
    {
        $words = explode(" ", $string);
        if (count($words) > $limit) {
            return implode(" ", array_splice($words, 0, $limit));
        } else {
            return $string;
        }

    }

    public static function ToJs($data){
        echo '<script type="text/javascript">
	    /* <![CDATA[ */';

        foreach ($data as $k => $v) {
            echo 'var ' . $k . '= ' . json_encode($v) . ';';
        }
        echo '/* ]]> */
	    </script>';
    }

    public static function NiceTime($date)
    {
        {
            if (empty($date)) {
                return "No Date Provided";
            }

            $periods = array("Second", "Minute", "Hour", "Day", "Week", "Month", "Year", "Decade");
            $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

            $now = time();
            $unix_date = strtotime($date);

            // check validity of date
            if (empty($unix_date)) {
                return "Bad date";
            }

            // is it future date or past date
            if ($now > $unix_date) {
                $difference = $now - $unix_date;
                $tense = "Ago";

            } else {
                $difference = $unix_date - $now;
                $tense = "From Now";
            }

            for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
                $difference /= $lengths[$j];
            }

            $difference = round($difference);

            if ($difference != 1) {
                $periods[$j] .= "s";
            }
            return "$difference $periods[$j] {$tense}";

        }
    }


    public static function x_week_range($date)
    {
        $ts = strtotime($date);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
        return array(date('Y-m-d', $start),
            date('Y-m-d', strtotime('next saturday', $start)));
    }


    public static function LastWeek($format="Y-m-d"){
        $previous_week = strtotime("-1 week +1 day");

        $start_week = strtotime("last sunday midnight",$previous_week);
        $end_week = strtotime("next saturday",$start_week);

        $start_week = date($format, $start_week);
        $end_week = date($format, $end_week);

        return array($start_week, $end_week);
    }
}


