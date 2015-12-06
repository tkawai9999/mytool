<?php

class Model_Status extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'sort_no',
		'delf',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'statuses';

    protected static $_has_one = array(
        'todo' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Todo',
            'key_to' => 'status_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );

   /**
     * ステータス一覧取得
     *
     * @param なし
     * @return array ステータス一覧
     */
    public static function getListAll()
    {
        $list = static::find('all', array(
            'where' => array( array('delf', 0),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        return $list;
    }

}