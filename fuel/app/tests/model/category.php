<?php
/**
 * Model Category Test
 * 
 * @group All
 * @group Category
 */
class Test_Model_Category extends \TestCase
{
    /**
     * 準備
     * @beforeClass
     */
    public static function initTest()
    {
        Config::load('define',true);
        Model_Util::execSqlFile(APPPATH."tests/sql/category.sql");
        Model_Util::execSqlFile(APPPATH."tests/sql/todo.sql");
    }
    /**
     * @afterClass
     */
    public static function endTest()
    {
    }

    /**
     * 正常：カテゴリ取得
     * @test
     */
    public function getListAll_ok1(){
        $list=Model_Category::getListAll(5);
        $this->assertCount(6, $list);
    }

    /**
     * 正常(新規)
     * @test
     */
    public function validData_ok1(){

        $category = new Model_Category();
        $work=array('category_id'=>'', 'name'=>'aaa','delf'=>'0');
        $category->setData($work,5);
        $rc=$category->validData();
        $this->assertTrue($rc);
    }

    /**
     * 正常(更新)
     * @test
     */
    public function validData_ok2(){
        Model_Fieldset::reset();  //validationインスタンスを初期化
        $category = new Model_Category();
        $work=array('category_id'=>'10', 'name'=>'aaa','delf'=>'1');
        $category->setData($work,5);
        $rc=$category->validData();
        $this->assertTrue($rc);
    }

    /**
     * 異常：カテゴリ名（必須）
     * @test
     */
    public function validData_ng_category_name1(){
        Model_Fieldset::reset();  //validationインスタンスを初期化
        $category = new Model_Category();
        $work=array('category_id'=>'10', 'name'=>'','delf'=>'0');
        $category->setData($work,5);
        $rc=$category->validData();
        $this->assertFalse($rc);
        $this->assertEquals( $category->getMessage(),"カテゴリ名が入力されていません。");
    }

    /**
     * 異常：カテゴリ名（上限）
     * @test
     */
    public function validData_ng_category_name2(){
        Model_Fieldset::reset();  //validationインスタンスを初期化
        $category = new Model_Category();
        $work=array('category_id'=>'10', 'name'=>'1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456','delf'=>'0');
        $category->setData($work,5);
        $rc=$category->validData();
        $this->assertFalse($rc);
        $this->assertEquals( $category->getMessage(),"カテゴリ名が255文字を超えています。");
    }

    /**
     * 異常：カテゴリID (例外エラー)
     * @expectedException Exception
     * @test
     */
    public function validData_ng_category_id1(){
        Model_Fieldset::reset();  //validationインスタンスを初期化
        $category = new Model_Category();
        $work=array('category_id'=>'aa', 'name'=>'aaa','delf'=>'0');
        $category->setData($work,5);
        $rc=$category->validData();
    }

    /**
     * 異常：カテゴリID (例外エラー)
     * @expectedException Exception
     * @test
     */
    public function validData_ng_delf1(){
        Model_Fieldset::reset();  //validationインスタンスを初期化
        $category = new Model_Category();
        $work=array('category_id'=>'aa', 'name'=>'aaa');
        $category->setData($work,5);
        $rc=$category->validData();
    }

    /**
     * 正常：新規登録
     * @test
     */
    public function saveData_ok1(){
        $category = new Model_Category();
        $work=array('category_id'=>'', 'name'=>'aaa', 'delf'=>'0');
        $category->setData($work,5);
        $category->saveData();

        $data=$category->getData();
        $this->assertArrayHasKey('category_id', $data);
        $result=Model_Category::find($data['category_id']);
        $this->assertEquals($result['name'],$work['name']);
        $this->assertEquals($result['sort_no'],$data['category_id']);
    }

