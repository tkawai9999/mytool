<?php

namespace Fuel\Migrations;

class Add_uid_to_statuses
{
	public function up()
	{
		\DBUtil::add_fields('statuses', array(
			'uid' => array('constraint' => 11, 'type' => 'int', 'after' => 'sort_no'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('statuses', array(
			'uid'

		));
	}
}