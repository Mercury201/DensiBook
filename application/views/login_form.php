 <?php
 
 //$this->load->helper('form');
 //$this->load->helper('url');
 
  // echo form_open(site_url('/Auth/login'));
  // echo '<p>メールアドレス:';
  // echo form_input('email', '');
  // echo '</p>';
  // echo '<p>パスワード:';
  // echo form_password('password', '');
  // echo '</p>';
  // echo '<p>';
  // echo form_submit('login_submit', 'ログイン');
  // echo '</p>';
  // echo form_close();
  
  ?>
  
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"
    rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css"
    rel="stylesheet">
  </head>
  
  <body>
    <div class="container pull-left">
      <div class="well">
        <h3>
          　　　「電子ぶっく」へようこそ　　　
        </h3>
        
        <?php
        //エラーメッセージ表示
        if(isset($message)) echo $message;
        ?>
        
        <form id="form" action="<?php echo site_url('/Auth/login'); ?>" method="POST">
          <div class="form-group">
            <label>
              email
              <br>
            </label>
            <input type="email" class="form-control" name="email">
            <div class="form-group">
              <b>password</b>
              <div>
                <input type="password" class="form-control" name="password">
                <input type="submit"  name ="login_submit" value="ログイン" class="btn pull-right btn-success btn-sm">
              </div>
            </div>
          </div>
        </form>
        <div>
          <a href="<?php echo site_url('/Auth/createAccount'); ?>">アカウント新規作成はこちら</a>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"
    >
    </script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"
    >
    </script>
  </body>

</html>