    /**
     * 正常：更新
     * @test
     */
    public function saveData_ok2(){
        $category = new Model_Category();
        $work=array('category_id'=>'', 'name'=>'aaa', 'delf'=>'0');
        $category->setData($work,5);
        $category->saveData();

        $data=$category->getData();
        $this->assertArrayHasKey('category_id', $data);

        $work=array('category_id'=>$data['category_id'], 'name'=>'いいい', 'delf'=>'0', 'sort_no'=>$data['sort_no']);
        $category->setData($work,5);
        $category->saveData();

        $result=Model_Category::find($data['category_id']);
        $this->assertEquals($result['name'],$work['name']);
        $this->assertEquals($result['sort_no'],$work['sort_no']);
    }

    /**
     * 正常：論理更新
     * @test
     */
    public function saveData_ok3(){
        $category = new Model_Category();
        $work=array('category_id'=>'', 'name'=>'aaa', 'delf'=>'0');
        $category->setData($work,5);
        $category->saveData();

        $data=$category->getData();
        $this->assertArrayHasKey('category_id', $data);

        $work=array('category_id'=>$data['category_id'], 'name'=>'いいい', 'delf'=>'1', 'sort_no'=>$data['sort_no']);
        $category->setData($work,5);
        $category->saveData();

        $result=Model_Category::find($data['category_id']);
        $this->assertEquals($result['name'],$work['name']);
        $this->assertEquals($result['delf'],$work['delf']);
        $this->assertEquals($result['sort_no'],$work['sort_no']);
    }

    /**
     * 異常：更新対象のデータなし
     * @test
     * @expectedException Exception
     */
    public function saveData_ng1(){
        $category = new Model_Category();
        $work=array('category_id'=>'99999', 'name'=>'aaa', 'delf'=>'0');
        $category->setData($work,5);
        $rc=$category->saveData();
    }

    /**
     * 正常
     * @test
     */
    public function validDeleteData_ok1(){
        Model_Fieldset::reset();  //validationインスタンスを初期化

        //新規登録
        $category = new Model_Category();
        $work=array('category_id'=>'', 'name'=>'aaa','delf'=>'0');
        $category->setData($work,5);
        $category->saveData();
        $data=$category->getData();
        
        //削除チェック
        $category = new Model_Category();
        $work=array('category_id'=>$data['category_id'], 'name'=>'aaa','delf'=>'1', 'sort_no'=>$data['sort_no']);
        $category->setData($work,5);
        $rc=$category->validDeleteData();
        $this->assertTrue($rc);
    }

    /**
     * 異常：カテゴリが１件しかない
     * @test
     */
    public function validDeleteData_ng1(){
        Model_Fieldset::reset();  //validationインスタンスを初期化

        //新規登録
        $category = new Model_Category();
        $work=array('category_id'=>'', 'name'=>'aaa','delf'=>'0');
        $category->setData($work,99);
        $category->saveData();
        $data=$category->getData();

        //削除チェック
        $category = new Model_Category();
        $work=array('category_id'=>$data['category_id'], 'name'=>'aaa','delf'=>'1', 'sort_no'=>$data['sort_no']);
        $category->setData($work,99);
        $rc=$category->validDeleteData();
        $this->assertFalse($rc);
        $this->assertEquals( $category->getMessage(),"カテゴリが一つしないため削除できません。");

    }

    /**
     * 異常：当該カテゴリ設定済のTodoあり
     * @test
     */
    public function validDeleteData_ng2(){
        Model_Fieldset::reset();  //validationインスタンスを初期化

        //新規登録
        $category = new Model_Category();
        $work=array('category_id'=>'1', 'name'=>'aaa','delf'=>'1');
        $category->setData($work,5);
        $rc=$category->validDeleteData();
        $this->assertFalse($rc);
        $this->assertEquals( $category->getMessage(),"todoに設定されているため削除できません。");
    }

    /**
     * 異常：iカテゴリIDなし
     * @test
     * @expectedException Exception
     */
    public function validDeleteData_ng3(){
        $category = new Model_Category();
        $work=array('category_id'=>'', 'name'=>'aaa');
        $category->setData($work,5);
        $rc=$category->validDeleteData();
    }

    /**
     * 異常：uidなし
     * @test
     * @expectedException Exception
     */
    public function validDeleteData_ng4(){
        $category = new Model_Category();
        $work=array('category_id'=>'3', 'name'=>'aaa');
        $category->setData($work,'a');
        $rc=$category->validDeleteData();
    }

