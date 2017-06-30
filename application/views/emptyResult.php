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
                    <div class="label label-primary" style="font-size: 20px">成績を表示する選手を選択して下さい</div>
                    
                    <input type="button" id="return" value="グループTOPに戻る" class="btn btn-primary" 
                           onclick="location.href='<?=site_url('GroupMenu/index/'.$groupNo)?>'">
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
                                <div id="allBat1" style="position: absolute; top: 45px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat2" style="position: absolute; top: 45px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat3" style="position: absolute; top: 45px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat4" style="position: absolute; top: 45px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat5" style="position: absolute; top: 45px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat6" style="position: absolute; top: 105px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat7" style="position: absolute; top: 105px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat8" style="position: absolute; top: 105px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat9" style="position: absolute; top: 105px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat10" style="position: absolute; top: 105px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat11" style="position: absolute; top: 165px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat12" style="position: absolute; top: 165px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat13" style="position: absolute; top: 165px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat14" style="position: absolute; top: 165px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat15" style="position: absolute; top: 165px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat16" style="position: absolute; top: 225px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat17" style="position: absolute; top: 225px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat18" style="position: absolute; top: 225px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat19" style="position: absolute; top: 225px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat20" style="position: absolute; top: 225px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat21" style="position: absolute; top: 285px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat22" style="position: absolute; top: 285px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat23" style="position: absolute; top: 285px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat24" style="position: absolute; top: 285px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBat25" style="position: absolute; top: 285px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <img src="<?=base_url();?>user_guide/_images/course2.jpg" width="300" height="300" alt="">
                            </div>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">対右投手</p>
                                <div id="rightBat1" style="position: absolute; top: 45px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat2" style="position: absolute; top: 45px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat3" style="position: absolute; top: 45px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat4" style="position: absolute; top: 45px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat5" style="position: absolute; top: 45px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat6" style="position: absolute; top: 105px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat7" style="position: absolute; top: 105px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat8" style="position: absolute; top: 105px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat9" style="position: absolute; top: 105px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat10" style="position: absolute; top: 105px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat11" style="position: absolute; top: 165px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat12" style="position: absolute; top: 165px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat13" style="position: absolute; top: 165px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat14" style="position: absolute; top: 165px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat15" style="position: absolute; top: 165px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat16" style="position: absolute; top: 225px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat17" style="position: absolute; top: 225px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat18" style="position: absolute; top: 225px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat19" style="position: absolute; top: 225px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat20" style="position: absolute; top: 225px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat21" style="position: absolute; top: 285px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat22" style="position: absolute; top: 285px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat23" style="position: absolute; top: 285px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat24" style="position: absolute; top: 285px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBat25" style="position: absolute; top: 285px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <img src="<?=base_url();?>user_guide/_images/course2.jpg" width="300" height="300" alt="">
                            </div>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">対左投手</p>
                                <div id="leftBat1" style="position: absolute; top: 45px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat2" style="position: absolute; top: 45px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat3" style="position: absolute; top: 45px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat4" style="position: absolute; top: 45px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat5" style="position: absolute; top: 45px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat6" style="position: absolute; top: 105px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat7" style="position: absolute; top: 105px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat8" style="position: absolute; top: 105px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat9" style="position: absolute; top: 105px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat10" style="position: absolute; top: 105px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat11" style="position: absolute; top: 165px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat12" style="position: absolute; top: 165px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat13" style="position: absolute; top: 165px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat14" style="position: absolute; top: 165px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat15" style="position: absolute; top: 165px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat16" style="position: absolute; top: 225px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat17" style="position: absolute; top: 225px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat18" style="position: absolute; top: 225px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat19" style="position: absolute; top: 225px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat20" style="position: absolute; top: 225px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat21" style="position: absolute; top: 285px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat22" style="position: absolute; top: 285px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat23" style="position: absolute; top: 285px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat24" style="position: absolute; top: 285px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBat25" style="position: absolute; top: 285px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <img src="<?=base_url();?>user_guide/_images/course2.jpg" width="300" height="300" alt="">
                            </div>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <p style="font-size: 24px">コース別被打率</p>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">全打席</p>
                                <div id="allBattersFaces1" style="position: absolute; top: 45px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace2" style="position: absolute; top: 45px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace3" style="position: absolute; top: 45px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace4" style="position: absolute; top: 45px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace5" style="position: absolute; top: 45px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace6" style="position: absolute; top: 105px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace7" style="position: absolute; top: 105px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace8" style="position: absolute; top: 105px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace9" style="position: absolute; top: 105px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace10" style="position: absolute; top: 105px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace11" style="position: absolute; top: 165px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace12" style="position: absolute; top: 165px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace13" style="position: absolute; top: 165px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace14" style="position: absolute; top: 165px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace15" style="position: absolute; top: 165px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace16" style="position: absolute; top: 225px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace17" style="position: absolute; top: 225px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace18" style="position: absolute; top: 225px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace19" style="position: absolute; top: 225px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace20" style="position: absolute; top: 225px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace21" style="position: absolute; top: 285px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace22" style="position: absolute; top: 285px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace23" style="position: absolute; top: 285px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace24" style="position: absolute; top: 285px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="allBattersFace25" style="position: absolute; top: 285px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <img src="<?=base_url();?>user_guide/_images/course2.jpg" width="300" height="300" alt="">
                            </div>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">対右打者</p>
                                <div id="rightBattersFace1" style="position: absolute; top: 45px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace2" style="position: absolute; top: 45px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace3" style="position: absolute; top: 45px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace4" style="position: absolute; top: 45px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace5" style="position: absolute; top: 45px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace6" style="position: absolute; top: 105px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace7" style="position: absolute; top: 105px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace8" style="position: absolute; top: 105px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace9" style="position: absolute; top: 105px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace10" style="position: absolute; top: 105px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace11" style="position: absolute; top: 165px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace12" style="position: absolute; top: 165px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace13" style="position: absolute; top: 165px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace14" style="position: absolute; top: 165px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace15" style="position: absolute; top: 165px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace16" style="position: absolute; top: 225px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace17" style="position: absolute; top: 225px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace18" style="position: absolute; top: 225px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace19" style="position: absolute; top: 225px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace20" style="position: absolute; top: 225px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace21" style="position: absolute; top: 285px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace22" style="position: absolute; top: 285px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace23" style="position: absolute; top: 285px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace24" style="position: absolute; top: 285px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="rightBattersFace25" style="position: absolute; top: 285px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <img src="<?=base_url();?>user_guide/_images/course2.jpg" width="300" height="300" alt="">
                            </div>
                            <div class="col-sm-4">
                                <p style="font-size: 18px">対左打者</p>
                                <div id="leftBattersFace1" style="position: absolute; top: 45px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace2" style="position: absolute; top: 45px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace3" style="position: absolute; top: 45px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace4" style="position: absolute; top: 45px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace5" style="position: absolute; top: 45px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace6" style="position: absolute; top: 105px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace7" style="position: absolute; top: 105px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace8" style="position: absolute; top: 105px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace9" style="position: absolute; top: 105px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace10" style="position: absolute; top: 105px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace11" style="position: absolute; top: 165px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace12" style="position: absolute; top: 165px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace13" style="position: absolute; top: 165px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace14" style="position: absolute; top: 165px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace15" style="position: absolute; top: 165px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace16" style="position: absolute; top: 225px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace17" style="position: absolute; top: 225px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace18" style="position: absolute; top: 225px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace19" style="position: absolute; top: 225px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace20" style="position: absolute; top: 225px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace21" style="position: absolute; top: 285px; left: 20px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace22" style="position: absolute; top: 285px; left: 80px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace23" style="position: absolute; top: 285px; left: 140px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace24" style="position: absolute; top: 285px; left: 200px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <div id="leftBattersFace25" style="position: absolute; top: 285px; left: 260px; width: 50px; font-size: 24px">
                                    <p>------</p>
                                </div>
                                <img src="<?=base_url();?>user_guide/_images/course2.jpg" width="300" height="300" alt="">
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
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            打席数
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            打数
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            安打
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            二塁打
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            三塁打
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            本塁打
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            打点
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            得点
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            三振
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            四死球
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            犠打・犠飛
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            盗塁
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            盗塁死
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            併殺打
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-8">
                                <img src="<?=base_url();?>user_guide/_images/ground.jpg" width="600" height="600" alt="" class="img-responsive">
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
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            勝利数
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            敗戦
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            投球回数
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            被安打
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            被本塁打
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            与四死球
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            失点
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            自責点
                                        </td>
                                        <td class="text-right">
                                            0
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-8">
                                <img src="<?=base_url();?>user_guide/_images/ground.jpg" width="600" height="600" alt="" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
    
</html>