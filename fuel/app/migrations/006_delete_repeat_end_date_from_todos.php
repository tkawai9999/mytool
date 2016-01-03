<?php

namespace Fuel\Migrations;

class Delete_repeat_end_date_from_todos
{
	public function up()
	{
		\DBUtil::drop_fields('todos', array(
			'repeat_end_date'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('todos', array(
			'repeat_end_date' => array('type' => 'datetime'),

		));
	}
}
