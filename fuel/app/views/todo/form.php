 <div class="modal-dialog">
  <div class="modal-content todo">
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">

    <title>MyTool!</title>

    <!-- Bootstrap core CSS -->
    <?php echo Asset::css('bootstrap.min.css','bootstrap-custom.css'); ?>
    <?php echo Asset::js(array('bootstrap.min.js','jquery-2.1.4.min.js'));?>
    <?php echo Asset::css('dashboard.css'); ?>
  </head>
  <body>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
      <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
    </button>
    <h4 class="modal-title">ToDo 登録</h4>
  </div><!-- /modal-header -->
  <div class="modal-body">
     <form class="form-horizontal" role="form">
        <div class="form-group">
          <label for="task" class="col-sm-3 control-label">タスク</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="task" value="">
          </div>
        </div>

        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">開始</label>
          <div class="col-sm-8 form-inline">
            <input type="text" class="form-control" id="yaar_s" value="2015" style="width: 100px"><span style="margin: 0 5px;">年</span>
            <input type="text" class="form-control" id="month_s" value="12" style="width: 50px"><span style="margin: 0 5px;">月</span>
            <input type="text" class="form-control" id="day_s" value="31" style="width: 50px"><span style="margin: 0 5px;">日</span>
            <input type="text" class="form-control" id="hour_s" value="23" style="width: 50px"><span style="margin: 0 5px;">時</span>
            <input type="text" class="form-control" id="minute_s" value="59" style="width: 50px"><span style="margin: 0 5px;">分</span>
          </div>
        </div>
       <div class="form-group">
          <label for="s" class="col-sm-3 control-label ">終了(期限)</label>
          <div class="col-sm-8 form-inline">
            <input type="text" class="form-control" id="yaar_s" value="2015" style="width: 100px"><span style="margin: 0 5px;">年</span>
            <input type="text" class="form-control" id="month_s" value="12" style="width: 50px"><span style="margin: 0 5px;">月</span>
            <input type="text" class="form-control" id="day_s" value="31" style="width: 50px"><span style="margin: 0 5px;">日</span>
            <input type="text" class="form-control" id="hour_s" value="23" style="width: 50px"><span style="margin: 0 5px;">時</span>
            <input type="text" class="form-control" id="minute_s" value="59" style="width: 50px"><span style="margin: 0 5px;">分</span>
          </div>
        </div>
        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">繰り返し</label>
          <div class="col-sm-8 form-inline">
            <label class="checkbox">
            <input type="checkbox" value="">する</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" class="form-control" id="yaar_s" value="1" style="width: 50px">&nbsp;&nbsp;&nbsp;
                   <select class="form-control"  style="width: 100px">
                      <option>日</option>
                      <option>週</option>
                      <option>月</option>
                      <option>年</option>
                    </select>
                    <span style="margin: 0 5px;">毎</span>

          </div>
        </div>
        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">カレンダー表示</label>
          <div class="col-sm-8 form-inline">
            <label class="checkbox">
            <input type="checkbox" value="">する</label>
         </div>
        </div>
    
        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">ステータス</label>
          <div class="col-sm-8 form-inline">
                   <select class="form-control" style="width: 150px">
                      <option>未</option>
                      <option>対応中</option>
                      <option>完了</option>
                      <option>保留</option>
                    </select>
          </div>
        </div>
        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">カテゴリ</label>
          <div class="col-sm-8 form-inline">
                   <select class="form-control" style="width: 150px">
                      <option>デフォルト</option>
                      <option>近々作業</option>
                      <option>定常作業</option>
                      <option>イベント</option>
                    </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">ノート</label>
          <div class="col-sm-8">
            <textarea class="form-control" rows="3"></textarea>
          </div>
        </div>
      </form>
    </div><!-- /modal-body -->
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">削除</button>
      <button type="button" class="btn btn-success" data-dismiss="modal">新規に保存</button>
      <button type="button" class="btn btn-primary" data-dismiss="modal">変更を保存</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
    </div><!-- /modal-footer -->
  </body>
  </html>
</div>
</div>


