<?php
class Controller_TodoEdit extends Controller_Template
{
    /**
     * 前処理
     *
     */
    public function before()
    {
        parent::before(); 
        Log::info("START ".Request::active()->controller. ":".Request::active()->action);

        Config::load('define',true);
        $this->template->title = Config::get('define.title_name.todo');
        $this->template->menu_todo = "active";

        $data=Input::all();
        Log::info("param=".print_r($data,true));

        //ログインチェック
        if (!Auth::check())
        {
            Response::redirect('/users/');
        }
    }

    /**
     * 後処理
     *
     */
    public function after($response)
    {
        $response=parent::after($response);
        Log::info("END ".Request::active()->controller. ":".Request::active()->action);
        return $response;

    }

    /**
     * 初期表示
     *
     */
	public function action_index()
	{
        $data=Input::post();


        $view= View::forge('todo/form',$data);
		return Response::forge( Presenter::Forge('todo/form', 'view', null, $view));
	}

    /**
     * 保存
     *
     */
	public function action_save()
	{
        try
        {
            $data=Input::post();
           
            $todo= new Model_Todo();
            $todo->setData($data);

            $rc=$todo->validData();
            if(!$rc)
            {
                //うまく動かない。。（保留）
                $view= View::forge('todo/form',$data);
		        return Response::forge( Presenter::Forge('todo/form', 'view', null, $view));

            }

            $todo->saveData();


            Response::redirect($data['refer']);
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
	}

    /**
     * 削除
     *
     */
	public function action_delete()
	{
        try
        {
            $data=Input::post();


            //削除
            Model_Todo::deleteData($data['todo_id']);


            Response::redirect($data['refer']);
        
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
    }
}
