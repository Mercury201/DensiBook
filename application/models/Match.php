<?php

class Match extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //試合登録
    public function entryMatch($match){
        $sql = 'insert into `match` (`opponent`, `location`, `date`, `myteamTop`, `groupNo`) values (?, ?, ?, ?, ?);';
        
        //$sql = $sql . 'select last_insert_id() from `match`';
        
        $value = $match;
        //var_dump($sql);
        $this->db->query($sql, $value);
        
        $matchNo = $this->db->insert_id();    //オートインクリメントされた試合Noの取得
        
        //var_dump($MatchNo);
        
        return $matchNo;
    }
    
    //自チームが先攻かを返す
    public function getMyteamTop($matchNo){
        $sql = 'SELECT `myteamTop` FROM `match` WHERE `matchNo` = ?';
        
        $value = $matchNo;
        
        $query = $this->db->query($sql, $value);
        
        $myteamTop = array_column($query->result('array'), 'myteamTop');
        return $myteamTop;
    }
    
    //日付と対戦相手から試合Noを返す
    public function searchMatchNo($date, $opponent){
        $sql = 'SELECT `matchNo` FROM `match` WHERE `date` = ? AND `opponent` = ?';
        $value = array(
                    $date, 
                    $opponent);
        $query = $this->db->query($sql, $value);
        
        
        $row = $query->row();
        
        return $row->matchNo;
    }
    
    //グループの試合情報を返す
    public function getGroupMatch($groupNo){
        $sql = 'SELECT `matchNo`, `opponent`, `date` FROM `match` WHERE `groupNo` = ?';
        $value = $groupNo;
        $query = $this->db->query($sql, $value);
        
        // $matchNo = array_column($query->result('array'), 'matchNo');
        // $match = $query->result('array');
        // $matchNo = array_column($query->result('array'), 'matchNo');
        // $opponent = array_column($query->result('array'), 'opponent');
        // $date = array_column($query->result('array'), 'date');
        
        // $data['matchNo'] = $matchNo;
        // $data['opponent'] = $opponent;
        // $data['date'] = $date;
        
        return $query->result('array');
    }
    
    //状況Noから自チームのグループNoを取得する
    public function getSituationGroupNo($situationNo){
        $sql = 'SELECT `groupNo` FROM `match` WHERE `matchNo` in (SELECT `matchNo` FROM `situation` WHERE `situationNo` = ?)';
        $value = $situationNo;
        $query = $this->db->query($sql, $value);
        $groupNo = $query->row('groupNo');
        return $groupNo;
    }
    
    //グループNoから、試合が登録されているかどうか
    public function isMatch($groupNo){
        
        $sql = 'SELECT count(*) as count FROM `match` WHERE groupNo = ?';
        $value = $groupNo;
        $query = $this->db->query($sql, $value);
        
        if($query->row()->count > 0){
            return true;
        }else{
            return false;
        }
    }
}