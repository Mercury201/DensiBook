<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>アカウントページ</title>
	<link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css">
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?=base_url();?>js/bootstrap.min.js"></script>

	<div id="header" class="container-fluid bg-info">	
	<h3><a href="<?=site_url('Account/')?>">アカウントTOP</a></h3>
	<?=$title?>
	<a href="<?=site_url('Account/mySetting')?>">個人設定</a>
	<a href="<?=site_url('Account/logout')?>">ログアウト</a>
	<a href="<?=site_url('Account/makingGroup')?>">グループ作成</a>
	<a href="<?=site_url('Account/groupDel')?>">グループ削除</a>
	</div>