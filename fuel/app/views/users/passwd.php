<div class="container-fluid">
    <?php if( isset($msg) && $msg<>"" ):?>
<div class="alert alert-danger" role="alert"><?php echo $msg?></div>
    <?php endif;?>
  <form class="form-signin" action='changePasswd'  method='post'>
    <h2 class="form-signin-heading">パスワードを設定してください。</h2>
    <label for="old_passwd" class="sr-only">Password</label>
    <input type="password" name="old_passwd" class="form-control" 
       placeholder="現在のパスワード" >
    <label for="Password" class="sr-only">Password</label>
    <input type="password" name="new_passwd1" class="form-control" 
      placeholder="新しいパスワード" required value="">
    <label for="Password" class="sr-only">Password</label>
    <input type="password" name="new_passwd2" class="form-control" 
      placeholder="新しいパスワード(再入力)" required value="">
    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit">変更</button>
  </form>
</div> <!-- /container -->

