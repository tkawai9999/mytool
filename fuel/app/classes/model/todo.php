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
		'repeat_flag',
		'repeat_unit_id',
		'repeat_interval',
		'repeat_end_date',
		'status_id',
		'category_id',
		'note',
		'sort_no',
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
     * @param なし
     * @return array ToDo一覧
     */
    public static function getListDuring()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $all = static::find('all', array(
            'where' => array( array('delf', 0),),
            'order_by' => array('end_date' => 'asc'),
        ));
        Log::debug(DB::last_query());
        $list=array();
        foreach ( $all as $rec)
        {
            $remain_day = Model_Util::getRemainDay($rec->end_date);
            if ( $rec->status_id==Config::get('define.statuses_id.during') )
            {
                array_push ( $list, $rec );
            }
            elseif($rec->status_id==Config::get('define.statuses_id.untreated') )
            {
                if ( $remain_day <> NULL && $remain_day <= 7)
                {
                    array_push ( $list, $rec );
                }  
            }
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }


    /**
     * ToDo一覧取得（未-期限あり）
     *
     * @param なし
     * @return array ToDo一覧
     */
    public static function getListUntreatDeadLineYes()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $all = static::find('all', array(
            'where' => array( array('delf', 0),
              array('status_id', Config::get('define.statuses_id.untreated')),),
            'order_by' => array('end_date' => 'asc'),
        ));
        Log::debug(DB::last_query());

        $list=array();
        foreach ( $all as $rec)
        {
            if ( $rec['end_date'] <> NULL ) array_push ( $list, $rec );
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

    /**
     * ToDo一覧取得（未-期限なし）
     *
     * @param なし
     * @return array ToDo一覧
     */
    public static function getListUntreatDeadLineNo()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $all = static::find('all', array(
            'where' => array( array('delf', 0),
              array('status_id', Config::get('define.statuses_id.untreated')),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug(DB::last_query());

        $list=array();
        foreach ( $all as $rec)
        {
            if ( $rec['end_date'] == NULL ) array_push ( $list, $rec );
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }

    /**
     * ToDo一覧取得（保留）
     *
     * @param なし
     * @return array ToDo一覧
     */
    public static function getListHold()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( array('delf', 0),
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
     * @param なし
     * @return array ToDo一覧
     */
    public static function getListFinished()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( array('delf', 0),
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
     * @param $category_id カテゴリID
     * @return array ToDo一覧
     */
    public static function getListCategory($category_id)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( array('delf', 0),
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
     * @param なし
     * @return array カテゴリ件数一覧
     */
    public static function getCategoryCnt()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        $all = static::find('all', array(
            'where' => array( array('delf', 0),),
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
     * @param $todo_id 対象のtodo_id
     * @param $status_id 対象のstatus_id
     * @return true:正常  false:異常
     */
    public static function updateStatus($todo_id, $status_id)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        //status_idチェック
        $status = Model_Status::find($status_id);
        if (count($status)==0 )
        {
            $msg="対象statusなし。status_id=$status_id";
            Log::error($msg);
            throw new Exception($msg);
        }

        //対象データ取得
        $todo = static::find($todo_id);
        if (count($todo)==0 )
        {
            $msg="対象データなし。todo_id=$todo_id";
            Log::error($msg);
            throw new Exception($msg);
        }

        //更新
        $todo['status_id'] = $status_id;
        $todo->save();
        Log::debug(DB::last_query());

        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return true;
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
        $work=array();

        $work['todo_id']='3';
        $work['name']='aaaa';
        $work['start_y']='2016';
        $work['start_m']='1';
        $work['start_d']='10';
        $work['start_h']='14';
        $work['start_mi']='30';
        $work['end_y']='';
        $work['end_m']='';
        $work['end_d']='';
        $work['end_h']='';
        $work['end_mi']='';
        $work['repeat_flag']=1;
        $work['repeat_interval']='3';
        $work['repeat_unit_id']='3';
        $work['status_id']=3;
        $work['category_id']=2;
        $work['note']='aaaaaa';
        
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
       return $work; 

    }
    /**
     * 登録データをセットする
     *
     * @param $data 登録対象のデータ
     * @return なし
     */
    public function setData($data)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $this->_save_data=$data;
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
     * @param $data 登録対象のデータ
     * @return boolean true:正常 false:異常
     */
    public function validData ()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $this->_message='aaa';

        Log::debug("END ".__CLASS__.":".__FUNCTION__);
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
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return true;
    }


    /**
     * データを削除する
     *
     * @param $id 削除対象のid
     * @return true:正常  false:異常
     */
    public static function deleteData($id)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return true;
    }

}
