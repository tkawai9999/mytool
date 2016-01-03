<?php

namespace Fuel\Migrations;

class Add_end_date_real_to_todos
{
	public function up()
	{
		\DBUtil::add_fields('todos', array(
            'end_date_real' => array('type' => 'datetime', 'null' => true, 'after' => 'end_date'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('todos', array(
			'end_date_real'

		));
	}
}
