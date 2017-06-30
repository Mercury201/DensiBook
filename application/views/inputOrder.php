<!DOCTYPE html>
<?php
$this->load->helper('form');
$this->load->helper('url');
$orderNumber =1;

//$userNo1 = $userNo['0'];
// $userNoJs = implode(',',$userNo);
//$jsonUserNo = json_encode($userNo['0']);
?>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>メンバー登録</title>
        <!-- css -->
        <link rel="stylesheet" href="<?=base_url() ?>css/inputOrder.css" type="text/css" />
        <!--<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900|Raleway:400,300,500,600,700,800,900' rel='stylesheet' type='text/css'>-->
        <!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
        <!--<link rel="stylesheet" type="text/css" href="css/custom.css">-->
        <link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css">
        <?php
        echo('<script type="text/javascript">');
        // $i = 0;
        // foreach($userNo as $userNumber){
        //     echo('var num'.$i.' = '.$userNumber.';');
        //     $i++;
        // }
        $i = 0;
        foreach($userNo as $num){
            echo('var userNo'.$i.' = '.$num.';');
            $i++;
        }
        
        echo('var memberCount = '.$i.';');
        
        $i = 0;
        foreach($name as $memberName){
            echo('var userName'.$i.' = "'.$memberName.'";');
            $i++;
        }
        
        $i = 0;
        foreach($battingHanded as $batting){
            echo('var batting'.$userNo[$i].' = "'.$batting.'";');
            $i++;
        }
        
        $i = 0;
        foreach($throwHanded as $throw){
            echo('var pitching'.$userNo[$i].' = "'.$throw.'";');
            $i++;
        }
        ?>
        
        
        </script>
        <script type="text/javascript" src="<?=base_url();?>js/order.js"></script>
        
        
    
        
        <script>

