<?php
/**
 * Model_Fieldset
 *
 * phpunit用(Validationxのエラー対策）
 */
class Model_Fieldset extends \Fuel\Core\Fieldset {
  //fieldsetの$_instancesを初期化するメソッド
  public static function reset(){
    parent::$_instances = array();
  }
}

