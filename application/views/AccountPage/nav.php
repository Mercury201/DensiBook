	<div id="row" class="container-fluid">
		<div id ="nav" class="col-sm-3 bg-success">
			<ul id="navList">
				
				<?php if(!isset($data)) echo 'NO'?>
				
				<?php foreach ($data as $value): ?>
					<li><a href="<?=site_url('GroupMenu/index/'.$value['groupNo'])?>"><?=$value['groupName']?></a></li>
						<ul>
							<li><a href="<?=site_url('Account/memberSetting/'.$value['groupNo'])?>">メンバー編集</a></li>
							<li><a href="<?=site_url('Account/addMember/'.$value['groupNo'])?>">メンバー追加</a></li>
						</ul>
				<?php endforeach; ?>
				
			</ul>			
		</div>