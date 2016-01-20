<?php
class Controller_CategoryEdit extends Controller_Hybrid
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
        $data=Input::post();


        $view= View::forge('todo/category',$data);
		return Response::forge( Presenter::Forge('todo/category', 'view', null, $view));
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

            $category= new Model_Category();
            $category->setData($data, $this->_uid);

            $rc=$category->validData();
            if(!$rc)
            {
                $json['res'] = 'NG';
                $json['error'] = trim($category->getMessage());
                $this->response($json);
                return;
            }

            $category->saveData();
            $this->response($json);

        }
        catch (Exception $e)
        {
            Model_Util::logException($e);

            $json['res'] = 'NG';
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

            $json = array(
                'res'   => 'OK',
                'error' => '',
            );

            $category= new Model_Category();
            $category->setData($data, $this->_uid);

            $rc=$category->validDeleteData();
            if(!$rc)
            {
                $json['res'] = 'NG';
                $json['error'] = trim($category->getMessage());
                $this->response($json);
                return;
            }

            $category->saveData();
            $this->response($json);

        }
        catch (Exception $e)
        {
            Model_Util::logException($e);

            $json['res'] = 'NG';
            $json['error'] = "予期せぬエラーが発生しました。";
            $this->response($json);
        }
    }

     /**
     * 並べ替え（上に移動）
     *
     */
    public function action_up()
    {
        try
        {
            $data=Input::post();
            Model_Category::sort($data['category_id'], 'up',$this->_uid);

            $json = array(
                'res'   => 'OK',
                'error' => '',
            );
           $this->response($json);

        }
        catch (Exception $e)
        {
            Model_Util::logException($e);

            $json['res'] = 'NG';
            $json['error'] = "予期せぬエラーが発生しました。";
            $this->response($json);
        }
    }

    /**
     * 並べ替え（下に移動）
     *
     */
    public function action_down()
    {
        try
        {
            $data=Input::post();
            Model_Category::sort($data['category_id'], 'down', $this->_uid);

            $json = array(
                'res'   => 'OK',
                'error' => '',
            );
           $this->response($json);

        }
        catch (Exception $e)
        {
            Model_Util::logException($e);

            $json['res'] = 'NG';
            $json['error'] = "予期せぬエラーが発生しました。";
            $this->response($json);
        }
    }
}
