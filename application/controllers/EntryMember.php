<?php
class EntryMember extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('User');
        $this->load->model('Affiliation');
        $this->load->model('Match');
        $this->load->model('Player');
        $this->load->model('Position');
        $this->load->model('Match');
        $this->load->model('Course');
        $this->load->model('BattedBall');
        $this->load->model('Situation');
        $this->load->model('Scoring');
        $this->load->model('Steal');
        $this->load->library('session');
        
        //$this->load->helper('url');
    }
    
    public function entry($groupNo){
        $userNo = $this->User->getUserNo($this->session->userdata('email'));
        // $userNo = 3;    //仮
        
        // $member['userNo']= $this->Affiliation->getGroupMember($userNo);
        
        $member['userNo'] = $this->Affiliation->getSelectedGroupMember($groupNo);
        
        $number = $member['userNo'];
        
        $number = $this->User->getActiveUserNo($number);
        
        $member = $this->User->getPlayerData($number);
        
        $member['groupNo'] = $groupNo;
        
        $this->load->view('inputOrder', $member);
    }
    
    public function entryPlayer(){
        
        $match[0] = $_POST["opponent"];
        $match[1] = $_POST["location"];
        $match[2] = date("Y-m-d");
        $match[3] = $_POST["topBottom"];
        $match[4] = $_POST["groupNo"];
        
        $matchNo = $this->Match->entryMatch($match);
        
        $bench = $_POST["benchNum"];
        $benchNumber = explode(',', $bench);
        // var_dump($benchNumber);
        
        if($benchNumber[0] != ""){
            $benchMember = $this->User->getPlayerData($benchNumber);
        
            $this->Player->setPlayer($benchMember, $matchNo);
        }
        
        
        for($i = 0; $i < 9; $i++){
            $j = $i+1;
            $number[$i] = $_POST["member$j"];
            $position[$i] = $_POST["position$j"];
            $battingOrder[$i] = $j;
        }
        
        
        //var_dump($number);
        
        //var_dump($position);
        $players = $this->User->getPlayerData($number);
        
        //var_dump($players);
        
        
        //var_dump($players);
        $playerId = $this->Player->setPlayer($players, $matchNo);
        
        //var_dump($playerId);
        
        
        $orders["num"] = $number;
        $orders["pos"] = $position;
        $orders["bat"] = $battingOrder;
        
        for($i = 0; $i < 9; $i++){
            $order[$number[$i]] = array_column($orders, $i);
        }
        // var_dump($order);
        ksort($order);
        // var_dump($order);
        
        $i = 0;
        foreach ($order as $data){
	    	$number[$i] = $data[0];
	    	$position[$i] = $data[1];
	    	$battingOrder[$i] = $data[2];
	    	
	    	$i++;
    	}
        
        
        
        for($i = 0; $i < 9; $i++){
            $playerNo[$i] = $playerId + $i;
        }
        
        
        $this->Position->entryOrder($playerNo, $battingOrder, $position, $matchNo);
        
        //相手チームのオーダー登録
        
        // $bench = $_POST["benchNum"];
        // $benchNumber = explode(',', $bench);
        // var_dump($benchNumber);
        
        $nameText = $_POST["opponentName"];
        $battingHandedText = $_POST["opponentBattingHanded"];
        $throwHandedText = $_POST["opponentThrowHanded"];
        $positionText = $_POST["opponentPosition"];
        
        $name = explode(',', $nameText);
        $battingHanded = explode(',', $battingHandedText);
        $throwHanded = explode(',', $throwHandedText);
        $position = explode(',', $positionText);
        
        
        
        // for($i = 0; $i < 9; $i++){
        //     $j = $i+1;
            
        //     $name[$i] = $_POST["name$j"];
        //     $battingHanded[$i] = $_POST["opponentBattingHanded$j"];
        //     $throwHanded[$i] = $_POST["opponentThrowHanded$j"];
        //     $position[$i] = $_POST["opponentPosition$j"];
        //     $battingOrder[$i] = $j;
        // }
        
        $opponent[0] = $name;
        
        $opponent[1] = $battingHanded;
        $opponent[2] = $throwHanded;
        //$opponent[3] = $position;
        
        
        $playerId = $this->Player->setOpponentPlayer($opponent, $matchNo);
        
        
        
        
        for($i = 0; $i < 9; $i++){
            $playerNo[$i] = $playerId + $i;
            $battingOrder[$i] = $i + 1;
        }
        
        // $opponentOrder[0] = $position;
        // $opponentOrder[1] = $playerNo;
        
        $this->Position->entryOrder($playerNo, $battingOrder, $position, $matchNo);
        
        // $this->load->view('testTamura', array('matchNo' => $matchNo));
        // $this->load->view('atbatView', array('matchNo' => $matchNo));
        
        //遷移する
        
        $this->playBall($matchNo);
        
    }
    
    
    //打席記録画面に必要なものを渡す
    public function playBall($matchNo){
        $batterNo = $this->getTopLeadOff($matchNo);
        $batter = $this->Player->getPlayerData($batterNo);
        $batterName = $batter['playerName'];
        $batterHanded = $batter['battingHanded'];
        
        $pitcherNo = $this->getTopPitcher($matchNo);
        $pitcher = $this->Player->getPlayerData($pitcherNo);
        $pitcherName = $pitcher['playerName'];
        $pitcherHanded = $pitcher['throwHanded'];
        
        $topBottom = true;
        $inning = 1;
        $plateAppearance = 1;
        $pitchCount = 0;
        $orderNo = 1;
        $battedOutcount = 0;
        
        $situationNo = $this->Situation->setSituation(null, null, null, $batterNo, $pitcherNo, $topBottom, $inning, $plateAppearance,
                                                      $pitchCount, $matchNo, null, null, null);
        
        if($topBottom){
            $topBottom = "表";
        }else{
            $topBottom = "裏";
        }
        
        // var_dump($situationNo);
        
        $firstRunnerNo = 0;
        $firstRunnerName = "";
        $secondRunnerNo = 0;
        $secondRunnerName = "";
        $thirdRunnerNo = 0;
        $thirdRunnerName = "";
        
        
        $data['situationNo'] = $situationNo;
        $data['inning'] = $inning;
        $data['topBottom'] = $topBottom;
        $data['battedOutcount'] = $battedOutcount;
        $data['orderNo'] = $orderNo;
        $data['batterNo'] = $batterNo;
        $data['batterName'] = $batterName;
        $data['batterHanded'] = $batterHanded;
        $data['pitcherNo'] = $pitcherNo;
        $data['pitcherName'] = $pitcherName;
        $data['pitcherHanded'] = $pitcherHanded;
        $data['firstRunnerNo'] = $firstRunnerNo;
        $data['firstRunnerName'] = $firstRunnerName;
        $data['secondRunnerNo'] = $secondRunnerNo;
        $data['secondRunnerName'] = $secondRunnerName;
        $data['thirdRunnerNo'] = $thirdRunnerNo;
        $data['thirdRunnerName'] = $thirdRunnerName;
        
        $this->load->view('atbatRecord', $data);
    }
    
    
    //先攻の1番バッターを返す
    public function getTopLeadOff($matchNo){
        
        $readOff = $this->Position->getLeadOff($matchNo);
        // var_dump($readOff);
        
        $userNo = $this->Player->getUserNo($readOff[0]);
        // var_dump($userNo);
        
        $myeamMember = array(2);
        if($userNo[0] == null){
            $myeamMember[0] = false;
            $myeamMember[1] = true;
        }else{
            $myeamMember[0] = true;
            $myeamMember[1] = false;
        }
        
        // var_dump($myeamMember);
        
        
        $myteamTop = $this->Match->getMyteamTop($matchNo);
        
        // var_dump($myteamTop);
        if($myteamTop[0] == 1){
            $myteamTop[0] = true;
        }else{
            $myteamTop[0] = false;
        }
        // var_dump($myteamTop[0]);
        // var_dump($myeamMember[0]);
        $a = ($myteamTop[0] xor $myeamMember[0]);
        // var_dump($a);
        
        
        if($a){
            // var_dump($readOff[1]);
            
            return $readOff[1];
        }else{
            // var_dump($readOff[0]);
            return $readOff[0];
        }
    }
    
    //試合開始時のピッチャーを返す
    public function getTopPitcher($matchNo){
        $pitchers = $this->Position->getStartingPitcher($matchNo);
        // var_dump($pitchers);
        
        $userNo = $this->Player->getUserNo($pitchers[0]);
        
        $myeamMember = array(2);
        if($userNo[0] == null){
            $myteamMember[0] = false;
            $myteamMember[1] = true;
        }else{
            $myteamMember[0] = true;
            $myteamMember[1] = false;
        }
        
        
        $myteamTop = $this->Match->getMyteamTop($matchNo);
        
        // var_dump($myteamTop);
        if($myteamTop[0] == 1){
            $myteamTop[0] = true;
        }else{
            $myteamTop[0] = false;
        }
        
        
        $a = ($myteamTop[0] xor $myteamMember[0]);
        // var_dump($a);
        
        
        if($a){
            // var_dump($readOff[1]);
            
            return $pitchers[0];
        }else{
            // var_dump($readOff[0]);
            return $pitchers[1];
        }
        
    }
    
    
    public function getCurrentSituation($situation, $battedOutcount){
        $situationNo = $situation['situationNo'];
        
        
        $inning = $situation['inning'];
        $topBottom = $situation['topBottom'];
        
        
        
        $pitcherNo = $situation['pitcher'];
        $pitcher = $this->Player->getPlayerData($pitcherNo);
        $pitcherName = $pitcher['playerName'];
        $pitcherHanded = $pitcher['throwHanded'];
        
        $nextBatter = $this->getNextBatter($situation['batter'], $situation['matchNo']);
        
        $batterNo = $nextBatter[0];
        
        $orderNo = $nextBatter[1];
        
        // var_dump($orderNo);
        
        $batter = $this->Player->getPlayerData($batterNo);
        $batterName = $batter['playerName'];
        $batterHanded = $batter['battingHanded'];
        
        // var_dump($batterName);
        
        
        $runner = $this->getRunner($situationNo);
        
        $firstRunnerNo = $this->nullChange($runner[0][0], 0);
        $firstRunnerName = $this->nullChange($runner[1][0], "");
        $secondRunnerNo = $this->nullChange($runner[0][1], 0);
        $secondRunnerName = $this->nullChange($runner[1][1], "");
        $thirdRunnerNo = $this->nullChange($runner[0][2], 0);
        $thirdRunnerName = $this->nullChange($runner[1][2], "");
        
        
        
        $data['situationNo'] = $situationNo;
        $data['inning'] = $inning;
        $data['topBottom'] = $topBottom;
        $data['battedOutcount'] = $battedOutcount;
        $data['orderNo'] = $orderNo;
        $data['batterNo'] = $batterNo;
        $data['batterName'] = $batterName;
        $data['batterHanded'] = $batterHanded;
        $data['pitcherNo'] = $pitcherNo;
        $data['pitcherName'] = $pitcherName;
        $data['pitcherHanded'] = $pitcherHanded;
        $data['firstRunnerNo'] = $firstRunnerNo;
        $data['firstRunnerName'] = $firstRunnerName;
        $data['secondRunnerNo'] = $secondRunnerNo;
        $data['secondRunnerName'] = $secondRunnerName;
        $data['thirdRunnerNo'] = $thirdRunnerNo;
        $data['thirdRunnerName'] = $thirdRunnerName;
        
        // $this->load->view('testTamura', $data);
        $this->load->view('atbatRecord', $data);
        
        
    }
    
    
    
    public function setNextSituation($situation, $battedOutcount){
        if($battedOutcount == 3){
            $battedOutcount = 0;
            if($situation['topBottom']){
                $situation['topBottom'] = false;
            }else{
                
                $situation['topBottom'] = true;
                $situation['inning']++;
                
            }
            
            $situation['plateAppearance'] = 1;
            
            if($situation['inning'] == 1){
                $batters = $this->Position->getLeadOff($situation['matchNo']);
                // var_dump($situation);
                $topLeadOff = $this->getTopLeadOff($situation['matchNo']);
                $orderNo = 1;
                if($batters[0] == $topLeadOff){
                    $situation['batter'] = $batters[1];
                }else{
                    $situation['batter'] = $batters[0];
                }
                
            }else{
                
                $beforeBatter = $this->Situation->getLastBatter($situation['matchNo'], ($situation['inning'] - 1), $situation['topBottom']);
                $newBatter = $this->getNextBatter($beforeBatter, $situation['matchNo']);
                $situation['batter'] = $newBatter[0];
                $orderNo = $newBatter[1];
            }
            
            $situation['firstRunner'] = null;
            $situation['secondRunner'] = null;
            $situation['thirdRunner'] = null;
            
            $situation['pitcher'] = $this->Position->getNextPitcher($situation['matchNo'], $situation['pitcher']);
            
            
        }else{
            // var_dump($situation['batter']);
            $newBatter = $this->getNextBatter($situation['batter'], $situation['matchNo']);
            // var_dump($newBatter);
            $situation['batter'] = $newBatter[0];
            $orderNo = $newBatter[1];
            // var_dump($situation['batter']);
            $situation['plateAppearance']++;
        }
        
        $situation['pitchCount'] = 0;
        
        
        $situation['situationNo'] = $this->Situation->setSituation($situation['firstRunner'], $situation['secondRunner'], 
                                    $situation['thirdRunner'], $situation['batter'], $situation['pitcher'], $situation['topBottom'],
                                    $situation['inning'], $situation['plateAppearance'], 0, $situation['matchNo'], null, null, null);
        
        $batter = $this->Player->getPlayerData($situation['batter']);
        $batterName = $batter['playerName'];
        $batterHanded = $batter['battingHanded'];
        $pitcher = $this->Player->getPlayerData($situation['pitcher']);
        $pitcherName = $pitcher['playerName'];
        $pitcherHanded = $pitcher['throwHanded'];
        
        if($situation['firstRunner'] == null){
            $firstRunnerNo = 0;
            $firstRunnerName = "";
        }else{
            $firstRunnerNo = $situation['firstRunner'];
            $firstRunnerName = $this->Player->getPlayerName($firstRunnerNo)[0];
        }
        
        
        if($situation['secondRunner'] == null){
            $secondRunnerNo = 0;
            $secondRunnerName = "";
        }else{
            $secondRunnerNo = $situation['secondRunner'];
            $secondRunnerName = $this->Player->getPlayerName($secondRunnerNo)[0];
        }
        
        
        if($situation['thirdRunner'] == null){
            $thirdRunnerNo = 0;
            $thirdRunnerName = "";
        }else{
            $thirdRunnerNo = $situation['thirdRunner'];
            $thirdRunnerName = $this->Player->getPlayerName($thirdRunnerNo)[0];
        }
        
        if($situation['topBottom']){
            $topBottom = "表";
        }else{
            $topBottom = "裏";
        }
        
        
        $data['situationNo'] = $situation['situationNo'];
        $data['inning'] = $situation['inning'];
        $data['topBottom'] = $topBottom;
        $data['battedOutcount'] = $battedOutcount;
        $data['orderNo'] = $orderNo;
        $data['batterNo'] = $situation['batter'];
        $data['batterName'] = $batterName;
        $data['batterHanded'] = $batterHanded;
        $data['pitcherNo'] = $situation['pitcher'];
        $data['pitcherName'] = $pitcherName;
        $data['pitcherHanded'] = $pitcherHanded;
        $data['firstRunnerNo'] = $firstRunnerNo;
        $data['firstRunnerName'] = $firstRunnerName;
        $data['secondRunnerNo'] = $secondRunnerNo;
        $data['secondRunnerName'] = $secondRunnerName;
        $data['thirdRunnerNo'] = $thirdRunnerNo;
        $data['thirdRunnerName'] = $thirdRunnerName;
        
        $this->load->view('atbatRecord', $data);
        
        
    }
    
    
    
    
    public function getNextBatter($batter, $matchNo){
        // var_dump($batter);
        
        // var_dump($batter);
        $orderNo = $this->Position->getOrderNo($batter);
        
        $orderNo[0]++;
        if($orderNo[0] == 10){
            $orderNo[0] = 1;
        }
        // var_dump($orderNo);
        // die();
        
        $members = $this->Position->getOrderBatter($matchNo, $orderNo);
        
        // var_dump($members);
        
        $batterUserNo = $this->Player->getUserNo($batter);
        if($batterUserNo[0] != null){
            $myteamMember = true;
        }else{
            $myteamMember = false;
        }
        
        
        
        // var_dump($topBottom);
        
        $userNo = $this->Player->getUserNo($members[0]);
        
        if($userNo != null){
            $myteam0 = true;
        }else{
            $myteam0 = false;
        }
        // var_dump($myteamMember);
        // var_dump($myteam0);
        
        
        
        if($myteamMember xor $myteam0){
            $nextBatter[0] = $members[1];
            $nextBatter[1] = $orderNo[0];
            
        }else{
            $nextBatter[0] = $members[0];
            $nextBatter[1] = $orderNo[0];
        }
        return $nextBatter;
    }
    
    
    
    public function getRunner($situationNo){
        $runnerNo = $this->Situation->getRunner($situationNo);
        
        for($i = 0; $i < 3; $i++){
            if($runnerNo[$i] == null){
                $runnerNo[$i] = 0;
                $runnerName[$i] = "";
            }else{
                $runnerName[$i] = $this->Player->getPlayerName($runnerNo[$i])[0];
            }
        }
        
        $runner[0] = $runnerNo;
        $runner[1] = $runnerName;
        // var_dump($runnerName);
        
        // var_dump($runner);
        // die();
        
        return $runner;
    }
    
    public function receiveAtbatData(){
        $situationNo = $_POST["situationNo"];
        // var_dump($situationNo);
        
        $courseText = $_POST["array"];
        
        $courseArray = explode(',', $courseText);
        
        // var_dump($courseText);
        // die();
        
        
        for($i = 0; $i < count($courseArray) / 4; $i++){
            $j = $i*4;
            $course[$i]['coordinateX'] = $courseArray[$j];
            $j++;
            $course[$i]['coordinateY'] = $courseArray[$j];
            $j++;
            $course[$i]['decisionNo'] = $courseArray[$j];
            $j++;
            $course[$i]['typeOfPitchNo'] = $courseArray[$j];
        }
        
        // var_dump($course);
        
        $stealText = $_POST["stealArray"];
        // $stealText = "2232";    //バッターの値が返ってきたので仮に設定
        if($stealText != ""){
            $stealArray = explode(',', $stealText);
        }else{
            $stealArray = "";
        }
        // var_dump("盗塁成功データ");
        // var_dump($stealText);
        // var_dump($stealArray);
        
        $caughtStealText = $_POST["outStealArray"];
        // var_dump($caughtStealText);
        if($caughtStealText != ""){
            $caughtStealArray = explode(',', $caughtStealText);
        }else{
            $caughtStealArray = "";
        }
        // var_dump("盗塁失敗データ");
        // var_dump($caughtStealText);
        // var_dump($caughtStealArray);
        
        $battedBall['coordinateX'] = $_POST["battedBallx"];
        $battedBall['coordinateY'] = $_POST["battedBally"];
        
        
        $runMemberText = $_POST["scoreArray"];
        // var_dump($runMemberText);
        if($runMemberText != ""){
            $runMember = explode(',', $runMemberText);
        }else{
            $runMember = "";
        }
        // var_dump($runMember);
        // var_dump($runMember);
        
        // die();
        
        // var_dump($run);
        
        if(isset($_POST["rbi"])){
            $rbi = $_POST["rbi"];
        }else{
            $rbi = 0;
        }
        // var_dump($rbi);
        
        
        // var_dump($rbi);
        // die();
        
        $runnerText = $_POST["runnerArray"];
        $runnerArray = explode(',', $runnerText);
        $runner[0] = $runnerArray[1];
        $runner[1] = $runnerArray[2];
        $runner[2] = $runnerArray[3];
        
        // var_dump("runner");
        // var_dump($runnerText);
        
        $battedRunnerText = $_POST["battedRunnerArray"];
        $battedRunner = explode(',', $battedRunnerText);
        
        // var_dump($battedRunner);
        // var_dump($battedRunnerText);
        // die();
        $battedOutcount = $_POST["afteroutCount"];  
        // var_dump($battedOutcount);
        // die();
        
        $strike = $_POST["StrikeCount"];
        $ball = $_POST["BallCount"];
        $out = $_POST["outCount"];
        // var_dump($courseText);
        // die();
        
        $this->setAtbatData($situationNo, $course, $stealArray, $caughtStealArray, $battedBall, $runMember, $rbi, $runner, $battedRunner,
                            $battedOutcount, $strike, $ball, $out);
        
        // var_dump($out);
        
        $groupNo = $this->Match->getSituationGroupNo($situationNo);
        
        //ここに試合終了だった場合の処理
        if($_POST['end'] == '試合終了'){
            redirect(site_url('GroupMenu/index/'.$groupNo));
        }
        
    }
    
    public function setAtbatData($situationNo, $course, $steal, $caughtSteal, $battedBall, $run, $RBI, $runner, $battedRunner, $battedOutcount,
                                 $strike, $ball, $out){
        
        foreach($course as $Row){
            $situationNo = $this->setSituationPitch($situationNo);
            
            $this->setCourse($situationNo, $Row['coordinateX'], $Row['coordinateY'], $Row['decisionNo'], $Row['typeOfPitchNo']);
            
            
        }
        
        if($steal != ""){
            
            foreach($steal as $Row){
                // $this->setSteal($situationNo, $Row['playerNo'], $Row['succecc'], $Row['countNo']);
                // var_dump($Row);
                $this->setSteal($situationNo, $Row, true, 1);
            }
            
        }
        
        if($caughtSteal != ""){
            
            foreach($caughtSteal as $Row){
                // $this->setSteal($situationNo, $Row['playerNo'], $Row['succecc'], $Row['countNo']);
                // var_dump($Row);
                $this->setSteal($situationNo, $Row, false, 1);
            }
            
        }
        
        
        // if($run != 0){
        //     $this->setScoring($situationNo, $run, $RBI);
        // }
        
        if($run != ""){
            $situation = $this->Situation->getSituation($situationNo);
            foreach($run as $row){
                if($RBI > 0){
                    $this->Scoring->setScoring($situationNo, $row, $situation['batter']);
                    $RBI--;
                }else{
                    $this->Scoring->setScoring($situationNo, $row, null);
                }
            }
        }
        
        if($battedBall['coordinateX'] != ""){
            $this->setBattedBall($situationNo, $battedBall['coordinateX'], $battedBall['coordinateY']);
        }
        
        
        // var_dump("a");
        $situation = $this->Situation->getSituation($situationNo);
        // var_dump("b");
        $pitchCount = $situation['pitchCount'];
        
        $startRunner = array(
            $situation['firstRunner'],
            $situation['secondRunner'],
            $situation['thirdRunner']
            );
        
        
        $runner[0] = $this->zeroChange($runner[0], null);
        $runner[1] = $this->zeroChange($runner[1], null);
        $runner[2] = $this->zeroChange($runner[2], null);
        $battedRunner[0] = $this->zeroChange($battedRunner[0], null);
        $battedRunner[1] = $this->zeroChange($battedRunner[1], null);
        $battedRunner[2] = $this->zeroChange($battedRunner[2], null);
            
        // var_dump($startRunner);
        // var_dump($runner);
        
        
        
        if($runner === $startRunner){
            
        }else{
            // var_dump("AAA".$startRunner[0], $startRunner[1], $startRunner[2], $situation['topBottom'], $situation['inning'], 
            //                               $situation['plateAppearance'], ($situation['pitchCount'] - 1));
            $this->Situation->updateRunner($startRunner[0], $startRunner[1], $startRunner[2], $situation['topBottom'], $situation['inning'], 
                                           $situation['plateAppearance'], ($situation['pitchCount'] - 1));
            
            
        }
        
        $this->Situation->setCount($strike, $ball, $out, $situation['topBottom'], $situation['inning'], 
                                           $situation['plateAppearance'], ($situation['pitchCount'] - 1));
        
        $this->Situation->setCount(null, null, $battedOutcount, $situation['topBottom'], $situation['inning'], 
                                           $situation['plateAppearance'], ($situation['pitchCount']));
        
        if($runner === $battedRunner){
            
        }else{
            // var_dump("BBB".$startRunner[0], $startRunner[1], $startRunner[2], $situation['topBottom'], $situation['inning'], 
            //                               $situation['plateAppearance'], $situation['pitchCount']);
            $this->Situation->updateRunner($battedRunner[0], $battedRunner[1], $battedRunner[2], $situation['topBottom'], $situation['inning'], 
                                           $situation['plateAppearance'], $situation['pitchCount']);
            
        }
        // var_dump("a");
        $situation = $this->Situation->getSituation($situationNo);
        // var_dump("b");
        $this->setNextSituation($situation, $battedOutcount);
        
        
    }
    
    
    public function setSituationPitch($situationNo){
        // var_dump("a");
        $situation = $this->Situation->getSituation($situationNo);
        // var_dump("b");
        
        $situation['pitchCount'] += 1;
        
        // var_dump($situation['pitchCount']);
        
        $situationNo = $this->Situation->setSituation($situation['firstRunner'], $situation['secondRunner'], $situation['thirdRunner'],
                        $situation['batter'], $situation['pitcher'], $situation['topBottom'], $situation['inning'],
                        $situation['plateAppearance'], $situation['pitchCount'], $situation['matchNo'], null, null, null);
        
        return $situationNo;
    }
    
    
    public function setCourse($situationNo, $coordinateX, $coordinateY, $decisionNo, $typeOfPitchNo){
        $matchNo = $this->Situation->getMatchNo($situationNo)[0];
        
        $this->Course->setCourse($matchNo, $situationNo, $coordinateX, $coordinateY, $decisionNo, $typeOfPitchNo);
    }
    
    
    public function setSteal($situationNo, $playerNo, $success, $countNum){
        $matchNo = $this->Situation->getMatchNo($situationNo);
        // var_dump("a");
        $situation = $this->Situation->getSituation($situationNo);
        // var_dump("b");
        
        $situationNo = $this->Situation->getStealSituation($situation['topBottom'], $situation['inning'], $situation['plateAppearance'], 
                                                           $countNum, $matchNo)[0];
        
        // var_dump($situationNo);                 
        $situation = $this->Situation->getSituation($situationNo);
        // var_dump("b");
        $this->Steal->setSteal($situationNo, $playerNo, $success);
    }
    
    
    public function setBattedBall($situationNo, $coordinateX, $coordinateY){
        
        $courseNo = $this->Course->getCourseNo($situationNo);
        
        $this->BattedBall->setBattedBall($courseNo, $coordinateX, $coordinateY);
    }
    
    public function setScoring($situationNo, $runCount, $RBI){
        // var_dump($situationNo);
        // die();
        $runner = $this->Situation->getRunner($situationNo);
        $situation = $this->Situation->getSituation($situationNo);
        $runnerCount = $runCount;
        $RBICount = $RBI;
        
        for($i = 2; $i >= 0; $i--){
            
            if($runner[$i] != null){
                
                if($runnerCount > 0){
                    
                    if($RBICount > 0){
                        $batter = $situation['batter'];
                        $RBICount--;
                    }else{
                        $batter = null;
                    }
                    // var_dump("a");
                    $this->Scoring->setScoring($situationNo, $runner[$i], $batter);
                    $runnerCount--;
                }
            }
            
            
        }
        
        if($runnerCount > 0){
            if($RBI > 0){
                // var_dump("b");
                $this->Scoring->setScoring($situationNo, $situation['batter'], $situation['batter']);
            }else{
                // var_dump("c");
                $this->Scoring->setScoring($situationNo, $situation['batter'], null);
            }
            
        }
    }
    
    
    public function nullChange($variable, $char){
        if($variable == null){
            return $char;
        }else{
            return $variable;
        }
    }
    
    
    public function zeroChange($variable, $char){
        if($variable == 0){
            return $char;
        }else{
            return $variable;
        }
    }
}