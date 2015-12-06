<?php
/**
 * Model Status Test
 * 
 * @group All
 * @group Status
 */
class Test_Model_Status extends \TestCase
{
    /**
     * 準備
     * @beforeClass
     */
    public static function initTest()
    {
        Config::load('define',true);
        Model_Util::execSqlFile(APPPATH."tests/sql/status.sql");
    }
    /**
     * @afterClass
     */
    public static function endTest()
    {
    }

    /**
     * 正常：ステータス取得
     * @test
     */
    public function getListAll_ok1(){
        $list=Model_Status::getListAll();
        $this->assertCount(4, $list);
    }
}
