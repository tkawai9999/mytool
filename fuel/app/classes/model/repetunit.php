<?php

class Model_Repetunit extends \Orm\Model
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
}
