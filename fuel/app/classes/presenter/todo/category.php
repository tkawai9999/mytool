<?php
class Presenter_Todo_Category extends Presenter
{
    /**
     * 画面表示
     *
     */
    public function view()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);

        //ログインID取得
        $login_user=Auth::get_user_id();
        $uid=$login_user[1];

       //カテゴリ一覧取得
        $this->categories =  Model_Category::getListAll($uid);

        Log::debug("END ".__CLASS__.":".__FUNCTION__);
    }
}
