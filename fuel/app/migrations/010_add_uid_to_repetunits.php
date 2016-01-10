<?php

namespace Fuel\Migrations;

class Add_uid_to_repetunits
{
	public function up()
	{
		\DBUtil::add_fields('repetunits', array(
			'uid' => array('constraint' => 11, 'type' => 'int', 'after' => 'sort_no'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('repetunits', array(
			'uid'

		));
	}
}