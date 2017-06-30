<?php

class Situation extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //状況テーブル入力
    public function setSituation($firsRrunner, $secondRunner, $thirdRunner, $batter, $pitcher, 
                                 $topBottom, $inning, $plateAppearance, $pitchCount, $matchNo, $strike, $ball, $out){
        $sql = 'INSERT INTO `situation` (`firstRunner`, `secondRunner`, `thirdRunner`, `batter`, `pitcher`, `topBottom`, `inning`, 
                `plateAppearance`, `pitchCount`, `matchNo`, `strike`, `ball`, `out`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        
        $value = array(
                $firsRrunner,
                $secondRunner,
                $thirdRunner,
                $batter,
                $pitcher,
                $topBottom,
                $inning,
                $plateAppearance,
                $pitchCount,
                $matchNo,
                $strike, 
                $ball, 
                $out
            );
            
        $this->db->query($sql,$value);
        
        $situationNo = $this->db->insert_id();
        return $situationNo;
    }
    
    
    //状況Noの一致する試合Noを返す
    public function getMatchNo($situationNo){
        $sql = 'SELECT `matchNo` FROM `situation` WHERE `situationNo` = ?';
        $value = $situationNo;
        
        $query = $this->db->query($sql, $value);
        
        $matchNo = array_column($query->result('array'), 'matchNo');
        
        return $matchNo;
        
    }
    
    
    //現在のランナーを返す
    public function getRunner($situationNo){
        $sql = 'SELECT `firstRunner`, `secondRunner`, `thirdRunner` FROM `situation` WHERE `situationNo` = ?';
        $value = $situationNo;
        
        $query = $this->db->query($sql, $value);
        
        // $runner = array_column($query->result(''), 'firstRunner');
        
        $row = $query->row();
        
        $runner[0] = $row->firstRunner;
        $runner[1] = $row->secondRunner;
        $runner[2] = $row->thirdRunner;
        
        return $runner;
    }
    
    
    //状況Noの一致する行を返す
    public function getSituation($situationNo){
        $sql = 'SELECT * FROM `situation` WHERE `situationNo` = ?';
        $value = $situationNo;
        
        $query = $this->db->query($sql, $value);
        
        $situation = $query->result('array');
        
        return $situation[0];
    }
    
    
    public function getStealSituation($topBottom, $inning, $plateAppearance, $pitchCount, $matchNo){
        $sql = 'SELECT `situationNo` FROM `situation` WHERE `topBottom` = ? AND `inning` = ? AND `plateAppearance` = ?
                AND `pitchCount` = ? AND `matchNo` = ?';
        
        $value = array(
                $topBottom,
                $inning,
                $plateAppearance,
                $pitchCount,
                $matchNo
            );
        
        $query = $this->db->query($sql, $value);
        
        $situationNo = array_column($query->result('array'), 'situationNo');
        return $situationNo;
    }
    
    
    public function updateRunner($firstRunner, $secondRunner, $thirdRunner, $topBottom, $inning, $plateAppearance, $pitchCount){
        $sql = 'UPDATE `situation`SET `firstRunner` = ?, `secondRunner` = ?, `thirdRunner` = ?
                WHERE `topBottom` = ? AND `inning` = ? AND `plateAppearance` = ? AND `pitchCount` = ?';
        
        $value = array(
                $firstRunner,
                $secondRunner,
                $thirdRunner,
                $topBottom,
                $inning,
                $plateAppearance,
                $pitchCount
            );
            
        $this->db->query($sql, $value);
        
    }
    
    
    public function updateBattedRunner($situationNo, $firsRrunner, $secondRunner, $thirdRunner){
        $sql = 'UPDATE `situation`SET `firstRunner` = ?, `secondRunner` = ?, `thirdRunner` = ?
                WHERE situationNo = ?';
        
        $value = array(
                $firsRrunner,
                $secondRunner,
                $thirdRunner,
                $situationNo
            );
        
        $this->db->query($sql, $value);
    }
    
    
    public function getLastBatter($matchNo, $inning, $topBottom){
        $sql = 'SELECT DISTINCT`batter` FROM `situation` WK1 , (SELECT max(`plateAppearance`) as "plateAppearance" 
                FROM `situation` WHERE `matchNo` = ? AND `topBottom` = ? AND `inning` = ?) WK2 
                WHERE WK1.`plateAppearance` = WK2.`plateAppearance` AND `matchNo` = ? AND `topBottom` = ? AND `inning` = ?';
        
        $value = array(
            $matchNo, 
            $topBottom,
            $inning,
            $matchNo, 
            $topBottom,
            $inning
            );
            
        // var_dump($value);
        
        $query = $this->db->query($sql, $value);
        
        
        $playerNo = array_column($query->result('array'), 'batter')[0];
        return $playerNo;
    }
    
    
    public function setCount($strike, $ball, $out, $topBottom, $inning, $plateAppearance, $pitchCount){
        $sql = 'UPDATE `situation`SET `strike` = ?, `ball` = ?, `out` = ?
                WHERE `topBottom` = ? AND `inning` = ? AND `plateAppearance` = ? AND `pitchCount` = ?';
        
        $value = array(
                $strike,
                $ball,
                $out,
                $topBottom,
                $inning,
                $plateAppearance,
                $pitchCount
            );
            
        $this->db->query($sql, $value);
    }
    
    //バッターの打席ごとの最後の投球時の状況Noを返す
    public function getBattedSituationNo($playerNo){
        $sql = 'SELECT `situationNo` FROM `situation` as a WHERE `batter` in(' . substr(str_repeat(',?', count($playerNo)), 1) .')'.
               'AND NOT EXISTS(SELECT * FROM `situation` as b WHERE a.`matchNo` = b.`matchNo` AND a.`inning` = b.`inning` AND '.
               'a.`topBottom` = b.`topBottom` AND a.`plateAppearance` = b.`plateAppearance` AND a.`pitchCount` < b.`pitchCount`)';
        $value = $playerNo;
        $query = $this->db->query($sql, $value);
        
        $situationNo = array_column($query->result('array'), 'situationNo');
        return $situationNo;
    }
    
    
    //投手の打席ごとの最後の投球時の状況Noを返す
    public function getBattedSituationPitchNo($playerNo){
        $sql = 'SELECT `situationNo` FROM `situation` as a WHERE `pitcher` in(' . substr(str_repeat(',?', count($playerNo)), 1) .')'.
               'AND NOT EXISTS(SELECT * FROM `situation` as b WHERE a.`matchNo` = b.`matchNo` AND a.`inning` = b.`inning` AND '.
               'a.`topBottom` = b.`topBottom` AND a.`plateAppearance` = b.`plateAppearance` AND a.`pitchCount` < b.`pitchCount`)';
        $value = $playerNo;
        $query = $this->db->query($sql, $value);
        
        $situationNo = array_column($query->result('array'), 'situationNo');
        return $situationNo;
    }
    
    //投手の全試合の球数の合計を返す
    public function getSumPitchCount($pitcher){
        $sql = 'SELECT sum(`pitchCount`) FROM `situation` as a WHERE `pitcher` in(' . substr(str_repeat(',?', count($pitcher)), 1) .')'.
               'AND NOT EXISTS(SELECT * FROM `situation` as b WHERE a.`matchNo` = b.`matchNo` AND a.`inning` = b.`inning` AND '.
               'a.`topBottom` = b.`topBottom` AND a.`plateAppearance` = b.`plateAppearance` AND a.`pitchCount` < b.`pitchCount`)';
        $value = $pitcher;
        $query = $this->db->query($sql, $value);
        
        $pitchCount = $query->result('array')[0];
        
        return $pitchCount['sum(`pitchCount`)'];
    }
    
    //投手の全試合の投球回の合計を返す
    public function getInningsPitched($pitcher){
        $sql = 'select distinct`matchNo`, `inning`, `out` from `situation` as a where `pitcher` IN (' . 
            substr(str_repeat(',?', count($pitcher)), 1) .')AND NOT EXISTS(SELECT * FROM `situation` as b WHERE'.
            ' a.`matchNo` = b.`matchNo` AND a.`inning` < b.`inning` AND a.`topBottom` = b.`topBottom`)'.
            'AND NOT EXISTS(SELECT * FROM `situation` as b WHERE a.`matchNo` = b.`matchNo` AND a.`inning` = b.`inning` AND '.
            'a.`topBottom` = b.`topBottom` and a.`out` < b.`out`)and `out` is not null';
        
        $value = $pitcher;
        $query = $this->db->query($sql, $value);
        
        //$data = $query->result('array');
        $data['inning'] = array_column($query->result('array'), 'inning');
        $data['out'] = array_column($query->result('array'), 'out');
        
        return $data;
    }
    
    public function getBatter($playerNo){
        $sql = 'SELECT `batter` FROM `situation` WHERE `batter` in(' . substr(str_repeat(',?', count($playerNo)), 1) .')';
        $value = $playerNo;
        $query = $this->db->query($sql, $value);
        $batter = array_column($query->result('array'), 'batter');
        return $batter;
    }
    
    //選手の打席結果確定直前の状況を打席数分返す
    public function getBatterSituation($playerNo){
        $sql = 'SELECT * FROM `situation` WHERE `batter` = ? AND `strike` IS NOT NULL';
        $value = $playerNo;
        $query = $this->db->query($sql, $value);
        return $query->result('array');
    }
    
    //打席の球数を返す
    public function getPitchCount($topBottom, $inning, $plateAppearance){
        $sql = 'SELECT max(`pitchCount`) FROM `situation` WHERE `topBottom` = ? AND `inning` = ? AND `plateAppearance` = ?';
        $value = array(
                    $topBottom,
                    $inning,
                    $plateAppearance
                    );
        $query = $this->db->query($sql, $value);
        $row = $query->result('array')[0]["max(`pitchCount`)"];
        return $row;
    }
    
    
    public function getLastBattedSituationNo($topBottom, $inning, $plateAppearance, $pitchCount){
        $sql = 'SELECT `situationNo` FROM `situation` WHERE `topBottom` = ? AND `inning` = ? AND `plateAppearance` = ? AND `pitchCount` = ?';
        $value = array(
                    $topBottom,
                    $inning,
                    $plateAppearance,
                    $pitchCount
                    );
        $query = $this->db->query($sql, $value);
        $row = array_column($query->result('array'), 'situationNo')[0];
        return $row;
    }
    
    //選択された打席と同じ打席の状況Noを返す
    public function getSameAtbat($matchNo, $topBottom, $inning, $plateAppearance){
        $sql = 'SELECT `situationNo` FROM `situation` WHERE `matchNo` = ? AND `topBottom` = ? AND `inning` = ? AND `plateAppearance` = ?
                order by `pitchCount` asc';
        $value = array(
                    $matchNo, 
                    $topBottom, 
                    $inning, 
                    $plateAppearance
                    );
        $query = $this->db->query($sql, $value);
        $situationNo = array_column($query->result('array'), 'situationNo');
        return $situationNo;
    }
    
}