<?php

class Decision extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    
    public function getDecisionName($decisionNo){
        $sql = 'SELECT `decisionName` FROM `decision` WHERE `decisionNo` = ?';
        $value = $decisionNo;
        $query = $this->db->query($sql, $value);
        $decisionName = array_column($query->result('array'), 'decisionName')[0];
        return $decisionName;
    }
    
}