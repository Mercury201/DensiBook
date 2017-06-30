
<html>
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
    
  <script type="text/javascript">
  //パスワードと確認が同じかの確認スクリプト
    window.onload = function () {
    	document.getElementById("password").onchange = validatePassword;
    	document.getElementById("passwordConfirm").onchange = validatePassword;
    }
    function validatePassword(){
    var pass2=document.getElementById("passwordConfirm").value;
    var pass1=document.getElementById("password").value;
    if(pass1!=pass2)
    	document.getElementById("passwordConfirm").setCustomValidity("パスワードが一致していません");
    else
    	document.getElementById("passwordConfirm").setCustomValidity('');	 
    //empty string means no validation error
    }
</script>
  
  </head>
  
  <body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"
    >
    </script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"
    >
    </script>
    
    <div class="container">
      <div class="page-header">
        <h3>
          新規アカウント登録
        </h3>
        <?php
        if(isset($message)){
          echo '<p>'. $message. '</p>';
        }else{
          //echo '<p>$messageの中身がないよ</p>';
        }
        
        //初期化
        $message = null;
        ?>
      </div>
      <form method="POST" action="">
        <div class="form-group">
          <div class="form-group">
            <label>
              名前
            </label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="form-group">
            <label>
              生年月日
            </label>
            <input type="date" class="form-control" name="birthday" required>
          </div>
          <div class="form-group">
            <label>
              学校名
            </label>
            <input type="text" class="form-control" name="school" required>
          </div>
          <div class="form-group">
            <label>
              メールアドレス
            </label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="form-group">
            <label>
              パスワード
            </label>
            <input type="password" class="form-control" name="password" id="password" required>
          </div>
          <div class="form-group">
            <label>
              パスワード確認
              <br>
            </label>
            <input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" required>
          </div>
          <div class="form-group">
            <label>
              利き投げを選択:
            </label>
            <select class="form-control" name="throw">
              <option value="右">
                右投げ
              </option>
              <option value="左">
                左投げ
              </option>
            </select>
          </div>
          <div class="form-group">
            <label>
              利き打ちを選択:
            </label>
            <select class="form-control" name="hit">
              <option value="右">
                右打ち
              </option>
              <option value="左">
                左打ち
              </option>
            </select>
          </div>
          <input type="submit" value="新規作成" class="btn btn-success pull-left btn-lg">
        </div>
      </form>
    </div>
  </body>

</html>