    /**
     * 異常：delfdなし
     * @test
     * @expectedException Exception
     */
    public function validDeleteData_ng5(){
        $category = new Model_Category();
        $work=array('category_id'=>'3', 'name'=>'aaa');
        $category->setData($work,'1');
        $rc=$category->validDeleteData();
    }

    /**
     * 正常：上に移動
     * @test
     */
    public function sort_ok1(){

        $category1=5;
        $category2=6;
        $category3=7;
        $result=Model_Category::find($category1);
        $this->assertEquals($result['sort_no'],'5');
        $result=Model_Category::find($category2);
        $this->assertEquals($result['sort_no'],'6');
        $result=Model_Category::find($category3);
        $this->assertEquals($result['sort_no'],'7');

        Model_Category::sort($category3,'up',5);
        $result=Model_Category::find($category1);
        $this->assertEquals($result['sort_no'],'5');
        $result=Model_Category::find($category2);
        $this->assertEquals($result['sort_no'],'7');
        $result=Model_Category::find($category3);
        $this->assertEquals($result['sort_no'],'6');

        Model_Category::sort($category3,'up',5);
        $result=Model_Category::find($category1);
        $this->assertEquals($result['sort_no'],'6');
        $result=Model_Category::find($category2);
        $this->assertEquals($result['sort_no'],'7');
        $result=Model_Category::find($category3);
        $this->assertEquals($result['sort_no'],'5');


    }

    /**
     * 正常：下に移動
     * @test
     */
    public function sort_ok2(){

        $category1=5;
        $category2=6;
        $category3=7;
        $result=Model_Category::find($category1);
        $this->assertEquals($result['sort_no'],'6');
        $result=Model_Category::find($category2);
        $this->assertEquals($result['sort_no'],'7');
        $result=Model_Category::find($category3);
        $this->assertEquals($result['sort_no'],'5');

        Model_Category::sort($category3,'down',5);
        $result=Model_Category::find($category1);
        $this->assertEquals($result['sort_no'],'5');
        $result=Model_Category::find($category2);
        $this->assertEquals($result['sort_no'],'7');
        $result=Model_Category::find($category3);
        $this->assertEquals($result['sort_no'],'6');

        Model_Category::sort($category3,'down',5);
        $result=Model_Category::find($category1);
        $this->assertEquals($result['sort_no'],'5');
        $result=Model_Category::find($category2);
        $this->assertEquals($result['sort_no'],'6');
        $result=Model_Category::find($category3);
        $this->assertEquals($result['sort_no'],'7');
    }

    /**
     * 正常：先頭(変更がない事）
     * @test
     */
    public function sort_ok3(){
        $uid=5;
       $result = Model_Category::find('first', array(
            'where' => array( array('delf', 0),
                       array('uid', 5),),
            'order_by' => array('sort_no' => 'asc'),
        ));

        $now_id=$result->id;
        $now_sort_no=$result->sort_no;
        Model_Category::sort($now_id,'up',5);

        $result = Model_Category::find($now_id);
        $this->assertEquals($result->sort_no,$now_sort_no);
    }

    /**
     * 正常：末尾(変更がない事）
     * @test
     */
    public function sort_ok4(){
        $uid=5;
       $result = Model_Category::find('first', array(
            'where' => array( array('delf', 0),
                       array('uid', 5),),
            'order_by' => array('sort_no' => 'desc'),
        ));

        $now_id=$result->id;
        $now_sort_no=$result->sort_no;
        Model_Category::sort($now_id,'down',5);

        $result = Model_Category::find($now_id);
        $this->assertEquals($result->sort_no,$now_sort_no);
    }

   /**
     * 異常：idなし
     * @test
     * @expectedException Exception
     */
    public function sort_ng1(){
        Model_Category::sort(9999,'down',5);

    }

   /**
     * 異常： move_action不正
     * @test
     * @expectedException Exception
     */
    public function sort_ng2(){
        Model_Category::sort(5,'aaa',5);

    }
}
