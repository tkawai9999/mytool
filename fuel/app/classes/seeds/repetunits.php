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
            'sort_no',
            'delf',
            'created_at',
            'updated_at',

                )
        )->values(array(
            '日',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '週',
            '2',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '月',
            '3',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '年',
            '4',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                )
        )->execute();
    }
}

