<?php
namespace Seeds;

class Statuses
{
    public static function seed()
    {
        \DBUtil::truncate_table('statuses');
        \DB::insert(
                'statuses'
        )->columns(array(
            'name',
            'sort_no',
            'uid',
            'delf',
            'created_at',
            'updated_at',
                )
        )->values(array(
            '未',
            '1',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '対応中',
            '2',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '保留',
            '3',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                ), array(
            '完了',
            '4',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                )
        )->execute();
    }
}

