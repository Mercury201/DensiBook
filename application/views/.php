<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../user_guide/_images/images.jpg" />
        <title>打席記録画面</title>
        <!-- <link rel="stylesheet" href="Canvas.css" type="text/css"　media="all" /> -->
        
        <style type="text/css">
        
            select{
                width: 100px;
            }
            
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
            
            /* 表示領域全体 */
		div.sample div.sampletabbox {margin: 0px; width: 500px;}
		/* タブ部分 */
		div.sample p.sampletabs { margin: 0px; padding: 0px; }
		div.sample p.sampletabs a { display: block; width: 10em; float: left; margin: 0px 1px 0px 0px; padding: 3px; text-align: center; border-radius: 12px 12px 0px 0px; }
		div.sample p.sampletabs a.sampletab1 { background-color: blue;  color: black; }
		div.sample p.sampletabs a.sampletab2 { background-color: #aaaa00; color: black; }
		div.sample p.sampletabs a:hover { color: yellow; text-decoration: underline; }
		/* 対応表示領域 */
		div.sample div.sampletab { height: 500px; overflow: auto; clear: left; }
		div.sample div#sampletab1 { border: 3px solid blue;  background-color: white; }
		div.sample div#sampletab2 { border: 3px solid #aaaa00; background-color: #ffffcc; }
		div.sample div.sampletab p { margin: 0.5em; }
		/* 装飾（今回のテクニックとは無関係） */
		div.sample div.sampletab ul, div.sampletab ol { margin-top: 0.5em; margin-bottom: 0.5em; }
		div.sample div.sampletab li { line-height: 1.35; margin-bottom: 0px; margin-top: 0px; }
		div.sample div.sampletab ul li { list-style-type: disc; }
		div.sample div.sampletab p.tabhead { font-weight: bold; border-bottom: 3px double gray; }

            
        </style>
        
        
        <link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url();?>css/jquery-ui-bootstrap-masterbs3/css/custom-theme/jquery-ui-1.10.3.custom.css">
        
        
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="<?=base_url();?>js/bootstrap.min.js"></script>
        
        
        <script type="text/javascript">
        
        
        /*どうやらこの書き方ではいけないらしい
            $("#lowerright").button({
               icons: {
                   primary: 'ui-icon-arrowthick-1-se'
               } 
            });
        */  
          
            
            var pitchCanArray = new Array(10);//コースキャンバスを保存
            var pitchNumArray = new Array();//投球配列
            var flagArray = 0;//pitchArrayのフラグ
            var pitchNum = 0;//球数
            var countStrike = 0;//ストライクカウント
            var countBall = 0;//ボールカウント
            var flgGround = 0;//グラウンドキャンバスのフラグ
            var typeOfPitchNo = 0;//球種No
            var runnerflag = 0;//ランナーキャンバスフラグ
            var firstRunner = true;//一塁走者(false:なし/true:あり)
            var secondRunner = false;//二塁走者
            var ThirdRunner = false;//三塁走者
            var mouseX;//マウスの絶対x座標
            var mouseY;//マウスの絶対ｙ座標
            var MouseX;//コースのx座標
            var MouseY;//コースのy座標
            var groundMouseX;//打球方向のx座標
            var groundMouseY;//打球方向のy座標
            var Canvas;
            var groundCanvas;
            var runnerCanvas;
            var ctx;
            var groundctx;
            var runnerctx;
            var firstRunnerctx;
            var secondRunnerctx;
            var img;//コース画像
            var groundimg;//グラウンド画像
            var runnerimg;//ランナー画像
            var decision;//判定(ボール、ストライク）
            
            //テスト用変数
            var runnerArray = new Array();
            var testX;
            var testY;
            var testButNo;
            var testDecidion;
            var testArray = [
                [1,2,3,4],
                [5,6,7,8]
                ];
            var testMatchNo = 33;
            
            
            ///////////////////////メインメソッド///////////////////////
            window.onload = function(){
                 
                //確定ボタンを押せなくする
                $('#confirm').attr('disabled',true);
                //戻るボタンを押せなくする
                $('#back').attr('disabled',true);
                
                //キャンバスの初期処理
                drawCanvas();
                drawgroundCanvas();
                drawrunnerCanvas();
                
                //投球内容を描く
                canvasdraw();
                
                //打球方向を書く
                grounddraw();
            };  
            
            //コースキャンバスを描く
            function drawCanvas(){
                
                Canvas = document.getElementById('Canvas');
                //Canvas.style.position = "absolute";
                //Canvas.style.left = "150px";
                //Canvas.style.top = "180px";
                
                //2dコンテキスト
                ctx = Canvas.getContext('2d');
                
                //表示画像を指定
                img = new Image();
                img.src = "../../user_guide/_images/course_1.jpg";
                
                //画像の読み込み、表示
                img.onload = function(){
                    ctx.drawImage(img,0,0,350,350);
                }
                
                //キャンバスの初期状態を保存
                //pitchArray[flagArray] = ctx.getImageData(0, 0, Canvas.width, Canvas.height);
            }
            
            //グラウンドキャンバスを描く
            function drawgroundCanvas(){
                
                groundCanvas = document.getElementById('GroundCanvas');
                groundCanvas.style.left = "150px";
                groundCanvas.style.top = "180px";
                
                //2dコンテキスト
                groundctx = groundCanvas.getContext('2d');
                
                //表示画像を指定
                groundimg = new Image();
                groundimg.src = "../../user_guide/_images/ground.jpg";
                
                //画像の読み込み、表示
                groundimg.onload = function(){
                    groundctx.drawImage(groundimg,0,0,400,400);
                }
            }
            
            //ランナーキャンバスを描く
            function drawrunnerCanvas(){
                
                runnerCanvas = document.getElementById('runnerCanvas');
                runnerCanvas.style.left = "150px";
                runnerCanvas.style.top = "180px";
                
                //2dコンテキスト
                runnerctx = runnerCanvas.getContext('2d');
                
                //表示画像を指定
                groundimg = new Image();
                groundimg.src = "../../user_guide/_images/ground.jpg";
                
                //画像の読み込み、表示
                groundimg.onload = function(){
                    runnerctx.drawImage(groundimg,0,0,400,400);
                }
            }
            
            
            //ランナーを描く
            function drawRunner(){
                
                if(firstRunner){
                
                    //表示画像を指定
                    runnerimg = new Image();
                    runnerimg.src = "../../user_guide/_images/runner.jpg";
                    
                    //画像の読み込み、表示
                    runnerimg.onload = function(){
                    
                        runnerctx.drawImage(runnerimg,270,230,20,30);
                    }
                    firstRunner = false;
                }
                
                if(secondRunner){
                    
                    //表示画像を指定
                    runnerimg = new Image();
                    runnerimg.src = "../../user_guide/_images/runner.jpg";
                    
                    runnerimg.onload = function(){
                        runnerctx.drawImage(runnerimg,190,140,20,30);
                    }
                }
                
                secondRunner = true;
            }
            
            //投球を記録する
            function canvasdraw(){
                
                //mousedown event listener関数を設定
                Canvas.onmousedown = mouseDownListener;
                
                function mouseDownListener(e){
                    //座標調整
                    adjustXY(e);
                    
                    //左ボタン
                    if(typeOfPitchNo == 1){
                        
                        //左三角を描く
                        ctx.beginPath();
                        ctx.fillStyle = "#000000";
                        ctx.moveTo(mouseX+10, mouseY-10);
                        ctx.lineTo(mouseX+10, mouseY+10);
                        ctx.lineTo(mouseX-10, mouseY);
                        ctx.closePath();
                        ctx.fill();
                    }
                    
                    //ストレートボタン
                    if(typeOfPitchNo == 2){
                    
                        //円を描く
                        ctx.beginPath();
                        ctx.fillStyle = "#000000";
                        ctx.arc(mouseX, mouseY, 10, 0, Math.PI * 2, false);
                        ctx.fill();
                    
                    }
                    
                    //右ボタン
                    if(typeOfPitchNo == 3){
                        
                        //右三角を描く
                        ctx.beginPath();
                        ctx.fillStyle = "#000000";
                        ctx.moveTo(mouseX-10, mouseY-10);
                        ctx.lineTo(mouseX-10, mouseY+10);
                        ctx.lineTo(mouseX+10, mouseY);
                        ctx.closePath();
                        ctx.fill();
                    }
                    
                    //右下ボタン
                    if(typeOfPitchNo == 4){
                        
                        //右下三角を描く
                        ctx.beginPath();
                        ctx.fillStyle = "#000000";
                        ctx.moveTo(mouseX,mouseY-14);
                        ctx.lineTo(mouseX+14,mouseY);
                        ctx.lineTo(mouseX-7,mouseY+7);
                        ctx.closePath();
                        ctx.fill();
                        
                    }
                    
                    //下ボタン
                    if(typeOfPitchNo == 5){
                        
                        //下三角を描く
                        ctx.beginPath();
                        ctx.fillStyle = "#000000";
                        ctx.moveTo(mouseX-10,mouseY-10);
                        ctx.lineTo(mouseX+10,mouseY-10);
                        ctx.lineTo(mouseX,mouseY+10);
                        ctx.closePath();
                        ctx.fill();
                    }
                    
                    //右下ボタン
                    if(typeOfPitchNo == 6){
                        
                        //右下三角を描く
                        ctx.beginPath();
                        ctx.fillStyle = "#000000";
                        ctx.moveTo(mouseX,mouseY-14);
                        ctx.lineTo(mouseX-14,mouseY);
                        ctx.lineTo(mouseX+7,mouseY+7);
                        ctx.closePath();
                        ctx.fill();
                        
                    }
                    
                    if(typeOfPitchNo != 0){
                        
                        MouseX = mouseX;
                        MouseY = mouseY;
                        
                        //コース座標の描画
                        console.log("X座標：" + MouseX);
                        console.log("Y座標：" + MouseY);
                        
                        //キャンバスの情報を保存
                        saveImageDate();
                    
                        //戻る、確定ボタンON
                        $('#back').attr('disabled',false);
                        $('#confirm').attr('disabled',false);
                      
                        //球種ボタン,キャンバスoff
                        $('#left').attr('disabled',true);
                        $('#straight').attr('disabled',true);
                        $('#right').attr('disabled',true);
                        $('#lowerleft').attr('disabled',true);
                        $('#lower').attr('disabled',true);
                        $('#lowerright').attr('disabled',true);
                        $('#Canvas').attr('disabled',true);
                    }
                }
            }
            
            //キャンバスの状態を保存する
            function saveImageDate(){
                ++flagArray;
                //配列に投球格納
                pitchCanArray[flagArray] = ctx.getImageData(0, 0, Canvas.width, Canvas.height);
            }
            
            //打球方向を書く
            function grounddraw(){
                
                    groundCanvas.onmousedown = mouseDownListener;
                    function mouseDownListener(e){
                    
                        //座標調整
                        adjustXY(e);
                    
                    if(flgGround == 0){
                        
                        //打球方向を書く
                        groundctx.beginPath();
                        groundctx.fillStyle = "#000000";
                        groundctx.moveTo(197,354);
                        groundctx.lineTo(mouseX,mouseY);
                        groundctx.closePath();
                        groundctx.stroke();
                        
                        flgGround = 1;
                    }
                }
            }
            
            
            
            //マウスの絶対座標位置を取得
            function adjustXY(e){
                var rect = e.target.getBoundingClientRect();
                mouseX = e.clientX - rect.left;
                mouseY = e.clientY - rect.top;
            }
            
            //投球を確定する
            function pushConfirm(){
                
                //コース、球種の記録を格納する
                if(document.countform.rStrike.checked
                     || document.countform.rBall.checked){
                    
                    judgment();
                }else{
                    //打球方向、打席結果の記録に移る
                    alert("打球方向を記録しますか？");
                }
                
                //戻る、確定ボタンON
                    $('#back').attr('disabled',true);
                    $('#confirm').attr('disabled',true);
                      
                    //球種ボタン,キャンバスoff
                    $('#left').attr('disabled',false);
                    $('#straight').attr('disabled',false);
                    $('#right').attr('disabled',false);
                    $('#lowerleft').attr('disabled',false);
                    $('#lower').attr('disabled',false);
                    $('#lowerright').attr('disabled',false);
                    $('#Canvas').attr('disabled',false);
            }
            
            //ストライク、ボールの判定、投球記録
            function judgment(){
                decision = $("[name=selectCount]:checked").val();
                
                    //配列の初期化
                    pitchNumArray[pitchNum] = new Array();
                
                    //投球情報格納
                    pitchNumArray[pitchNum][0] = MouseX;
                    pitchNumArray[pitchNum][1] = MouseY;
                    pitchNumArray[pitchNum][2] = decision;
                    pitchNumArray[pitchNum][3] = typeOfPitchNo;
                    ++pitchNum;
                    
                    alert("確定しました");
                    
                    $("input[name=selectCount]").attr("checked",false);
                    
                    //ストレイク、ボールカウント計算
                    if(decision == "strike"){
                        ++countStrike;
                        alert(countStrike);
                    }else{
                        ++countBall;
                        alert(countBall);
                    }
            }
            
            //押されたボタン取得
            function pushLeft(){
                typeOfPitchNo = 1;
            }
            
            function pushStraight(){
                typeOfPitchNo = 2;
            }
            
            function pushRight(){
                typeOfPitchNo = 3;
            }
            
            function pushLowerLeft(){
                typeOfPitchNo = 4;
            }
            
            function pushLower(){
                typeOfPitchNo = 5;
            }
            
            function pushLowerRight(){
                typeOfPitchNo = 6;
            }
            
            //戻るボタン
            $('#back').click(function(e){
                
                --flagArray;
                ctx.putImageData(pitchCanArray[flagArray], 0, 0);
                drawCanvas();
                $('#back').attr('disabled',true);
            });
            
            $('#forword').click(function(e){
                
                ++flagArray;
                ctx.putImageData(pitchCanArray[flagArray],0 ,0);
            });
            
            //投球内容、打席結果を格納する
            function submitAtbatResult(){
                
                //球数
                $(':hidden[name="pitchNum"]').val(pitchNum);
                //試合No
                $(':hidden[name="matchNo"]').val(testMatchNo);
                //状況No
                $(':hidden[name="situationNo"]').val(1);
                //投球内容（配列）
                $(':hidden[name="array"]').val(pitchNumArray);
            }
            
		function ChangeTab(tabname) {
			// 全部消す
			document.getElementById('sampletab1').style.display = 'none';
			document.getElementById('sampletab2').style.display = 'none';
			// 指定箇所のみ表示
			if(tabname) {
				document.getElementById(tabname).style.display = 'block';
			}
		}
	</script>

</head>
<body>
    
    <div id="header" class="container-fluid bg-primary">
        <h4>1番 <?php echo "Takuma";?></h4>
    </div>

    <div id="row" class="container-fluid">
        <div id="left" class="col-sm-6 bg-danger">
            <div class="col-sm-offset-4 col-sm-4 col-sm-offset-4 bg-success">
                
                https://jquery-ui-bootstrap.github.io/jquery-ui-bootstrap/components.html#block-icons
                
                <!-- ツールバー風のボタン作成 -->
                <div id="direction" class="btn-group">
                    <button id="left" class="btn btn-primary" onclick="pushLeft()">
                        <i class="glyphicon glyphicon-triangle-left"></i>
                    </button>
                    <button id="straight" class="btn btn-primary" onclick="pushStraight()">
                        <i class="glyphicon glyphicon-triangle-left"></i>
                    </button>
                    <button id="right" class="btn btn-primary" onclick="pushRight()">
                        <i class="glyphicon glyphicon-triangle-right"></i>
                    </button>
                    <br>
                    <button id="lowerleft" class="btn btn-primary" onclick="pushLowerLeft()">
                        <i class="glyphicon glyphicon-triangle-left"></i>
                    </button>
                    <button id="lower" class="btn btn-primary" onclick="pushLower()">
                        <i class="glyphicon glyphicon-triangle-left"></i>
                    </button>
                    <button id="lowerright" class="btn btn-primary" onclick="pushLowerRight()">
                        <i class="ui-icon ui-icon-carat-1-n"></i>
                    </button>
                </div>
            </div>
            <div class="col-sm-12 bg-primary">
                <h1></h1>
            </div>
            
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2 bg-warning">
            <canvas id="Canvas" width="350" height="350" style="background-color: red;"></canvas>
            </div>
            
            <div class="col-sm-3 bg-primary">
                <button id="back" class="btn btn-primary" onclick="">戻る</button>
            </div>
            
            <div class="col-sm-5 bg-success">
                <form name="countform">
                    <input type="radio" id="rStrike" name="selectCount" id="strikeCount" value="1">
                    <label for="rStrike">ストライク</label>
                    <input type="radio" id="rBall" name="selectCount" id="ballCount" value="2">
                    <label for="rBall">ボール</label>
                </form>    
            </div>
            
            <div class="col-sm-4 bg-warning">
                <button id="confirm" class="btn btn-primary" onclick="pushConfirm()">投球確定</button>
            </div>
        </div>
    
        <div id="right" class="col-sm-6 bg-success">
            <div class="center-block">
                <div class="sample" id="tabbox">
		        <div class="sampletabbox">
			        <p class="sampletabs">
				        <a onclick="ChangeTab('sampletab1'); return false;" class="sampletab1" href="#sampletab1">打席状況</a>
				        <a onclick="ChangeTab('sampletab2'); drawRunner(); return false;" class="sampletab2" href="#sampletab2">走者状況</a>
			        </p>
			        
			        <div class="sampletab" id="sampletab1">
			
                        <canvas id="GroundCanvas" width="400" height="400" style="background-color: blue; z-index: 1;"></canvas>
            
                    <div id="footer2">
                
                        <form name="input_form" action="<?php echo site_url('/TestTakuma/atbatResult'); ?>" method="post">
                            <select name="atbatresult" id="atbatResult" class="form-control" style="width: 150px;">
                                <option value="見逃し三振">見逃し三振</option>
                                <option value="空振り三振">空振り三振</option>
                                <option value="一ゴロ">一ゴロ</option>
                                <option value="二ゴロ">二ゴロ</option>
                        <option value="三ゴロ">三ゴロ</option>
                        <option value="遊ゴロ">遊ゴロ</option>
                        <option value="投ゴロ">投ゴロ</option>
                        <option value="捕ゴロ">捕ゴロ</option>
                        <option value="四球">四球</option>
                        <option value="死球">死球</option>
                        <option value="左安打">左安打</option>
                        <option value="右安打">右安打</option>
                        <option value="中安打">中安打</option>
                        <option value="左中２安打">左中２安打</option>
                        <option value="右中２安打">右中２安打</option>
                            </select>
                            
                            <select name="rbi" class="form-control" value="打点" style="width: 100px;">
                                <option value="0"　checked>0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            
                            <select name="score" class="form-control" value="得点" style="width: 100px;">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                    
                    <!-- 球数,試合No,状況No -->
                    <input type="hidden" name="pitchNum" value="" />
                    <input type="hidden" name="matchNo" value=""/>
                    <input type="hidden" name="situationNo" value=""/>
                    <!-- 投球内容 -->
                    <input type="hidden" name="array" value="" />
                     
                    <input type="submit" id="nextbutter" class="btn btn-primary" value="打席確定" onclick="submitAtbatResult()">
                </form>
                <ul class="nav nav-tabs">
  <li class="active"><a href="#home" data-toggle="tab">home</a></li>
  <li><a href="#second" data-toggle="tab">second</a></li>
  <li><a href="#third" data-toggle="tab">third</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="home">ホーム</div>
  <div class="tab-pane" id="second">セカンド</div>
  <div class="tab-pane" id="third">サード</div>
</div>

                
            </div>
			</div>
			<div class="sampletab" id="sampletab2">
				<canvas id="runnerCanvas" width="400" height="400" style="background-color: green;">
            </canvas>
			</div>
            </div>
        </div>
	</div>
		<script type="text/javascript">
			// デフォルトのタブを選択
			ChangeTab('sampletab1');
		</script>
	</div>
</body>
</html>
