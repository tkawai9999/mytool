<?php
return array(
	'_root_'  => 'todolist/index',  // The default route
	'_404_'   => 'todolist/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);
