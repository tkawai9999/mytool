<?php
/**
 * Model Todo Test
 * 
 * @group All
 * @group Todo
 */
class Test_Model_Todo extends \TestCase
{
    private $_entry_data=array(
        'name'=>'entry',
        'start_y'=>'',
        'start_m'=>'',
        'start_d'=>'',
        'start_h'=>'',
        'start_mi'=>'',
        'end_y'=>'',
        'end_m'=>'',
        'end_d'=>'',
        'end_h'=>'',
        'end_mi'=>'',
        'repeat_flag'=>'',
        'repeat_interval'=>'',
        'repeat_unit_id'=>'',
        'status_id'=>'1',
        'category_id'=>'2',
        'note'=>'entry',
    );

    /**
     * 準備
     * @beforeClass
     */
    public static function initTest()
    {
        Config::load('define',true);
        Model_Util::execSqlFile(APPPATH."tests/sql/todo.sql");
        Model_Util::execSqlFile(APPPATH."tests/sql/category.sql");
    }
    /**
     * @afterClass
     */
    public static function endTest()
    {
        //echo "end";
    }

    /**
     * 正常：対応中
     * @test
     */
    public function getListDuring_ok1(){
        $list=Model_Todo::getListDuring();
        $this->assertCount(4, $list);
    }
    /**
     * 正常：未-期限有り
     * @test
     */
    public function getListUntreatDeadLineYes_ok1(){
        $list=Model_Todo::getListUntreatDeadLineYes();
        $this->assertCount(5, $list);
    }
    /**
     * 正常：未-期限無し
     * @test
     */
    public function getListUntreatDeadLineNo_ok1(){
        $list=Model_Todo::getListUntreatDeadLineNo();
        $this->assertCount(2, $list);
    }
    /**
     * 正常：保留
     * @test
     */
    public function getListHold_ok1(){
        $list=Model_Todo::getListHold();
        $this->assertCount(1, $list);
    }

    /**
     * 正常：完了
     * @test
     */
    public function getListFinished_ok1(){
        $list=Model_Todo::getListFinished();
        $this->assertCount(1, $list);
    }


    /**
     * 正常：カテゴリ取得1
     * @test
     */
    public function getListCategory_ok1(){
        $list=Model_Todo::getListCategory(1);
        $this->assertCount(4, $list);
    }
    /**
     * 正常：カテゴリ取得2
     * @test
     */
    public function getListCategory_ok2(){
        $list=Model_Todo::getListCategory(3);
        $this->assertCount(2, $list);
    }
    /**
     * 正常：カテゴリ取得(データなし）
     * @test
     */
    public function getListCategory_ok3(){
        $list=Model_Todo::getListCategory(9);
        $this->assertCount(0, $list);
    }

    /**
     * 正常：カテゴリ件数取得
     * @test
     */
    public function getCategoryCnt_ok1(){
        $list=Model_Todo::getCategoryCnt();
        foreach ( $list as $rec)
        {
            if ( $rec['id']==1) $this->assertEquals($rec['cnt'], 4);
            if ( $rec['id']==2) $this->assertEquals($rec['cnt'], 5);
            if ( $rec['id']==3) $this->assertEquals($rec['cnt'], 2);
        }
    }

    /**
     * 正常：ステータス更新
     * @test
     */
    public function updateStatus_ok1(){
        $todo_id=1;
        $status_id=2;
        $rc=Model_Todo::updateStatus($todo_id,$status_id);
        $this->assertTrue($rc);
        $info=Model_Todo::find($todo_id);
        $this->assertEquals($info['status_id'], $status_id);

        $status_id=3;
        $rc=Model_Todo::updateStatus($todo_id,$status_id);
        $this->assertTrue($rc);
        $info=Model_Todo::find($todo_id);
        $this->assertEquals($info['status_id'], $status_id);

    }

