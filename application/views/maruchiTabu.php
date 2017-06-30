<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../user_guide/_images/images.jpg" />
        <title>タブ作成画面</title>
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
            
            var tab1;
            var pagetab2;
            var pagetab3;
            
            var lightBoximg;//右打席画像
            var courseimg;//コース画像
            var leftBoximg;//左打席画像
            var groundimg;//グラウンド画像
            var diamondimg;//ダイヤモンド画像
            var firstrunnerimg;//1塁ランナー画像
            var secondrunnerimg;//2塁ランナー画像
            var Thirdrunnerimg;//3塁ランナー画像
            
            var courseCanvas1;
            var courseCanvas2;
            var courseCanvas3;
            var coursectx1;
            var coursectx2;
            var coursectx3;
            var courseimg1;
            var courseimg2;
            var courseimg3;
            
            
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
                
                //タブのクラス属性追加
                //$('liTab1').attr('class','active');
                setAttr();
                
                //確定ボタンを押せなくする
                $('#confirm').attr('disabled',true);
                $('#runnerConfirm').attr('disabled',true);
                $('#back').attr('disabled',true);
                $('#atbatResult').attr('disabled',true);
                $('#rbi').attr('disabled',true);
                $('#force').attr('disabled',true);
                $('#atbatadvance').attr('disabled',true);
                $('#advancenum').attr('disabled',true);
                $('#out').attr('disabled',true);
                $('#bunt').attr('disabled',true);
                $('#cBatterRun').attr('disabled',true);
                //$('#nextbatter').attr('disabled',true);
                
                //runnerArray = [batterNo,firstRunnerNo,secondRunnerNo,thirdRunnerNo];
                
                //キャンバスの初期処理
                drawCountCanvas();
                drawLightBoxCanvas();
                drawCourseCanvas();
                drawLeftBoxCanvas();
                drawgroundCanvas();
                drawdiamondCanvas();
                
                //投球内容を描く
                canvasdraw();
                
                //打球方向を書く
                grounddraw();

                mouseButtonHover();
            };
            
            function drawCountCanvas(){
                
                countCanvas = document.getElementById('countCanvas');   
                
                //2dコンテキスト
                countctx = countCanvas.getContext('2d');
                
                countctx.fillStyle = "black";
                countctx.font = "30px 'ＭＳ ゴシック'";
                countctx.textAlign = "left";
                countctx.textBaseline = "top";

                countctx.fillText("B",15,20);
                countctx.beginPath();
                countctx.arc(50, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                countctx.beginPath();
                countctx.arc(81, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                countctx.beginPath();
                countctx.arc(111, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                
                countctx.fillText("S",154,20);
                countctx.beginPath();
                countctx.arc(189, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                countctx.beginPath();
                countctx.arc(220, 35, 13, 0, Math.PI*2, false);
                countctx.stroke();
                
                countctx.fillText("O",265,20);
                drawoutCount();
            }
            
            //右打席を描く
            function drawLightBoxCanvas(){
                
                lightBoxCanvas = document.getElementById('lightbox');
                
                //2dコンテキスト
                lightBoxctx = lightBoxCanvas.getContext('2d');
                
                //表示画像を指定
                lightBoximg = new Image();
                lightBoximg.src = "../../user_guide/_images/lightbox.jpg";
                
                //画像の読み込み、表示
                lightBoximg.onload = function(){
                    lightBoxctx.drawImage(lightBoximg,0,0,25,300);
                }
            }
            
            //コースキャンバスを描く
            function drawCourseCanvas(){
                
                <?php $number = 1;
                foreach($atbatsum as $value): ?>
                
                courseCanvas<?= $number;?> = document.getElementById('courseCanvas<?=$number?>');
                
                //2dコンテキスト
                coursectx<?=$number?> = courseCanvas<?=$number?>.getContext('2d');
                
                //表示画像を指定
                courseimg<?=$number?> = new Image();
                courseimg<?=$number?>.src = "../../user_guide/_images/course_2.jpg";
                
                //画像の読み込み、表示
                courseimg<?=$number?>.onload = function(){
                    coursectx<?=$number?>.drawImage(courseimg<?=$number?>,0,0,300,300);
                }
                <?php $number = $number + 1 ?>
                <?php endforeach; ?>
            }
            
            //左打席キャンバスを描く
            function drawLeftBoxCanvas(){
                
                leftBoxCanvas = document.getElementById('leftbox');
                
                //2dコンテキスト
                leftBoxctx = leftBoxCanvas.getContext('2d');
                
                //表示画像を指定
                leftBoximg = new Image();
                leftBoximg.src = "../../user_guide/_images/leftbox.jpg";
                
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
                groundimg.src = "../../user_guide/_images/ground.jpg";
                
                //画像の読み込み、表示
                groundimg.onload = function(){
                    groundctx.drawImage(groundimg,0,0,350,350);
                    
                    saveGroundImageDate();
                }
            }
            
            //ダイヤモンドキャンバスを描く
            function drawdiamondCanvas(){
                
                diamondCanvas = document.getElementById('diamondCanvas');
                
                //2dコンテキスト
                diamondctx = diamondCanvas.getContext('2d');
                
                //表示画像を指定
                diamondimg = new Image();
                diamondimg.src = "../../user_guide/_images/diamond.jpg";
                
                //画像の読み込み、表示
                diamondimg.onload = function(){
                    diamondctx.drawImage(diamondimg,0,0,350,350);
                }
            }
            
            
            ///////////////ランナーを描く///////////////
            function drawRunner(){
                
                //打者ランナー
                if(runnerArray[0] != 0){
                    
                    //表示画像を指定
                    firstrunnerimg = new Image();
                    firstrunnerimg.src = "../../user_guide/_images/runner.jpg";
                        
                    firstrunnerimg.onload = function(){
                        /*
                        右打者
                        diamondctx.drawImage(firstrunnerimg,130,300,35,45);
                        */
                        diamondctx.drawImage(firstrunnerimg,175,300,35,45);
                    }
                    
                    //ランナーのplayerNoを取得
                    
                }
                
                //1塁ランナー判定
                if(runnerArray[1] != 0){
                    
                    //表示画像を指定
                    firstrunnerimg = new Image();
                    firstrunnerimg.src = "../../user_guide/_images/runner.jpg";
                        
                    firstrunnerimg.onload = function(){
                        diamondctx.drawImage(firstrunnerimg,245,145,40,50);
                    
                        diamondctx.fillStyle = "black";
                        diamondctx.font = "15px 'ＭＳ ゴシック'";
                        diamondctx.textAlign = "left";
                        diamondctx.textBaseline = "top";

                        diamondctx.fillText(firstRunnerName,225,130);
                        
                    }
                    
                    firstRunner = true;
                }
                
                //2塁ランナー判定
                if(runnerArray[2] != 0){
                    
                    //表示画像を指定
                    secondrunnerimg = new Image();
                    secondrunnerimg.src = "../../user_guide/_images/runner.jpg";
                        
                    secondrunnerimg.onload = function(){
                        diamondctx.drawImage(secondrunnerimg,148,30,40,50);
                    
                        diamondctx.fillStyle = "black";
                        diamondctx.font = "15px 'ＭＳ ゴシック'";
                        diamondctx.textAlign = "left";
                        diamondctx.textBaseline = "top";

                        diamondctx.fillText(secondRunnerName,128,15);
                    }
                    
                    secondRunner = true;
                }
                
                //3塁ランナー判定
                if(runnerArray[3] != 0){
                    
                    //表示画像を指定
                    Thirdrunnerimg = new Image();
                    Thirdrunnerimg.src = "../../user_guide/_images/runner.jpg";
                        
                    Thirdrunnerimg.onload = function(){
                        diamondctx.drawImage(Thirdrunnerimg,48,145,40,50);
                    
                        diamondctx.fillStyle = "black";
                        diamondctx.font = "15px 'ＭＳ ゴシック'";
                        diamondctx.textAlign = "left";
                        diamondctx.textBaseline = "top";

                        diamondctx.fillText(thirdRunnerName,28,130);
                    }
                    
                    thirdRunner = true;
                }
                
                if(!firstRunner){
                    $('#cFirstRun').attr('disabled',true);
                }else{
                    $('#cFirstRun').attr('disabled',false);
                }
                
                if(!secondRunner){
                    $('#cSecondRun').attr('disabled',true);
                }else{
                    $('#cSecondRun').attr('disabled',false);
                }
                
                if(!thirdRunner){
                    $('#cThirdRun').attr('disabled',true);
                }else{
                    $('#cThirdRun').attr('disabled',false);
                }
                
            }
            
            function drawoutCount(){
                
                if(outCount == 0){
                    
                    countctx.beginPath();
                    countctx.arc(300, 35, 13, 0, Math.PI*2, false);
                    countctx.stroke();
                    
                    countctx.beginPath();
                    countctx.arc(331, 35, 13, 0, Math.PI*2, false);
                    countctx.stroke();
                }else if(outCount == 1){
                    
                    countctx.beginPath();
                    countctx.fillStyle = 'rgb(255, 00, 00)';
                    countctx.arc(300, 35, 13, 0, Math.PI*2, false);
                    countctx.fill();
                
                    countctx.beginPath();
                    countctx.arc(331, 35, 13, 0, Math.PI*2, false);
                    countctx.stroke();
                }else if(outCount == 2){
                    
                    countctx.beginPath();
                    countctx.fillStyle = 'rgb(255, 00, 00)';
                    countctx.arc(300, 35, 13, 0, Math.PI*2, false);
                    countctx.fill();
                    
                    countctx.beginPath();
                    countctx.fillStyle = 'rgb(255, 00, 00)';
                    countctx.arc(331, 35, 13, 0, Math.PI*2, false);
                    countctx.fill();
                }
            }
            
            //打席確定後の走者状況更新
            function drawbattedRunner(){
                
                //打者ランナー判定
                if(battedArray[0] != 0){
                    
                    //表示画像を指定
                    firstrunnerimg = new Image();
                    firstrunnerimg.src = "../../user_guide/_images/runner.jpg";
                        
                    firstrunnerimg.onload = function(){
                        diamondctx.drawImage(firstrunnerimg,175,300,35,45);
                    }
                    
                    //ランナーのplayerNoを取得
                    
                    batterRunner = true;
                }
                
                //1塁ランナー判定
                if(battedArray[1] != 0){
                    
                    //表示画像を指定
                    secondrunnerimg = new Image();
                    secondrunnerimg.src = "../../user_guide/_images/runner.jpg";
                        
                    secondrunnerimg.onload = function(){
                        diamondctx.drawImage(firstrunnerimg,245,145,40,50);
                    
                        diamondctx.fillStyle = "black";
                        diamondctx.font = "15px 'ＭＳ ゴシック'";
                        diamondctx.textAlign = "left";
                        diamondctx.textBaseline = "top";

                        diamondctx.fillText(firstRunnerName,225,130);
                    }
                    
                    firstRunner = true;
                }
                
                //2塁ランナー判定
                if(battedArray[2] != 0){
                    
                    //表示画像を指定
                    Thirdrunnerimg = new Image();
                    Thirdrunnerimg.src = "../../user_guide/_images/runner.jpg";
                        
                    Thirdrunnerimg.onload = function(){
                        diamondctx.drawImage(secondrunnerimg,148,30,40,50);
                    
                        diamondctx.fillStyle = "black";
                        diamondctx.font = "15px 'ＭＳ ゴシック'";
                        diamondctx.textAlign = "left";
                        diamondctx.textBaseline = "top";

                        diamondctx.fillText(secondRunnerName,128,15);
                    }
                    
                    secondRunner = true;
                }
                
                //3塁ランナー判定
                if(battedArray[3] != 0){
                    
                    //表示画像を指定
                    Thirdrunnerimg = new Image();
                    Thirdrunnerimg.src = "../../user_guide/_images/runner.jpg";
                        
                    Thirdrunnerimg.onload = function(){
                        diamondctx.drawImage(Thirdrunnerimg,48,145,40,50);
                    
                        diamondctx.fillStyle = "black";
                        diamondctx.font = "15px 'ＭＳ ゴシック'";
                        diamondctx.textAlign = "left";
                        diamondctx.textBaseline = "top";

                        diamondctx.fillText(thirdRunnerName,28,130);
                    }
                    
                    thirdRunner = true;
                }
                
                if(!batterRunner){
                    $('#cBatterRun').attr('disabled',true);
                }else{
                    $('#cBatterRun').attr('disabled',false);
                }
                
                if(!firstRunner){
                    $('#cFirstRun').attr('disabled',true);
                }else{
                    $('#cFirstRun').attr('disabled',false);
                }
                
                if(!secondRunner){
                    $('#cSecondRun').attr('disabled',true);
                }else{
                    $('#cSecondRun').attr('disabled',false);
                }
                
                if(!thirdRunner){
                    $('#cThirdRun').attr('disabled',true);
                }else{
                    $('#cThirdRun').attr('disabled',false);
                }
                
            }
            
            //投球を記録する
            function canvasdraw(){
                
                //mousedown event listener関数を設定
                courseCanvas.onmousedown = mouseDownListener;
                
                function mouseDownListener(e){
                    //座標調整
                    adjustXY(e);
                    
                    if(pitchflag == 0){
                        //左ボタン
                        if(typeOfPitchNo == 1){
                        
                            //左三角を描く
                            coursectx.beginPath();
                            coursectx.fillStyle = "#000000";
                            coursectx.moveTo(mouseX+10, mouseY-10);
                            coursectx.lineTo(mouseX+10, mouseY+10);
                            coursectx.lineTo(mouseX-10, mouseY);
                            coursectx.closePath();
                            coursectx.fill();
                        }
                    
                        //ストレートボタン
                        if(typeOfPitchNo == 2){
                    
                            //円を描く
                            coursectx.beginPath();
                            coursectx.fillStyle = "#000000";
                            coursectx.arc(mouseX, mouseY, 10, 0, Math.PI * 2, false);
                            coursectx.fill();
                    
                        }
                    
                        //右ボタン
                        if(typeOfPitchNo == 3){
                        
                            //右三角を描く
                            coursectx.beginPath();
                            coursectx.fillStyle = "#000000";
                            coursectx.moveTo(mouseX-10, mouseY-10);
                            coursectx.lineTo(mouseX-10, mouseY+10);
                            coursectx.lineTo(mouseX+10, mouseY);
                            coursectx.closePath();
                            coursectx.fill();
                        }
                    
                        //右下ボタン
                        if(typeOfPitchNo == 4){
                        
                            //右下三角を描く
                            coursectx.beginPath();
                            coursectx.fillStyle = "#000000";
                            coursectx.moveTo(mouseX,mouseY-14);
                            coursectx.lineTo(mouseX+14,mouseY);
                            coursectx.lineTo(mouseX-7,mouseY+7);
                            coursectx.closePath();
                            coursectx.fill();
                        }
                    
                        //下ボタン
                        if(typeOfPitchNo == 5){
                        
                            //下三角を描く
                            coursectx.beginPath();
                            coursectx.fillStyle = "#000000";
                            coursectx.moveTo(mouseX-10,mouseY-10);
                            coursectx.lineTo(mouseX+10,mouseY-10);
                            coursectx.lineTo(mouseX,mouseY+10);
                            coursectx.closePath();
                            coursectx.fill();
                        }
                    
                        //右下ボタン
                        if(typeOfPitchNo == 6){
                        
                            //右下三角を描く
                            coursectx.beginPath();
                            coursectx.fillStyle = "#000000";
                            coursectx.moveTo(mouseX,mouseY-14);
                            coursectx.lineTo(mouseX-14,mouseY);
                            coursectx.lineTo(mouseX+7,mouseY+7);
                            coursectx.closePath();
                            coursectx.fill();
                        }
                    
                        if(typeOfPitchNo != 0){
                        
                            MouseX = mouseX;
                            MouseY = mouseY;
                        
                            //コース座標の描画
                            console.log("X座標：" + MouseX);
                            console.log("Y座標：" + MouseY);
                        
                            //キャンバスの情報を保存
                            saveCourseImageDate();
                    
                            //戻る、確定ボタンON
                            $('#back').attr('disabled',false);
                            $('#confirm').attr('disabled',false);
                      
                            //球種ボタン,キャンバスoff
                            $('#Left').attr('disabled',true);
                            $('#straight').attr('disabled',true);
                            $('#right').attr('disabled',true);
                            $('#lowerleft').attr('disabled',true);
                            $('#lower').attr('disabled',true);
                            $('#lowerright').attr('disabled',true);
                            $('#Canvas').attr('disabled',true);
                        
                            //球種No初期化
                            pitchflag = 1;
                        }
                    }
                }
            }
            
            //コースキャンバスの状態を保存する
            function saveCourseImageDate(){
                
                // 現在の状態を保存
                if(pitchArrayflag == pitchCanArray.length-1){
                    pitchCanArray.shift();
                }else{
                    ++pitchArrayflag;
                }
                //配列に投球格納
                pitchCanArray[pitchArrayflag] = coursectx.getImageData(0, 0, courseCanvas.width, courseCanvas.height);
            }
            
            //グラウンドキャンバスの状態を保存する
            function saveGroundImageDate(){
                
                // 現在の状態を保存
                if(battedBallArrayflag == battedBallArray.length-1){
                    battedBallArray.shift();
                }else{
                    ++battedBallArrayflag;
                }
                //配列に投球格納
                battedBallArray[battedBallArrayflag] = groundctx.getImageData(0, 0, groundCanvas.width, groundCanvas.height);
            }
            
            //打球方向を書く
            function grounddraw(){
                
                    groundCanvas.onmousedown = mouseDownListener;
                    function mouseDownListener(e){
                    
                        //座標調整
                        adjustXY(e);
                    
                    if(flgGround == 0){
                        
                        Orbit();
                        
                        flgGround = 1;
                    }else if(flgGround == 1){
                        
                        groundctx.putImageData(battedBallArray[1], 0, 0);
                        
                        Orbit();
                    }
                    
                    console.log("X座標：" + mouseX);
                    console.log("Y座標：" + mouseY);
                    
                    groundMouseX = mouseX;
                    groundMouseY = mouseY;
                }
            }
            
            function Orbit(){
                
                //打球方向を書く
                        groundctx.beginPath();
                        groundctx.fillStyle = "#000000";
                        groundctx.moveTo(197,354);
                        groundctx.lineTo(mouseX,mouseY);
                        groundctx.closePath();
                        groundctx.stroke();
            }
            
            //マウスの絶対座標位置を取得
            function adjustXY(e){
                var rect = e.target.getBoundingClientRect();
                mouseX = Math.floor(e.clientX - rect.left);
                mouseY = Math.floor(e.clientY - rect.top);
            }
            
            //投球を確定する
            function pushConfirm(){
                
                //コース、球種の記録を格納する
                if(document.countform.rStrike.checked || 
                    document.countform.rBall.checked ||
                    document.countform.rFarr.checked){
                    
                    judgment();
                    
                    //戻る、確定ボタンOff
                    $('#back').attr('disabled',true);
                    $('#confirm').attr('disabled',true);
                      
                    //球種ボタン,キャンバスON
                    $('#Left').attr('disabled',false);
                    $('#straight').attr('disabled',false);
                    $('#right').attr('disabled',false);
                    $('#lowerleft').attr('disabled',false);
                    $('#lower').attr('disabled',false);
                    $('#lowerright').attr('disabled',false);
                    $('#Canvas').attr('disabled',false);
                }else{
                    //////打球方向,打席結果,走塁状況の記録に移る///////
                    var res = confirm("打球方向を記録しますか？");
                    
                    if(res == true){
                        
                        //打球、走者状況記録に移る
                        
                        $('#atbatResult').attr('disabled',false);
                        $('#rbi').attr('disabled',false);
                        $('#force').attr('disabled',false);
                        $('#atbatadvance').attr('disabled',false);
                        $('#back').attr('disabled',true);
                        $('#confirm').attr('disabled',true);
                        $('#rStrike').attr('disabled',true);
                        $('#rBall').attr('disabled',false);
                        $('#pickOff').attr('disabled',false);
                        $('#balk').attr('disabled',true);
                        $('#bunt').attr('disabled',false);
                        $('#out').attr('disabled',false);
                        $('#cBatterRun').attr('disabled',false);
                        $('#rFarr').attr('disabled',true);
                        
                        
                        //配列の初期化
                        pitchNumArray[pitchNum] = new Array();
                        
                        //打席結果以外の投球内容を配列に格納
                        pitchNumArray[pitchNum][0] = MouseX;
                        pitchNumArray[pitchNum][1] = MouseY;
                        pitchNumArray[pitchNum][3] = typeOfPitchNo;
                        ++pitchNum;
                        
                        afteroutCount = outCount;
                        
                        battedflag = 1;
                        
                        //打席確定後走者状況配列に格納する
                        
                        battedArray[0] = batterNo;
                        battedArray[1] = runnerArray[0];
                        battedArray[2] = runnerArray[1];
                        battedArray[3] = runnerArray[2];
                        
                    }else{
                        
                        alert("カウントをチェックして下さい。")
                    }
                }
                
                typeOfPitchNo = 0;
                
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
                
                pitchflag = 0;
                    
                $("input[name=selectCount]").attr("checked",false);
                
                //ストレイク、ボールカウント計算
                if(decision == 1){
                    if(countStrike  < 3){
                        ++countStrike;    
                    }
                    
                    switch(countStrike){
                        case 1:
                            countctx.beginPath();
                            countctx.fillStyle = 'rgb(255, 255, 00)';
                            countctx.arc(189, 35, 13, 0, Math.PI*2, false);
                            countctx.fill();
                            break;
                        
                        case 2:
                            countctx.beginPath();
                            countctx.fillStyle = 'rgb(255, 255, 00)';
                            countctx.arc(220, 35, 13, 0, Math.PI*2, false);
                            countctx.fill();
                            break;
                        
                        case 3:
                            //打席結果：三振を選択
                            document.getElementById('atbatResult').options[11].selected = true;
                            break;
                    }
                    
                }else if(decision == 2){
                    ++countBall;
                    
                    switch(countBall){
                        case 1:
                            countctx.beginPath();
                            countctx.fillStyle = 'rgb(00, 128, 00)';
                            countctx.arc(50, 35, 13, 0, Math.PI*2, false);
                            countctx.fill();
                            break;
                
                        case 2:
                            countctx.beginPath();
                            countctx.fillStyle = 'rgb(00, 128, 00)';
                            countctx.arc(81, 35, 13, 0, Math.PI*2, false);
                            countctx.fill();
                            break;
                            
                        case 3:
                            countctx.beginPath();
                            countctx.fillStyle = 'rgb(00, 128, 00)';
                            countctx.arc(111, 35, 13, 0, Math.PI*2, false);
                            countctx.fill();    
                            break;
                            
                        case 4:
                            //四球の処理をする
                            document.getElementById('atbatResult').options[5].selected = true;
                            
                            //ランナーの状況も変更する
                    }
                }else{
                    if(countStrike < 2){
                        ++countStrike;
                    }
                    
                    switch(countStrike){
                        case 1:
                            countctx.beginPath();
                            countctx.fillStyle = 'rgb(255, 255, 00)';
                            countctx.arc(189, 35, 13, 0, Math.PI*2, false);
                            countctx.fill();
                            break;
                        
                        case 2:
                            countctx.beginPath();
                            countctx.fillStyle = 'rgb(255, 255, 00)';
                            countctx.arc(220, 35, 13, 0, Math.PI*2, false);
                            countctx.fill();
                            break;
                    }
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
            
            //戻るボタン(コースキャンバス)
            function back(){
                
                --pitchArrayflag;
                coursectx.putImageData(pitchCanArray[pitchArrayflag], 0, 0);
                
                typeOfPitchNo = 0;
                pitchflag = 0;
                
                $('#back').attr('disabled',true);
                
                //球種ボタン,キャンバスON
                $('#Left').attr('disabled',false);
                $('#straight').attr('disabled',false);
                $('#right').attr('disabled',false);
                $('#lowerleft').attr('disabled',false);
                $('#lower').attr('disabled',false);
                $('#lowerright').attr('disabled',false);
                $('#Canvas').attr('disabled',false);
                
                //カウントラジオボタンのチェック外す
                $("input[name=selectCount]").attr("checked",false);
            }
            
            //投球内容、打席結果を格納する
            function submitAtbatResult(){
                
                if($('#atbatResult').val() == 0){
                    
                    alert("打席結果を選択して下さい");
                    
                    return false;
                    
                }else if(runChangeflag == 0){
                    
                    var submitText = confirm("打席、走者の状況を確定する");
                
                    if(submitText == true){
                    
                        //アウトカウント(打席確定前)
                        $(':hidden[name="outCount"]').val(outCount);
                        
                        if(afteroutCount > 3){
                            afteroutCount = 3;
                        }
                        //アウトカウント(打席確定後)
                        $(':hidden[name="afterCount"]').val(afteroutCount);
                        //ストライクカウント
                        $(':hidden[name="StrikeCount"]').val(countStrike);
                        //ボールカウント
                        $(':hidden[name="BallCount"]').val(countBall);
                        //球数
                        $(':hidden[name="pitchNum"]').val(pitchNum);
                        //状況No
                        $(':hidden[name="situationNo"]').val(1);
                
                        //打席結果セレクトボックスのvakue値を格納する
                        pitchNumArray[--pitchNum][2] = $('#atbatResult').val();
                
                        //投球内容（配列）
                        $(':hidden[name="array"]').val(pitchNumArray);
                        //打球方向(x)
                        $(':hidden[name="battedBallx"]').val(groundMouseX);
                        //打球方向(y)
                        $(':hidden[name="battedBally"]').val(groundMouseY);
                
                        if(stealNum > 0){
                    
                            //盗塁Array（配列）
                            $(':hidden[name="stealArray"]').val(stealArray);    
                        }else{
                    
                            //盗塁Array（空白文字）
                            $(':hidden[name="stealArray"]').val("");
                        }
                
                        if(outStealNum > 0){
                    
                            //盗塁死Array（配列）
                            $(':hidden[name="outStealArray"]').val(outStealArray);
                        }else{
                    
                            //盗塁死Array（空白文字）
                            $(':hidden[name="outStealArray"]').val("");
                        }
                
                        //ランナーArray(打席確定前)
                        $(':hidden[name="runnerArray"]').val(runnerArray);
                        
                        finalBattedArray[0] = battedArray[1];
                        finalBattedArray[1] = battedArray[2];
                        finalBattedArray[2] = battedArray[3];
                        
                        
                        //ランナーArray(打席確定後)
                        $(':hidden[name="battedRunnerArray"]').val(finalBattedArray);
                        
                        if(countScore != 0){
                            $('hidden[name="scoreArray"]').val(scoreArray);
                        }else{
                            $('hidden[name"scoreArray"]').val("");
                        }
                    
                        return true;
                    }else{
                    
                        alert("キャンセルしました");
                    
                        return false;
                    }
                }else{
                    
                    alert("ランナーの状況を変更して下さい");
                    
                    return false;
                }
            }
            
            /////////////////////////走者状況更新/////////////////////////////
            function advanceConfirm(){

                if(battedflag == 0 ){
            /////////打席確定前の(盗塁等)の更新//////////
                    //進路ラジオボタンが押されているか
                    if(document.formAdvance.steal.checked){
                    
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            stealArray[stealNum] = runnerArray[3];
                            scoreArray[countScore] = runnerArray[3];
                            runnerArray[3] = 0;
                            thirdRunner = false;
                            
                            countScore++;
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                        }
                
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner && !thirdRunner){
                    
                            stealArray[stealNum] = runnerArray[2];
                            runnerArray[3] = runnerArray[2];
                            runnerArray[2] = 0;
                            
                            thirdRunnerName = secondRunnerName;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                        }
                
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner && !secondRunner){
                        
                            stealArray[stealNum] = runnerArray[1];
                            runnerArray[2] = runnerArray[1];
                            runnerArray[1] = 0;
                            
                            secondRunnerName = firstRunnerName;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                        }
                    
                        stealNum++;
                        
                        advanceFlag = 1;
                    
                    }else if(document.formAdvance.error.checked ||
                        document.formAdvance.balk.checked ){
                    
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            
                            
                            runnerArray[3] = 0;
                            thirdRunner = false;
                            
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                        }
                
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner && !thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            runnerArray[3] = runnerArray[2];
                            runnerArray[2] = 0;
                            
                            thirdRunnerName = secondRunnerName;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                        }
                
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner && !secondRunner){
                        
                            //一塁ランナーの情報、状況を更新する
                            runnerArray[2] = runnerArray[1];
                            runnerArray[1] = 0;
                            
                            secondRunnerName = firstRunnerName;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                        }
                    
                    }else if(document.formAdvance.outSteal.checked){
                    
                        ////盗塁死判定/////
                    
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            outStealArray[outStealNum] = runnerArray[3];
                            runnerArray[3] = 0;
                            thirdRunner = false;
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                        }
                
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner && !thirdRunner){
                    
                            outStealArray[outStealNum] = runnerArray[2];
                            runnerArray[2] = 0;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                        }
                
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner && !secondRunner){
                        
                            outStealArray[outStealNum] = runnerArray[1];
                            runnerArray[1] = 0;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                        }
                    
                        //盗塁死数加算
                        outStealNum++;
                        
                        //アウトカウント加算
                        outCount++;
                        
                        drawoutCount();
                        
                    }else if(document.formAdvance.pickOff.checked){
                            
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            runnerArray[3] = 0;
                            thirdRunner = false;
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                        }
                    
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner){
                    
                            runnerArray[2] = 0;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                        }
                    
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner){
                        
                            runnerArray[1] = 0;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                        }
                        
                        outCount++;
                        
                        drawoutCount();
                        
                    }else{
                        alert("進塁項目を選択して下さい！");
                    }
                    
                    //ダイヤモンドキャンバスを消去
                    diamondctx.clearRect(0,0,350,350);
                
                    //ダイヤモンドキャンバスを再描画
                    drawdiamondCanvas();
                
                    //ランナーを描画
                    drawRunner();
                    
                }else{
            
            /////////打席確定後の(盗塁等)の更新///////
            
                    //進路ラジオボタンが押されているか
                    if(document.formAdvance.steal.checked){                     /////盗塁/////
                    
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            stealArray[stealNum] =  battedArray[3];
                            scoreArray[countScore] = battedArray[3];
                            battedArray[3] = 0;
                            
                            thirdRunner = false;
                            
                            countScore++;
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                        }
                
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner && !thirdRunner){
                    
                            stealArray[stealNum] = battedArray[2];
                            battedArray[3] = battedArray[2];
                            battedArray[2] = 0;
                            
                            thirdRunnerName = secondRunnerName;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                        }
                
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner && !secondRunner){
                        
                            stealArray[stealNum] = battedArray[1];
                            battedArray[2] = battedArray[1];
                            battedArray[1] = 0;
                            
                            secondRunnerName = firstRunnerName;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                        }
                    
                        stealNum++;
                        
                        advanceFlag = 1;
                        
                        drawSetRunner();
                    
                    }else if(document.formAdvance.error.checked ||
                        document.formAdvance.balk.checked ){                    /////ボーク,エラー/////
                    
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            scoreArray[countScore] = battedArray[3];
                            battedArray[3] = 0;
                            thirdRunner = false;
                            
                            countScore++;
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                        }
                
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner && !thirdRunner){
                    
                            //一塁ランナーの情報、状況を更新する
                            battedArray[3] = battedArray[2];
                            battedArray[2] = 0;
                            
                            thirdRunnerName = secondRunnerName;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                        }
                
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner && !secondRunner){
                        
                            //一塁ランナーの情報、状況を更新する
                            battedArray[2] = battedArray[1];
                            battedArray[1] = 0;
                            
                            secondRunnerName = firstRunnerName;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                        }
                        
                        drawSetRunner();
                    
                    }else if(document.formAdvance.outSteal.checked){            /////盗塁死/////
                    
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            outStealArray[outStealNum] = battedArray[3];
                            battedArray[3] = 0;
                            thirdRunner = false;
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                            
                            afteroutCount++;
                        }
                
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner && !thirdRunner){
                    
                            outStealArray[outStealNum] = battedArray[2];
                            battedArray[2] = 0;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                            
                            afteroutCount++;
                        }
                
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner && !secondRunner){
                        
                            outStealArray[outStealNum] = battedArray[1];
                            battedArray[1] = 0;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                            
                            afteroutCount++;
                        }
                    
                        //盗塁死数加算
                        outStealNum++;
                        
                        drawSetRunner();
                    
                    }else if(document.formAdvance.out.checked){               /////凡・併殺打/////
                        
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            battedArray[3] = 0;
                            thirdRunner = false;
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                            
                            afteroutCount++;
                        }
                    
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner){
                    
                            battedArray[2] = 0;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                            
                            afteroutCount++;
                        }
                    
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner){
                        
                            battedArray[1] = 0;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                            
                            afteroutCount++;
                        }
                        
                        //打者ランナー
                        if($("[name=cBatterRunner]").prop("checked")){
                            
                            battedArray[0] = 0;
                            batterRunner = false;
                            
                            afteroutCount++;
                        }
                        
                        drawSetRunner();
                    
                    }else if(document.formAdvance.bunt.checked){               /////犠打・犠飛/////
                        
                        //3塁ランナー
                        if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
                    
                            //ランナーの情報、状況を更新する
                            scoreArray[countScore] = battedArray[3];
                            battedArray[3] = 0;
                            thirdRunner = false;
                            
                            countScore++;
                            
                            $("[name=cThirdRunner]").prop("checked",false);
                        }
                
                        //2塁ランナー
                        if($("[name=cSecondRunner]").prop("checked") && secondRunner && !thirdRunner){
                    
                            //一塁ランナーの情報、状況を更新する
                            battedArray[3] = battedArray[2];
                            battedArray[2] = 0;
                            
                            thirdRunnerName = secondRunnerName;
                            secondRunner = false;
                            
                            $("[name=cSecondRunner]").prop("checked",false);
                        }else{
                            alert("3塁ランナーを更新して下さい");
                        }
                
                        //1塁ランナー
                        if($("[name=cFirstRunner]").prop("checked") && firstRunner && !secondRunner){
                        
                            //一塁ランナーの情報、状況を更新する
                            battedArray[2] = battedArray[1];
                            battedArray[1] = 0;
                            
                            secondRunnerName = firstRunnerName;
                            firstRunner = false;
                            
                            $("[name=cFirstRunner]").prop("checked",false);
                        }else{
                            alert("2塁ランナーを更新して下さい");
                        }
                        
                        if($("[name=cBatterRunner]").prop("checked")){
                            
                            battedArray[0] = 0;
                            batterRunner = false;
                            
                            $("[name=cBatterRunner]").prop("checked",false);
                            
                            afteroutCount++;
                        }
                        
                        drawSetRunner();
                    
                    }else if(document.formAdvance.atbatadvance.checked){               /////進塁・安打/////
                    
                        atbatAdvance();
                        
                    }else{
                        alert("進塁項目を選択して下さい！");
                    }
                    
                    battedChangeRunflag = 1;
                }       
            }
            
            ////drawbattedRunner()セットメソッド
            function drawSetRunner(){
                //ダイヤモンドキャンバスを消去
                diamondctx.clearRect(0,0,350,350);
                
                //ダイヤモンドキャンバスを再描画
                drawdiamondCanvas();
                
                //ランナーを描画
                drawbattedRunner();
            }
            
            //////////////////////進塁・安打でのランナー進塁///////////////////////
            function atbatAdvance(){
            
                //進塁数を取得する
                advanceNum = Number($('#advancenum').val());
            
                //3塁ランナー
                if($("[name=cThirdRunner]").prop("checked") && thirdRunner){
            
                    //ランナーの情報、状況を更新する
                    scoreArray[countScore] = battedArray[3];
                    battedArray[3] = 0;
                    thirdRunner = false;
                
                    atbatAdvanceFlag = 1;
                    
                    countScore++;
                
                    $("[name=cThirdRunner]").prop("checked",false);
                }
                
                //2塁ランナー
                if($("[name=cSecondRunner]").prop("checked") && secondRunner && !thirdRunner){
                    
                    //進塁数による判定
                    if(advanceNum == 1){
                    
                        //ランナー配列内のプレイヤーNoの格納位置変更
                        battedArray[3] = battedArray[2];
                        thirdRunnerName = secondRunnerName;
                        
                    }else{
                        
                        scoreArray[countScore] = battedArray[2];
                        countScore++;
                    }
                            
                    battedArray[2] = 0;
                    secondRunner = false;
                
                    atbatAdvanceFlag = 1;
                
                    $("[name=cSecondRunner]").prop("checked",false);
                }
                
                //1塁ランナー
                if($("[name=cFirstRunner]").prop("checked") && firstRunner && advanceNum == 1 && !secondRunner
                    || $("[name=cFirstRunner]").prop("checked") && firstRunner && advanceNum == 2 && !secondRunner && !thirdRunner
                    || $("[name=cFirstRunner]").prop("checked") && firstRunner && advanceNum == 3 && !secondRunner && !thirdRunner){
                        
                    //進塁数による判定
                    if(advanceNum == 1){
                            
                        //ランナー配列内のプレイヤーNoの格納位置変更
                        battedArray[2] = battedArray[1];
                        secondRunnerName = firstRunnerName;
                        
                    }else if(advanceNum == 2){
                            
                        //ランナー配列内のプレイヤーNoの格納位置変更
                        battedArray[3] = battedArray[1];
                        thirdRunnerName = firstRunnerName;
                        
                    }else{
                        
                        //得点配列にプレイヤーNo格納
                        scoreArray[countScore] = battedArray[1];
                        countScore++;
                    }
                        
                    battedArray[1] = 0;
                    firstRunner = false;
                        
                    advancePlayerNum++;
                
                    atbatAdvanceFlag = 1;
                
                    $("[name=cFirstRunner]").prop("checked",false);
                }
                
                //打者ランナー
                if($("[name=cBatterRunner]").prop("checked") && advanceNum == 1 && !firstRunner 
                    || $("[name=cBatterRunner]").prop("checked") && advanceNum == 2 && !firstRunner && !secondRunner
                    || $("[name=cBatterRunner]").prop("checked") && advanceNum == 3 && !firstRuuner && !secondRunner && !thirdRunner){
                        
                    //進塁数による判定
                    if(advanceNum == 1){
                            
                        //ランナー配列内のプレイヤーNoの格納位置変更
                        battedArray[1] = battedArray[0];
                        firstRunnerName = batterName;
                        
                    }else if(advanceNum == 2){
                            
                        //ランナー配列内のプレイヤーNoの格納位置変更
                        battedArray[2] = battedArray[0];
                        secondRunnerName = batterName;
                        
                    }else{
                        
                        battedArray[3] = battedArray[0];
                        thirdRunnerName = batterName;
                        
                    }
                        
                    battedArray[0] = 0;
                    batterRunner = false;
                
                    atbatAdvanceFlag = 1;
                
                    $("[name=cFirstRunner]").prop("checked",false);
                }
            
                if(atbatAdvanceFlag == 1){
                
                    //ダイヤモンドキャンバスを消去
                    diamondctx.clearRect(0,0,350,350);
                
                    //ダイヤモンドキャンバスを再描画
                    drawdiamondCanvas();
                
                    //ランナーを描画
                    drawbattedRunner();
                
                    //atbatAdvanceFlagを初期化
                    atbatAdvanceFlag = 0;
                }else{
                
                    alert("選択が正しくありません！");
                }   
            }
            
            function disRunConfirm(){
                
                if(document.formAdvance.steal.checked || 
                    document.formAdvance.error.checked ||
                    document.formAdvance.balk.checked || 
                    document.formAdvance.outSteal.checked ||
                    document.formAdvance.pickOff.checked || 
                    document.formAdvance.out.checked ||
                    document.formAdvance.bunt.checked || 
                    document.formAdvance.atbatadvance.checked &&
                    $("[name=cFirstRunner").prop("checked") || 
                    $("[name=cSecondRunner").prop("checked") ||
                    $("[name=cThirdRunner").prop("checked")){
                        $('#runnerConfirm').attr('disabled',false);
                    }
            }
            
            //フォアボール,デッドボールの処理
            function fourDead(){
                
                if(thirdRunner && secondRunner && firstRunner){                 /////満塁/////
                    
                    //ランナーの情報、状況を更新する
                    battedArray[3] = battedArray[2];
                    battedArray[2] = battedArray[1];
                    battedArray[1] = battedArray[0];
                    battedArray[0] = 0;
                    
                    countScore++;
                
                }else if(secondRunner && firstRunner){                          /////1,2塁/////
                    
                    battedArray[3] = battedArray[2];
                    battedArray[2] = battedArray[1];
                    battedArray[1] = battedArray[0];
                    battedArray[0] = 0;
                
                }else if(firstRunner){                                          /////1塁(1,3塁)/////
                    
                    battedArray[2] = battedArray[1];
                    battedArray[1] = battedArray[0];
                    battedArray[0] = 0;
                    
                }else{                                                          //////それ以外//////
                    battedArray[1] = battedArray[0];
                    battedArray[0] = 0;
                }
                
                drawSetRunner();
            }
            
            //進塁数セレクトボックスのdisabledをfalseに
            function pushatbatAdvance(){
            
                $('#advancenum').attr('disabled',false);
                disRunConfirm();
            }
            
            //打席結果の処理
            function changeResultVal(){
                
                //打席結果の値を取得
                atbatResultVal = $('#atbatResult').val();
                
                if(atbatResultVal == 0){        /////結果を選択/////
                    
                    alert("結果を選択して下さい");
                
                }else if(atbatResultVal == 3){  /////安打/////
                    
                    
                }else if(atbatResultVal == 4){  /////二塁打/////
                
                
                }else if(atbatResultVal == 5){  /////三塁打/////
                    
                    
                }else if(atbatResultVal == 6){  /////本塁打/////
                    
                    
                    
                }else if(atbatResultVal == 7){  /////四球/////
                    
                    //ボールカウントが4未満
                    if(countBall != 4){
                        alert("結果が不適切です");
                        
                        $('#atbatResult').val("0");
                    }
                    
                }else if(atbatResultVal == 8){  /////死球/////
                    
                    
                    
                }else if(atbatResultVal == 9){  /////ゴロ/////
                    
                    
                    
                    
                    
                }else if(atbatResultVal == 10){ /////フライ/////
                    
                    
                    
                }else if(atbatResultVal == 11){ /////ライナー/////
                    
                    
                    
                }else if(atbatResultVal == 12){ /////フォースアウト/////
                    
                    
                }else if(atbatResultVal == 13){ /////三振/////
                    if(countStrike != 3){
                        alert("結果が不適切です");
                        
                        $('#atbatResult').val("0");
                    }else{
                        if(afteroutcountflag == 0){
                        
                            afteroutCount++;
                        }
                    
                        afteroutcountflag = 1;
                    }
                    
                }else if(atbatResultVal == 14){ /////エラー/////
                    
                    
                    runChangeflag = 1;
                    
                }else if(atbatResultVal == 15){ /////併殺打/////
                    
                    runChangeflag = 1;
                    
                }else if(atbatResultVal == 16){ /////犠打・犠飛/////
                    
                    runChangeflag = 1;
                }        
            }
            
            //タブを押したとき呼び出すメソッドを決める
            function drawRunnerFlag(){
                
                switch(battedChangeRunflag){
                    case 0:
                        drawRunner();
                        break;
                    
                    case 1:
                        drawbattedRunner();
                        break;
                }
            }
            
            function setAttr(){
                
                tab1 = document.getElementById('liTab1');
                tab1.setAttribute('class','active');
                
                pagetab2 = document.getElementById('pageTab2');
                pagetab2.setAttribute('class','tab-pane');
                
                pagetab3 = document.getElementById('pageTab3');
                pagetab3.setAttribute('class','tab-pane');
            }
            
            function delAttr(){
                pagetab1.setAttribute('class','tab-pane');
            }
            
            $('#pageTab2').click(function(){
               pagetab1.setAttribute('class','tab-pane'); 
            }); 
        
            //ランナーチェックボックスの(ture/false)
            function mouseButtonHover(){
            
            }   
        
            //////////////投球、打撃、走者(進塁)の情報が取れているか確認////////////
        
            function testDataGet(){
                //alert("打席確定前：" + runnerArray[0] + runnerArray[1] + runnerArray[2] + "\r\n" + 
                        //"打席確定後：" + battedArray[0] + battedArray[1] + battedArray[2] );
                
                //alert("打者No：" + batterNo + "\r\n打者Name：" + batterName);
            
                alert("");
            }
        
            function testOnChange(){
                
                //alert($('#advancenum').val());
                
                if(Number($('#advancenum').val()) >= 2){
                    alert("進塁数："　+ $('#advancenum').val());
                }
            }
        
	</script>