$(function(){
  $(".dropdown-menu li a").click(function(){
    $(this).parents('.dropdown').find('.dropdown-toggle').html($(this).text() + ' <span class="caret"></span>');
    $(this).parents('.dropdown').find('input[name="dropdown-value"]').val($(this).attr("data-value"));
  });
});
    </script>
        
    </head>
    <body>
        
        <form action="<?=site_url('EntryMember/entryPlayer')?>" method="post" accept-charset="utf-8"
                      onsubmit="return setFormData(this)">
        <input type="hidden" name="benchNum" value="" />
        <input type="hidden" name="opponentName" value="" />
        <input type="hidden" name="opponentPosition" value="" />
        <input type="hidden" name="opponentBattingHanded" value="" />
        <input type="hidden" name="opponentThrowHanded" value="" />
        <input type="hidden" name="groupNo" value="<?=$groupNo ?>" />
        
        <div class="bs-example bs-example-bg-classes" data-example-id="contextual-backgrounds-helpers">
            <div class="col-sm-12">
                <ul class="list-inline">
                    <!--<p class="bg-success">対戦相手<input type="textarea" name="opponent"></p>-->
                    <!--<p class="bg-success">試合場所<input type="textarea" name="location"></p>-->
                    <li class="bg-success">
                        自チーム：
                        <input type="radio" id="top" name="topBottom" value="1"> 先攻
                        <input type="radio" id="bottom" name="topBottom" value="0"> 後攻
                    </li>
                    <li class="bg-success">試合場所<input type="textarea" name="location" class="form-group"></li>
                    <li class="bg-success">対戦相手<input type="textarea" name="opponent" class="form-group"></li>
                    
                    <input type="submit" id="return" value="グループTOPに戻る" class="btn btn-primary" 
                           onclick="form.action='<?=site_url('GroupMenu/index/'.$groupNo)?>';return true">
                </ul>
            </div>
        </div>
        
        <div class="col-sm-12">
        <table class="frame">
            <tr>
                <div class="col-sm-6">
                <td class="orderFrame">
                    
                    <table id="myOrder"  class="table table-bordered">
                        <tr class="info">
                            <th>打順</th>
                            <th>名前</th>
                            <th>守</th>
                            <th>打</th>
                            <th>投</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>
                                <?php 
                                    //  valueの値が0から昇順で項目順に入る
                                    // $js = 'onChange="setHanded(value, '.$orderNumber.');"';
                                    // echo form_dropdown('membername1', $name, 0, $js);
                                    // $orderNumber++;
                                    
                                    //  valueの値がuserNoになる
                                    // echo '<select name="membername1" onChange="setHanded(value, this);">'.PHP_EOL;
                                    // echo '<option value="blank"></option>'.PHP_EOL;
                                    
                                    echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$userNo[$i].
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member1" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position1" value="">
                                </div>
                                <!--<SELECT name="position1">-->
                                <!--<OPTION value="投">投</OPTION>-->
                                <!--<OPTION value="捕">捕</OPTION>-->
                                <!--<OPTION value="一">一</OPTION>-->
                                <!--<OPTION value="二">二</OPTION>-->
                                <!--<OPTION value="三">三</OPTION>-->
                                <!--<OPTION value="遊">遊</OPTION>-->
                                <!--<OPTION value="左">左</OPTION>-->
                                <!--<OPTION value="中">中</OPTION>-->
                                <!--<OPTION value="右">右</OPTION>-->
                                <!--</SELECT>-->
                            </td>
                            <td>
                                <p name="batting1"></p>
                            </td>
                            <td>
                                <p name="pitching1"></p>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <?php 
                                    echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member2" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position2" value="">
                                </div>
                            </td>
                            <td>
                                <p name="batting2"></p>
                            </td>
                            <td>
                                <p name="pitching2"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <?php 
                                echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member3" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position3" value="">
                                </div>
                            </td>
                            <td>
                                <p name="batting3"></p>
                            </td>
                            <td>
                                <p name="pitching3"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>
                                <?php 
                                echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member4" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position4" value="">
                                </div>
                            </td>
                            <td>
                                <p name="batting4"></p>
                            </td>
                            <td>
                                <p name="pitching4"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>
                                <?php 
                                echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member5" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position5" value="">
                                </div>
                            </td>
                            <td>
                                <p name="batting5"></p>
                            </td>
                            <td>
                                <p name="pitching5"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>
                                <?php 
                                echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member6" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position6" value="">
                                </div>
                            </td>
                            <td>
                                <p name="batting6"></p>
                            </td>
                            <td>
                                <p name="pitching6"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>
                                <?php 
                                echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member7" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position7" value="">
                                </div>
                            </td>
                            <td>
                                <p name="batting7"></p>
                            </td>
                            <td>
                                <p name="pitching7"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>
                                <?php 
                                echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member8" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position8" value="">
                                </div>
                            </td>
                            <td>
                                <p name="batting8"></p>
                            </td>
                            <td>
                                <p name="pitching8"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>
                                <?php 
                                echo '<div class="dropdown">'.PHP_EOL;
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'.PHP_EOL;
                                    echo '選手選択'.PHP_EOL;
                                    echo '<span class="caret"></span>'.PHP_EOL;
                                    echo '</button>'.PHP_EOL;
                                    echo '<ol class="dropdown-menu">'.PHP_EOL;
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>'.PHP_EOL;
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>'.PHP_EOL;
                                    echo '<input type="hidden" name="member9" value="">'.PHP_EOL;
                                    echo '</div>'.PHP_EOL;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="position9" value="">
                                </div>
                            </td>
                            <td>
                                <p name="batting9"></p>
                            </td>
                            <td>
                                <p name="pitching9"></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>控え</td>
                            <td>
                                <?php 
                                echo '<div class="dropdown">';
                                    echo '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
                                    echo '選手選択';
                                    echo '<span class="caret"></span>';
                                    echo '</button>';
                                    echo '<ol class="dropdown-menu">';
                                    echo '<li value="0"><a href="#" onclick="changeBenchMemberElement(this),setHanded(this);return false;">　</a></li>';
                                    $i = 0;
                                    foreach($name as $row){
                                        // echo '<option value="'.$userNo[$i].'">'.$row.'</option>'.PHP_EOL;
                                        // $i++;
                                        
                                        echo '<li value="'.$userNo[$i].'"><a href="#" data-value="'.$row.
                                        '" onclick="changeBenchMemberElement(this),setHanded(this);return false;">'.$row.'</a></li>';
                                        $i++;
                                    }
                                    // echo '</select>';
                                    
                                    echo '</ol>';
                                    echo '<input type="hidden" name="member10" value="">';
                                    echo '</div>';
                                ?>
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                <p name="batting10"></p>
                            </td>
                            <td>
                                <p name="pitching10"></p>
                            </td>
                        </tr>
                    </table>
                    
                </td>
                </div>
                <div class="col-sm-6">
                <td class="orderFrame">
                    
                    <table id="opponentOrder" class="table table-bordered">
                        <tr class="info">
                            <th>打順</th>
                            <th>名前</th>
                            <th>守</th>
                            <th>打</th>
                            <th>投</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input type="text" name="name1"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition1" value="">
                                </div>
                                <!--<SELECT name="opponentPosition1">-->
                                <!--<OPTION value="投">投</OPTION>-->
                                <!--<OPTION value="捕">捕</OPTION>-->
                                <!--<OPTION value="一">一</OPTION>-->
                                <!--<OPTION value="二">二</OPTION>-->
                                <!--<OPTION value="三">三</OPTION>-->
                                <!--<OPTION value="遊">遊</OPTION>-->
                                <!--<OPTION value="左">左</OPTION>-->
                                <!--<OPTION value="中">中</OPTION>-->
                                <!--<OPTION value="右">右</OPTION>-->
                                <!--</SELECT>-->
                                
                            </td>
                            <td>
                                <input type="radio" id="bat1" name="opponentBattingHanded1" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded1" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw1" name="opponentThrowHanded1" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded1" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input type="text" name="name2"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition2" value="">
                                </div>
                            </td>
                            <td>
                                <input type="radio" id="bat2" name="opponentBattingHanded2" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded2" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw2" name="opponentThrowHanded2" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded2" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input type="text" name="name3"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition3" value="">
                                </div>
                            </td>
                            <td>
                                <input type="radio" id="bat3" name="opponentBattingHanded3" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded3" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw3" name="opponentThrowHanded3" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded3" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input type="text" name="name4"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition4" value="">
                                </div>
                            </td>
                            <td>
                                <input type="radio" id="bat4" name="opponentBattingHanded4" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded4" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw4" name="opponentThrowHanded4" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded4" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input type="text" name="name5"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition5" value="">
                                </div>
                            </td>
                            <td>
                                <input type="radio" id="bat5" name="opponentBattingHanded5" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded5" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw5" name="opponentThrowHanded5" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded5" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><input type="text" name="name6"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition6" value="">
                                </div>
                            </td>
                            <td>
                                <input type="radio" id="bat6" name="opponentBattingHanded6" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded6" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw6" name="opponentThrowHanded6" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded6" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><input type="text" name="name7"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition7" value="">
                                </div>
                            </td>
                            <td>
                                <input type="radio" id="bat7" name="opponentBattingHanded7" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded7" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw7" name="opponentThrowHanded7" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded7" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><input type="text" name="name8"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition8" value="">
                                </div>
                            </td>
                            <td>
                                <input type="radio" id="bat8" name="opponentBattingHanded8" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded8" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw8" name="opponentThrowHanded8" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded8" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td><input type="text" name="name9"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        守備位置
                                        <span class="caret"></span>
                                    </button>
                                    <ol class="dropdown-menu">
                                        <li value="1"><a href="#" data-value="投" onclick="changeElement(this);return false;">投</a></li>
                                        <li value="2"><a href="#" data-value="捕" onclick="changeElement(this);return false;">捕</a></li>
                                        <li value="3"><a href="#" data-value="一" onclick="changeElement(this);return false;">一</a></li>
                                        <li value="4"><a href="#" data-value="二" onclick="changeElement(this);return false;">二</a></li>
                                        <li value="5"><a href="#" data-value="三" onclick="changeElement(this);return false;">三</a></li>
                                        <li value="6"><a href="#" data-value="遊" onclick="changeElement(this);return false;">遊</a></li>
                                        <li value="7"><a href="#" data-value="左" onclick="changeElement(this);return false;">左</a></li>
                                        <li value="8"><a href="#" data-value="中" onclick="changeElement(this);return false;">中</a></li>
                                        <li value="9"><a href="#" data-value="右" onclick="changeElement(this);return false;">右</a></li>
                                    </ol>
                                    <input type="hidden" name="opponentPosition9" value="">
                                </div>
                            </td>
                            <td>
                                <input type="radio" id="bat9" name="opponentBattingHanded9" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded9" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw9" name="opponentThrowHanded9" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded9" value="左"> 左
                            </td>
                        </tr>
                        <tr>
                            <td>控え</td>
                            <td><input type="text" name="name10" onblur="changeOpponentBench(this)"></td>
                            <td>
                                
                            </td>
                            <td>
                                <input type="radio" id="bat10" name="opponentBattingHanded10" value="右"checked> 右
                                <input type="radio" name="opponentBattingHanded10" value="左"> 左
                            </td>
                            <td>
                                <input type="radio" id="throw10" name="opponentThrowHanded10" value="右"checked> 右
                                <input type="radio" name="opponentThrowHanded10" value="左"> 左
                            </td>
                        </tr>
                    </table>
                    
                </td>
                </div>
            </tr>
        </table>
        </div>
        <div class="col-sm-12">
        <input type="submit" class="btn btn-primary" name="order" value="決定" />
        </div>
        <?php 
            echo form_close(); 
        ?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="<?=base_url();?>js/bootstrap.min.js"></script>
    </body>
</html>