<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../user_guide/_images/images.jpg" />
    <title>打席分析</title>
    <!-- <link rel="stylesheet" href="Canvas.css" type="text/css"　media="all" /> -->

    <style type="text/css">
        
        label {
           border: 1px solid #8080ff;  /* 枠線 */
           border-radius: 9px;         /* 枠線の角丸 */
           padding: 4px 6px 4px 4px;   /* 内側の余白 */
           margin-bottom: 4px;         /* 外側の下の余白 */
           display: inline-block;      /* 途中で改行させない */
           cursor: pointer;            /* マウス形状を手形に */
        }
        /* ▼マウスが載ったときの追加装飾 */
        label:hover {
           background-color: blue;  /* 背景色 */
           color: white;            /* 文字色 */
        }
        
    </style>
    
    
    <link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url();?>css/jquery-ui-bootstrap-masterbs3/css/custom-theme/jquery-ui-1.10.3.custom.css">
    
    
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="<?=base_url();?>js/bootstrap.min.js"></script>
    
    
    <script type="text/javascript">
        
        //ランナー画像を描く
        var drawrunnerflag = 0;
    
        <?php $number = 1;
        foreach($atbatsum as $value): ?>
            var countCanvas<?=$number?>;
            var lightBoxCanvas<?=$number?>;
            var courseCanvas<?=$number?>;
            var leftBoxCanvas<?=$number?>;
            var groundCanvas<?=$number?>;
            var diamondCanvas<?=$number?>;
            
            var countctx<?=$number?>;
            var leftBoxctx<?=$number?>;
            var coursectx<?=$number?>;
            var lightBoxctx<?=$number?>;
            var groundctx<?=$number?>;
            var diamondctx<?=$number?>;
            var firstRunnerctx<?=$number?>;
            var secondRunnerctx<?=$number?>;
            
            var lightBoximg<?=$number?>;//右打席画像
            var courseimg<?=$number?>;//コース画像
            var leftBoximg<?=$number?>;//左打席画像
            var groundimg<?=$number?>;//グラウンド画像
            var diamondimg<?=$number?>;//ダイヤモンド画像
            var firstrunnerimg<?=$number?>;//1塁ランナー画像
            var secondrunnerimg<?=$number?>;//2塁ランナー画像
            var thirdrunnerimg<?=$number?>;//3塁ランナー画像
        <?php $number = $number + 1; ?>
        <?php endforeach; ?>
        
        ///////////////////////メインメソッド///////////////////////
        window.onload = function(){
                
            $('#textRbi').attr('disabled',true);
            $('#display').attr('disabled',true);
            
            //タブのクラス属性追加
            setAttr();
            
            //キャンバスの初期処理
            drawCountCanvas();
            drawLightBoxCanvas();
            drawCourseCanvas();
            drawLeftBoxCanvas();
            drawgroundCanvas();
            drawdiamondCanvas();
            
            addDate();
            addOpponent();
            addName();
        };
        
        //ストライク、ボールカウント表示
        function drawCountCanvas(){
            
            <?php $number = 1;
            foreach($atbatsum as $key => $value): ?>
                
            countCanvas<?=$number?> = document.getElementById('countCanvas<?=$number?>');   
            
            //2dコンテキスト
            countctx<?=$number?> = countCanvas<?=$number?>.getContext('2d');
            
            //ボールカウント
            countctx<?=$number?>.fillStyle = "black";
            countctx<?=$number?>.font = "30px 'ＭＳ ゴシック'";
            countctx<?=$number?>.textAlign = "left";
            countctx<?=$number?>.textBaseline = "top";
            
            countctx<?=$number?>.fillText("B",5,20);
            
            switch(<?=$atbatsum[$key]['ボールカウント'];?>){
                
                case 0:
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(40, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(71, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(101, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    break;
                
                case 1:
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                    countctx<?=$number?>.arc(40, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(71, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(101, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    break;
                
                case 2:
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                    countctx<?=$number?>.arc(40, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                    countctx<?=$number?>.arc(71, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(101, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    break;
                    
                case 3:
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                    countctx<?=$number?>.arc(40, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                    countctx<?=$number?>.arc(71, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                    countctx<?=$number?>.arc(101, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    break;
            }
            
            //ストライクカウント
            countctx<?=$number?>.fillStyle = "black";
            countctx<?=$number?>.font = "30px 'ＭＳ ゴシック'";
            countctx<?=$number?>.textAlign = "left";
            countctx<?=$number?>.textBaseline = "top";
            
            countctx<?=$number?>.fillText("S",144,20);
            
            switch(<?=$atbatsum[$key]['ストライクカウント'];?>){
                
                case 0:
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(179, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(210, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    break;
                
                case 1:
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(255, 180, 00)';
                    countctx<?=$number?>.arc(179, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.arc(210, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.stroke();
                    
                    break;
                
                case 2:
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(255, 180, 00)';
                    countctx<?=$number?>.arc(179, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    countctx<?=$number?>.beginPath();
                    countctx<?=$number?>.fillStyle = 'rgb(255, 180, 00)';
                    countctx<?=$number?>.arc(210, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number?>.fill();
                    
                    break;
            }
            
            //アウトカウント
            countctx<?=$number?>.fillStyle = "black";
            countctx<?=$number?>.font = "30px 'ＭＳ ゴシック'";
            countctx<?=$number?>.textAlign = "left";
            countctx<?=$number?>.textBaseline = "top";
            
            countctx<?=$number?>.fillText("O",255,20);
            
            switch(<?=$atbatsum[$key]['アウトカウント'];?>){
                
                case 0:
                    
                    countctx<?=$number;?>.beginPath();
                    countctx<?=$number;?>.arc(290, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number;?>.stroke();
                    
                    countctx<?=$number;?>.beginPath();
                    countctx<?=$number;?>.arc(321, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number;?>.stroke();
                    
                    break;
                
                case 1:
                    
                    countctx<?=$number;?>.beginPath();
                    countctx<?=$number;?>.fillStyle = 'rgb(255, 00, 00)';
                    countctx<?=$number;?>.arc(290, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number;?>.fill();
                
                    countctx<?=$number;?>.beginPath();
                    countctx<?=$number;?>.arc(321, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number;?>.stroke();
                    
                    break;
                
                case 2:
                    
                    countctx<?=$number;?>.beginPath();
                    countctx<?=$number;?>.fillStyle = 'rgb(255, 00, 00)';
                    countctx<?=$number;?>.arc(290, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number;?>.fill();
                    
                    countctx<?=$number;?>.beginPath();
                    countctx<?=$number;?>.fillStyle = 'rgb(255, 00, 00)';
                    countctx<?=$number;?>.arc(321, 35, 13, 0, Math.PI*2, false);
                    countctx<?=$number;?>.fill();
                    
                    break;
            }
            
            <?php $number = $number + 1;?>
            <?php endforeach; ?>
        }
        
        //右打席を描く
        function drawLightBoxCanvas(){
            
            <?php $number = 1;
            foreach($atbatsum as $value): ?>
            
            lightBoxCanvas<?=$number ?> = document.getElementById('lightbox<?=$number ?>');
                
            //2dコンテキスト
            lightBoxctx<?=$number ?> = lightBoxCanvas<?=$number ?>.getContext('2d');
                
            //表示画像を指定
            lightBoximg<?=$number ?> = new Image();
            lightBoximg<?=$number ?>.src = "<?=base_url('user_guide/_images/lightbox.jpg')?>";
                
            //画像の読み込み、表示
            lightBoximg<?=$number ?>.onload = function(){
                lightBoxctx<?=$number ?>.drawImage(lightBoximg<?=$number ?>,0,0,25,300);
            }
            
            <?php $number = $number + 1; ?>
            <?php endforeach; ?>
        }
	
	    //コースキャンバスを描く
        function drawCourseCanvas(){
                
            <?php $number = 1;
            foreach($atbatsum as $key => $value): ?>
            
            courseCanvas<?= $number;?> = document.getElementById('courseCanvas<?=$number?>');
            
            //2dコンテキスト
            coursectx<?=$number?> = courseCanvas<?=$number?>.getContext('2d');
            
            //表示画像を指定
            courseimg<?=$number?> = new Image();
            courseimg<?=$number?>.src = "<?=base_url('user_guide/_images/course_2.jpg')?>";
            
            //画像の読み込み、表示
            courseimg<?=$number?>.onload = function(){
                coursectx<?=$number?>.drawImage(courseimg<?=$number?>,0,0,300,300);
                
                <?php $num = 1;
                foreach($atbatsum[$key]['投球内容'] as $arrayKey => $val): ?>
                
                //コース座標,判定変数を作成,値代入
                var mouseX = <?= $atbatsum[$key]['投球内容'][$arrayKey]['x']?>;
                var mouseY = <?= $atbatsum[$key]['投球内容'][$arrayKey]['y']?>;
                var desition = <?= $atbatsum[$key]['投球内容'][$arrayKey]['判定']?>;
                
                ////打席確定時の投球か////
                if(<?= count($atbatsum[$key]['投球内容']) ?> == <?= $num ?>){
                    //左ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 1){
                    
                            //左三角を描く
                        coursectx<?=$number?>.beginPath();
                        coursectx<?=$number?>.fillStyle = "#000000";
                        coursectx<?=$number?>.moveTo(mouseX+6, mouseY-10);
                        coursectx<?=$number?>.lineTo(mouseX+6, mouseY+10);
                        coursectx<?=$number?>.lineTo(mouseX-15, mouseY);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                    }else
                    //ストレートボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 2){
                    
                        //円を描く
                        coursectx<?=$number?>.beginPath();
                        coursectx<?=$number?>.fillStyle = "#000000";
                        coursectx<?=$number?>.arc(mouseX, mouseY, 10, 0, Math.PI * 2, false);
                        coursectx<?=$number?>.fill();
                    
                    }else
                    //右ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 3){
                        
                        //右三角を描く
                        coursectx<?=$number?>.beginPath();
                        coursectx<?=$number?>.fillStyle = "#000000";
                        coursectx<?=$number?>.moveTo(mouseX-6, mouseY-10);
                        coursectx<?=$number?>.lineTo(mouseX-6, mouseY+10);
                        coursectx<?=$number?>.lineTo(mouseX+15, mouseY);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                    }else
                    //左下ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 4){
                    
                        //左下三角を描く
                        coursectx<?=$number?>.beginPath();
                        coursectx<?=$number?>.fillStyle = "#000000";
                        coursectx<?=$number?>.moveTo(mouseX-2,mouseY-12);
                        coursectx<?=$number?>.lineTo(mouseX+12,mouseY+2);
                        coursectx<?=$number?>.lineTo(mouseX-9,mouseY+9);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                        }else
                    //下ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 5){
                        
                        //下三角を描く
                        coursectx<?=$number?>.beginPath();
                        coursectx<?=$number?>.fillStyle = "#000000";
                        coursectx<?=$number?>.moveTo(mouseX-10,mouseY-10);
                        coursectx<?=$number?>.lineTo(mouseX+10,mouseY-10);
                        coursectx<?=$number?>.lineTo(mouseX,mouseY+10);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                    }else
                    //右下ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 6){
                        
                        //右下三角を描く
                        coursectx<?=$number?>.beginPath();
                        coursectx<?=$number?>.fillStyle = "#000000";
                        coursectx<?=$number?>.moveTo(mouseX+2,mouseY-12);
                        coursectx<?=$number?>.lineTo(mouseX-12,mouseY+2);
                        coursectx<?=$number?>.lineTo(mouseX+9,mouseY+9);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                    }
                    
                    //打席結果を表示
                    
                    displayAtbatResult(desition,<?=$number?>);
                    
                }else{                                                          /////打席確定前の投球内容//////
                    //左ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 1){
                    
                            //左三角を描く
                        coursectx<?=$number?>.beginPath();
                        if(desition == 1 || desition == 3){
                            coursectx<?=$number?>.fillStyle = 'rgb(255, 120, 00)';
                        }else{
                            coursectx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                        }
                        coursectx<?=$number?>.moveTo(mouseX+6, mouseY-10);
                        coursectx<?=$number?>.lineTo(mouseX+6, mouseY+10);
                        coursectx<?=$number?>.lineTo(mouseX-15, mouseY);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                    }else
                    //ストレートボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 2){
                    
                        //円を描く
                        coursectx<?=$number?>.beginPath();
                        if(desition == 1 || desition == 3){
                            coursectx<?=$number?>.fillStyle = 'rgb(255, 120, 00)';
                        }else{
                            coursectx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                        }
                        coursectx<?=$number?>.arc(mouseX, mouseY, 10, 0, Math.PI * 2, false);
                        coursectx<?=$number?>.fill();
                    
                    }else
                    //右ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 3){
                        
                        //右三角を描く
                        coursectx<?=$number?>.beginPath();
                        if(desition == 1 || desition == 3){
                            coursectx<?=$number?>.fillStyle = 'rgb(255, 120, 00)';
                        }else{
                            coursectx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                        }
                        coursectx<?=$number?>.moveTo(mouseX-6, mouseY-10);
                        coursectx<?=$number?>.lineTo(mouseX-6, mouseY+10);
                        coursectx<?=$number?>.lineTo(mouseX+15, mouseY);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                    }else
                    //左下ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 4){
                    
                        //左下三角を描く
                        coursectx<?=$number?>.beginPath();
                        if(desition == 1 || desition == 3){
                            coursectx<?=$number?>.fillStyle = 'rgb(255, 120, 00)';
                        }else{
                            coursectx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                        }
                        coursectx<?=$number?>.moveTo(mouseX-2,mouseY-12);
                        coursectx<?=$number?>.lineTo(mouseX+12,mouseY+2);
                        coursectx<?=$number?>.lineTo(mouseX-9,mouseY+9);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                        }else
                    //下ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 5){
                        
                        //下三角を描く
                        coursectx<?=$number?>.beginPath();
                        if(desition == 1 || desition == 3){
                            coursectx<?=$number?>.fillStyle = 'rgb(255, 120, 00)';
                        }else{
                            coursectx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                        }
                        coursectx<?=$number?>.moveTo(mouseX-10,mouseY-7);
                        coursectx<?=$number?>.lineTo(mouseX+10,mouseY-7);
                        coursectx<?=$number?>.lineTo(mouseX,mouseY+13);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                    }else
                    //右下ボタン
                    if(<?= $atbatsum[$key]['投球内容'][$arrayKey]['球種']; ?> == 6){
                        
                        //右下三角を描く
                        coursectx<?=$number?>.beginPath();
                        if(desition == 1 || desition == 3){
                            coursectx<?=$number?>.fillStyle = 'rgb(255, 120, 00)';
                        }else{
                            coursectx<?=$number?>.fillStyle = 'rgb(00, 128, 00)';
                        }
                        coursectx<?=$number?>.moveTo(mouseX+2,mouseY-12);
                        coursectx<?=$number?>.lineTo(mouseX-12,mouseY+2);
                        coursectx<?=$number?>.lineTo(mouseX+9,mouseY+9);
                        coursectx<?=$number?>.closePath();
                        coursectx<?=$number?>.fill();
                    }
                }
                
                coursectx<?=$number?>.fillStyle = "white";
                coursectx<?=$number?>.font = "bold 15px 'ＭＳ ゴシック'";
                coursectx<?=$number?>.textAlign = "center";
                coursectx<?=$number?>.textBaseline = "top";

                coursectx<?=$number?>.fillText(<?=$num?>,mouseX,mouseY-8);
                
                <?php $num = $num + 1?>
                <?php endforeach; ?>
            }
            <?php $number = $number + 1 ?>
            <?php endforeach; ?>
        }
                        
        //左打席キャンバスを描く
        function drawLeftBoxCanvas(){
            
            <?php $number = 1;
            foreach($atbatsum as $value): ?>
                    
            leftBoxCanvas<?=$number;?> = document.getElementById('leftbox<?=$number;?>');
            
            //2dコンテキスト
            leftBoxctx<?=$number;?> = leftBoxCanvas<?=$number;?>.getContext('2d');
            
            //表示画像を指定
            leftBoximg<?=$number;?> = new Image();
            leftBoximg<?=$number;?>.src = "<?=base_url('user_guide/_images/leftbox.jpg')?>";
            
            //画像の読み込み、表示
            leftBoximg<?=$number;?>.onload = function(){
                leftBoxctx<?=$number;?>.drawImage(leftBoximg<?=$number;?>,0,0,25,300);
            }
            
            <?php $number = $number + 1; ?>
            <?php endforeach; ?>
        }
                
        //グラウンドキャンバスを描く
        function drawgroundCanvas(){
                
            <?php $number = 1;
            foreach($atbatsum as $key => $value): ?>
            
            groundCanvas<?=$number?> = document.getElementById('GroundCanvas<?=$number?>');
            
            //2dコンテキスト
            groundctx<?=$number?> = groundCanvas<?=$number?>.getContext('2d');
            
            //表示画像を指定
            groundimg<?=$number?> = new Image();
            groundimg<?=$number?>.src = "<?=base_url('user_guide/_images/ground.jpg')?>";
            
            //画像の読み込み、表示
            groundimg<?=$number?>.onload = function(){
                groundctx<?=$number?>.drawImage(groundimg<?=$number?>,0,0,350,350);
                
                
                //打球方向を描く
                groundctx<?=$number?>.beginPath();
                groundctx<?=$number?>.fillStyle = "#000000";
                groundctx<?=$number?>.moveTo(172,310);
                groundctx<?=$number?>.lineTo(<?= $atbatsum[$key]['打球方向x']; ?>,<?= $atbatsum[$key]['打球方向y']; ?>);
                groundctx<?=$number?>.closePath();
                groundctx<?=$number?>.stroke();
            }
        
            <?php $number = $number + 1 ?>
            <?php endforeach; ?>
        }
                
        //ダイヤモンドキャンバスを描く
        function drawdiamondCanvas(){
                
            <?php $number = 1;
            foreach($atbatsum as $key => $value): ?>
            
            diamondCanvas<?=$number;?> = document.getElementById('diamondCanvas<?=$number;?>');
            
            //2dコンテキスト
            diamondctx<?=$number;?> = diamondCanvas<?=$number;?>.getContext('2d');
            
            //表示画像を指定
            diamondimg<?=$number;?> = new Image();
            diamondimg<?=$number;?>.src = "<?=base_url('user_guide/_images/diamond.jpg')?>";
            
            //画像の読み込み、表示
            diamondimg<?=$number;?>.onload = function(){
                diamondctx<?=$number;?>.drawImage(diamondimg<?=$number;?>,0,0,350,350);
                
                //ランナーを描く
                //1塁ランナー判定
            if(<?=$atbatsum[$key]['ランナー状況']['firstRunnerNo'];?> != 0){
                
                //表示画像を指定
                firstrunnerimg<?=$number;?> = new Image();
                firstrunnerimg<?=$number;?>.src = "<?=base_url('user_guide/_images/runner.png')?>";
                    
                firstrunnerimg<?=$number;?>.onload = function(){
                    diamondctx<?=$number;?>.drawImage(firstrunnerimg<?=$number;?>,245,145,40,50);
                
                    diamondctx<?=$number;?>.fillStyle = "black";
                    diamondctx<?=$number;?>.font = "15px 'ＭＳ ゴシック'";
                    diamondctx<?=$number;?>.textAlign = "left";
                    diamondctx<?=$number;?>.textBaseline = "top";
                        
                    diamondctx<?=$number;?>.fillText(<?php echo "'" .$atbatsum[$key]['ランナー状況']['firstRunnerName']. "'";?>,225,130);
                    
                }
            }
            
            //2塁ランナー判定
            if(<?=$atbatsum[$key]['ランナー状況']['secondRunnerNo'];?> != 0){
                
                //表示画像を指定
                secondrunnerimg<?=$number;?> = new Image();
                secondrunnerimg<?=$number;?>.src = "<?=base_url('user_guide/_images/runner.png')?>";
                    
                secondrunnerimg<?=$number;?>.onload = function(){
                    diamondctx<?=$number;?>.drawImage(secondrunnerimg<?=$number;?>,148,30,40,50);
                
                    diamondctx<?=$number;?>.fillStyle = "black";
                    diamondctx<?=$number;?>.font = "15px 'ＭＳ ゴシック'";
                    diamondctx<?=$number;?>.textAlign = "left";
                    diamondctx<?=$number;?>.textBaseline = "top";
                        
                    diamondctx<?=$number;?>.fillText(<?php echo "'" .$atbatsum[$key]['ランナー状況']['secondRunnerName']. "'";?>,128,15);
                }
            }
            
            //3塁ランナー判定
            if(<?=$atbatsum[$key]['ランナー状況']['thirdRunnerNo'];?> != 0){
                
                //表示画像を指定
                thirdrunnerimg<?=$number;?> = new Image();
                thirdrunnerimg<?=$number;?>.src = "<?=base_url('user_guide/_images/runner.png')?>";
                    
                thirdrunnerimg<?=$number;?>.onload = function(){
                    diamondctx<?=$number;?>.drawImage(thirdrunnerimg<?=$number;?>,48,145,40,50);
                
                    diamondctx<?=$number;?>.fillStyle = "black";
                    diamondctx<?=$number;?>.font = "15px 'ＭＳ ゴシック'";
                    diamondctx<?=$number;?>.textAlign = "left";
                    diamondctx<?=$number;?>.textBaseline = "top";
                        
                    diamondctx<?=$number;?>.fillText(<?php echo "'" .$atbatsum[$key]['ランナー状況']['thirdRunnerName']. "'";?>,28,130);
                }
            }
            }
            
            <?php $number = $number + 1; ?>
            <?php endforeach; ?>
        }
        
        //selectboxに日付を追加
        function addDate(){
            var select = document.getElementById('date');
            
            <?php foreach($select['日付'] as $key => $value): ?>
                var option = document.createElement('option');
                
                option.setAttribute('value',<?= "'" .$value. "'" ?>);
                option.innerHTML = <?= "'" .$value. "'" ?>;
                
                select.appendChild(option);
                
            <?php endforeach; ?>
        }
        
        //selectboxに対戦校を追加
        function addOpponent(){
            
            var value = $('#date').val();
            
            if(value == 0){
                $('#display').attr('disabled',true);
            }else{
                
                var len = document.getElementById('opponent').length
                if(len > 1){
                    len--;
                    for(var i = len; i > 0; i--){
                        document.getElementById('opponent').options[i] = null;
                    }
                }
                
                var select = document.getElementById('opponent');
                
                <?php foreach($select['試合'] as $key => $value): ?>
                
                    if(value == <?= "'" .$select['試合'][$key]['日付']. "'" ?>){
                        
                        var option = document.createElement('option');
                        
                        option.setAttribute('value',<?= "'" .$select['試合'][$key]['対戦校']. "'" ?>);
                        option.innerHTML = <?= "'" .$select['試合'][$key]['対戦校']. "'" ?>;
                        
                        select.appendChild(option);
                    }
                    
                <?php endforeach; ?>
            }
            
        }
        
        //selectboxに名前を追加
        function addName(){
            var select = document.getElementById('name');
            
            <?php foreach($select['ユーザ名'] as $key => $value): ?>
                var option = document.createElement('option');
                
                option.setAttribute('value',<?= "'" .$select['ユーザNo'][$key]. "'" ?>);
                option.innerHTML = <?= "'" .$value. "'" ?>;
                
                select.appendChild(option);
                
            <?php endforeach; ?>
        }
        
        //打席結果を表示
        function displayAtbatResult(val,num){
            
            var result;
            
            switch(val){
                
                case 4:
                    result = "安打";
                    break;
                case 5:
                    result = "二塁打";
                    break;
                case 6:
                    result = "三塁打";
                    break;
                case 7:
                    result = "本塁打";
                    break;
                case 8:
                    result = "四球";
                    break;
                case 9:
                    result = "死球";
                    break;
                case 10:
                    result = "ゴロ";
                    break;
                case 11:
                    result = "フライ";
                    break;
                case 12:
                    result = "ライナー";
                    break;
                case 13:
                    result = "三振";
                    break;
                case 14:
                    result = "エラー";
                    break;
                case 15:
                    result = "併殺打";
                    break;
                case 16:
                    result = "犠打・犠飛";
                    break;
            }
            $('#textAtbat' + num).val(result);
        }
        
        function selectCheck(){
                
                if($('#date').val() != 0 &&
                    $('#opponent').val() != 0 &&
                    $('#name').val() != 0){
                    
                    $('#display').attr('disabled',false);    
                }else{
                    $('#display').attr('disabled',true);
                }
            }
            
        function setAttr(){
            
            <?php $number = 1;
            foreach($atbatsum as $key => $value): ?>
            
                if(<?=$key?> == 0){
                    var tab<?=$number?> = document.getElementById('liTab<?=$number?>');
                    tab<?=$number?>.setAttribute('class','active');
                }else{
                    var pagetab<?=$number?> = document.getElementById('pageTab<?=$number?>');
                    pagetab<?=$number?>.setAttribute('class','tab-pane');   
                }
            
            <?php $number = $number + 1;?>
            <?php endforeach;?>
            
        }
                
	</script>
</head>                                                                         
<body>
    <div id="header" class="container-fluid">
        <div class="form-inline">
            <div class="col-sm-10">
                <div class="col-sm-7 form-group">
                    <form name="input_form" action="" method="post">
                        <div class="form-inline">
                            <div class="form-group">
                                <select name="date" id="date" class="form-control" style="width: 150px;" onchange="addOpponent()">
                                    <option value="0">日付を選択</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <select name="opponent" id="opponent" class="form-control" style="width: 150px;" onchange="selectCheck()">
                                    <option value="0">対戦校を選択</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <select name="name" id="name" class="form-control" style="width: 120px;" onchange="selectCheck()">
                                    <option value="0">名前を選択</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <input type="submit" id="display" class="btn btn-primary" value="表示">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" name="" value="" 
                onclick="location.href='<?php echo site_url('/GroupMenu/index/'.$select['グループNo']); ?>'">グループTopに戻る</button>
            </div>
        </div>
    </div>

<!-- タブの生成 -->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <?php $tabNum = 1;
                foreach($atbatsum as $value): ?>
                
            <li id="liTab<?=$tabNum; ?>"><a href="#pageTab<?= $tabNum; ?>" data-toggle="tab"><?php echo $tabNum; ?>打席目</a></li>
            
            <?php $tabNum = $tabNum + 1; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <!-- タブの中身生成 -->
    <div class="tab-content">
        <?php $pageNum = 1;
        foreach($atbatsum as $key => $value): ?>
        
        <div class="tab-pane active" id="pageTab<?=$pageNum;?>">
            <div id="header" class="container-fluid">
                <!-- <?=$data1?>-->
                <div class="col-sm-2 bg-primary" style="text-align: center">
                    <h4><?php echo $atbatsum[$key]['イニング']; ?></h4>
                </div>
                
                <div class="col-sm-5 bg-success" style="text-align: center">
                    <h4>＜打者＞　<?php echo $atbatsum[$key]['打者名']; ?> （<?php echo $atbatsum[$key]['打者利き打ち']; ?>打ち）</h4>
                </div>
        
                <div class="col-sm-5 bg-dangar" style="text-align: center">
                    <h4>＜投手＞　<?php echo $atbatsum[$key]['対戦投手']; ?> （<?php echo $atbatsum[$key]['投手利き手']; ?>投げ）</h4>
                </div>
        
            </div>
            
            <div id="row" class="container-fluid">
                <div id="left" class="col-sm-6 bg-danger">
                    
                    <div class="col-sm-offset-1 col-sm-8 bg-warning">
                        <canvas id="countCanvas<?=$pageNum;?>" width="350" height="60"></canvas>
                    </div>
            
                    <div class="col-sm-offset-1 col-sm-10 bg-danger">
                        <canvas id="lightbox<?=$pageNum;?>" width="25" height="300"></canvas>
                        <canvas id="courseCanvas<?=$pageNum;?>" width="300" height="300" style="background-color: red;"></canvas>
                        <canvas id="leftbox<?=$pageNum;?>" width="25" height="300"></canvas>
                    </div>
                </div>
    
            <div id="right" class="col-sm-6 bg-success">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#home<?=$pageNum;?>" data-toggle="tab">打席状況</a></li>
                  <li><a href="#second<?=$pageNum;?>" data-toggle="tab">走者状況</a></li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active" id="home<?=$pageNum;?>">
			            <div class="col-sm-8 col-sm-offset-2 bg-success">
			                <canvas id="GroundCanvas<?=$pageNum;?>" width="350" height="350" style="background-color: blue;"></canvas>
			            </div>
                            <div class="col-sm-6 bg-danger">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <h4>打席結果：</h4>
                                    </div>
                                
                                    <div class="form-group">
                                        <form name="textatbat">
                                            <input type="text" disabled class="form-control" name="textatBat" id="textAtbat<?=$pageNum?>" value="" style="width: 100px; text-align: center;">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 bg-warning">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <h4>打点：</h4>    
                                    </div>
                            
                                    <div class="form-group">
                                            <input type="text" disabled class="form-control" id="textRbi" value="<?php echo $atbatsum[$key]['打点']; ?>"
                                        style="width: 80px; text-align:center;">
                                    </div>
                                </div>
                            </div>
                </div>
                
                <div class="tab-pane" id="second<?=$pageNum;?>">
                    <div class="center-block">
                            
                        <div class="col-sm-8 col-sm-offset-2 bg-success">   
                            <canvas id="diamondCanvas<?=$pageNum;?>" width="350" height="350" style="background-color: green;"></canvas>
                        </div>
                    </div>
                </div>
		    </div>
        </div>
            </div>
        </div> 
        
        <?php $pageNum = $pageNum + 1; ?>
        <?php endforeach; ?>
    </div>
</body>
</html>
