
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
    <?php echo Asset::css('bootstrap.min.css'); ?>
    <?php echo Asset::js(array('bootstrap.min.js','jquery-2.1.4.min.js'));?>
  </head>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">MyTool!</a>
        </div>
        <div class="collapse navbar-collapse" id="collapse-target">
          <ul class="nav navbar-nav">
            <li><a href="#">Hoge</a></li>
            <li><a href="#">Fuga</a></li>
          </ul>
          <button class="navbar-btn btn btn-default">Button</button>
        </div>
      </div>
    </nav>

<div class="panel panel-default">
    <div class="panel-heading">
        パネルのヘッダー
    </div>
    <div class="panel-body">
        パネルの内容
    </div>
    <div class="panel-footer">
        パネルのフッター
    </div>
</div>

  </body>
</html>
