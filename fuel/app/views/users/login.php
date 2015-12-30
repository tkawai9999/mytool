<div class="container-fluid">
    <?php if( isset($msg) && $msg<>"" ):?>
<div class="alert alert-danger" role="alert"><?php echo $msg?></div>
    <?php endif;?>
  <form class="form-signin" action='login' method='post'>
    <h2 class="form-signin-heading">ログインしてください</h2>
    <label for="inputEmail" class="sr-only">Userid</label>
    <input type="text" name="uid" class="form-control" placeholder="Userid" 
      autofocus required value="<?php echo $uid?>">
    <label for="Password" class="sr-only">Password</label>
    <input type="password" name="passwd" class="form-control" 
      placeholder="Password" required value="<?php echo $passwd?>">
    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  </form>
</div> <!-- /container -->

