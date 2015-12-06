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
        $list=Model_Category::getListAll();
        $this->assertCount(3, $list);
    }
}
