<?php

class Model_Repetunit extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'dateword',
		'sort_no',
		'uid',
		'delf',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => true,
		),
	);

	protected static $_table_name = 'repetunits';

    protected static $_has_one = array(
        'todo' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Todo',
            'key_to' => 'repeat_unit_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );

    /**
     * 全データ取得
     *
     * @param なし
     * @return array 全データ
     */
    public static function getListAll()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( array('delf', 0),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug(DB::last_query());
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }
}
