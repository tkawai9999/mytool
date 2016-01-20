<?php
class Model_Util
{
    /**
     * 残り日数（終了日と現在日の差）を取得
     *
     * @param date $end_data 終了日
     * @return integer $remain_day 残り日数（終了日未指定ならNULL)
     */
    public static function getRemainDay($end_date)
    {
       if ($end_date==NULL) return NULL;
        $now_day= date('Y-m-d');
        $end_day= substr($end_date,0,10);
        $remain_day= (strtotime($end_day) - strtotime($now_day))
            / ( 60 * 60 * 24);
        return $remain_day;
    }

    /**
     * SQLファイルの実行
     *
     * @param string $sql_file sqlスクリプトファイルパス
     */
    public static function execSqlFile($sql_file)
    {
        $sql=file_get_contents($sql_file);
                $query = DB::query($sql);
                $result = $query->execute();
    }

    /**
     * Exception発生時のエラーログ出力
     *
     * @param Exception $e Exception情報
     */
    public static function logException($e)
    {
        $msg="予期せぬエラーが発生しました。\n";
        $msg=$msg.$e->getMessage()."\n";
        $msg=$msg.$e->getTraceAsString();
        Log::error($msg);
    }

}
