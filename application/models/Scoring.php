<?php

class Scoring extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //得点と打点を記録する
    public function setScoring($situationNo, $runner, $batter){
        $sql = 'insert into `scoring` (`situationNo`, `runner`, `batter`) values (?, ?, ?);';
        
        $value = array(
                $situationNo, 
                $runner, 
                $batter
            );
            
        //var_dump($sql);
        $this->db->query($sql, $value);
        
        return;
    }
    
    //選手の得点を返す
    public function getRun($runner){
        $sql = 'SELECT `situationNo` FROM `scoring` WHERE `runner` in(' . substr(str_repeat(',?', count($runner)), 1) .')';
        $value = $runner;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //選手の打点を返す
    public function getRBI($batter){
        $sql = 'SELECT `situationNo` FROM `scoring` WHERE `batter` in(' . substr(str_repeat(',?', count($batter)), 1) .')';
        $value = $batter;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //１打席の得点を返す
    public function getAtbatRun($situationNo){
        $sql = 'SELECT `situationNo` FROM `scoring` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .')';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //１打席の打点を返す
    public function getAtbatRbi($situationNo){
        $sql = 'SELECT `situationNo` FROM `scoring` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .')
              AND `batter` IS NOT NULL';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //送られた打席の得点の合計を返す
    public function getSituationRun($situationNo){
        $sql = 'SELECT `situationNo` FROM `scoring` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .')';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //試合のチームの得点を返す
    public function getTeamScoring($topBottom, $matchNo){
        $sql = 'SELECT `situationNo` FROM `scoring` WHERE `situationNo` in '.
               '(SELECT  `situationNo` from `situation` where `topBottom` = ? and `matchNo` = ? )';
        $value = array($topBottom, $matchNo);
        $query = $this->db->query($sql, $value);
        $situationNo = array_column($query->result('array'), 'situationNo');
        
        
        return count($situationNo);
        
    }
}