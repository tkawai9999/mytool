<?php
class Controller_TodoList extends Controller_Template
{
    private $_uid;
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
        //ログインID取得
        $login_user=Auth::get_user_id();
        $this->_uid=$login_user[1];

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
            $data['todos'] = Model_Todo::getListDuring($this->_uid);

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
            $data['todos'] = Model_Todo::getListUntreatDeadLineYes($this->_uid);

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
            $data['todos'] = Model_Todo::getListUntreatDeadLineNo($this->_uid);

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
            $data['todos'] = Model_Todo::getListHold($this->_uid);

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
            $data['todos'] = Model_Todo::getListFinished($this->_uid);

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
            $data['todos'] = Model_Todo::getListCategory(
                               $data['category_id'],$this->_uid);

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

            //更新
            $info=Model_Todo::getPk($todo_id);
            if ( count($info)==0)
            {
                $msg="todo_idなし:$todo_id";
                Log::error($msg.":".__FILE__.":".__LINE__);
                throw new Exception($msg);
            }
            $info['status_id']=$status_id;
            $todo= new Model_Todo();
            $todo->setData($info,$this->_uid);
            $rc=$todo->validData();
            if (!$rc)
            {
                $msg=$todo->getMessage();
                Log::error($msg.":".__FILE__.":".__LINE__);
                throw new Exception($msg);
            }
            $todo->saveData();

            //更新後のステータスの一覧にリダイレクト
            $action=Model_Todo::getTodoListKind($todo_id);

            Response::redirect("todolist/$action");
            return;

            //ステータス更新
            $data['todos'] = Model_Todo::updateStatus($todo_id, 
                $status_id, $this->_uid);

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
