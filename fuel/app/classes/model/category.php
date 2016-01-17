<?php

class Model_Category extends \Orm\Model
{
    private $_save_data;
    private $_message;

    protected static $_properties = array(
		'id',
		'name',
		'sort_no',
		'uid',
		'delf',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => true,
		),
	);

	protected static $_table_name = 'categories';

    protected static $_has_one = array(
        'todo' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Todo',
            'key_to' => 'category_id',
            'cascade_save' => false, 
            'cascade_delete' => false,
        )
    );

    /**
     * カテゴリ一覧取得
     * 
     * @param $uid  ログインユーザID
     * @return array カテゴリ一覧
     */
    public static function getListAll($uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( array('delf', 0),
                       array('uid', $uid),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug(DB::last_query());
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

    /**
     * 登録データをセットする
     *
     * @param $data 登録対象のデータ
     * @param $uid  ログインユーザID
     * @return なし
     */
    public function setData($data,$uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $this->_save_data=$data;
        $this->_save_data['uid']=$uid;
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
    }

    /**
     * エラーメッセージの取得（Iエラーの場合）
     *
     * @param なし
     * @return string エラーメッセージ
     */
    public function getMessage ()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        return $this->_message;
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
    }

    /**
     * 登録データを返す
     *
     * @param なし
     * @return array 登録データ
     */
    public function getData ()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        return $this->_save_data;
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
    }


    /**
     * 登録データをチェックする
     *
     * @param なし
     * @return boolean true:正常 false:異常
     */
    public function validData ()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        $val = Validation::forge();

        //チェック定義&例外エラー対応
        $val->add('name', 'カテゴリ名')
            ->add_rule('required')
            ->add_rule('max_length',255);

        if ( $this->_save_data['category_id'] <>'' &&
              !is_numeric( $this->_save_data['category_id']))
        {
            $msg="category_id不正=".$this->_save_data['category_id'];
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }
        if ( $this->_save_data['uid'] =='' ||
              !is_numeric( $this->_save_data['uid']))
        {
            $msg="uid不正=".$this->_save_data['uid'];
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }
        if ( $this->_save_data['delf'] =='' ||
              !is_numeric( $this->_save_data['delf']))
        {
            $msg="delf不正=".$this->_save_data['uid'];
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }

        //実行
        if (!$val->run($this->_save_data))
        {
            $errors = $val->error();
            foreach ($errors as $error)
            {
                //先頭１個だけ返す
                $this->_message = $error;
                Log::error($error);

                break;
            }
            return false;
        }

        Log::debug("END ".__CLASS__.":".__FUNCTION__);
       return true;
    }

    /**
     * 削除可能かチェックする
     *
     * @param なし
     * @return boolean true:正常 false:異常
     */
    public function validDeleteData ()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        //必須チェック
        if ( $this->_save_data['category_id'] =='' ||
              !is_numeric( $this->_save_data['category_id']))
        {
            $msg="category_id不正=".$this->_save_data['category_id'];
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }
        if ( $this->_save_data['uid'] =='' ||
              !is_numeric( $this->_save_data['uid']))
        {
            $msg="uid不正=".$this->_save_data['uid'];
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }
        if ( $this->_save_data['delf'] =='' ||
              !is_numeric( $this->_save_data['delf']))
        {
            $msg="delf不正=".$this->_save_data['uid'];
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }

        $val = Validation::forge();
        $val->add_callable('Model_ValidCustom');

       //チェック定義
        $val->add('category_id', '')
            ->add_rule('last_category', $this->_save_data['uid'])
            ->add_rule('category_todo_setting', $this->_save_data['uid']);

       //実行
        if (!$val->run($this->_save_data))
        {
            $errors = $val->error();
            foreach ($errors as $error)
            {
                //先頭１個だけ返す
                $this->_message = $error;
                Log::error($error);

                break;
            }
            return false;
        }

        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        return true;
    }

    /**
     * データを保存する
     *
     * @param なし
     * @return なし
     */
    public function saveData ()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        //新規/更新判定フラグ
        $flag_new=false;
        if (!isset($this->_save_data['category_id']) || 
                      $this->_save_data['category_id']=="") $flag_new=true;

       //登録データ編集
        $work=array();
        $work['name']=$this->_save_data['name'];

        if (!isset($this->_save_data['sort_no']) ||
            $this->_save_data['sort_no']=="")
        {
            if ($flag_new)
            {
                $query = static::query();
                $max=$query->max('id');
                $work['sort_no']=$query->max('id')+1;
            }
        }

        $work['uid']=$this->_save_data['uid'];
        $work['delf']=$this->_save_data['delf'];

        if ($flag_new)
        {
            $category = static::forge($work);
        }
        else
        {
            $category = static::find($this->_save_data['category_id']);
        }

        $work['uid']=$this->_save_data['uid'];
        $work['delf']=$this->_save_data['delf'];

        if ($flag_new)
        {
            $category = static::forge($work);
        }
        else
        {
            $category = static::find($this->_save_data['category_id']);
            if(!isset($category))
            {
                $msg="category_idなし:".$this->_save_data['category_id'];
                Log::error($msg.":".__FILE__.":".__LINE__);
                throw new Exception($msg);
            }
            $work['sort_no']=$category['sort_no'];
            $category->set($work);
        }
        $category->save();
        Log::debug(DB::last_query());
        $this->_save_data['category_id']=$category->id;
        $this->_save_data['sort_no']=$category->sort_no;
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return true;
    }

    /**
     * データを並べ替える（ソートの入れ替え）
     *
     * @param  $from_category_id 対象のカテゴリID
     * @param  $move_action  up:上に移動 down:下に移動
     * @param  $uid ログインユーザID
     * @return なし
     */
    public static function sort ($from_category_id, $move_action, $uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        if ( $move_action == "up" )
        {
            $order_by='desc';
        }
        elseif ( $move_action == "down" )
        {
            $order_by='asc';
        }
        else
        {
            $msg="move action不正=$move_action";
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }

        $list = static::find('all', array(
            'where' => array( array('delf', 0),
                       array('uid', $uid),),
            'order_by' => array('sort_no' => $order_by),
        ));
        Log::debug(DB::last_query());

        $from_find_flag=false;
        $to_find_flag=false;
        foreach ( $list as $rec)
        {
            //フラグがONで最初のデータが入れ替え対象
            if ( $from_find_flag ) {
                $to_category_id=$rec->id;
                $to_sort_no=$rec->sort_no;
                Log::debug("to id=$to_category_id, sort=$to_sort_no");
                $to_find_flag=true;
                break;
            }
            //対象のカテゴリIDを見つけたらフラグをONにする
            if ( $rec->id== $from_category_id)
            {
                $from_sort_no=$rec->sort_no;
                Log::debug("from id=$from_category_id, sort=$from_sort_no");
                $from_find_flag=true;
            }
        }

        if (!$from_find_flag)
        {
            $msg="category_idなし=$from_category_id";
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }

        //対象が先頭/末尾なら並べ替え不要
        if (!$to_find_flag) return;

        //ソート番号入れ替え
        $category = static::find($from_category_id);
        $category->sort_no=$to_sort_no;
        $category->save();
        $category = static::find($to_category_id);
        $category->sort_no=$from_sort_no;
        $category->save();
        Log::debug("END ".__CLASS__.":".__FUNCTION__);

    }
}
