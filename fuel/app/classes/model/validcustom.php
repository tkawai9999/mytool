<?php
class Model_ValidCustom
{
    /**
     * datetime形式の型チェック
     * @param $val 対象のデータ
     * @return boolean true:正常 false:異常
     */
    public static function _validation_valid_datetime ($val) 
    {
        if ( trim($val)=="") return true;

        if (!strptime( $val, '%Y-%m-%d %H:%M:%S' ))
        {
            return false;
        }
        return true;
    }

    /**
     * カテゴリが２件以上あるかチェック
     * （カテゴリ削除用。削除後０にならないようチェック）
     * @param $val 対象のデータ
     * @param $uid ログインユーザのユーザID
     * @return boolean true:正常 false:異常
     */
    public static function _validation_last_category ($val, $uid)
    {
       $list=Model_Category::getListAll($uid);
        if ( count($list) <= 1)
        {
            return false;
        }
        return true;
    }

    /**
     * 当該カテゴリがTodoに設定されているかチェックする
     * （カテゴリ削除用）
     * @param $val 対象のデータ
     * @param $uid ログインユーザのユーザID
     * @return boolean true:正常 false:異常
     */
    public static function _validation_category_todo_setting ($val, $uid)
    {
       $list=Model_Todo::getCategoryCnt($uid);
        foreach ( $list as $rec)
        {
            if ($val==$rec['id'])
            {
                return false;
            }
        }
        return true;
    }
}
