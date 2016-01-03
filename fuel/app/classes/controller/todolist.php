<?php
class Controller_TodoList extends Controller_Template
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
        Response::redirect("todolist/during");
	}

    /**
     * ToDo一覧表示（対応中）
     *
     */
	public function action_during()
	{
        try
        {
            $data=Input::all();

            //Todo一覧作成
            $data['side_during'] =  "active";
            $data['page_name'] =  "対応中";
            $data['todos'] = Model_Todo::getListDuring();

            $view= View::forge('todo/list',$data);
            $this->template->content = 
                  Presenter::Forge('todo/list', 'view', null, $view);
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
	}

    /**
     * ToDo一覧表示 未(期限有）
     *
     */
	public function action_untreat1()
	{
        try
        {
            $data=Input::all();
        
            //Todo一覧作成
            $data['side_untreat1'] =  "active";
            $data['page_name'] =  "未(期限有）";
            $data['todos'] = Model_Todo::getListUntreatDeadLineYes();

            $view= View::forge('todo/list',$data);
            $this->template->content = 
                Presenter::Forge('todo/list', 'view', null, $view);
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
	}

    /**
     * ToDo一覧表示 未(期限無）
     *
     */
	public function action_untreat2()
	{
        try
        {
            $data=Input::all();
        
            //Todo一覧作成
            $data['side_untreat2'] =  "active";
            $data['page_name'] =  "未(期限無）";
            $data['todos'] = Model_Todo::getListUntreatDeadLineNo();

            $view= View::forge('todo/list',$data);
            $this->template->content = 
                Presenter::Forge('todo/list', 'view', null, $view);
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
	}

    /**
     * ToDo一覧表示(保留)
     *
     */
	public function action_hold()
	{
        try
        {
            $data=Input::all();
        
            //Todo一覧作成
            $data['side_hold'] =  "active";
            $data['page_name'] =  "保留";
            $data['todos'] = Model_Todo::getListHold();

            $view= View::forge('todo/list',$data);
            $this->template->content = 
                Presenter::Forge('todo/list', 'view', null, $view);
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
	}

    /**
     * ToDo一覧表示(完了)
     *
     */
	public function action_finished()
	{
        try
        {
            $data=Input::all();
        
            //Todo一覧作成
            $data['side_finished'] =  "active";
            $data['page_name'] =  "完了";
            $data['todos'] = Model_Todo::getListFinished();

            $view= View::forge('todo/list',$data);
            $this->template->content = 
                Presenter::Forge('todo/list', 'view', null, $view);
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
	}

    /**
     * ToDo一覧表示(カテゴリ)
     *
     */
    public function action_category()
    {
        try
        {
            $data=Input::all();

            //Todo一覧作成
            $data['todos'] = Model_Todo::getListCategory($data['category_id']);

            $view= View::forge('todo/list',$data);
            $this->template->content =
                Presenter::Forge('todo/list', 'view', null, $view);
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
    }

    /**
     * ステータス更新
     *
     */
	public function action_changeStatus()
	{
        try
        {
            $data=Input::all();

            $todo_id=$data['todo_id'];
            $status_id=$data['status_id'];
            $refer=$data['refer'];

            //ステータス更新
            $data['todos'] = Model_Todo::updateStatus($todo_id, $status_id);

            Response::redirect($refer);
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
	}

    /**
     * 404エラー
     *
     */
    public function action_404()
    {
        $this->template->content = View::forge('404');
    }
    /**
     * 工事中
     *
     */
    public function action_working()
    {
        $this->template->content = View::forge('working');
    }
}