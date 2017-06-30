<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>さんぷる</title>
    </head>
    
    <body>
        <h1>データの受け取り方</h1>
        
        <article>
            
            <h3>普通の変数の受け取り方</h3>
            <p><?php echo $dataInt ?></p>
            
            <h3>↑の省略系</h3>
            <p><?=$dataInt?></p>
            
        </article>
        
        
        <article>
            
            <h3>配列の受け取り方</h3>
            <p><?php echo $dataAry['data12']?></p>
            
            <h3>全ての配列の内容を表示</h3>
            <p>
                <?php
                    foreach($dataAry as $value){
                        echo $value;
                    }
                ?>
            </p>
            
            
            <h3>codeIgniter特有のループの書き方</h3>
            <?php foreach ($dataAry as $value): ?>
				<?=$value?>
			<?php endforeach; ?>
			
			
			<h3>2重ループ</h3>
			<p>$arysのlength=<?=count($arys)?></p>
            <?php foreach ($arys as $ary): ?>
            
                <p>$aryのlength<?=count($ary)?><br/>
                
				<?php foreach ($ary as $value): ?>
				
				    <?=$value?>
				    
			    <?php endforeach; ?>
			    </p>
			    
			<?php endforeach; ?>
			
			
        </article>
        
        
        
    </body>
</html>