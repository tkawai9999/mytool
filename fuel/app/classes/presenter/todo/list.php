<?php
class Presenter_Todo_List extends Presenter
{
    /**
     * 画面表示
     *
     */
    public function view()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        $this->page_name =  "";

        //ログインID取得
        $login_user=Auth::get_user_id();
        $uid=$login_user[1];

        //バッチ情報
        $this->cnt_during = count(Model_Todo::getListDuring($uid));
        $this->cnt_untreat1 = 
            count(Model_Todo::getListUntreatDeadLineYes($uid));
        $this->cnt_untreat2 = 
            count(Model_Todo::getListUntreatDeadLineNo($uid));
        $this->cnt_hold = count(Model_Todo::getListHold($uid));

        //カテゴリ一覧取得
        $active_categroy_id="";
        if(isset($this->_view->category_id)) 
                $active_categroy_id=$this->_view->category_id;
        $this->categories = $this->_getCategoryList($active_categroy_id, $uid);

        //ステータス一覧取得
        $this->statuses =  Model_Status::getListAll();

        //Todo一覧編集(残り日数追加)
        $list=array();
        foreach( $this->_view->todos as $rec)
        {
            if ( $rec['end_date_real'] <>"" )
            {
                $rec['remain_day']= Model_Util::getRemainDay($rec['end_date_real']);
            }
            array_push($list, $rec);
        }
        $this->todos = $list;



        Log::debug("END ".__CLASS__.":".__FUNCTION__);
    }

    /**
     * Side表示用のカテゴリ一覧取得
     *
     * @param  int $active_categroy_id 選択されたカテゴリID
     * @param  int $uid ログインユーザID
     * @return array カテゴリ一覧
     */
    private function _getCategoryList($active_categroy_id, $uid)
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        //カテゴリ一覧取得
        $category_info = Model_Category::getListAll($uid);
        //Todoに設定されたカテゴリ情報取得
        $todo_category_cnt = Model_Todo::getCategoryCnt($uid);
        //カテゴリ一覧編集
        $list=array();
        foreach ( $category_info as $rec )
        {
            $buf=array();
            $buf['id']=$rec->id;
            $buf['name']=$rec->name;
            $buf['cnt']=0;
            foreach ( $todo_category_cnt as $rec_cnt )
            {
                if ($buf['id']==$rec_cnt['id'])
                {
                    $buf['cnt']=$rec_cnt['cnt'];
                    break;
                }
            }
            $buf['active']=false;
            if ($active_categroy_id==$buf['id']) 
            {
                $this->page_name =  "カテゴリ：".$buf['name'];
                $buf['active']=true;
            }
            array_push ( $list,$buf);
        }
        Log::debug("END ".__CLASS__.":".__FUNCTION__);
        return $list;
    }
}
