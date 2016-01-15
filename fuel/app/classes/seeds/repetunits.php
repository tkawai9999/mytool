<?php
namespace Seeds;

class Repetunits
{
    public static function seed()
    {
        \DBUtil::truncate_table('repetunits');
        \DB::insert(
                'repetunits'
        )->columns(array(
            'name',
            'dateword',
            'sort_no',
            'uid',
            'delf',
            'created_at',
            'updated_at',

                )
        )->values(array(
            '日',
            'day',
            '1',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '週',
            'week',
            '2',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '月',
            'month',
            '3',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '年',
            'year',
            '4',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                )
        )->execute();
    }
}
