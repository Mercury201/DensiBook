<?php

class Course extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //投球内容の登録
    public function addCourse($matchNo,$situationNo,$X,$Y,$countNo,$decisionNo){
        
        $sql = 'INSERT INTO course (matchNo,situationNo,coordinateX,coordinateY,decisionNo,typeOfPitchNo) 
        VALUES (?,?,?,?,?,?)';
        
        $value = array(
                $matchNo,
                $situationNo,
                $X,
                $Y,
                $countNo,
                $decisionNo
            );
            
        $this->db->query($sql,$value);
        return;
    }
    
    
    //状況Noの一致するコースNoを返す
    public function getCourseNo($situationNo){
        $sql = 'SELECT `courseNo` FROM `course` WHERE `situationNo` = ?';
        $value = $situationNo;
        
        $query = $this->db->query($sql, $value);
        
        $courseNo = array_column($query->result('array'), 'courseNo');
        
        return $courseNo;
        
    }
    
    
    //状況Noの一致する判定Noを返す
    public function getDecisionNo($situationNo){
        $sql = 'SELECT `decisionNo` FROM `course` WHERE `situationNo` = ?';
        $value = $situationNo;
        
        $query = $this->db->query($sql, $value);
        
        $decisionNo = array_column($query->result('array'), 'decisionNo');
        
        return $decisionNo;
        
    }
    
    
    //投球を記録
    public function setCourse($matchNo, $situationNo, $coordinateX, $coordinateY, $decisionNo, $typeOfPitchNo){
        $sql = 'INSERT INTO `course` (`matchNo`, `situationNo`, `coordinateX`, `coordinateY`, `decisionNo`, `typeOfPitchNo`) 
                VALUES (?,?,?,?,?,?)';
        
        $value = array(
                $matchNo, 
                $situationNo, 
                $coordinateX, 
                $coordinateY, 
                $decisionNo, 
                $typeOfPitchNo
            );
        
        $this->db->query($sql,$value);
        return;
    }
    
    
    
    
    //複数の状況Noのうち打席数にカウントされる打席結果の数を返す
    public function getPlateAppearance($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち打数にカウントされる打席結果の数を返す
    public function getAtbat($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(4, 5, 6, 7, 10, 11, 12, 13, 14, 15)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうちヒットにカウントされる打席結果の数を返す
    public function getHit($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(4, 5, 6, 7)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち単打にカウントされる打席結果の数を返す
    public function getSingle($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(4)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち二塁打にカウントされる打席結果の数を返す
    public function getDouble($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(5)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち三塁打にカウントされる打席結果の数を返す
    public function getTriple($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(6)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち本塁打にカウントされる打席結果の数を返す
    public function getHomerun($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(7)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち三振にカウントされる打席結果の数を返す
    public function getStrikeOut($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(13)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち四死球にカウントされる打席結果の数を返す
    public function getFourDeadBall($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(8,9)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち犠打・犠飛にカウントされる打席結果の数を返す
    public function getSacrifice($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(16)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    //複数の状況Noのうち併殺打にカウントされる打席結果の数を返す
    public function getDoublePlay($situationNo){
        $sql = 'SELECT `situationNo` FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .') 
                AND `decisionNo` in(15)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->num_rows();
    }
    
    
    //送られた状況Noが格納されている投球情報を返す
    public function getAtbatCourse($situationNo){
        $sql = 'SELECT * FROM `course` WHERE `situationNo` in(' . substr(str_repeat(',?', count($situationNo)), 1) .')';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        return $query->result('array');
    }
}