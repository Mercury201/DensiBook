<?php 
class PersonalResult extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        
        //必要なものをロード
        $this->load->model('Match');
        $this->load->model('User');
        $this->load->model('Affiliation');
        $this->load->model('Player');
        $this->load->model('Position');
        $this->load->model('Situation');
        $this->load->model('Course');
        $this->load->model('BattedBall');
        $this->load->model('Steal');
        $this->load->model('Scoring');
        $this->load->library('session');
    }
    
    
    public function index($groupNo=null){
        
        //post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $res =  $this->Result($_POST['selectUser']);
            
            $data = array('member' => $this->getMemberData($groupNo),
             'result' => $res,
             'groupNo' => $groupNo
             );
            //echo 'post';
            $this->load->view('result', $data);
            
        //get     
        }else{
             
             $data = array('member' => $this->getMemberData($groupNo),
             'result' => null,
             'groupNo' => $groupNo
             );
             
            $this->load->view('emptyResult', $data);
        }
        
    }
    
    
    public function Result($userNo){
        
        $user = $this->User->getPlayerData($userNo);
        $userName = $user['name'][0];
        $userBattingHanded = $user['battingHanded'][0];
        $userThrowHanded = $user['throwHanded'][0];
        
        //ユーザの全試合のプレイヤーNoを取得する
        $playerNo = $this->Player->getUserPlayerNo($userNo);
        //プレイヤーの全ての打席の打席確定時の状況Noを取得する
        if(count($playerNo) == 0){
            //プレイヤーNoが無い場合は空
            $battedSituationNo = null;
        }else{
            $battedSituationNo = $this->Situation->getBattedSituationNo($playerNo);
        }
        
        if(count($playerNo) == 0){
            //プレイヤーNoが無い場合は0を入れる
            $matchNum = 0;
            $rbi = 0;
            $run = 0;
            $steal = 0;
            $caughtSteal = 0;
        }else{
            //試合数を取得
            $matchNum = $this->Position->getParticipateNum($playerNo);
            //打点の合計を取得
            $rbi = $this->Scoring->getRBI($playerNo);
            //得点の合計を取得
            $run = $this->Scoring->getRun($playerNo);
            //盗塁の合計を取得
            $steal = $this->Steal->getSteal($playerNo);
            //盗塁死の合計を取得
            $caughtSteal = $this->Steal->getCaughtSteal($playerNo);
        }
        
        //打者成績取得
        if(count($battedSituationNo) == 0){
            //打席確定後の状況Noが無い場合は0を入れる
            $plateAppearance = 0;
            $atbat = 0;
            $hit = 0;
            $single = 0;
            $double = 0;
            $triple = 0;
            $homerun = 0;
            $strikeOut = 0;
            $fourDeadBall = 0;
            $sacrifice = 0;
            $doublePlay = 0;
            $battedCoordinate = "";
            
            for($i = 1; $i <= 25; $i++){
                $courseAvg['allAtbat'][$i] = "------";
                $courseAvg['vsRightAtbat'][$i] = "------";
                $courseAvg['vsLeftAtbat'][$i] = "------";
            }
            
        }else{
            //打席数を取得
            $plateAppearance = $this->Course->getPlateAppearance($battedSituationNo);
            //打数を取得
            $atbat = $this->Course->getAtbat($battedSituationNo);
            //ヒット（単打・長打すべて）の合計を取得
            $hit = $this->Course->getHit($battedSituationNo);
            //シングルヒットの合計を取得
            $single = $this->Course->getSingle($battedSituationNo);
            //二塁打の合計を取得
            $double = $this->Course->getDouble($battedSituationNo);
            //三塁打の合計を取得
            $triple = $this->Course->getTriple($battedSituationNo);
            //本塁打の合計を取得
            $homerun = $this->Course->getHomerun($battedSituationNo);
            
            //三振の合計を取得
            $strikeOut = $this->Course->getStrikeOut($battedSituationNo);
            //四死球の合計を取得
            $fourDeadBall = $this->Course->getFourDeadBall($battedSituationNo);
            //犠打・犠飛の合計を取得
            $sacrifice = $this->Course->getSacrifice($battedSituationNo);
            //併殺打の合計を取得
            $doublePlay = $this->Course->getDoublePlay($battedSituationNo);
            
            //打球位置座標を取得
            $battedCoordinate = $this->BattedBall->getSituationCoordinate($battedSituationNo);
            
            //コース別打率を取得
            // $courseDivide = array(1 => array('allAtbat' => 0), 2 => array('allAtbat' => 0), 3 => array('allAtbat' => 0), 
            //     4 => array('allAtbat' => 0), 5 => array('allAtbat' => 0), 6 => array('allAtbat' => 0), 7 => array('allAtbat' => 0), 
            //     8 => array('allAtbat' => 0), 9 => array('allAtbat' => 0), 10 => array('allAtbat' => 0), 11 => array('allAtbat' => 0), 
            //     12 => array('allAtbat' => 0), 13 => array('allAtbat' => 0), 14 => array('allAtbat' => 0), 15 => array('allAtbat' => 0), 
            //     16 => array('allAtbat' => 0), 17=> array('allAtbat' => 0),
            //     18 => array('allAtbat' => 0), 19 => array('allAtbat' => 0), 20 => array('allAtbat' => 0), 21 => array('allAtbat' => 0), 
            //     22 => array('allAtbat' => 0), 23 => array('allAtbat' => 0), 24 => array('allAtbat' => 0), 25=> array('allAtbat' => 0));
            
            for($i = 1; $i <= 25; $i++){
                $courseDivide[$i] = array('allAtbat' => 0,
                                          'allAtbatHit' => 0,
                                          'vsRightAtbat' => 0,
                                          'vsRightAtbatHit' => 0,
                                          'vsLeftAtbat' => 0,
                                          'vsLeftAtbatHit' => 0
                                          );
                $courseAvg['allAtbat'][$i] = 0;
                $courseAvg['vsRightAtbat'][$i] = 0;
                $courseAvg['vsLeftAtbat'][$i] = 0;
            }
            
            //状況Noに対応した投球情報を取得する
            $courseCoordinate = $this->Course->getAtbatCourse($battedSituationNo);
            //コースごとに何打席存在するか取得
            foreach($courseCoordinate as $key => $value){
                //コースのx軸
                $x = ceil($value['coordinateX'] / 60);
                //コースのy軸
                $y = ceil($value['coordinateY'] / 60) - 1;
                //25分割した際にどこに位置するか取得
                $courseDividePosition = $x + $y * 5;
                //打席結果が打数に含まれるか取得
                $atbatNum = $this->Course->getAtbat($value['situationNo']);
                //打席結果が安打に含まれるか取得
                $hitNum = $this->Course->getHit($value['situationNo']);
                //全打数に追加
                $courseDivide[$courseDividePosition]['allAtbat'] = $courseDivide[$courseDividePosition]['allAtbat'] + $atbatNum;
                //全安打に追加
                $courseDivide[$courseDividePosition]['allAtbatHit'] = $courseDivide[$courseDividePosition]['allAtbatHit'] + $hitNum;
                //対戦投手の利き腕を取得
                $throwHanded = $this->Player->getPitcheHanded($value['situationNo']);
                
                if($throwHanded == "右"){
                    //対右打数に追加
                    $courseDivide[$courseDividePosition]['vsRightAtbat'] = $courseDivide[$courseDividePosition]['vsRightAtbat'] + $atbatNum;
                    //対右安打に追加
                    $courseDivide[$courseDividePosition]['vsRightAtbatHit'] = $courseDivide[$courseDividePosition]['vsRightAtbatHit'] + $hitNum;
                }else if($throwHanded == "左"){
                    //対左打数に追加
                    $courseDivide[$courseDividePosition]['vsLeftAtbat'] = $courseDivide[$courseDividePosition]['vsLeftAtbat'] + $atbatNum;
                    //対左安打に追加
                    $courseDivide[$courseDividePosition]['vsLeftAtbatHit'] = $courseDivide[$courseDividePosition]['vsLeftAtbatHit'] + $hitNum;
                }
            }
            
            foreach($courseDivide as $key => $value){
                if($value['allAtbatHit'] == 0){
                    if($value['allAtbat'] == 0){
                        $courseAvg['allAtbat'][$key] = '------';
                    }else{
                        $courseAvg['allAtbat'][$key] = number_format(0, 3);
                    }
                    
                }else{
                    $courseAvg['allAtbat'][$key] = number_format(round($value['allAtbatHit'] / $value['allAtbat'], 3), 3);
                }
                
                if($value['vsRightAtbatHit'] == 0){
                    if($value['vsRightAtbat'] == 0){
                        $courseAvg['vsRightAtbat'][$key] = '------';
                    }else{
                        $courseAvg['vsRightAtbat'][$key] = number_format(0, 3);
                    }
                    
                }else{
                    $courseAvg['vsRightAtbat'][$key] = number_format(round($value['vsRightAtbatHit'] / $value['vsRightAtbat'], 3), 3);
                }
                
                if($value['vsLeftAtbatHit'] == 0){
                    if($value['vsLeftAtbat'] == 0){
                        $courseAvg['vsLeftAtbat'][$key] = '------';
                    }else{
                        $courseAvg['vsLeftAtbat'][$key] = number_format(0, 3);
                    }
                    
                }else{
                    $courseAvg['vsLeftAtbat'][$key] = number_format(round($value['vsLeftAtbatHit'] / $value['vsLeftAtbat'], 3), 3);
                }
            }
            
        }
        // var_dump($courseAvg);
        
        //投手成績取得
        //現在取得する投手情報は交代を考慮していない
        
        
        //勝利数の合計
        $win = 0;
        //敗戦の合計を取得
        $lose = 0;
        //投球時の打席確定時の状況No取得
        if(count($playerNo) == 0){
            $battedSituationPitchNo = null;
        }else{
            $battedSituationPitchNo = $this->Situation->getBattedSituationPitchNo($playerNo);
        }
        
        //投手として出場した試合Noを取得
        if(count($playerNo) == 0){
            $pitchMatch = null;
        }else{
            $pitchMatch = $this->Position->getPitchParticipateMatch($playerNo);
        }
        
        //投手として出場した試合数を取得
        $pitchMatchNum = count($pitchMatch);
        
        //勝利・敗戦数の計算
        if($pitchMatch == null){
            
        }else{
            foreach($pitchMatch as $row){
                //自チームが先攻か後攻か取得
                $myteamTom = $this->Match->getMyteamTop($row)[0];
                if($myteamTom == 0){
                    $myteamTom = false;
                }else{
                    $myteamTom = true;
                }
                
                //自チームの得点を取得
                $myteamRun = $this->Scoring->getTeamScoring($myteamTom, $row);
                //敵チームの得点を取得
                $opponentTeamRun = $this->Scoring->getTeamScoring(!$myteamTom, $row);
                //得点を比較
                if($myteamRun > $opponentTeamRun){
                    $win++;
                }else if($myteamRun < $opponentTeamRun){
                    $lose++;
                }
            }
        }
        
        
        
        
        //投球回の合計を取得
        if(count($playerNo) == 0){
            $pitchInning = null;
            $inningSum = 0;
        }else{
            $pitchInning = $this->Situation->getInningsPitched($playerNo);
            $inningSum = array_sum($pitchInning['inning']);
            
            //端数の調整
            $fractionSum = array_sum($pitchInning['out']);
            $fractionNum = count($pitchInning['out']);
            $minusInning = $fractionNum * 3 - $fractionSum;
            $fractionInning = $minusInning % 3;
            $minusInning = floor($minusInning/3);
            $inningSum = $inningSum - $minusInning;
            
            if($fractionInning == 1){
                $fractionInning = 0.2;
            }else if($fractionInning == 2){
                $fractionInning = 0.1;
            }
            
            if($fractionInning != 0){
                $inningSum = $inningSum - 1;
                $inningSum = $inningSum + $fractionInning;
            }
        }
        
        
        
        
        if(count($battedSituationPitchNo) == 0){
            $hitsAllowed = 0;
            $homeRunsAllowed = 0;
            $fourDeadBallAllowed = 0;
            $runsAllowed = 0;
            $earnedRuns = 0;
            $battedCoordinateAllowed = "";
            
            for($i = 1; $i <= 25; $i++){
                $courseAvgAllowed['allAtbat'][$i] = "------";
                $courseAvgAllowed['vsRightAtbat'][$i] = "------";
                $courseAvgAllowed['vsLeftAtbat'][$i] = "------";
            }
        }else{
            //被安打の合計を取得
            $hitsAllowed = $this->Course->getHit($battedSituationPitchNo);
            //被本塁打の合計を取得
            $homeRunsAllowed = $this->Course->getHomerun($battedSituationPitchNo);
            //与四死球の合計wお取得
            $fourDeadBallAllowed = $this->Course->getFourDeadBall($battedSituationPitchNo);
            //失点の合計を取得
            $runsAllowed = $this->Scoring->getSituationRun($battedSituationPitchNo);
            //自責点の合計を取得
            //現在は失点と同じ値を入れる
            $earnedRuns = $runsAllowed;
            //被打球位置を取得
            $battedCoordinateAllowed = $this->BattedBall->getSituationCoordinate($battedSituationPitchNo);
            // var_dump($battedCoordinateAllowed);
            //コース別被打率を取得
            
            for($i = 1; $i <= 25; $i++){
                $courseDivideAllowed[$i] = array('allAtbat' => 0,
                                          'allAtbatHit' => 0,
                                          'vsRightAtbat' => 0,
                                          'vsRightAtbatHit' => 0,
                                          'vsLeftAtbat' => 0,
                                          'vsLeftAtbatHit' => 0
                                          );
                $courseAvgAllowed['allAtbat'][$i] = 0;
                $courseAvgAllowed['vsRightAtbat'][$i] = 0;
                $courseAvgAllowed['vsLeftAtbat'][$i] = 0;
            }
            //状況Noに対応した投球情報を取得する
            $courseCoordinateAllowed = $this->Course->getAtbatCourse($battedSituationPitchNo);
            
            //コースごとに何打席存在するか取得
            foreach($courseCoordinateAllowed as $key => $value){
                //コースのx軸
                $x = ceil($value['coordinateX'] / 60);
                //コースのy軸
                $y = ceil($value['coordinateY'] / 60) - 1;
                //25分割した際にどこに位置するか取得
                $courseDividePosition = $x + $y * 5;
                //打席結果が打数に含まれるか取得
                $atbatNum = $this->Course->getAtbat($value['situationNo']);
                //打席結果が安打に含まれるか取得
                $hitNum = $this->Course->getHit($value['situationNo']);
                //全打数に追加
                $courseDivideAllowed[$courseDividePosition]['allAtbat'] = $courseDivideAllowed[$courseDividePosition]['allAtbat'] + $atbatNum;
                //全被安打に追加
                $courseDivideAllowed[$courseDividePosition]['allAtbatHit'] = 
                                                    $courseDivideAllowed[$courseDividePosition]['allAtbatHit'] + $hitNum;
                //対戦打者の利き腕を取得
                $battingHanded = $this->Player->getBatterHanded($value['situationNo']);
                
                if($battingHanded == "右"){
                    //対右打数に追加
                    $courseDivideAllowed[$courseDividePosition]['vsRightAtbat'] = 
                                                    $courseDivideAllowed[$courseDividePosition]['vsRightAtbat'] + $atbatNum;
                    //対右安打に追加
                    $courseDivideAllowed[$courseDividePosition]['vsRightAtbatHit'] = 
                                                    $courseDivideAllowed[$courseDividePosition]['vsRightAtbatHit'] + $hitNum;
                }else if($battingHanded == "左"){
                    //対左打数に追加
                    $courseDivideAllowed[$courseDividePosition]['vsLeftAtbat'] = 
                                                    $courseDivideAllowed[$courseDividePosition]['vsLeftAtbat'] + $atbatNum;
                    //対左安打に追加
                    $courseDivideAllowed[$courseDividePosition]['vsLeftAtbatHit'] = 
                                                    $courseDivideAllowed[$courseDividePosition]['vsLeftAtbatHit'] + $hitNum;
                }
            }
            
            
            foreach($courseDivideAllowed as $key => $value){
                if($value['allAtbatHit'] == 0){
                    if($value['allAtbat'] == 0){
                        $courseAvgAllowed['allAtbat'][$key] = '------';
                    }else{
                        $courseAvgAllowed['allAtbat'][$key] = number_format(0, 3);
                    }
                }else{
                    $courseAvgAllowed['allAtbat'][$key] = number_format(round($value['allAtbatHit'] / $value['allAtbat'], 3), 3);
                }
                
                if($value['vsRightAtbatHit'] == 0){
                    if($value['vsRightAtbat'] == 0){
                        $courseAvgAllowed['vsRightAtbat'][$key] = '------';
                    }else{
                        $courseAvgAllowed['vsRightAtbat'][$key] = number_format(0, 3);
                    }
                }else{
                    $courseAvgAllowed['vsRightAtbat'][$key] = number_format(round($value['vsRightAtbatHit'] / $value['vsRightAtbat'], 3), 3);
                }
                
                if($value['vsLeftAtbatHit'] == 0){
                    if($value['vsLeftAtbat'] == 0){
                        $courseAvgAllowed['vsLeftAtbat'][$key] = '------';
                    }else{
                        $courseAvgAllowed['vsLeftAtbat'][$key] = number_format(0, 3);
                    }
                }else{
                    $courseAvgAllowed['vsLeftAtbat'][$key] = number_format(round($value['vsLeftAtbatHit'] / $value['vsLeftAtbat'], 3), 3);
                }
            }
            
        }
        
        $record['選手名'] = $userName;
        $record['利き投げ'] = $userThrowHanded;
        $record['利き打ち'] = $userBattingHanded;
        $record['試合数'] = $matchNum;
        $record['打席数'] = $plateAppearance;
        $record['打数'] = $atbat;
        $record['安打'] = $hit;
        $record['単打'] = $single;
        $record['二塁打'] = $double;
        $record['三塁打'] = $triple;
        $record['本塁打'] = $homerun;
        $record['打点'] = $rbi;
        $record['得点'] = $run;
        $record['三振'] = $strikeOut;
        $record['四死球'] = $fourDeadBall;
        $record['犠打・犠飛'] = $sacrifice;
        $record['盗塁'] = $steal;
        $record['盗塁死'] = $caughtSteal;
        $record['併殺打'] = $doublePlay;
        $record['登板数'] = $pitchMatchNum;
        $record['勝利'] = $win;
        $record['敗戦'] = $lose;
        $record['投球回'] = $inningSum;
        $record['被安打'] = $hitsAllowed;
        $record['被本塁打'] = $homeRunsAllowed;
        $record['与四死球'] = $fourDeadBallAllowed;
        $record['失点'] = $runsAllowed;
        $record['自責点'] = $earnedRuns;
        
        $record['打球位置'] = $battedCoordinate;
        $record['被打球位置'] = $battedCoordinateAllowed;
        
        $record['コース別打率'] = $courseAvg;
        $record['コース別被打率'] = $courseAvgAllowed;
        return $record;
    }
    
    
    public function getMemberData($groupNo){
        //グループに所属するユーザのユーザNoを取得する
        $userNo = $this->Affiliation->getSelectedGroupMember($groupNo);
        //現行ユーザを取得
        $userNo = $this->User->getActiveUserNo($userNo);
        //ユーザの登録データを取得する
        $user = $this->User->getPlayerData($userNo);
        $userName = $user['name'];
        
        // var_dump($userName);
        
        foreach($userNo as $key => $value){
            $member[$key]['userNo'] = $value;
            $member[$key]['userName'] = $userName[$key];
        }
        
        $data = $member;
        
        return $data;
        
    }
}


?>