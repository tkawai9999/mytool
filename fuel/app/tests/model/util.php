<?php
/**
 * Model Util Test
 * 
 * @group All
 * @group Util
 */
class Test_Model_Util extends \TestCase
{
    /**
     * 準備
     * @beforeClass
     */
    public static function initTest()
    {
        Config::load('define',true);
    }
    /**
     * @afterClass
     */
    public static function endTest()
    {
    }

    /**
     * 正常：残り日数(3日)
     * @test
     */
    public function getRemainDay_ok1()
    {
        $end = date('Y-m-d H:i:s',strtotime("+3 day"));
        $day=Model_Util::getRemainDay($end);
        $this->assertEquals($day, 3);
    }

    /**
     * 正常：残り日数(0日)
     * @test
     */
    public function getRemainDay_ok2()
    {
        $end = date('Y-m-d H:i:s');
        $day=Model_Util::getRemainDay($end);
        $this->assertEquals($day, 0);
    }

    /**
     * 正常：期限切れ
     * @test
     */
    public function getRemainDay_ok3()
    {
        $end = date('Y-m-d H:i:s',strtotime("-4 day"));
        $day=Model_Util::getRemainDay($end);
        $this->assertEquals($day, -4);
    }

    /**
     * 正常：期限切れ
     * @test
     */
    public function getRemainDay_ok4()
    {
        $end =""; 
        $day=Model_Util::getRemainDay($end);
        $this->assertNull($day);
    }

    /**
     * 正常：SQLファイル実行
     * @test
     */
    public function execSqlFile_ok1()
    {
        $file=APPPATH."tests/sql/todo.sql";
        Model_Util::execSqlFile($file);
    }

    /**
     * 異常：SQLファイルなし
     * @test
     * @expectedException Exception
     */
    public function execSqlFile_ng1()
    {
        $file="";
        Model_Util::execSqlFile($file);
    }

}
