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

    <title>MyTool!</title>

    <!-- Bootstrap core CSS -->
    <?php echo Asset::css('bootstrap.min.css','bootstrap-custom.css'); ?>
    <?php echo Asset::js(array('bootstrap.min.js','jquery-2.1.4.min.js'));?>
    <?php echo Asset::css('dashboard.css'); ?>
  <script>
  $(document).ready(function(){
alert('a');
      changeRepeat(); 
  });
  </script>

  </head>
  <body>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onClick="closeForm()">
      <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
    </button>
    <h4 class="modal-title">ToDo 登録</h4>
  </div><!-- /modal-header -->
  <div class="modal-body">
     <form class="form-horizontal" role="form" name='fm' id='fm'>
        <div class="form-group">
          <label for="name" class="col-sm-3 control-label">タスク</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="name" id="name"
                            value="<?php echo $todo['name'] ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">開始</label>
          <div class="col-sm-8 form-inline">
            <input type="text" class="form-control" name="start_y" value="<?php echo $todo['start_y'] ?>" style="width: 100px"><span style="margin: 0 5px;">年</span>
            <input type="text" class="form-control" name="start_m" value="<?php echo $todo['start_m'] ?>" style="width: 50px"><span style="margin: 0 5px;">月</span>
            <input type="text" class="form-control" name="start_d" value="<?php echo $todo['start_d'] ?>" style="width: 50px"><span style="margin: 0 5px;">日</span>
            <input type="text" class="form-control" name="start_h" value="<?php echo $todo['start_h'] ?>" style="width: 50px"><span style="margin: 0 5px;">時</span>
            <input type="text" class="form-control" name="start_mi" value="<?php echo $todo['start_mi'] ?>" style="width: 50px"><span style="margin: 0 5px;">分</span>
          </div>
        </div>
       <div class="form-group">
          <label for="s" class="col-sm-3 control-label ">終了(期限)</label>
          <div class="col-sm-8 form-inline">
            <input type="text" class="form-control" name="end_y" value="<?php echo $todo['end_y'] ?>" style="width: 100px"><span style="margin: 0 5px;">年</span>
            <input type="text" class="form-control" name="end_m" value="<?php echo $todo['end_m'] ?>" style="width: 50px"><span style="margin: 0 5px;">月</span>
            <input type="text" class="form-control" name="end_d" value="<?php echo $todo['end_d'] ?>" style="width: 50px"><span style="margin: 0 5px;">日</span>
            <input type="text" class="form-control" name="end_h" value="<?php echo $todo['end_h'] ?>" style="width: 50px"><span style="margin: 0 5px;">時</span>
            <input type="text" class="form-control" name="end_mi" value="<?php echo $todo['end_mi'] ?>" style="width: 50px"><span style="margin: 0 5px;">分</span>
          </div>
        </div>
        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">繰り返し</label>
          <div class="col-sm-8 form-inline">
            <label class="checkbox"> 
            <input type="hidden" name='repeat_flag' value="0"> 
            <input type="checkbox" id="repeat_flag" name='repeat_flag' 
              value="1" <?php if ($todo['repeat_flag'] == 1) echo "checked"; ?> 
              onChange="changeRepeat()"> する
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div id ='repeat_block'  >
              <input type="text" class="form-control" name="repeat_interval" 
                value="<?php echo $todo['repeat_interval'] ?>" 
                style="width: 50px"> &nbsp;&nbsp;&nbsp;
              <select class="form-control" name='repeat_unit_id' 
                style="width: 150px">
                <?php foreach ($repetunits as $repetunit ): ?>
                  <option value='<?php echo $repetunit->id?>'
                    <?php if($repetunit->id==$todo['repeat_unit_id']) echo "selected"?>>
                    <?php echo $repetunit->name?></option>
                <?php endforeach; ?>
              </select>
              <span style="margin: 0 5px;">毎</span>
           </div> <!--/repeat_block-->
          </div>
        </div>
<!-- 当面保留
        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">カレンダー表示</label>
          <div class="col-sm-8 form-inline">
            <label class="checkbox">
            <input type="checkbox" value="">する</label>
         </div>
        </div>
-->    
        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">ステータス</label>
          <div class="col-sm-8 form-inline">
            <select class="form-control" name=' status_id' style="width: 150px">
              <?php foreach ($statuses as $status ): ?>

                <option value='<?php echo $status->id?>'
                  <?php if($status->id==$todo['status_id']) echo "selected"?>>
                  <?php echo $status->name?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="birth" class="col-sm-3 control-label ">カテゴリ</label>
          <div class="col-sm-8 form-inline">
            <select class="form-control" name='category_id' style="width: 150px">
              <?php foreach ($categories as $category ): ?>

                <option value='<?php echo $category->id?>'
                  <?php if($category->id==$todo['category_id']) echo "selected"?>>
                  <?php echo $category->name?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">ノート</label>
          <div class="col-sm-8">
            <textarea class="form-control" rows="3" name='note'><?php echo $todo['note']?></textarea>
          </div>
        </div>
        <input type="hidden" name="todo_id" id="todo_id"  value="" >
      </form>
    </div><!-- /modal-body -->
    <div class="modal-footer">
      <?php if ($todo['todo_id'] ==""): ?>
        <button type="button" class="btn btn-primary"  
          onClick="actionForm('/mytool/todoedit/save','')"> 新規に保存</button>
      <?php else: ?>
        <button type="button" class="btn btn-danger" 
          onClick="actionForm('/mytool/todoedit/delete','<?php echo $todo['todo_id']?>')">
          削除</button>
        <button type="button" class="btn btn-success" 
          onClick="actionForm('/mytool/todoedit/save','')"> 新規に保存</button>
        <button type="button" class="btn btn-primary"
          onClick="actionForm('/mytool/todoedit/save','<?php echo $todo['todo_id']?>')">
          変更を保存</button>
      <?php endif ?>
    </div><!-- /modal-footer -->
  </body>
  </html>
</div>
</div>
