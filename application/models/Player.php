<?php

class Player extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //入力された選手オーダーを入れる
    public function setPlayer($players, $matchNo){
        //var_dump($players);
        
        $sql = 'INSERT INTO player (';
        $columns = array('matchNo', 'UserNo', 'playerName', 'battingHanded', 'throwHanded');
        $orderRow = array('userNo', 'name', 'battingHanded', 'throwHanded');
                
        foreach ($columns as $column){
	    	$sql = $sql.$column.', ';
    	}
    	
    	$sql = mb_substr($sql, 0, (mb_strlen($sql)-2));		// 最後のコンマを除いた文字列に整形
	    $sql = $sql.') VALUES ';
                
                
        // SQL後半の挿入データ部分の作成
        
        for($i = 0; $i < count($players['userNo']); $i++){
            $sql = $sql.'(';
            foreach($players as $datas){
                //$sql = $sql.$datas[$i].', ';
                $sql = $sql.'?, ';
            }
            $sql = $sql.'?, ';
            $sql = mb_substr($sql, 0, (mb_strlen($sql)-2));	// 最後のコンマを除いた文字列に整形
            $sql = $sql.'),';
        }
        
    	
    	$sql = mb_substr($sql, 0, (mb_strlen($sql)-1));	// 最後のコンマを除いた文字列に整形
        //var_dump($sql);
        
        $n = 0;
        for($i = 0; $i < count($players['userNo']); $i++){
            $value[$n] = $matchNo;
            $n++;
            foreach($players as $datas){
                //$sql = $sql.$datas[$i].', ';
                //$sql = $sql.'?, ';
                
                $value[$n] = $datas[$i];
                
                
                $n++;
            }
        }
        
        
        
        $query = $this->db->query($sql, $value);
        
        $playerId = $this->db->insert_id();
        
        return $playerId;
    }
    
    public function setOpponentPlayer($players, $matchNo){
        // var_dump($players);
        
        $sql = 'INSERT INTO player (';
        $columns = array('matchNo', 'playerName', 'battingHanded', 'throwHanded');
        $orderRow = array('name', 'battingHanded', 'throwHanded');
                
        foreach ($columns as $column){
	    	$sql = $sql.$column.', ';
    	}
    	
    	$sql = mb_substr($sql, 0, (mb_strlen($sql)-2));		// 最後のコンマを除いた文字列に整形
	    $sql = $sql.') VALUES ';
                
                
        // SQL後半の挿入データ部分の作成
        
        for($i = 0; $i < count($players[0]); $i++){
            $sql = $sql.'(';
            foreach($players as $datas){
                //$sql = $sql.$datas[$i].', ';
                $sql = $sql.'?, ';
            }
            $sql = $sql.'?, ';
            $sql = mb_substr($sql, 0, (mb_strlen($sql)-2));	// 最後のコンマを除いた文字列に整形
            $sql = $sql.'),';
        }
        
    	
    	$sql = mb_substr($sql, 0, (mb_strlen($sql)-1));	// 最後のコンマを除いた文字列に整形
        //var_dump($sql);
        
        $n = 0;
        for($i = 0; $i < count($players[0]); $i++){
            $value[$n] = $matchNo;
            $n++;
            foreach($players as $datas){
                //$sql = $sql.$datas[$i].', ';
                //$sql = $sql.'?, ';
                
                $value[$n] = $datas[$i];
                
                
                $n++;
            }
        }
        
        //var_dump($value);
        
        
        
        $query = $this->db->query($sql, $value);
        
        $playerId = $this->db->insert_id();
        
        return $playerId;
    }
    
    
    public function getUserNo($playerNo){
        $sql = 'SELECT `userNo` FROM player WHERE `playerNo` = ?';
        
        $value = $playerNo;
        
        $query = $this->db->query($sql, $value);
        
        $userNo = array_column($query->result('array'), 'userNo');
        return $userNo;
    }
    
    
    public function getPlayerName($playerNo){
        $sql = 'SELECT `playerName` FROM player WHERE `playerNo` = ?';
        
        $value = $playerNo;
        
        $query = $this->db->query($sql, $value);
        
        $playerName = array_column($query->result('array'), 'playerName');
        return $playerName;
    }
    
    
    public function getPlayerData($playerNo){
        $sql = 'SELECT * FROM `player` WHERE `playerNo` = ?';
        
        $value = $playerNo;
        
        $query = $this->db->query($sql, $value);
        
        $player = $query->result('array')[0];
        return $player;
    }
    
    //ユーザNoの一致するすべてのプレイヤーNoを返す
    public function getUserPlayerNo($userNo){
        $sql = 'SELECT `playerNo` FROM `player` WHERE `userNo` = ?';
        $value = $userNo;
        $query = $this->db->query($sql, $value);
        
        $playerNo = array_column($query->result('array'), 'playerNo');
        return $playerNo;
    }
    
    //指定された試合とユーザNoのプレイヤーNoを返す
    public function getMatchPlayerNo($matchNo, $userNo){
        $sql = 'SELECT `playerNo` FROM `player` WHERE `matchNo` = ? AND `userNo` = ?';
        $value = array(
                    $matchNo,
                    $userNo
                    );
        $query = $this->db->query($sql, $value);
        $playerNo = array_column($query->result('array'), 'playerNo');
        return $playerNo[0];
    }
    
    //その試合に参加したユーザを返す
    public function getparticipateUser($matchNo){
        $sql = 'SELECT distinct`userNo` FROM `player` WHERE `matchNo` in(' . substr(str_repeat(',?', count($matchNo)), 1) . ')
                AND `userNo` IS NOT NULL';
        $value = $matchNo;
        $query = $this->db->query($sql, $value);
        $userNo = array_column($query->result('array'), 'userNo');
        return $userNo;
    }
    
    //その状況で対戦した投手の利き上を返す
    public function getPitcheHanded($situationNo){
        $sql = 'SELECT `throwHanded` FROM `player` WHERE `playerNo` in (SELECT `pitcher` FROM `situation` WHERE `situationNo` = ?)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        $throwHanded = $query->row()->throwHanded;
        return $throwHanded;
    }
    
    
    //その状況で対戦した打者の利き打ちを返す
    public function getBatterHanded($situationNo){
        $sql = 'SELECT `battingHanded` FROM `player` WHERE `playerNo` in (SELECT `batter` FROM `situation` WHERE `situationNo` = ?)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        $battingHanded = $query->row()->battingHanded;
        return $battingHanded;
    }
}