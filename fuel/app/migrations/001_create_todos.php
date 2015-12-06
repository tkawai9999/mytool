<?php

namespace Fuel\Migrations;

class Create_todos
{
	public function up()
	{
		\DBUtil::create_table('todos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'start_date' => array('type' => 'datetime', 'null' => true),
			'end_date' => array('type' => 'datetime', 'null' => true),
			'repeat_flag' => array('constraint' => 11, 'type' => 'int'),
			'repeat_unit_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'repeat_interval' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'repeat_end_date' => array('type' => 'datetime', 'null' => true),
			'status_id' => array('constraint' => 11, 'type' => 'int'),
			'category_id' => array('constraint' => 11, 'type' => 'int'),
			'note' => array('type' => 'text', 'null' => true),
			'sort_no' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'delf' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('todos');
	}
}