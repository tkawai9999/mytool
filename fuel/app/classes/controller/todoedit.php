<?php
class Controller_TodoEdit extends Controller_Hybrid
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
        try
        {
            $data=Input::post();

            $view= View::forge('todo/form',$data);
		    return Response::forge( Presenter::Forge('todo/form', 'view', null, $view));
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
	}

    /**
     * 保存
     *
     */
	public function action_save()
	{
        try
        {
            $json = array(
                'res'   => 'OK',
                'error' => '',
            );
            $data=Input::post();

            $todo= new Model_Todo();
            $todo->setData($data, $this->_uid);
            $rc=$todo->validData();
            if(!$rc)
            {
                $json['res'] = 'NG';
                $json['error'] = trim($todo->getMessage());
                $this->response($json);
                return;
            }
            $todo->saveData();
            $this->response($json);
        }
        catch (Exception $e) 
        {
            $json['res'] = 'NG';
            $msg=$e->getmessage().":".$e->getfile().":".$e->getline();
            Log::error($msg);

            $json['error'] = $e->getmessage();
            $json['error'] = "予期せぬエラーが発生しました。";
            $this->response($json);
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
            Model_Todo::deleteData($data['todo_id'],$this->_uid);

            Response::redirect($data['refer']);
        
        }
        catch (Exception $e) 
        {
            $data['message']=$e->getmessage();
            $this->template->content = View::forge('error',$data);
        }
    }
}
