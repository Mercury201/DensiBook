<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>打席記録画面</title>
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
            
            span {
                display: inline-block;
                width: 6em;
            }
            
        </style>
        
        
        <link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url();?>css/jquery-ui-bootstrap-masterbs3/css/custom-theme/jquery-ui-1.10.3.custom.css">
        
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="<?=base_url();?>js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="./bootstrap.css">
        <script src="./jquery.min.js"></script>
        <script src="./bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/result.js"></script>
        
        <script type="text/javascript">
            var groundimg;
            var groundimg2;
            window.onload = function(){
                drawgroundCanvas();
                drawCourseCanvas();
                
                colorAtbatAvg();
            }
            
            //コース別打率に色を付ける
            function colorAtbatAvg(){
                
            }
            
            //グラウンドキャンバスを描く
            function drawgroundCanvas(){
                groundCanvas = document.getElementById('GroundCanvas');
                groundCanvas2 = document.getElementById('GroundCanvas2');
                //2dコンテキスト
                groundctx = groundCanvas.getContext('2d');
                groundctx2 = groundCanvas2.getContext('2d');
                //表示画像を指定
                groundimg = new Image();
                groundimg.src = "<?=base_url('user_guide/_images/ground.jpg')?>";
                
                //画像の読み込み、表示
                groundimg.onload = function(){
                    groundctx.drawImage(groundimg,0,0,600,600);
                    
                    groundctx2.drawImage(groundimg,0,0,600,600);
                    <?php 
                        if($result['打球位置'] != ""){
                            foreach($result['打球位置'] as $row){
                                echo ("grounddraw('GroundCanvas', ".$row['coordinateX'].", ".$row['coordinateY'].");");
                            }
                        }
                        
                        
                        if($result['被打球位置'] != ""){
                            foreach($result['被打球位置'] as $key => $value){
                                
                                echo ("grounddraw('GroundCanvas2', ".$value['coordinateX'].", ".$value['coordinateY'].");");
                            }
                        }
                        
                    ?>
                    
                    
                    
                    saveGroundImageDate();
                }    
                
                
            }
            
            //コースキャンバスを描く
            function drawCourseCanvas(){
                
                // courseCanvas = document.getElementById('CourseCanvas1');
                
                // //2dコンテキスト
                // coursectx = courseCanvas.getContext('2d');
                
                // //表示画像を指定
                // courseimg = new Image();
                // courseimg.src = "<?=base_url('user_guide/_images/course2.jpg')?>";
                
                //画像の読み込み、表示
                // courseimg.onload = function(){
                    // coursectx.drawImage(courseimg,0,0,300,300);
                    
                    // coursectx.fillStyle = "rgb(255, 0, 0)";
                    // coursectx.fillRect(1, 1, 60, 60);
                    // coursectx.fillRect(61, 61, 60, 60);
                    // coursectx.fillRect(121, 121, 59, 59);
                    // coursectx.fillRect(180, 180, 60, 60);
                    // coursectx.fillRect(240, 240, 60, 60);
                    <?php 
                        $count = 0;
                        foreach($result['コース別打率'] as $key0 => $value0){
                            $count++;
                            $canvas = 'CourseCanvas'.$count;
                            foreach($value0 as $key => $value){
                                
                                $x = 60 * (($key-1) % 5);
                                $y = 60 * floor(($key-1) / 5);
                                
                                if((($key) % 5) == 3){
                                    $w = 59;
                                }else{
                                    $w = 60;
                                }
                                // $w--;
                                // $w--;
                                if(floor(($key-1) / 5) == 2){
                                    $h = 59;
                                }else{
                                    $h = 60;
                                }
                                // $h--;
                                // $h--;
                                if((($key-1) % 5) < 3){
                                    $x++;
                                }
                                // $x++;
                                if(floor(($key-1) / 5) < 3){
                                    $y++;
                                }
                                // $y++;
                                //0.300以上なら赤・0.200未満なら青でコースを塗り潰す
                                if($value != "------"){
                                    if($value >= 0.3){
                                        $color = 'rgb(255, 50, 50)';
                                        echo("fillCourse('" . $canvas . "', '" . $color . "', " . $x . ", " . $y . ", " . $w . ", " . $h . ");");
                                        // echo("alert(" . $value . ");");
                                    }else if($value < 0.2){
                                        $color = 'rgb(50, 50, 255)';
                                        echo("fillCourse('" . $canvas . "', '" . $color . "', " . $x . ", " . $y . ", " . $w . ", " . $h . ");");
                                        // echo("alert('蒼" . $value . "');");
                                    }
                                }
                                
                            }
                            
                            
                            
                        }
                        
                        
                        foreach($result['コース別被打率'] as $key0 => $value0){
                            $count++;
                            $canvas = 'CourseCanvas'.$count;
                            foreach($value0 as $key => $value){
                                $x = 60 * (($key-1) % 5);
                                $y = 60 * floor(($key-1) / 5);
                                
                                if((($key) % 5) == 3){
                                    $w = 59;
                                }else{
                                    $w = 60;
                                }
                                // $w--;
                                // $w--;
                                if(floor(($key-1) / 5) == 2){
                                    $h = 59;
                                }else{
                                    $h = 60;
                                }
                                // $h--;
                                // $h--;
                                if((($key-1) % 5) < 3){
                                    $x++;
                                }
                                // $x++;
                                if(floor(($key-1) / 5) < 3){
                                    $y++;
                                }
                                // $y++;
                                //0.200未満なら赤・0.300以上なら青でコースを塗り潰す
                                if($value != "------"){
                                    if($value < 0.2){
                                        $color = 'rgb(255, 50, 50)';
                                        echo("fillCourse('" . $canvas . "', '" . $color . "', " . $x . ", " . $y . ", " . $w . ", " . $h . ");");
                                        // echo("alert(" . $value . ");");
                                    }else if($value >= 0.3){
                                        $color = 'rgb(50, 50, 255)';
                                        echo("fillCourse('" . $canvas . "', '" . $color . "', " . $x . ", " . $y . ", " . $w . ", " . $h . ");");
                                        // echo("alert('蒼" . $value . "');");
                                    }
                                }
                                
                            }
                            
                        }
                    ?>
                    
                    // fillCourse('CourseCanvas1', 'rgb(255, 0, 0)', 1, 1, 60, 60);
                    // fillCourse('CourseCanvas1', 'rgb(255, 0, 0)', 61, 61, 60, 60);
                    // fillCourse('CourseCanvas1', 'rgb(255, 0, 0)', 121, 121, 59, 59);
                    // fillCourse('CourseCanvas1', 'rgb(255, 0, 0)', 180, 180, 60, 60);
                    // fillCourse('CourseCanvas1', 'rgb(255, 0, 0)', 240, 240, 60, 60);
                    
                    courseCanvas1 = document.getElementById("CourseCanvas1");
                    courseCanvas2 = document.getElementById("CourseCanvas2");
                    courseCanvas3 = document.getElementById("CourseCanvas3");
                    courseCanvas4 = document.getElementById("CourseCanvas4");
                    courseCanvas5 = document.getElementById("CourseCanvas5");
                    courseCanvas6 = document.getElementById("CourseCanvas6");
                    //2dコンテキスト
                    courseCoursectx1 = courseCanvas1.getContext('2d');
                    courseCoursectx2 = courseCanvas2.getContext('2d');
                    courseCoursectx3 = courseCanvas3.getContext('2d');
                    courseCoursectx4 = courseCanvas4.getContext('2d');
                    courseCoursectx5 = courseCanvas5.getContext('2d');
                    courseCoursectx6 = courseCanvas6.getContext('2d');
                    
                    //表示画像を指定
                    courseimg2 = new Image();
                    courseimg2.src = "<?=base_url('user_guide/_images/course2.gif')?>";
                    courseimg2.onload = function(){
                        
                        courseCoursectx1.drawImage(courseimg2,0,0,300,300);
                        courseCoursectx2.drawImage(courseimg2,0,0,300,300);
                        courseCoursectx3.drawImage(courseimg2,0,0,300,300);
                        courseCoursectx4.drawImage(courseimg2,0,0,300,300);
                        courseCoursectx5.drawImage(courseimg2,0,0,300,300);
                        courseCoursectx6.drawImage(courseimg2,0,0,300,300);
                    }
                    
                    
                    //初期状態保存
                    saveCourseImageDate();
                // }
            }
            
            //コース別の枠線を書く
            function coursedraw(canvas){
                courseCanvas = document.getElementById(canvas);
                // alert(courseCanvas);
                //2dコンテキスト
                coursectx = courseCanvas.getContext('2d');
                
                //表示画像を指定
                courseimg = new Image();
                courseimg.src = "<?=base_url('user_guide/_images/course2.gif')?>";
                courseimg.onload = function(){
                    coursectx.drawImage(courseimg,0,0,300,300);
                
                }
                
            }
            
            //打球方向を書く
            function grounddraw(ground, coordinateX, coordinateY){
                //描画コンテキストの取得
                coordinateX = coordinateX * 2;
                coordinateY = coordinateY * 2;
                var canvas = document.getElementById(ground);
                if (canvas.getContext) {
                    var context = canvas.getContext('2d');
                    //ここに具体的な描画内容を指定する
                    //新しいパスを開始する
                    context.beginPath();
                    //パスの開始座標を指定する
                    context.moveTo(coordinateX,coordinateY);
                    //座標を指定してラインを引いていく
                    context.lineTo(295,535);
                    //パスを閉じる（最後の座標から開始座標に向けてラインを引く）
                    context.closePath();
                    //現在のパスを輪郭表示する
                    context.stroke();
                }
            }
            
            //コース別打率・被打率の塗りつぶし
            function fillCourse(course, color, x, y, w, h){
                
                var canvas = document.getElementById(course);
                if(canvas.getContext){
                    var content = canvas.getContext('2d');
                    content.fillStyle = color;
                    content.fillRect(x, y, w, h);
                    
                }
            }
        </script>
    </head>
    
    <body>
        <div id="header" class="container-fluid bg-primary">
            
            <form action="" method="post" onsubmit="return checkSelect()">
                
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                        選手選択
                        <span class="caret"></span>
                    </button>
                    <ol class="dropdown-menu">
                        <?php
                            foreach($member as $row){
                                echo '<li value="' . $row['userNo'] . '"><a href="#" data-value="' . $row['userName'] . 
                                     '" onclick="changeElement(this);return false;">' . $row['userName'] . '</a></li>';
                            }
                        ?>
                    </ol>
                    <input type="hidden" id="selectUserId" name="selectUser" value="">
                    
                    
                    <input type="submit" id="display" class="btn btn-primary" value="表示">
                    <div class="label label-primary" style="font-size: 20px"><?php echo($result['選手名'].":".$result['利き投げ'].
                    "投げ".$result['利き打ち']."打ち") ?></div>
                    <input type="button" id="return" value="グループTOPに戻る" class="btn btn-primary" 
                           onclick="location.href='<?=site_url('GroupMenu/index/'.$groupNo)?>'"></button>
                </div>
                
                    
            </form>
            
            
        </div>
        
        <div id="row" class="container">
            <!--タブ-->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">コース別成績</a></li>
                <li><a href="#tab2" data-toggle="tab">成績・打球方向</a></li>
            </ul>
            <!-- / タブ-->
            <div id="myTabContent1" class="tab-content">
                <div class="tab-pane in active" id="tab1">
                    <!--タブ-->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab3" data-toggle="tab">打率</a></li>
                        <li><a href="#tab4" data-toggle="tab">被打率</a></li>
                    </ul>
                    <!-- / タブ-->
                    <div id="myTabContent2" class="tab-content">
                        <div class="tab-pane in active" id="tab3">
                            <p style="font-size: 24px">コース別打率</p>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">全打席</p>
                                <?php
                                    foreach($result['コース別打率']['allAtbat'] as $key => $value){
                                        $white = "";
                                        if(($value >= 0.3) || ($value < 0.2) && $value != "------"){
                                            $white = ';color : #ffffff';
                                        }
                                        echo('<div id="allBat' . $key . 
                                            '" style="position: absolute; top: ' . (45+(floor(($key-1)/5))*60) . 'px; left: ' . (20+(($key-1)%5)*60) . 
                                            'px; width: 50px; font-size: 24px' . $white .'">');
                                        if($value == "1.000"){
                                            echo("<p>" . substr($value, 0, 4) . "</p>");
                                        }else if($value != "------"){
                                            echo("<p>" . substr($value, -4) . "</p>");
                                        }else{
                                            echo("<p>" . $value . "</p>");
                                        }
                                        
                                        echo('</div>');
                                    }
                                ?>
                                
                                <canvas id="CourseCanvas1" width="300" height="300" style="background-color: white;">
                                    
                                </canvas>
                                
                            </div>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">対右投手</p>
                                <?php
                                    foreach($result['コース別打率']['vsRightAtbat'] as $key => $value){
                                        $white = "";
                                        if(($value >= 0.3) || ($value < 0.2) && $value != "------"){
                                            $white = ';color : #ffffff';
                                        }
                                        echo('<div id="rightBat' . $key . 
                                            '" style="position: absolute; top: ' . (45+(floor(($key-1)/5))*60) . 'px; left: ' . (20+(($key-1)%5)*60) . 
                                            'px; width: 50px; font-size: 24px' . $white .'">');
                                        if($value == "1.000"){
                                            echo("<p>" . substr($value, 0, 4) . "</p>");
                                        }else if($value != "------"){
                                            echo("<p>" . substr($value, -4) . "</p>");
                                        }else{
                                            echo("<p>" . $value . "</p>");
                                        }
                                        echo('</div>');
                                    }
                                ?>
                                <canvas id="CourseCanvas2" width="300" height="300" style="background-color: white;">
                                    
                                </canvas>
                            </div>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">対左投手</p>
                                <?php
                                    foreach($result['コース別打率']['vsLeftAtbat'] as $key => $value){
                                        $white = "";
                                        if(($value >= 0.3) || ($value < 0.2) && $value != "------"){
                                            $white = ';color : #ffffff';
                                        }
                                        echo('<div id="leftBat' . $key . 
                                            '" style="position: absolute; top: ' . (45+(floor(($key-1)/5))*60) . 'px; left: ' . (20+(($key-1)%5)*60) . 
                                            'px; width: 50px; font-size: 24px' . $white .'">');
                                        if($value == "1.000"){
                                            echo("<p>" . substr($value, 0, 4) . "</p>");
                                        }else if($value != "------"){
                                            echo("<p>" . substr($value, -4) . "</p>");
                                        }else{
                                            echo("<p>" . $value . "</p>");
                                        }
                                        echo('</div>');
                                    }
                                ?>
                                <canvas id="CourseCanvas3" width="300" height="300" style="background-color: white;">
                                    
                                </canvas>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <p style="font-size: 24px">コース別被打率</p>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">全打席</p>
                                <?php
                                    foreach($result['コース別被打率']['allAtbat'] as $key => $value){
                                        $white = "";
                                        if(($value >= 0.3) || ($value < 0.2) && $value != "------"){
                                            $white = ';color : #ffffff';
                                        }
                                        echo('<div id="allBattersFace' . $key . 
                                            '" style="position: absolute; top: ' . (45+(floor(($key-1)/5))*60) . 'px; left: ' . (20+(($key-1)%5)*60) . 
                                            'px; width: 50px; font-size: 24px' . $white .'">');
                                        if($value == "1.000"){
                                            echo("<p>" . substr($value, 0, 4) . "</p>");
                                        }else if($value != "------"){
                                            echo("<p>" . substr($value, -4) . "</p>");
                                        }else{
                                            echo("<p>" . $value . "</p>");
                                        }
                                        echo('</div>');
                                    }
                                ?>
                                
                                <canvas id="CourseCanvas4" width="300" height="300" style="background-color: white;">
                                    
                                </canvas>
                            </div>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">対右打者</p>
                                <?php
                                    foreach($result['コース別被打率']['vsRightAtbat'] as $key => $value){
                                        $white = "";
                                        if(($value >= 0.3) || ($value < 0.2) && $value != "------"){
                                            $white = ';color : #ffffff';
                                        }
                                        echo('<div id="rightBattersFace' . $key . 
                                            '" style="position: absolute; top: ' . (45+(floor(($key-1)/5))*60) . 'px; left: ' . (20+(($key-1)%5)*60) . 
                                            'px; width: 50px; font-size: 24px' . $white .'">');
                                        if($value == "1.000"){
                                            echo("<p>" . substr($value, 0, 4) . "</p>");
                                        }else if($value != "------"){
                                            echo("<p>" . substr($value, -4) . "</p>");
                                        }else{
                                            echo("<p>" . $value . "</p>");
                                        }
                                        echo('</div>');
                                    }
                                ?>
                                
                                <canvas id="CourseCanvas5" width="300" height="300" style="background-color: white;">
                                    
                                </canvas>
                            </div>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">対左打者</p>
                                <?php
                                    foreach($result['コース別被打率']['vsLeftAtbat'] as $key => $value){
                                        $white = "";
                                        if(($value >= 0.3) || ($value < 0.2) && $value != "------"){
                                            $white = ';color : #ffffff';
                                        }
                                        echo('<div id="leftBattersFace' . $key . 
                                            '" style="position: absolute; top: ' . (45+(floor(($key-1)/5))*60) . 'px; left: ' . (20+(($key-1)%5)*60) . 
                                            'px; width: 50px; font-size: 24px' . $white .'">');
                                        if($value == "1.000"){
                                            echo("<p>" . substr($value, 0, 4) . "</p>");
                                        }else if($value != "------"){
                                            echo("<p>" . substr($value, -4) . "</p>");
                                        }else{
                                            echo("<p>" . $value . "</p>");
                                        }
                                        echo('</div>');
                                    }
                                ?>
                                
                                <canvas id="CourseCanvas6" width="300" height="300" style="background-color: white;">
                                    
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <!--タブ-->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab5" data-toggle="tab">打者</a></li>
                        <li><a href="#tab6" data-toggle="tab">投手</a></li>
                    </ul>
                    <!-- / タブ-->
                    <div id="myTabContent3" class="tab-content">
                        <div class="tab-pane in active" id="tab5">
                            <p style="font-size: 24px">打者成績</p>
                            <div class="col-sm-4">
                                <table class="table table-condensed table-bordered table-striped">
                                    <tr>
                                        <td>
                                            試合数
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['試合数']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            打席数
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['打席数']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            打数
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['打数']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            安打
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['単打']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            二塁打
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['二塁打']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            三塁打
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['三塁打']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            本塁打
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['本塁打']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            打点
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['打点']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            得点
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['得点']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            三振
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['三振']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            四死球
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['四死球']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            犠打・犠飛
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['犠打・犠飛']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            盗塁
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['盗塁']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            盗塁死
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['盗塁死']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            併殺打
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['併殺打']) ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-8">
                                <canvas id="GroundCanvas" width="600" height="600" style="background-color: blue;">
                                    
                                </canvas>
                                
                                
                            </div>
                        </div>
                        <div class="tab-pane" id="tab6">
                            <p style="font-size: 24px">投手成績</p>
                            <div class="col-sm-4">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td>
                                            試合数
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['登板数']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            勝利数
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['勝利']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            敗戦
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['敗戦']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            投球回数
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['投球回']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            被安打
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['被安打']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            被本塁打
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['被本塁打']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            与四死球
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['与四死球']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            失点
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['失点']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            自責点
                                        </td>
                                        <td class="text-right">
                                            <?php echo($result['自責点']) ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-8">
                                <canvas id="GroundCanvas2" width="600" height="600" style="background-color: blue;">
                                    
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
    
</html>