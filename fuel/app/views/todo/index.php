<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-3 col-md-2 sidebar">
      <?php echo View::forge('todo/side'); ?>
    </div>
    <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <?php echo View::forge('todo/main'); ?>
    </div>
  </div>
  <div class="modal fade" id="MyModal"  role="dialog" aria-hidden="true"> </div>
</div>
