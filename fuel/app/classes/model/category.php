<?php

class Model_Category extends \Orm\Model
{
    private $_save_data;
    private $_message;

    protected static $_properties = array(
		'id',
		'name',
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
     * @param なし
     * @return array カテゴリ一覧
     */
    public static function getListAll()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        $list = static::find('all', array(
            'where' => array( array('delf', 0),),
            'order_by' => array('sort_no' => 'asc'),
        ));
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
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
