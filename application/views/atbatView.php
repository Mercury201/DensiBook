<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>打席記録画面</title>
        <!-- <link rel="stylesheet" href="Canvas.css" type="text/css"　media="all" /> -->
        
        <style type="text/css">
            #direction{
                position: absolute;
                top: 60px;
                left: 265px;
                width: 143px;
            }

            #backbutton{
                position: absolute;
                top: 180px;
                left: 550px;
                width: 30px;
            }

            #footer{
                position: absolute;
                top: 600px;
                left: 180px;
                width: 200px;
            }
            
            #footer1{
                position: absolute;
                top: 600px;
                left: 400px;
            }

            #footer2{
                position: absolute;
                top: 600px;
                left: 700px;
                width: 500px;
            }

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
            
            #div1{
	            width: 150px;
	            height: 150px;
	            background:red;
            }
            
        </style>
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        
        <script type="text/javascript">
        
        $(function() {
	        $(img).draggable();
        });
        
            $(function() {
                //button／buttonsetメソッドでボタンに整形
                $('button').button();
                $('input[type="button"]').button();
                $('input[type="submit"]').button();
                $('a').button();
                $('input.only').button();
                $('.group').buttonset();
            });
            
            //アイコンボタンの作成
            $(function() {
                $('button.left').button({
                    icons: {
                        primary: 'ui-icon-arrowthick-1-w'
                    },
                    text: false
                });
                
                $('button.straight').button({
                    icons: {
                        primary: 'ui-icon-bullet'
                    },
                    text: false
                });
                
                $('button.light').button({
                    icons: {
                        primary: 'ui-icon-arrowthick-1-e'
                    },
                    text: false
                });
                
                $('button.lowerleft').button({
                    icons: {
                        primary: 'ui-icon-arrowthick-1-sw'
                    },
                    text: false
                });
                
                $('button.lower').button({
                    icons: {
                        primary: 'ui-icon-arrowthick-1-s'
                    },
                    text: false
                });
                
                $('button.lowerlight').button({
                    icons: {
                        primary: 'ui-icon-arrowthick-1-se'
                    },
                    text: false
                });

            });
            
            var pitchCanArray = new Array(10);//コースキャンバスを保存
            var pitchNumArray = new Array();//投球配列
            var flagArray = 0;//pitchArrayのフラグ
            var pitchNum = 0;//球数
            var countStrike = 0;//ストライクカウント
            var countBall = 0;//ボールカウント
            var flgGround = 0;//グラウンドキャンバスのフラグ
            var typeOfPitchNo = 0;//球種No
            var mouseX;//マウスの絶対x座標
            var mouseY;//マウスの絶対ｙ座標
            var MouseX;//コースのx座標
            var MouseY;//コースのy座標
            var groundMouseX;//打球方向のx座標
            var groundMouseY;//打球方向のy座標
            var Canvas;
            var groundCanvas;
            var ctx;
            var groundctx;
            var img;//コース画像
            var groundimg;//グラウンド画像
            var decision;//判定(ボール、ストライク）
            
            //テスト用変数
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
                
                //キャンバスに絵を描く
                canvasdraw();
                
                //打球方向を書く
                grounddraw();
            };
            
            //コースキャンバスを描く
            function drawCanvas(){
                
                Canvas = document.getElementById('Canvas');
                Canvas.style.position = "absolute";
                Canvas.style.left = "150px";
                Canvas.style.top = "180px";
                
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
                groundCanvas.style.position = "absolute";
                groundCanvas.style.left = "750px";
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
                        $('#light').attr('disabled',true);
                        $('#lowerleft').attr('disabled',true);
                        $('#lower').attr('disabled',true);
                        $('#lowerlight').attr('disabled',true);
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
                    $('#light').attr('disabled',false);
                    $('#lowerleft').attr('disabled',false);
                    $('#lower').attr('disabled',false);
                    $('#lowerlight').attr('disabled',false);
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
            function directionButton(){
                
                $('#left').click(function(e){
                    typeOfPitchNo = 1; 
                });
                
                $('#straight').click(function(e){
                    typeOfPitchNo = 2;
                });
                
                $('#light').click(function(e){
                    typeOfPitchNo = 3; 
                });
                
                $('#lowerleft').click(function(e){
                    typeOfPitchNo = 4;
                });
                
                $('#lower').click(function(e) {
                    typeOfPitchNo = 5;
                });
            
                $('#lowerlight').click(function(e) {
                    typeOfPitchNo = 6;
                });
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
            
            
////////////////////////////////////////テスト用メソッド/////////////////////////////////////////////////
            
            //確認用テストボタン
            function testConfirmation(){
                
                testButNo = pitchNumArray[1][3];
                alert("球種No： " + testButNo + 
                        "\n球数: " + pitchNum);
            }
            
            function submitTestArray(){
                $(':hidden[name="pitchNum"]').val(pitchNum);
                $(':hidden[name="matchNo"]').val(testMatchNo);
                $(':hidden[name="situationNo"]').val(1);
                $(':hidden[name="array"]').val(pitchNumArray);
            }
            
            

            
        </script>
        
    </head>
    <body>
            <canvas id="Canvas" width="350" height="350" style="background-color: red; z-index: 0;">
            </canvas>
            <canvas id="GroundCanvas" width="400" height="400" style="background-color: blue; z-index: 1;">
            </canvas>
            
            <!-- ツールバー風のボタン作成 -->
            <div id="direction" class="ui-widget-header ui-corner-all" style="padding: 10px; background-color:red;">
              <button id="left" class="left" onclick="directionButton()">Left</button>
              <button id="straight" class="straight" onclick="directionButton()">Straight</button>
              <button id="light" class="light" onclick="directionButton()">Light</button>
              <button id="lowerleft" class="lowerleft" onclick="directionButton()">Lowerleft</button>
              <button id="lower" class="lower" onclick="directionButton()">Lower</button>
              <button id="lowerlight" class="lowerlight" onclick="directionButton()">Lowerlight</button>
            </div>
            
            <div id="backbutton">
                <button id="back" class="back">戻る</button>
                <button id="forword" class="forword">進む</button>
            </div>
            
            <div id="footer">
                <form name="countform">
                    <input type="radio" id="rStrike" name="selectCount" id="strikeCount" value="1">
                    <label for="rStrike">ストライク</label>
                    <input type="radio" id="rBall" name="selectCount" id="ballCount" value="2">
                    <label for="rBall">ボール</label>
                </form>
            </div>
            
            <div id="footer1">
                <button id="confirm" class="confirm" onclick="pushConfirm()">投球確定</button>
            </div>
            
            <div id="footer2">
                
                <form name="input_form" action="<?php echo site_url('/TestTakuma/atbatResult'); ?>" method="post">
                    <select name="atbatresult" id="atbatResult">
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
                    
                    <!-- 球数,試合No,状況No -->
                    <input type="hidden" name="pitchNum" value="" />
                    <input type="hidden" name="matchNo" value=""/>
                    <input type="hidden" name="situationNo" value=""/>
                    <!-- 投球内容 -->
                    <input type="hidden" name="array" value="" />
                     
                    <input type="submit" id="nextbutter" value="打席確定" onclick="submitAtbatResult()">
                </form>
            </div>
            
            <div id="div1" style="z-index: 2;">
    </body>
</html>