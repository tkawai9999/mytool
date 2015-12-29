<?php
class Presenter_Todo_Form extends Presenter
{
    /**
     * 画面表示
     *
     */
    public function view()
    {
        Log::debug("START ".__CLASS__.":".__FUNCTION__);
        //Todoデータ
        if ( !isset($this->_view->id) || $this->_view->id=="" )
        {
            $work=array();
            $work['todo_id']='';
            $work['name']= (!isset($this->_view->name)) 
                            ?'':$this->_view->name;
            $work['start_y']= (!isset($this->_view->start_y)) 
                            ?'':$this->_view->start_y;
            $work['start_m']= (!isset($this->_view->start_m)) 
                            ?'':$this->_view->start_m;
            $work['start_d']= (!isset($this->_view->start_d)) 
                            ?'':$this->_view->start_d;
            $work['start_h']= (!isset($this->_view->start_h)) 
                            ?'':$this->_view->start_h;
            $work['start_mi']= (!isset($this->_view->start_mi)) 
                            ?'':$this->_view->start_mi;
            $work['end_y']= (!isset($this->_view->end_y)) 
                            ?'':$this->_view->end_y;
            $work['end_m']= (!isset($this->_view->end_m)) 
                            ?'':$this->_view->end_m;
            $work['end_d']= (!isset($this->_view->end_d)) 
                            ?'':$this->_view->end_d;
            $work['end_h']= (!isset($this->_view->end_h)) 
                            ?'':$this->_view->end_h;
            $work['end_mi']= (!isset($this->_view->end_mi)) 
                            ?'':$this->_view->end_mi;
            $work['repeat_flag']= (!isset($this->_view->repeat_flag)) 
                            ?'0':$this->_view->repeat_flag;
            $work['repeat_unit_id']= (!isset($this->_view->repeat_unit_id)) 
                            ?'1':$this->_view->repeat_unit_id;
            $work['repeat_interval']= (!isset($this->_view->repeat_interval)) 
                            ?'':$this->_view->repeat_interval;
            $work['status_id']= (!isset($this->_view->status_id)) 
                            ?'':$this->_view->status_id;
            $work['category_id']= (!isset($this->_view->category_id)) 
                            ?'':$this->_view->category_id;
            $work['note']= (!isset($this->_view->note)) 
                            ?'':$this->_view->note;
            $this->todo = $work;
        }
        else
        {
            $this->todo = Model_Todo::getPk($this->_view->id);
        }

        //ステータス一覧取得
        $this->statuses =  Model_Status::getListAll();
        //繰り返し一覧取得
        $this->repetunits =  Model_Repetunit::getListAll();
        //カテゴリ一覧取得
        $this->categories =  Model_Category::getListAll();

        Log::debug("END ".__CLASS__.":".__FUNCTION__);
    }

}