    /**
     * 異常：対象のtodo_idなし
     * @test
     * @expectedException Exception
     */
    public function updateStatus_ng1(){
        $todo_id=10000;
        $status_id=1;
        $rc=Model_Todo::updateStatus($todo_id,$status_id);
    }
    /**
     * 異常：ステータスid不正
     * @test
     * @expectedException Exception
     */
    public function updateStatus_ng2(){
        $todo_id=1;
        $status_id='a';
        $rc=Model_Todo::updateStatus($todo_id,$status_id);
    }


    /**
     * 正常：Todoレコード取得(全項目設定データ）
     * @test
     */
    public function getPk_ok1(){
        $id=12;

        $result=Model_Todo::getPk($id);
        $this->assertEquals($result['name'],'task_pk1');
        $this->assertEquals($result['start_date'],'2016-01-12 09:50:00');
        $this->assertEquals($result['start_y'],'2016');
        $this->assertEquals($result['start_m'],'01');
        $this->assertEquals($result['start_d'],'12');
        $this->assertEquals($result['start_h'],'09');
        $this->assertEquals($result['start_mi'],'50');
        $this->assertEquals($result['end_date'],'2016-06-11 23:59:00');
        $this->assertEquals($result['end_y'],'2016');
        $this->assertEquals($result['end_m'],'06');
        $this->assertEquals($result['end_d'],'11');
        $this->assertEquals($result['end_h'],'23');
        $this->assertEquals($result['end_mi'],'59');
        $this->assertEquals($result['end_date_real'],'2016-01-19 09:50:00');
        $this->assertEquals($result['repeat_flag'],'1');
        $this->assertEquals($result['repeat_unit_id'],'2');
        $this->assertEquals($result['repeat_interval'],'1');
        $this->assertEquals($result['status_id'],'1');
        $this->assertEquals($result['category_id'],'2');
        $this->assertEquals($result['note'],'pk');
 
    }

    /**
     * 正常：Todoレコード取得(必須のみ設定）
     * @test
     */
    public function getPk_ok2(){
        $id=13;

        $result=Model_Todo::getPk($id);
        $this->assertEquals($result['name'],'task_pk2');
        $this->assertEquals($result['start_date'],'');
        $this->assertEquals($result['start_y'],'');
        $this->assertEquals($result['start_m'],'');
        $this->assertEquals($result['start_d'],'');
        $this->assertEquals($result['start_h'],'');
        $this->assertEquals($result['start_mi'],'');
        $this->assertEquals($result['end_date'],'');
        $this->assertEquals($result['end_y'],'');
        $this->assertEquals($result['end_m'],'');
        $this->assertEquals($result['end_d'],'');
        $this->assertEquals($result['end_h'],'');
        $this->assertEquals($result['end_mi'],'');
        $this->assertEquals($result['end_date_real'],'');
        $this->assertEquals($result['repeat_flag'],'0');
        $this->assertEquals($result['repeat_unit_id'],'');
        $this->assertEquals($result['repeat_interval'],'');
        $this->assertEquals($result['status_id'],'1');
        $this->assertEquals($result['category_id'],'2');
        $this->assertEquals($result['note'],'pk');
    }
    /**
     * 正常：Todoレコードなし
     * @test
     */
    public function getPk_ok3(){
        $id=99999;
        $result=Model_Todo::getPk($id);
        $this->assertCount(0,$result);

    }
    /**
     * 正常：新規登録（必須項目の保存）
     * @test
     */
    public function saveData_ok1(){
        $todo = new Model_Todo();
        $todo->setData($this->_entry_data);
        $todo->saveData();
        
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $result=Model_Todo::getPk($data['todo_id']);

        $this->assertEquals($result['name'],$this->_entry_data['name']);
        $this->assertEquals($result['status_id'],$this->_entry_data['status_id']);
        $this->assertEquals($result['category_id'],$this->_entry_data['category_id']);
        $this->assertEquals($result['note'],$this->_entry_data['note']);

    }

