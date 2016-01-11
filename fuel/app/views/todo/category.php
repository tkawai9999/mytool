<div class="modal-dialog">
  <div class="modal-content category">
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
  </head>
  <body>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
      </button>
      <h4 class="modal-title">カテゴリ編集</h4>
    </div><!-- /modal-header -->
    <div class="modal-body">
      <form class="form-horizontal" id='fm' name='fm' role="form">
        <div class="form-group">
          <div class="col-sm-12">
            <label for="category" class=" control-label">名称</label>
          </div>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="name" id='name' value="">
          </div>
        </div>
        <p class="text-right">
<!--
          <button type="button" class="btn btn-danger" 
              data-dismiss="modal">↑</button>&nbsp;
          <button type="button" class="btn btn-danger" 
              data-dismiss="modal">↓</button>&nbsp;&nbsp;
-->
          <button type="button" class="btn btn-success" 
               onClick="clearCategory()">クリア</button>&nbsp;&nbsp;
          <button type="button" class="btn btn-danger" data-dismiss="modal"
              onClick="actionCategory('/mytool/categoryedit/delete','1')">
              削除</button>&nbsp;&nbsp;
          <button type="button" class="btn btn-primary"  
              onClick="actionCategory('/mytool/categoryedit/save','0')">
              保存</button>
        </p>
        <div class="form-group">
          <div class="col-sm-12">
          <ul class="list-group category" >
            <?php foreach ($categories as $category ): ?>
              <a class="list-group-item" onClick="selectCategory('<?php echo $category->id?>','<?php echo $category->name?>')">
                <?php echo $category->name?></a>
            <?php endforeach; ?>
          </ul>
        </div> <!--col-sm -->
        </div> <!--form-group -->
        <input type="hidden" name="category_id"  id='category_id' value="" >
        <input type="hidden" name="delf"  id='delf' value="" >
      </form>
    </div><!-- /modal-body -->
  </body>
  </html>
</div>
</div>
