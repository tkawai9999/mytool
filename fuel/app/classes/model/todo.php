<?php

class Model_Todo extends \Orm\Model
{
    private $_save_data;
    private $_message;
	protected static $_properties = array(
		'id',
		'name',
		'start_date',
		'end_date',
		'end_date_real',
		'repeat_flag',
		'repeat_unit_id',
		'repeat_interval',
		'status_id',
		'category_id',
		'note',
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

	protected static $_table_name = 'todos';
    protected static $_belongs_to  = array(
        'category' => array(
            'key_from' => 'category_id',
            'model_to' => 'Model_Category',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
        'status' => array(
            'key_from' => 'status_id',
            'model_to' => 'Model_Status',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
        'repeat_unit' => array(
            'key_from' => 'repeat_unit_id',
            'model_to' => 'Model_Repetunit',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );

    /**
     * ToDo一覧取得（対応中）
     *
     * @param $uid ログインユーザID
     * @return array ToDo一覧
     */
    public static function getListDuring($uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $all = static::find('all', array(
            'where' => array( array('delf', 0),
              array('uid', $uid), ),
            'order_by' => array('end_date' => 'asc'),
        ));
        Log::debug(DB::last_query());
        $list=array();
        foreach ( $all as $rec)
        {
            if ( $rec->status_id==Config::get('define.statuses_id.during') )
            {
                array_push ( $list, $rec );
            }
            elseif($rec->status_id==Config::get('define.statuses_id.untreated') )
            {
                if ( $rec->end_date_real <> NULL )
                {
                    $remain_day = Model_Util::getRemainDay($rec->end_date_real);
                    if ( $remain_day <=7) array_push ( $list, $rec );
                }
            }
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }


    /**
     * ToDo一覧取得（未-期限あり）
     *
     * @param $uid ログインユーザID
     * @return array ToDo一覧
     */
    public static function getListUntreatDeadLineYes($uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $all = static::find('all', array(
            'where' => array( array('delf', 0),
              array('uid', $uid), 
              array('status_id', Config::get('define.statuses_id.untreated')),),
            'order_by' => array('end_date' => 'asc'),
        ));
        Log::debug(DB::last_query());

        $list=array();
        foreach ( $all as $rec)
        {
            if ( $rec['end_date_real'] <> NULL ) 
            {
                $remain_day = Model_Util::getRemainDay($rec->end_date_real);
                if ( $remain_day >7) array_push ( $list, $rec );
            }
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

    /**
     * ToDo一覧取得（未-期限なし）
     *
     * @param $uid ログインユーザID
     * @return array ToDo一覧
     */
    public static function getListUntreatDeadLineNo($uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $all = static::find('all', array(
            'where' => array( array('delf', 0),
              array('uid', $uid), 
              array('status_id', Config::get('define.statuses_id.untreated')),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug(DB::last_query());

        $list=array();
        foreach ( $all as $rec)
        {
            if ( $rec['end_date_real'] == NULL ) array_push ( $list, $rec );
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

    /**
     * ToDo一覧取得（保留）
     *
     * @param $uid ログインユーザID
     * @return array ToDo一覧
     */
    public static function getListHold($uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( array('delf', 0),
              array('uid', $uid), 
              array('status_id', Config::get('define.statuses_id.hold')),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug(DB::last_query());
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

    /**
     * ToDo一覧取得（完了）
     *
     * @param $uid ログインユーザID
     * @return array ToDo一覧
     */
    public static function getListFinished($uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( array('delf', 0),
              array('uid', $uid), 
              array('status_id', Config::get('define.statuses_id.finished')),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug(DB::last_query());
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

   /**
     * ToDo一覧取得（カテゴリ）
     *
     * @param $uid ログインユーザID
     * @param $category_id カテゴリID
     * @return array ToDo一覧
     */
    public static function getListCategory($category_id,$uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( 
              array('delf', 0),
              array('uid', $uid), 
              array('category_id', $category_id),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug(DB::last_query());
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

    /**
     * Todo設定済のカテゴリ件数を取得
     *
     * @param $uid ログインユーザID
     * @return array カテゴリ件数一覧
     */
    public static function getCategoryCnt($uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        $all = static::find('all', array(
            'where' => array( array('delf', 0),
              array('uid', $uid),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug(DB::last_query());

        $list=array();
        foreach ( $all as $rec)
        {
            $buf=array();
            $buf['id']=$rec->category->id;
            $buf['cnt']=1;

            $flag=false;
            for( $intCnt=0; $intCnt<count($list) ; $intCnt++ )
            {
                if ($list[$intCnt]['id'] == $buf['id'] ) 
                {
                    $list[$intCnt]['cnt']++;
                    $flag=true;
                    break;
                }
            }
            if (!$flag) array_push ( $list,$buf);
        }

        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

    /**
     * ステータスを変更する
     *
     * @param $id 対象のtodo_id
     * @return array todoレコード
     */
    public static function getPk($id)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        
        $info = static::find($id);
        if ( count($info)== 0 ) return array();

        $work=array();
        $work['todo_id']=$info['id'];
        $work['name']=$info['name'];
        $work['start_date']=$info['start_date'];
        if ($work['start_date']=="")
        {
            $work['start_y']='';
            $work['start_m']='';
            $work['start_d']='';
            $work['start_h']='';
            $work['start_mi']='';
        }
        else
        {
            $date_work = new DateTime($info['start_date']);
            $work['start_y']=$date_work->format('Y');
            $work['start_m']=$date_work->format('m');
            $work['start_d']=$date_work->format('d');
            $work['start_h']=$date_work->format('H');
            $work['start_mi']=$date_work->format('i');
        }
        $work['end_date']=$info['end_date'];
        if ($work['end_date']=="")
        {
            $work['end_y']='';
            $work['end_m']='';
            $work['end_d']='';
            $work['end_h']='';
            $work['end_mi']='';
        }
        else
        {
            $date_work = new DateTime($info['end_date']);
            $work['end_y']=$date_work->format('Y');
            $work['end_m']=$date_work->format('m');
            $work['end_d']=$date_work->format('d');
            $work['end_h']=$date_work->format('H');
            $work['end_mi']=$date_work->format('i');
        }

        $work['end_date_real']=$info['end_date_real'];
        $work['repeat_flag']= $info['repeat_flag'];
        $work['repeat_interval']=$info['repeat_interval'];
        $work['repeat_unit_id']=$info['repeat_unit_id'];
        $work['status_id']=$info['status_id'];
        $work['category_id']=$info['category_id'];
        $work['sort_no']=$info['sort_no'];
        $work['note']=$info['note'];
        
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
       return $work; 

    }
    /**
     * 登録データをセットする
     *
     * @param $data 登録対象のデータ
     * @param $uid  ログインユーザID
     * @return なし
     */
    public function setData($data, $uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $this->_save_data=$data;

        //ユーザID
        $this->_save_data['uid']=$uid;

        //開始日、終了日の設定
        $this->_save_data['start_date']="";
        if ($this->_save_data['start_y']<>"")
        {
            $this->_save_data['start_date']=
                sprintf("%4d-%02d-%02d %02d:%02d:00",
                    $this->_save_data['start_y'],
                    $this->_save_data['start_m'],
                    $this->_save_data['start_d'],
                    $this->_save_data['start_h'],
                    $this->_save_data['start_mi']);
        }

        $this->_save_data['end_date']="";
        if ($this->_save_data['end_y']<>"")
        {
            $this->_save_data['end_date']=
                sprintf("%4d-%02d-%02d %02d:%02d:00",
                    $this->_save_data['end_y'],
                    $this->_save_data['end_m'],
                    $this->_save_data['end_d'],
                    $this->_save_data['end_h'],
                    $this->_save_data['end_mi']);
        }

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
     * 登録データをチェックする
     *
     * @param $なし
     * @return boolean true:正常 false:異常
     */
    public function validData ()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        $val = Validation::forge();
        $val->add_callable('Model_ValidCustom');

        //チェック定義&例外エラー対応
        $val->add('name', 'タスク')
            ->add_rule('required')
            ->add_rule('max_length',255);
        $val->add('start_date', '開始')
            ->add_rule('valid_datetime');
        $val->add('end_date', '終了')
            ->add_rule('valid_datetime');

        if ( $this->_save_data['repeat_flag'] =='1')
        {
            $val->add('repeat_interval', '繰り返し間隔')
                ->add_rule('required')
                ->add_rule('valid_string','numeric');

            if ( $this->_save_data['repeat_unit_id'] =='' ||
                  !is_numeric( $this->_save_data['repeat_unit_id']))
            {
                $msg="repeat_unit_id不正=".$this->_save_data['repeat_unit_id'];
                Log::error($msg.":".__FILE__.":".__LINE__);
                throw new Exception($msg);
            }
        }

        if ( $this->_save_data['status_id'] =='' ||
              !is_numeric( $this->_save_data['status_id']))
        {
            $msg="status_id不正=".$this->_save_data['status_id'];
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        }
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

        //実行
        if (!$val->run($this->_save_data))
        {
            $errors = $val->error();
            foreach ($errors as $error)
            {
                //先頭１個だけ返す
                $this->_message = trim($error);
                Log::error($error);

                break;
            }
            return false;
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return true;
    }
    /**
     * データを保存する
     *
     * @param なし
     * @return なし
     */
    public function saveData()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        //終了日（直近）の設定
        if ( $this->_save_data['repeat_flag'] == 
                Config::get('define.repeat_flag.yes') ) 
        {
            $this->_getNextEndDateReal();
        }
        else
        {
            $this->_save_data['end_date_real']=$this->_save_data['end_date'];
        }

        //登録データ編集
        $work=array();
        $work['name']=$this->_save_data['name'];
        $work['start_date']=NULL;
        if ( $this->_save_data['start_date'] <> "")
            $work['start_date'] = $this->_save_data['start_date'];
        $work['end_date']=NULL;
        if ( $this->_save_data['end_date'] <> "")
            $work['end_date'] = $this->_save_data['end_date'];
        $work['end_date_real']=NULL;
        if ( $this->_save_data['end_date_real'] <> "")
            $work['end_date_real'] = $this->_save_data['end_date_real'];
        $work['repeat_flag']=0;
        if ($this->_save_data['repeat_flag']<>"")
            $work['repeat_flag']= $this->_save_data['repeat_flag'];
        $work['repeat_interval']=NULL;
        if ($this->_save_data['repeat_interval']<>"")
            $work['repeat_interval']=$this->_save_data['repeat_interval'];
        $work['repeat_unit_id']=NULL;
        if ($this->_save_data['repeat_unit_id']<>"")
            $work['repeat_unit_id']=$this->_save_data['repeat_unit_id'];
        $work['status_id']=$this->_save_data['status_id'];
        $work['category_id']=$this->_save_data['category_id'];
        $work['note']=$this->_save_data['note'];
        $work['uid']=$this->_save_data['uid'];
        if (!isset($this->_save_data['sort_no']) || 
            $this->_save_data['sort_no']=="")
        {
            $query = static::query();
            $max=$query->max('id');
            $work['sort_no']=$query->max('id')+1;
            $this->_save_data['sort_no']=$work['sort_no'];
        }
        $work['delf']=0;

 
        if (!isset($this->_save_data['todo_id']) || $this->_save_data['todo_id']=="")
        {
            //新規
            $todo = static::forge($work);
        }
        else
        {
            //更新
            $todo = static::find($this->_save_data['todo_id']);
            if(!isset($todo))
            {
                $msg="todo_idなし:".$this->_save_data['todo_id'];
                Log::error($msg.":".__FILE__.":".__LINE__);
                throw new Exception($msg);
            } 
            $todo->set($work);
        }
        $todo->save();
        $this->_save_data['todo_id']=$todo->id;

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
     * データを削除する
     *
     * @param $id 削除対象のid
     * @param $uid ログインユーザID (当面未使用。論理削除の場合）
     * @return true:正常  false:異常
     */
    public static function deleteData($id, $uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $todo = static::find($id);
        if(!isset($todo))
        {
            $msg="todo_idなし:".$id;
            Log::error($msg.":".__FILE__.":".__LINE__);
            throw new Exception($msg);
        } 
        $todo->delete();
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return true;
    }


    /**
     * 指定したtodo_idが表示されるべきリストのアクションを取得する
     *
     * @param $id 対象のid
     * @return string todo一覧のアクション
     */
    public static function getTodoListKind($id)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        $info=static::getPk($id);
        if (count($info)==0 )
        {
            $msg="対象データなし。todo_id=$id";
            Log::error($msg);
            throw new Exception($msg);
        }
               
        switch ($info['status_id'])
        {
            case Config::get('define.statuses_id.during'):
                $action = "during";
                break;
            case Config::get('define.statuses_id.untreated'):
                $remain_day = Model_Util::getRemainDay($info['end_date_real']);
                if ( $info['end_date_real'] == NULL )
                {
                    $action = "untreat2";
                }  
                elseif ( $remain_day <= 7)
                {
                    $action = "during";
                }  
                else
                {
                    $action = "untreat1";
                }  
                break;
            case Config::get('define.statuses_id.hold'):
                $action = "hold";
                break;
            case Config::get('define.statuses_id.finished'):
                $action = "finished";
                break;
            default:
                $msg="対象statusなし。status_id=".$info['status_id'];
                Log::error($msg.":".__FILE__.":".__LINE__);
                throw new Exception($msg);
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $action;
    }


    /**
     * 次の直近終了日を設定する(繰り返し設定のみ）
     *
     * @param $id 削除対象のid
     * @return true:正常  false:異常
     */
    private function _getNextEndDateReal()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        if (!isset($this->_save_data['end_date_real'])
                    || $this->_save_data['end_date_real']=="")
        {
            //最初の設定（デフォルト値を設定）
            if ($this->_save_data['start_date'] =="")
            {
                $this->_save_data['end_date_real'] = date('Y-m-d H:i:00');
            }
            else
            {
                $this->_save_data['end_date_real'] = 
                    $this->_save_data['start_date'] ;
            }
        } 
        else
        {
            //直近終了日設定済なら完了に更新した場合のみ設定
            if ( $this->_save_data['status_id'] ==
                     Config::get('define.statuses_id.finished'))
            {
                $end_date_real=$this->_save_data['end_date_real'];
                $ival=$this->_save_data['repeat_interval'];
//下記は変更予定＊＊＊＊＊＊＊＊＊＊＊＊
                switch ($this->_save_data['repeat_unit_id'])
                {
                    case '1':
                        $unit="day";
                        break;
                    case '2':
                        $unit="week";
                        break;
                    case '3':
                        $unit="month";
                        break;
                    case '4':
                        $unit="year";
                        break;
                }
                $end_date_real = date('Y-m-d H:i:00', 
                        strtotime("$end_date_real +$ival $unit"));
                if ( $this->_save_data['end_date'] =="" ||
                     $end_date_real <= $this->_save_data['end_date'])
                {
                    $this->_save_data['status_id'] = 
                        Config::get('define.statuses_id.untreated');
                    $this->_save_data['end_date_real']= $end_date_real;
                } 
            }
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
    }
}
