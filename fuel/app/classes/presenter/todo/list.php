<?php
class Presenter_Todo_List extends Presenter
{

    /**
     * 画面表示
     *
     */
    public function view()
    {
        //バッチ情報
        $this->cnt_during = count(Model_Todo::getListDuring());
        $this->cnt_untreat1 = count(Model_Todo::getListUntreatDeadLineYes());
        $this->cnt_untreat2 = count(Model_Todo::getListUntreatDeadLineNo());
        $this->cnt_hold = count(Model_Todo::getListHold());

        //カテゴリ一覧取得
        $active_categroy_id="";
        if(isset($this->_view->category_id)) 
                $active_categroy_id=$this->_view->category_id;
        $this->categories = $this->_getCategoryList($active_categroy_id);

        //ステータス一覧取得
        $this->statuses =  Model_Status::getListAll();
    }

    /**
     * Side表示用のカテゴリ一覧取得
     *
     * @param  int $active_categroy_id 選択されたカテゴリID
     * @return array カテゴリ一覧
     */
    private function _getCategoryList($active_categroy_id)
    {
        //カテゴリ一覧取得
        $category_info = Model_Category::getListAll();
        //Todoに設定されたカテゴリ情報取得
        $todo_category_cnt = Model_Todo::getCategoryCnt();
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
            if ($active_categroy_id==$buf['id']) $buf['active']=true;

            array_push ( $list,$buf);
        }
        return $list;
    }
}
