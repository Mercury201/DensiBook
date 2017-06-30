<?php

class Position extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //入力された選手オーダーを入れる
    public function entryOrder($number, $orderNum, $position, $matchNo){
        
        $sql = 'INSERT INTO position (';
        
        $columns = array('matchNo', 'battingOrder', 'position', 'playerNo');
        
        foreach ($columns as $column){
	    	$sql = $sql.$column.', ';
    	}
    	
    	$sql = mb_substr($sql, 0, (mb_strlen($sql)-2));		// 最後のコンマを除いた文字列に整形
	    $sql = $sql.') VALUES ';
	    
	    // SQL後半の挿入データ部分の作成
	    $value = array();
	    
	    for($i = 0; $i < 9; $i++){
	        $sql = $sql.'(?, ?, ?, ?),';
	       // $sql = $sql.$position[$i].',';
	       // $sql = $sql.$number[$i].')';
	       array_push($value, $matchNo);
	       array_push($value, $orderNum[$i]);
	       array_push($value, $position[$i]);
	       array_push($value, $number[$i]);
	       
	    }
	    
	    $sql = mb_substr($sql, 0, (mb_strlen($sql)-1));	// 最後のコンマを除いた文字列に整形
	    
	    
        
        
        
        
        $query = $this->db->query($sql, $value);
        
        
    }
    
    //試合の先頭打者（表と裏両方）を返す
    public function getLeadOff($matchNo){
    	$sql = 'SELECT `playerNo` FROM `position` WHERE `matchNo` = ? AND `battingOrder` = 1';
    	
    	$value = $matchNo;
    	
    	$query = $this->db->query($sql, $value);
    	
    	$playerNo = array_column($query->result('array'), 'playerNo');
    	
    	return $playerNo;
    }
    
    //指定した試合と打順の選手を返す
    public function getOrderBatter($matchNo, $orderNo){
        $sql = 'SELECT `playerNo` FROM `position` WHERE `matchNo` = ? AND `battingOrder` = ?';
    	
    	$value = array(
            $matchNo,
            $orderNo,
            );
        
        
    	
    	$query = $this->db->query($sql, $value);
    	
    	$playerNo = array_column($query->result('array'), 'playerNo');
    	
    	return $playerNo;
    }
    
    
    //選手の打順を返す
    public function getOrderNo($playerNo){
        $sql = 'SELECT `battingOrder` FROM `position` WHERE `playerNo` = ?';
    	
    	$value = $playerNo;
    	
    	$query = $this->db->query($sql, $value);
    	
    	$orderNo = array_column($query->result('array'), 'battingOrder');
    	
    	return $orderNo;
    }
    
    
    public function getStartingPitcher($matchNo){
        $sql = 'SELECT `playerNo` FROM `position` WHERE `position` = "投" AND `matchNo` = ?';
        
        $value = $matchNo;
        
        $query = $this->db->query($sql, $value);
        
        $playerNo = array_column($query->result('array'), 'playerNo');
        
        return $playerNo;
    }
    
    
    public function getNextPitcher($matchNo, $currentPitcher){
        $sql = 'SELECT `playerNo` FROM `position` WHERE `position` = "投" AND `matchNo` = ? AND `playerNo` != ?';
        
        $value = array(
            $matchNo,
            $currentPitcher
            );
        
        $query = $this->db->query($sql, $value);
        
        $playerNo = array_column($query->result('array'), 'playerNo')[0];
        
        return $playerNo;
    }
    
    //送られたプレイヤーNoのうちpositionテーブルに登録されているプレイヤーNoの数を返す
    public function getParticipateNum($playerNo){
        
        $sql = 'SELECT distinct`playerNo` FROM `position` WHERE `playerNo` in(' . substr(str_repeat(',?', count($playerNo)), 1) . ')';
        $value = $playerNo;
        $query = $this->db->query($sql, $value);
        return $query->num_rows();
    }
    
    //送られたプレイヤーNoのうち投手としてpositionテーブルに登録されている試合Noを返す
    public function getPitchParticipateMatch($playerNo){
        $sql = 'SELECT distinct`matchNo` FROM `position` WHERE `playerNo` in(' . substr(str_repeat(',?', count($playerNo)), 1) .
        ') AND `position` = "投" AND `matchNo` IS NOT NULL';
        $value = $playerNo;
        $query = $this->db->query($sql, $value);
        $matchNo = array_column($query->result('array'), 'matchNo');
        return $matchNo;
    }
}