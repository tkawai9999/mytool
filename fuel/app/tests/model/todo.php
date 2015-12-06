<?php
/**
 * Model Todo Test
 * 
 * @group All
 * @group Todo
 */
class Test_Model_Todo extends \TestCase
{
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
        $this->assertCount(4, $list);
    }
    /**
     * 正常：未-期限無し
     * @test
     */
    public function getListUntreatDeadLineNo_ok1(){
        $list=Model_Todo::getListUntreatDeadLineNo();
        $this->assertCount(1, $list);
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
            if ( $rec['id']==2) $this->assertEquals($rec['cnt'], 3);
            if ( $rec['id']==3) $this->assertEquals($rec['cnt'], 2);
        }
    }

}

