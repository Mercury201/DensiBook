<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Test</title>
	<link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css">
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>

<body>
    

    
    <form name="a" action="<?php echo site_url('/EntryMember/entryPlayer'); ?>" method="post">
        <input type="hidden" name="opponent" value="tamutyu2">
        <input type="hidden" name="location" value="テストグラウンド">
        <input type="hidden" name="topBottom" value="0">
        <input type="hidden" name="groupNo" value="1">
        
        <input type="hidden" name="benchNum" value="">
        
        <input type="hidden" name="member1" value="3">
        <input type="hidden" name="member2" value="5">
        <input type="hidden" name="member3" value="6">
        <input type="hidden" name="member4" value="7">
        <input type="hidden" name="member5" value="8">
        <input type="hidden" name="member6" value="10">
        <input type="hidden" name="member7" value="11">
        <input type="hidden" name="member8" value="12">
        <input type="hidden" name="member9" value="17">
        
        <input type="hidden" name="position1" value="投">
        <input type="hidden" name="position2" value="捕">
        <input type="hidden" name="position3" value="一">
        <input type="hidden" name="position4" value="二">
        <input type="hidden" name="position5" value="三">
        <input type="hidden" name="position6" value="遊">
        <input type="hidden" name="position7" value="左">
        <input type="hidden" name="position8" value="中">
        <input type="hidden" name="position9" value="右">
        
        <input type="hidden" name="opponentName" value="あ,い,う,え,お,か,き,く,け">
        <input type="hidden" name="opponentBattingHanded" value="右,右,右,右,右,右,右,右,右">
        <input type="hidden" name="opponentThrowHanded" value="右,右,右,右,右,右,右,右,右">
        <input type="hidden" name="opponentPosition" value="投,捕,一,二,三,遊,左,中,右">
    
        <input type="submit" name="order" value="決定"  />
    </form>
    
    
</body>