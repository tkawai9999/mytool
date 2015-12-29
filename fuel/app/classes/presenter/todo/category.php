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

       //カテゴリ一覧取得
        $this->categories =  Model_Category::getListAll();

        Log::debug("END ".__CLASS__.":".__FUNCTION__);
    }
}