    /**
     * 正常：ノーマル(開始日、終了日）
     * @test
     */
    public function saveData_ok2(){
        $work=$this->_entry_data;
        $work['start_y'] = '2016';
        $work['start_m'] = '01';
        $work['start_d'] = '05';
        $work['start_h'] = '10';
        $work['start_mi'] = '00';
        $work['end_y'] = '2016';
        $work['end_m'] = '12';
        $work['end_d'] = '31';
        $work['end_h'] = '23';
        $work['end_mi'] = '59';
//        $work['end_date_real'] = '2016/12/31 23:59:00';

        $todo = new Model_Todo();
        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $result=Model_Todo::getPk($data['todo_id']);

        $this->assertEquals($result['start_y'],$work['start_y']);
        $this->assertEquals($result['start_m'],$work['start_m']);
        $this->assertEquals($result['start_d'],$work['start_d']);
        $this->assertEquals($result['start_h'],$work['start_h']);
        $this->assertEquals($result['start_mi'],$work['start_mi']);
        $this->assertEquals($result['start_date'],"2016-01-05 10:00:00");
        $this->assertEquals($result['end_y'],$work['end_y']);
        $this->assertEquals($result['end_m'],$work['end_m']);
        $this->assertEquals($result['end_d'],$work['end_d']);
        $this->assertEquals($result['end_h'],$work['end_h']);
        $this->assertEquals($result['end_mi'],$work['end_mi']);
        $this->assertEquals($result['end_date'],"2016-12-31 23:59:00");
        $this->assertEquals($result['end_date_real'],"2016-12-31 23:59:00");

    }

    /**
     * 正常：ノーマル(繰り返し保存：開始日設定）
     * @test
     */
    public function saveData_ok3(){
        $work=$this->_entry_data;
        $work['start_y'] = '2016';
        $work['start_m'] = '1';
        $work['start_d'] = '5';
        $work['start_h'] = '10';
        $work['start_mi'] = '0';
        $work['repeat_flag'] = '1';
        $work['repeat_interval'] = '1';
        $work['repeat_unit_id'] = '2';
        $work['status_id'] = '2';

        $todo = new Model_Todo();
        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $result=Model_Todo::getPk($data['todo_id']);

        $this->assertEquals($result['repeat_flag'],$work['repeat_flag']);
        $this->assertEquals($result['repeat_interval'],$work['repeat_interval']);
        $this->assertEquals($result['repeat_unit_id'],$work['repeat_unit_id']);

        $this->assertEquals($result['status_id'],$work['status_id']);
        $this->assertEquals($result['end_date_real'],$result['start_date']);

    }


    /**
     * 正常：ノーマル(繰り返し保存：開始日未設定）
     * @test
     */
    public function saveData_ok4(){
        $work=$this->_entry_data;
        $work['repeat_flag'] = '1';
        $work['repeat_interval'] = '2';
        $work['repeat_unit_id'] = '3';
        $work['status_id'] = '1';

        $todo = new Model_Todo();
        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $result=Model_Todo::getPk($data['todo_id']);

        $this->assertEquals($result['end_date_real'],date('Y-m-d H:i:00'));
    }

   /**
     * 正常：更新（全項目更新）
     * @test
     */
    public function saveData_ok5(){
        $todo = new Model_Todo();
        $work=$this->_entry_data;
        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);

