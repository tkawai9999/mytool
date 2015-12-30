<?php

class Controller_Users extends Controller_Template
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

        $data=Input::all();
        //Log::info("param=".print_r($data,true)); 'ログ出力NG(passwd)

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
     * ログイン画面表示
     *
     */
	public function action_index()
	{
        $data['uid']="";
        $data['passwd']="";
		$this->template->content = View::forge('users/login',$data);
	}
    /**
     * ログイン処理
     *
     */
	public function action_login()
	{
        $data=Input::post();
        if (!isset($data['uid'])) $data['uid']='';
        if (!isset($data['passwd'])) $data['passwd']='';
        if (!Auth::login($data['uid'], $data['passwd']))
        {
            $data['msg']='正しいuserid、passwordを入力してください。';
		    $this->template->content = View::forge('users/login',$data);
            return;

        }

        Response::redirect("todolist");

	}
    /**
     * ログアウト処理
     *
     */
	public function action_logout()
	{
        Auth::logout();
        Response::redirect("users");
    }

    /**
     * パスワード変更画面表示
     *
     */
	public function action_changePasswdInit()
	{
		$this->template->content = View::forge('users/passwd');
    }

    /**
     * パスワード変更処理
     *
     */
	public function action_changePasswd()
	{
        $data=Input::post();
        $old_passwd=(isset($data['old_passwd']))?trim($data['old_passwd']):"";
        $new_passwd1=(isset($data['new_passwd1']))?trim($data['new_passwd1']):"";
        $new_passwd2=(isset($data['new_passwd2']))?trim($data['new_passwd2']):"";

        if ( $new_passwd1 =="" || $new_passwd2 =="")
        {
            $data['msg']='passwordを入力してください。';
		    $this->template->content = View::forge('users/passwd',$data);
            return;
        }
        if ( $new_passwd1 <> $new_passwd2 )
        {
            $data['msg']='同じpasswordを入力してください。';
		    $this->template->content = View::forge('users/passwd',$data);
            return;
        }

        if (!Auth::change_password($old_passwd, $new_passwd1))
        {
            $data['msg']='現在のパスワードが間違ってます。';
		    $this->template->content = View::forge('users/passwd',$data);
            return;
        }

		$this->template->content = View::forge('users/passwd_finished');
    }
}
