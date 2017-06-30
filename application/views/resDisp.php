<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
            
            var pitchCanArray = new Array();//コースキャンバスを保存
            var battedBallArray = new Array();//打球キャンバスを保存
            var pitchNumArray = new Array();//投球配列
            var cRunnerArray = new Array();//ランナーチェックボックス配列
            var runnerArray = new Array();//ランナー配列
            var battedArray = new Array();//打席確定直後のランナー配列
            var finalBattedArray = new Array();//最終のランナー配列
            var stealArray = new Array();//盗塁配列
            var outStealArray = new Array();//盗塁死配列
            var advanceArray = new Array();//進塁配列
            var scoreArray = new Array();//得点配列
            
            //pitchArrayのフラグ
            var pitchArrayflag = 0;
            //投球されたかどうかのフラグ
            var pitchflag = 0;
            //battedArrayのフラグ
            var battedBallArrayflag = 0;
            //進塁打のフラグ
            var atbatAdvanceFlag = 0;
            //打席途中の進塁フラグ
            var advanceFlag = 0;
            //打席確定フラグ
            var battedflag = 0;
            //グラウンドキャンバスのフラグ
            var flgGround = 0;
            //ランナーキャンバスフラグ
            var runnerflag = 0;
            //バッターランナーフラグ(打者が出塁したか)
            var batRunflag = 0;
            //ランナー状況変更有フラグ
            var runChangeflag = 0;
            //アウトカウントが加算された場合のフラグ
            var afteroutcountflag = 0;
            //確定後ランナー変更済フラグ
            var battedChangeRunflag = 0;
            
            var pitchNum = 0;//球数
            var countStrike = 0;//ストライクカウント
            var countBall = 0;//ボールカウント
            var typeOfPitchNo = 0;//球種No
            var stealNum = 0;//盗塁数
            var outStealNum = 0;//盗塁死数
            var advanceNum = 0;//進塁数
            var advancePlayerNum = 0;//進塁した選手の数
            var countScore = 0;//スコア
            
            
            var atbatResultVal//打席結果セレクトボックスのvalue値
            var decision;//判定(ボール、ストライク）
            var afteroutCount;//打席確定後のアウトカウント
            
            //打者ランナー(boolean)
            var batterRunner = false
            //一塁走者(false:なし/true:あり);
            var firstRunner = false;
            //二塁走者
            var secondRunner = false;
            //三塁走者
            var thirdRunner = false;
            
            var mouseX;//マウスの絶対x座標
            var mouseY;//マウスの絶対ｙ座標
            var MouseX;//コースのx座標
            var MouseY;//コースのy座標
            var groundMouseX;//打球方向のx座標
            var groundMouseY;//打球方向のy座標
            
            var countCanvas;
            var lightBoxCanvas;
            var courseCanvas;
            var leftBoxCanvas;
            var groundCanvas;
            var diamondCanvas;
            
            var countctx;
            var leftBoxctx;
            var coursectx;
            var lightBoxctx;
            var groundctx;
            var diamondctx;
            var firstRunnerctx;
            var secondRunnerctx;
            
            var lightBoximg;//右打席画像
            var courseimg;//コース画像
            var leftBoximg;//左打席画像
            var groundimg;//グラウンド画像
            var diamondimg;//ダイヤモンド画像
            var firstrunnerimg;//1塁ランナー画像
            var secondrunnerimg;//2塁ランナー画像
            var Thirdrunnerimg;//3塁ランナー画像
            
            //テスト用変数
            //var RunnerArray = [111,0,0];//playerNoを格納している
            var testX;
            var testY;
            var testButNo;
            var testDecidion;
            var testArray = [
                [1,2,3,4],
                [5,6,7,8]
                ];
            
            ///////////////////////メインメソッド///////////////////////
            window.onload = function(){
                
                //を押せなくする
                $('#display').attr('disabled',true);
                $('#rbi').attr('disabled',true);
                $('#textResult').attr('disabled',true);
                
                //runnerArray = [batterNo,firstRunnerNo,secondRunnerNo,thirdRunnerNo];
                
                //キャンバスの初期処理
                drawCountCanvas();
                drawLightBoxCanvas();
                drawCourseCanvas();
                drawLeftBoxCanvas();
                drawgroundCanvas();
                drawdiamondCanvas();
                
                addDate();
                //addOpponent();
                addName();
            };
            
            //カウントを描く
            function drawCountCanvas(){
                
                countCanvas = document.getElementById('countCanvas');   
                
                //2dコンテキスト
                countctx = countCanvas.getContext('2d');
                
                countctx.fillStyle = "black";
                countctx.font = "30px 'ＭＳ ゴシック'";
                countctx.textAlign = "left";
                countctx.textBaseline = "top";

                countctx.fillText("B",5,20);
                countctx.beginPath();
                countctx.arc(40, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                countctx.beginPath();
                countctx.arc(71, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                countctx.beginPath();
                countctx.arc(101, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                
                countctx.fillText("S",144,20);
                countctx.beginPath();
                countctx.arc(179, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                countctx.beginPath();
                countctx.arc(210, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                
                countctx.fillText("O",255,20);
                countctx.beginPath();
                countctx.arc(290, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                
                countctx.beginPath();
                countctx.arc(321, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
            }
            
            //右打席を描く
            function drawLightBoxCanvas(){
                
                lightBoxCanvas = document.getElementById('lightbox');
                
                //2dコンテキスト
                lightBoxctx = lightBoxCanvas.getContext('2d');
                
                //表示画像を指定
                lightBoximg = new Image();
                lightBoximg.src = "<?=base_url('user_guide/_images/lightbox.jpg')?>";
                
                //画像の読み込み、表示
                lightBoximg.onload = function(){
                    lightBoxctx.drawImage(lightBoximg,0,0,25,300);
                }
            }
            
            //コースキャンバスを描く
            function drawCourseCanvas(){
                
                courseCanvas = document.getElementById('courseCanvas');
                
                //2dコンテキスト
                coursectx = courseCanvas.getContext('2d');
                
                //表示画像を指定
                courseimg = new Image();
                courseimg.src = "<?=base_url('user_guide/_images/course_2.jpg')?>";
                
                //画像の読み込み、表示
                courseimg.onload = function(){
                    coursectx.drawImage(courseimg,0,0,300,300);
                }
            }
            
            //左打席キャンバスを描く
            function drawLeftBoxCanvas(){
                
                leftBoxCanvas = document.getElementById('leftbox');
                
                //2dコンテキスト
                leftBoxctx = leftBoxCanvas.getContext('2d');
                
                //表示画像を指定
                leftBoximg = new Image();
                leftBoximg.src = "<?=base_url('user_guide/_images/leftbox.jpg')?>";
                
                //画像の読み込み、表示
                leftBoximg.onload = function(){
                    leftBoxctx.drawImage(leftBoximg,0,0,25,300);
                }
            }
            
            //グラウンドキャンバスを描く
            function drawgroundCanvas(){
                
                groundCanvas = document.getElementById('GroundCanvas');
                
                //2dコンテキスト
                groundctx = groundCanvas.getContext('2d');
                
                //表示画像を指定
                groundimg = new Image();
                groundimg.src = "<?=base_url('user_guide/_images/ground.jpg')?>";
                
                //画像の読み込み、表示
                groundimg.onload = function(){
                    groundctx.drawImage(groundimg,0,0,350,350);
                }
            }
            
            //ダイヤモンドキャンバスを描く
            function drawdiamondCanvas(){
                
                diamondCanvas = document.getElementById('diamondCanvas');
                
                //2dコンテキスト
                diamondctx = diamondCanvas.getContext('2d');
                
                //表示画像を指定
                diamondimg = new Image();
                diamondimg.src = "<?=base_url('user_guide/_images/diamond.jpg')?>";
                
                //画像の読み込み、表示
                diamondimg.onload = function(){
                    diamondctx.drawImage(diamondimg,0,0,350,350);
                }
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
            
            function selectCheck(){
                
                if($('#date').val() != 0 &&
                    $('#opponent').val() != 0 &&
                    $('#name').val() != 0){
                    
                    $('#display').attr('disabled',false);    
                }else{
                    $('#display').attr('disabled',true);
                }
            }
                
            //////////////投球、打撃、走者(進塁)の情報が取れているか確認////////////
        
            function testDataGet(){
                
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
                                <select name="date" id="date" class="form-control" onchange="addOpponent()" style="width: 150px;">
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
                
                <div class="form-group">
                    <h4>検索項目を選択して下さい</h4>
                </div>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" name="" value="" 
                onclick="location.href='<?php echo site_url('/GroupMenu/index/'.$select['グループNo']); ?>'">グループTopに戻る</button>
            </div>
        </div>
    </div>
    
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">デモ打席</a></li>
        </ul>
    </div>
    
    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <div id="header" class="container-fluid">
            <!-- <?=$data1?>-->
                <div class="col-sm-2 bg-primary" style="text-align: center">
                    <h4> 回 </h4>
                </div>
                
                <div class="col-sm-5 bg-danger" style="text-align: center">
                    <h4> ＜打者＞  　　（　打ち）</h4>
                </div>
                
                <div class="col-sm-5 bg-success" style="text-align: center">
                    <h4> ＜投手＞  　　（　投げ）</h4>
                </div>
            </div>
        
            <div id="row" class="container-fluid">
                <div id="left" class="col-sm-6 bg-danger">
                    <div class="col-sm-offset-2 col-sm-8 bg-warning">
                        <canvas id="countCanvas" width="350" height="60"></canvas>
                    </div>
                    
                    <div class="col-sm-offset-1 col-sm-10 bg-danger">
                        <canvas id="lightbox" width="25" height="300"></canvas>
                        <canvas id="courseCanvas" width="300" height="300" style="background-color: red;"></canvas>
                        <canvas id="leftbox" width="25" height="300"></canvas>
                    </div>
                </div>
            
                <div id="right" class="col-sm-6 bg-success">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#home1" data-toggle="tab">打席状況</a></li>
                          <li><a href="#second" data-toggle="tab">走者状況</a></li>
                        </ul>
                        
                    <div class="tab-content">
                        <div class="tab-pane active" id="home1">
                            
        			        <div class="col-sm-8 col-sm-offset-2 bg-success">
        			            <canvas id="GroundCanvas" width="350" height="350" style="background-color: blue;"></canvas>
        			        </div>
                                
                                <form name="input_form" action="<?php echo site_url('/EntryMember/receiveAtbatData'); ?>" method="post"
                                    onsubmit="return submitAtbatResult()">
                                    
                                    <div class="col-sm-6 bg-danger">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <h4>打席結果：</h4>
                                            </div>
                                        
                                            <div class="form-group">
                                                <input type="text" disabled id="textResult" class="form-control" style="width: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6 bg-warning">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <h4>打点：</h4>    
                                            </div>
                                    
                                            <div class="form-group">
                                                <input type="text" disabled class="form-control" id="textRbi" value=""
                                                style="width: 80px; text-align:center;">
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        
                        <div class="tab-pane" id="second">
                            <div class="center-block">
                                <div class="col-sm-8 col-sm-offset-2 bg-success">   
                                    <canvas id="diamondCanvas" width="350" height="350" style="background-color: green;"></canvas>
                                </div>
                            </div>
                        </div>
        		    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
