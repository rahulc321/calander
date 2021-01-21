<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 10/20/16
 * Time: 10:51 AM
 */

namespace App\Services;


class LeadsChartsTransformer
{
    public static function SourcePieChart($data)
    {
        $pie = [];
        foreach ($data as $item) {
            /*"label": "Torklaw",
                    "color": "#4acab4",
                    "data": 30*/
            $pie[] = [
                'label' => $item->title,
                'color' => $item->color,
                'data' => ($item->leads->count('id') * 360) / 100
            ];
        }
        return $pie;
    }

    public static function UserBarChart($data)
    {
        $bar = [];
        /*["Peter", 27],
                        ["John", 82],
                        ["Rebeca", 56],
                        ["Jim", 14],
                        ["Natalia", 28]*/
        foreach ($data as $item) {
            $bar[] = [
                $item->fullName(), $item->assignedLeads->count('id')
            ];
        }

        return $bar;

    }
}