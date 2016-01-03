<?php

namespace Fuel\Migrations;

class Create_repetunits
{
	public function up()
	{
		\DBUtil::create_table('repetunits', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 128, 'type' => 'varchar'),
			'sort_no' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'delf' => array('constraint' => 11, 'type' => 'int'),
            'created_at' =>  array('type' => 'datetime'),
            'updated_at' =>  array('type' => 'datetime', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('repetunits');
	}
}
