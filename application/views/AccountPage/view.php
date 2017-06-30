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
	<h3>タイトル</h3>	
	<a href="">個人設定</a>
	<a href="">ログアウト</a>
	<a href="">グループ編集</a>
	<!-- グループ作成 削除に分けるかは今度決める-->
	</div>
	
	<div id="row" class="container-fluid">
		
		<div id ="nav" class="col-sm-3 bg-success">
			<ul>
				<li><a href="">test1</a></li>
				<li>test2</li>
				<li>test3</li>
			</ul>			
		</div>
		
		<div id="main" class="col-sm-6 bg-danger">
		<p>メインコンテンツ</p>
		</div>		
		
	</div>

	<div id="footer" class="container-fluid bg-info">		
	<p>フッター</p>
	</div>

</body>
</html>