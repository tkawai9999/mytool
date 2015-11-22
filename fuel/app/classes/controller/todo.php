<?php
class Controller_Todo extends Controller_Template
{
	public function action_index()
	{
        $this->template->title = "MYTool! ToDo";
        $this->template->menu_todo = "active";
        $data['main']="todo/ToDoList";
        $this->template->content = View::forge('todo/index',$data);
	}
	public function action_entry()
	{
		return Response::forge(View::forge('todo/form'));
	}

	public function action_category()
	{
		return Response::forge(View::forge('todo/category'));
	}

	public function action_test()
	{
		return Response::forge(View::forge('todo/test3'));
	}


}
