<?php

namespace Fuel\Migrations;

class Add_dateword_to_repetunits
{
	public function up()
	{
		\DBUtil::add_fields('repetunits', array(
			'dateword' => array('constraint' => 32, 'type' => 'varchar', 'after' => 'name'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('repetunits', array(
			'dateword'

		));
	}
}