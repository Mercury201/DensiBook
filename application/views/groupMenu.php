<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>タイトル</title>
    <link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?=base_url();?>js/bootstrap.min.js"></script>
    
    <style type="text/css">
        h1{
            text-align: center;
        }
        h3{
            text-align: center;
        }
       #midasi{
           font-family: 'sans-serif', cursive;
       }
       #komidasi{
       }
       body{
           text-align: center;
       }
        #buttonMoji{
        font-size: 30px;
        letter-spacing: 1em;
       }
       img{
           width:100%;
           height:auto;
       }
       
       
    </style>
  </head>
  <body>

    <div id="header" class="container-fluid bg-danger">
        <div id="head">
            <h1><label id="midasi">電子ぶっく</label></h1>
            <h3><label id="komidasi">～<?=$groupName?>～</label></h3>
        </div>
    </div>

    <div id="row" class="container-fluid">

      <div id="1" class="container-fluid bg-info col-sm-4">
          <button type="button" name="試合記録" onclick="location.href='<?=site_url("EntryMember/entry/". $groupNo)?>'">
          <img src="<?=base_url('user_guide/_images/bat.png')?>"><br/>
          <label id="buttonMoji">試合記録</label>
          </button>
      </div>

      <div id="3" class="container-fluid bg-success col-sm-4">
         <button type="button" name="個人成績" onclick="location.href='<?=site_url("PersonalResult/index/". $groupNo)?>'"<?php if($firstTime) echo 'disabled' ?> >
         <img src="<?=base_url('user_guide/_images/throw.png')?>"><br/>
         
         <label id="buttonMoji">個人成績</label>
         </button>
      </div>

      <div id="3" class="container-fluid bg-warning col-sm-4">
         <button type="button" name="個人分析" onclick="location.href='<?=site_url("Record/index/". $groupNo)?>'" <?php if($firstTime) echo 'disabled' ?> >
         <img src="<?=base_url('user_guide/_images/catch.png')?>"  style="width:75%;height:10%;"  ><br/>
         <label id="buttonMoji">個人分析</label>
         </button>
      </div>

    </div>

    <div id="footer" class="container-fluid bg-danger">
    <button type="button" name="" value="" onclick="location.href='<?=site_url('Account/')?>'">個人設定に戻る</button>
    </div>

  </body>
</html>