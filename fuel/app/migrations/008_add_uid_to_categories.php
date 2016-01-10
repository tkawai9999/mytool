<?php

namespace Fuel\Migrations;

class Add_uid_to_categories
{
	public function up()
	{
		\DBUtil::add_fields('categories', array(
			'uid' => array('constraint' => 11, 'type' => 'int', 'after' => 'sort_no'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('categories', array(
			'uid'

		));
	}
}