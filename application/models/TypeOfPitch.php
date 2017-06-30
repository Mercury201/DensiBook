<?php

class TypeOfPitch extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    
    public function getTypeOfPitchName($typeOfPitchNo){
        $sql = 'SELECT `typeOfPitchName` FROM `typeOfPitch` WHERE `typeOfPitchNo` = ?';
        $value = $typeOfPitchNo;
        $query = $this->db->query($sql, $value);
        $typeOfPitchName = array_column($query->result('array'), 'typeOfPitchName')[0];
        return $typeOfPitchName;
    }
    
}