<?php
namespace Seeds;

class Categories
{
    public static function seed()
    {
        \DBUtil::truncate_table('categories');
        \DB::insert(
                'categories'
        )->columns(array(
            'name',
            'sort_no',
            'delf',
            'created_at',
            'updated_at',
                )
        )->values(array(
            'デフォルト',
            '1',
            '0',
            date("Y/m/d H:i:s"),
            date("Y/m/d H:i:s")
                )
        )->execute();
    }
}

