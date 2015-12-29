<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">

    <title><?php echo $title ?></title>

    <!-- Bootstrap core CSS -->
    <?php echo Asset::css(array('bootstrap.min.css','bootstrap-custom.css')); ?>
    <?php echo Asset::js(array('jquery-2.1.4.min.js','bootstrap2.min.js','mytool.js'));?>
    <?php echo Asset::css('dashboard.css'); ?>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">My Tool!</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav ">
            <li class="<?php if(isset($menu_todo)) echo $menu_todo?>">
              <?php echo Html::anchor('todolist/','Todo');?>
            </li>
            <li class=""><a href="#">ブックマーク</a></li>
            <li><a href="#">ノート</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div><!-- .container -->
    </nav>
    <?php echo $content ?>
  </body>
</html>
