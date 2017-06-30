<?php

class Steal extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //盗塁テーブル入力
    public function setSteal($situationNo, $playerNo, $success){
        $sql = 'insert into `steal` (`situationNo`, `playerNo`, `success`) values (?, ?, ?);';
        
        $value = array(
                $situationNo,
                $playerNo,
                $success
            );
            
        //var_dump($sql);
        $this->db->query($sql, $value);
        
        return;
    }
    
    //選手の盗塁成功数を返す
    public function getSteal($playerNo){
        $sql = 'SELECT `stealNo` FROM `steal` WHERE `playerNo` in(' . substr(str_repeat(',?', count($playerNo)), 1) .')
                AND `success` = 1';
        $value = $playerNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //選手の盗塁死数を返す
    public function getCaughtSteal($playerNo){
        $sql = 'SELECT `stealNo` FROM `steal` WHERE `playerNo` in(' . substr(str_repeat(',?', count($playerNo)), 1) .')
                AND `success` = 0';
        $value = $playerNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
}