        $data['name']='entry2';
        $data['start_y']='2016';
        $data['start_m']='5';
        $data['start_d']='23';
        $data['start_h']='22';
        $data['start_mi']='15';
        $data['end_y']='2017';
        $data['end_m']='12';
        $data['end_d']='3';
        $data['end_h']='4';
        $data['end_mi']='20';
        $data['repeat_flag']='1';
        $data['repeat_interval']='6';
        $data['repeat_unit_id']='3';
        $data['status_id']='3';
        $data['category_id']='3';
        $data['note']='entry2';
        $todo->setData($data);
        $todo->saveData();
        $data=$todo->getData();
        $result=Model_Todo::getPk($data['todo_id']);
        $this->assertEquals($result['name'],$data['name']);
        $this->assertEquals($result['start_y'],$data['start_y']);
        $this->assertEquals($result['start_m'],$data['start_m']);
        $this->assertEquals($result['start_d'],$data['start_d']);
        $this->assertEquals($result['start_h'],$data['start_h']);
        $this->assertEquals($result['start_mi'],$data['start_mi']);
        $this->assertEquals($result['end_y'],$data['end_y']);
        $this->assertEquals($result['end_m'],$data['end_m']);
        $this->assertEquals($result['end_d'],$data['end_d']);
        $this->assertEquals($result['end_h'],$data['end_h']);
        $this->assertEquals($result['end_mi'],$data['end_mi']);
        $this->assertEquals($result['repeat_flag'],$data['repeat_flag']);
        $this->assertEquals($result['repeat_interval'],$data['repeat_interval']);
        $this->assertEquals($result['repeat_unit_id'],$data['repeat_unit_id']);
        $this->assertEquals($result['status_id'],$data['status_id']);
        $this->assertEquals($result['category_id'],$data['category_id']);
        $this->assertEquals($result['note'],$data['note']);
        $this->assertEquals($result['start_date'],'2016-05-23 22:15:00');
        $this->assertEquals($result['end_date'],'2017-12-03 04:20:00');
        $this->assertEquals($result['end_date_real'],'2016-05-23 22:15:00');

    }

    /**
     * 正常：更新（繰り返し保存：3日単位の更新）
     * @test
     */
    public function saveData_ok6(){
        $todo = new Model_Todo();
        $work=$this->_entry_data;
        $work['start_y']='2016';
        $work['start_m']='1';
        $work['start_d']='3';
        $work['start_h']='10';
        $work['start_mi']='00';
        $work['repeat_flag']='1';
        $work['repeat_interval']='3';
        $work['repeat_unit_id']='1';
        $work['status_id']='2';

        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $this->assertEquals($data['end_date_real'],'2016-01-03 10:00:00');

        $data['status_id']='4';
        $todo->setData($data);
        $todo->saveData();
        $data=$todo->getData();
        $result=Model_Todo::getPk($data['todo_id']);
        $this->assertEquals($result['end_date_real'],'2016-01-06 10:00:00');
        $this->assertEquals($result['status_id'],'1');
    }

    /**
     正常：更新（繰り返し保存：１週単位の更新）
     * @test
     */
    public function saveData_ok7(){
        $todo = new Model_Todo();
        $work=$this->_entry_data;
        $work['start_y']='2016';
        $work['start_m']='1';
        $work['start_d']='3';
        $work['start_h']='10';
        $work['start_mi']='00';
        $work['repeat_flag']='1';
        $work['repeat_interval']='1';
        $work['repeat_unit_id']='2';
        $work['status_id']='1';

        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $this->assertEquals($data['end_date_real'],'2016-01-03 10:00:00');

        $data['status_id']='4';
        $todo->setData($data);
        $todo->saveData();
        $data=$todo->getData();
        $result=Model_Todo::getPk($data['todo_id']);
        $this->assertEquals($result['end_date_real'],'2016-01-10 10:00:00');
        $this->assertEquals($result['status_id'],'1');
    }

    /**
     正常：更新（繰り返し保存：３ヶ月単位の更新）
     * @test
     */
    public function saveData_ok8(){
        $todo = new Model_Todo();
        $work=$this->_entry_data;
        $work['start_y']='2016';
        $work['start_m']='1';
        $work['start_d']='3';
        $work['start_h']='10';
        $work['start_mi']='00';
        $work['repeat_flag']='1';
        $work['repeat_interval']='3';
        $work['repeat_unit_id']='3';
        $work['status_id']='1';

        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $this->assertEquals($data['end_date_real'],'2016-01-03 10:00:00');

        $data['status_id']='4';
        $todo->setData($data);
        $todo->saveData();
        $data=$todo->getData();
        $result=Model_Todo::getPk($data['todo_id']);
        $this->assertEquals($result['end_date_real'],'2016-04-03 10:00:00');
        $this->assertEquals($result['status_id'],'1');
    }

    /**
     正常：更新（繰り返し保存：２年単位の更新）
     * @test
     */
    public function saveData_ok9(){
        $todo = new Model_Todo();
        $work=$this->_entry_data;
        $work['start_y']='2016';
        $work['start_m']='1';
        $work['start_d']='3';
        $work['start_h']='10';
        $work['start_mi']='00';
        $work['repeat_flag']='1';
        $work['repeat_interval']='2';
        $work['repeat_unit_id']='4';
        $work['status_id']='1';

        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $this->assertEquals($data['end_date_real'],'2016-01-03 10:00:00');

        $data['status_id']='4';
        $todo->setData($data);
        $todo->saveData();
        $data=$todo->getData();
        $result=Model_Todo::getPk($data['todo_id']);
        $this->assertEquals($result['end_date_real'],'2018-01-03 10:00:00');
        $this->assertEquals($result['status_id'],'1');
    }


   /**
     * 正常：更新（繰り返し保存：１日単位、終了日を過ぎた)
     * @test
     */
    public function saveData_ok10(){
        $todo = new Model_Todo();
        $work=$this->_entry_data;
        $work['start_y']='2016';
        $work['start_m']='1';
        $work['start_d']='2';
        $work['start_h']='10';
        $work['start_mi']='00';
        $work['end_y']='2016';
        $work['end_m']='1';
        $work['end_d']='4';
        $work['end_h']='10';
        $work['end_mi']='00';
        $work['repeat_flag']='1';
        $work['repeat_interval']='3';
        $work['repeat_unit_id']='1';
        $work['status_id']='1';

        $todo->setData($work);
        $todo->saveData();
        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $this->assertEquals($data['end_date_real'],'2016-01-02 10:00:00');

        $data['status_id']='4';
        $todo->setData($data);
        $todo->saveData();
        $data=$todo->getData();
        $result=Model_Todo::getPk($data['todo_id']);
        $this->assertEquals($result['end_date_real'],'2016-01-02 10:00:00');
        $this->assertEquals($result['status_id'],'4');
    }


    /**
     * 異常：型不正
     * @test
     * @expectedException Exception
     */
    public function saveData_ng1(){
        $todo = new Model_Todo();
        $work=$this->_entry_data;
        $work['status_id']='aaa';
        $todo->setData($work);
        $todo->saveData();
    }

    /**
     * 異常：更新対象のデータなし
     * @test
     * @expectedException Exception
     */
    public function saveData_ng2(){
        $todo = new Model_Todo();
        $work=$this->_entry_data;
        $work['todo_id']='99999';
        $todo->setData($work);
        $todo->saveData();
    }

   /**
     * 正常：更新（繰り返し保存：１日単位、終了日を過ぎた)
     * @test
     */
    public function deleteData_ok1(){
        $todo = new Model_Todo();
        $todo->setData($this->_entry_data);
        $todo->saveData();

        $data=$todo->getData();
        $this->assertArrayHasKey('todo_id', $data);
        $result=Model_Todo::getPk($data['todo_id']);
        $this->assertEquals($result['name'],$this->_entry_data['name']);
        
        Model_Todo::deleteData($data['todo_id']);
        $result=Model_Todo::getPk($data['todo_id']);
        $this->assertCount(0,$result);
    }

    /**
     * 異常：削除対象のデータなし
     * @test
     * @expectedException Exception
     */
    public function deleteData_ng1(){
        $id='99999';
        Model_Todo::deleteData($id);
    }
}

