<?php
class TestTamura extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Match');
        $this->load->model('Player');
        $this->load->model('Position');
        $this->load->model('Situation');
        $this->load->model('Course');
        $this->load->model('User');
        $this->load->model('BattedBall');
        $this->load->library('session');
    }
    
    
    
    
    public function testSetAtbatData(){
        $situationNo = 31;
        $course[0] = array(
            "coordinateX" => 150,
            "coordinateY" => 200,
            "decisionNo" => 1,
            "typeOfPitchNo" => 1
            );
        
        $course[1] = array(
            "coordinateX" => 190,
            "coordinateY" => 100,
            "decisionNo" => 1,
            "typeOfPitchNo" => 1
            );
        
        $course[2] = array(
            "coordinateX" => 10,
            "coordinateY" => 300,
            "decisionNo" => 2,
            "typeOfPitchNo" => 2
            );
        
        $course[3] = array(
            "coordinateX" => 150,
            "coordinateY" => 200,
            "decisionNo" => 10,
            "typeOfPitchNo" => 1
            );
        
        
        
        $steal = "";
        $caughtSteal = "";
        $battedBall = "";
        $run = 0;
        $RBI = 0;
        $runner = array(
            0 => 0,
            1 => 0,
            2 => 0
            );
        
        $battedRunner = array(
            0 => 0,
            1 => 0,
            2 => 0
            );
        
        $battedOutcount = 0;
        
        // var_dump($situationNo, $course, $steal, $caughtSteal, $battedBall, $run, $RBI, $runner, $battedRunner, $battedOutcount);
        
        
        $this->setAtbatData($situationNo, $course, $steal, $caughtSteal, $battedBall, $run, $RBI, $runner, $battedRunner, $battedOutcount);
    }
    
    
    
    public function testViewRecord(){
        $this->load->view('result');
    }
    
    public function testTamura(){
        $this->load->view('testTamura');
    }
    
    public function testRecord(){
        $matchNo = 171;
        $userNo = 3;
        $playerNo = $this->Player->getMatchPlayerNo($matchNo,$userNo);
        // var_dump($playerNo);
        $a = $this->Situation->getBatterSituation($playerNo);
        var_dump($a);
    }
    
    
    public function testGetPlayerNo(){
        $userNo = 3;
        $playerNo = $this->Player->getUserPlayerNo($userNo);
        var_dump($playerNo);
    }
    
    
    public function testGetBattedSituation(){
        $userNo = 3;
        $playerNo = $this->Player->getUserPlayerNo($userNo);
        $situationNo = $this->Situation->getBattedSituationNo($playerNo);
        var_dump($situationNo);
    }
    
    
    public function testGetBatter(){
        $userNo = 3;
        $playerNo = $this->Player->getUserPlayerNo($userNo);
        $situationNo = $this->Situation->getBatter($playerNo);
        var_dump($situationNo);
    }
    
    public function testGetAtbat(){
        $userNo = 3;
        $playerNo = $this->Player->getUserPlayerNo($userNo);
        $situationNo = $this->Situation->getBattedSituationNo($playerNo);
        $atbat = $this->Course->getHit($situationNo);
        var_dump($atbat);
    }
    
    public function testAutoInputOrder(){
        $this->load->view('testTamura');
    }
    
    public function testSearchMatchNo(){
        $data = '2016-01-01';
        $opponent = '敵中';
        $matchNo = $this->Match->searchMatchNo($data, $opponent);
        var_dump($matchNo);
    }
    
    public function testGetCoordinate(){
        $courseNo = 488;
        $coordinate = $this->BattedBall->getCoordinate($courseNo);
        var_dump($coordinate);
    }
    
    public function testGetSituationGroupNo(){
        $situationNo = 837;
        $groupNo = $this->Match->getSituationGroupNo($situationNo);
        var_dump($groupNo);
    }
    
    public function testGetActiveUserNo(){
        $userNo = array(20);
        $userNo = $this->User->getActiveUserNo($userNo);
        var_dump(count($userNo));
    }
}