</head>
<body>
    <!-- タブの生成 -->
    <ul class="nav nav-tabs">
        <?php $tabNum = 1;
            foreach($atbatsum as $value): ?>
            
        <li id="liTab<?=$tabNum; ?>"><a href="#pageTab<?= $tabNum; ?>" data-toggle="tab"><?php echo $tabNum; ?>打席目</a></li>
        
        <?php $tabNum = $tabNum + 1 ; ?>
        <?php endforeach; ?>
    </ul>
    
    <!-- タブの中身生成 -->
    <ul>
    <div class="tab-content">
        <?php $pageNum = 1;
        foreach($atbatsum as $val): ?>
        
        <div class="tab-pane active" id="pageTab<?=$pageNum;?>">
            <div id="row" class="container-fluid">
                <div id="left" class="col-sm-6 bg-danger">
                    
                    <div class="col-sm-offset-2 col-sm-8 bg-warning">
                        <canvas id="countCanvas<?=$pageNum;?>" width="350" height="60"></canvas>
                    </div>
            
                    <div class="col-sm-offset-1 col-sm-10 bg-warning">
                        <canvas id="lightbox<?=$pageNum;?>" width="25" height="300"></canvas>
                        <canvas id="courseCanvas<?=$pageNum;?>" width="300" height="300" style="background-color: red;"></canvas>
                        <canvas id="leftbox<?=$pageNum;?>" width="25" height="300"></canvas>
                    </div>
            
                    <div class="col-sm-7 bg-success">
                        <form name="countform">
                            <input type="radio" id="rStrike" name="selectCount" value="1">
                            <label for="rStrike">ストライク</label>
                            <input type="radio" id="rBall" name="selectCount" value="2">
                            <label for="rBall">ボール</label>
                            <input type="radio" id="rFarr" name="selectCount" value="3">
                            <label for="rFarr">ファール</label>
                        </form>    
                    </div>
                </div>
    
            <div id="right" class="col-sm-6 bg-success">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#home<?=$pageNum;?>" data-toggle="tab">打席状況</a></li>
                  <li><a href="#second<?=$pageNum;?>" data-toggle="tab" onclick="drawRunnerFlag()">走者状況</a></li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active" id="home<?=$pageNum;?>">
                        <div class="col-sm-12 bg-danger">
                            <h4>打球の落下地点を記録して下さい</h4>
                        </div>
                    
			            <div class="col-sm-8 col-sm-offset-2 bg-success">
			            <canvas id="GroundCanvas<?=$pageNum;?>" width="350" height="350" style="background-color: blue;"></canvas>
			            </div>
                            <div class="col-sm-6 bg-danger">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <h4>打席結果：</h4>
                                    </div>
                                
                                    <div class="form-group">
                                        <select name="atbatresult" id="atbatResult" class="form-control" style="width: 150px;"
                                            onchange="changeResultVal()">
                                            <option value="0" selected>結果を選択</option>
                                            <option value="4">安打</option>
                                            <option value="5">二塁打</option>
                                            <option value="6">三塁打</option>
                                            <option value="7">本塁打</option>
                                            <option value="8">四球</option>
                                            <option value="9">死球</option>
                                            <option value="10">ゴロ</option>
                                            <option value="11">フライ</option>
                                            <option value="12">ライナー</option>
                                            <option value="13">三振</option>
                                            <option value="14">エラー</option>
                                            <option value="15">併殺打</option>
                                            <option value="16">犠打・犠飛</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 bg-warning">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <h4>打点：</h4>    
                                    </div>
                            
                                    <div class="form-group">
                                        <select id="rbi" name="rbi" class="form-control" value="打点" style="width: 100px;">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 bg-success">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <h4>得点数　 ：</h4>    
                                    </div>
                            
                                    <div class="form-group">
                                        <select id="score" name="score" class="form-control" value="得点" style="width: 100px;">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                </div>
                
                <div class="tab-pane" id="second<?=$pageNum;?>">
                    <div class="center-block">
                            
                        <div class="col-sm-8 col-sm-offset-2 bg-primary">   
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
