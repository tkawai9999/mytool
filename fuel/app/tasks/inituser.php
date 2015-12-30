<?php

namespace Fuel\Tasks;
use Auth;

class InitUser
{

	/**
	 * 初期パスワード登録処理
	 * 
	 */
	public function run($args = NULL)
	{
        $list=array(
            array(
                'user'=>'root',
                'passwd'=>'root',
                'email'=>'root@aaa.co.jp',
                'group'=>100,
            ),
            array(
                'user'=>'kawai',
                'passwd'=>'kawai',
                'email'=>'kawai@aaa.co.jp',
                'group'=>1,
            ),
        );
        foreach ( $list as $rec)
        {
            Auth::create_user( $rec['user'],
                               $rec['passwd'],
                               $rec['email'],
                               $rec['group']);
            
        }
	}
}
