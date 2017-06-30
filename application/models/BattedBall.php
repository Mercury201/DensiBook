<?php

class BattedBall extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //打球位置を記録する
    public function setBattedBall($courseNo, $coordinateX, $coordinateY){
        $sql = 'insert into `battedBall` (`courseNo`, `coordinateX`, `coordinateY`) values (?, ?, ?);';
        
        $value = array(
                $courseNo,
                $coordinateX,
                $coordinateY
            );
        //var_dump($sql);
        $this->db->query($sql, $value);
        
        return;
    }
    
    //コースNoから打球位置座標を返す
    public function getCoordinate($courseNo){
        $sql = 'SELECT `coordinateX`, `coordinateY` FROM `battedBall` WHERE `courseNo` = ?';
        $value = $courseNo;
        $query = $this->db->query($sql, $value);
        
        $row = $query->row();
        if($row != null){
            $coordinateX = $row->coordinateX;
            $coordinateY = $row->coordinateY;
        }else{
            $coordinateX = 172;
            $coordinateY = 310;
        }
        
        
        $data['coordinateX'] = $coordinateX;
        $data['coordinateY'] = $coordinateY;
        return $data;
    }
    
    //複数の状況から打球位置が存在するものの座標を返す
    public function getSituationCoordinate($situationNo){
        $sql = 'SELECT `coordinateX` ,  `coordinateY` FROM  `battedBall` WHERE  `courseNo` IN ('.
                'SELECT  `courseNo` FROM  `course` WHERE  `situationNo` IN (' . substr(str_repeat(',?', count($situationNo)), 1) . '))';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        
        // $data['coordinateX'] = array_column($query->result('array'), 'coordinateX');
        // $data['coordinateY'] = array_column($query->result('array'), 'coordinateY');
        return $query->result('array');
    }
    
}