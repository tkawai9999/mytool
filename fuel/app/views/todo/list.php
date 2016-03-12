<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-3 col-md-2 sidebar">
<!--side start-->
<div class="panel panel-info">
  <div class="panel-heading">ステータス</div>
  <div class="panel-body">
    <ul class="nav nav-sidebar">
      <li class="<?php if(isset($side_during)) echo $side_during?>">
        <?php echo Html::anchor('todolist/during','対応中 <span class="badge">'.$cnt_during);?> </li>
      <li class="<?php if(isset($side_untreat1)) echo $side_untreat1?>">
        <?php echo Html::anchor('todolist/untreat1','未(期限有) <span class="badge">'.$cnt_untreat1);?> </li>
      <li class="<?php if(isset($side_untreat2)) echo $side_untreat2?>">
        <?php echo Html::anchor('todolist/untreat2','未(期限無) <span class="badge">'.$cnt_untreat2);?> </li>
      <li class="<?php if(isset($side_hold)) echo $side_hold?>">
        <?php echo Html::anchor('todolist/hold','保留 <span class="badge">'.$cnt_hold);?> </li>
      <li class="<?php if(isset($side_finished)) echo $side_finished?>">
        <?php echo Html::anchor('todolist/finished','完了');?> </li>
    </ul>
  </div>
</div>
<div class="panel panel-info">
  <div class="panel-heading">カテゴリ&nbsp;&nbsp;<button type="button" class="btn btn-primary "
      onClick="openForm('../categoryedit','','new');" >編集</button>
  </div>
  <div class="panel-body">
    <ul class="nav nav-sidebar">
      <?php foreach ($categories as $category ): ?>
        <li class="<?php if($category['active']) echo 'active';?>">
        <?php echo Html::anchor('todolist/category?category_id='.$category['id'],$category['name'].' <span class="badge">'.$category['cnt']);?> </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<!--side end-->

    </div>
    <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<!--main start-->
<h3 class="page-header">
  <span class="glyphicon glyphicon-ok-circle"></span>
  ToDo <?php echo $page_name?>
</h3>
<p class="text-right">
  <button type="button" class="btn btn-primary "
    onClick="openForm('../todoedit/','','new');" >＋</button>
</p>
<div class="table-responsive">
  <table class="table table-striped  table-hover">
    <thead>
      <tr class="warning">
        <th>ステータス</th>
        <th>タスク</th>
        <th>カテゴリ</th>
        <th>開始日</th>
        <th>終了日(期限)</th>
      </tr>
    </thead>
    <tbody>
    <form name='frm' >
      <?php foreach ($todos as $todo ): ?>
      <tr>
        <td>
          <select id="status_<?php echo $todo->id ?>" 
              onChange="changeStatus(frm,<?php echo $todo->id ?>)">>
          <?php foreach ($statuses as $status ): ?>
            <option value='<?php echo $status->id?>'
              <?php if($status->id==$todo->status_id):?>
                 selected <?php endif;?>>
              <?php echo $status->name?></option>
          <?php endforeach; ?>
          </select>
        </td>
        <td>
          <a onClick="openForm('../todoedit/','<?php echo $todo->id ?>','new');" >
              <?php echo $todo->name; ?></a>
        </td>
        <td><?php echo $todo->category->name ?></td>
        <td>
          <?php if ($todo->start_date==""): ?>
            -
          <?php else: ?>
            <?php echo date('Y/m/d',strtotime($todo->start_date)) ?>
          <?php endif; ?>
        </td>
        <td> 
          <?php if ($todo->end_date_real==""): ?>
            -
          <?php else: ?>
            <?php if ($todo->remain_day<=0 ) echo " <font color=\"red\">" ?> 
            <?php echo date('Y/m/d',strtotime($todo->end_date_real)) ?>
                 (残り<?php echo $todo->remain_day?>日)
            <?php if ($todo->remain_day<=0 ) echo "</font>" ?> 
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php echo Form::hidden("todo_id", '')?>
      <?php echo Form::hidden("status_id", '')?>
    </form>
    </tbody>
  </table>
<!--main end-->

    </div>
  </div>
  <div class="modal fade" id="MyModal"  role="dialog" aria-hidden="true"> </div>
</div>
