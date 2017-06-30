<?php

class Group extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('User');
    }
    
    
    //userNoから自身が所属するNameとNoを返す
    public function getGroupName($userNo){
        
        //escape
        $val = $this->db->escape($userNo);
        
        //SELECT * FROM `group` 
        //inner join `affiliation` on group.groupNo = affiliation.groupNo
        //where `userNo` = 2
        $sql = 'select * from `group` 
                inner join `affiliation` on group.groupNo = affiliation.groupNo
                where `userNo` = '. $val ;
                
        
         //クエリ実行
        $query = $this->db->query($sql);
        
        //初期化　宣言
        $array = array();
        
        foreach ($query->result() as $row){
            $array[] = array('groupNo' => $row->groupNo,
                            'groupName' =>$row->groupName);
        }
        
        return $array;
        
    }
    
    //変更前のuserNoすべて取得
    public function getUserNoBeforeAll($userNo){
        
        //escape
        $val = $this->db->escape($userNo);
        
        $allUserNo = array();
        
        while(true){
            
            //select `userNo`, `beforeUserNo` from `user` where `userNo` = 21
            $sql = 'select `userNo`, `beforeUserNo` from `user` where `userNo` ='. $val;
            $query = $this->db->query($sql);
            
            if($query->num_rows() > 0){
                
                $allUserNo[] = $query->row()->userNo;
                if($query->row()->beforeUserNo == null){
                return $allUserNo;
                
                }else{
                    $val = $query->row()->beforeUserNo;
                }
            }else{
                return $allUserNo;
            }
            
        }
    }
    
    //与えられたuserId全てのグループ名をとってくる
    public function getGroupNameAll($array){
        
        $groupNames = array();
        
        foreach($array as $key => $value){
            $groupNames = array_merge($groupNames, $this->getGroupName($value));
        }
        
        return $groupNames;
    }
    
    //グループNoから重複削除
    public function unipue($array){
        
        $tmp = array();
        $ary_result = array();
        
        foreach($array as $key => $value ){
             if( !in_array( $value['groupNo'], $tmp ) ) {
              $tmp[] = $value['groupNo'];
              $ary_result[] = $value;
            }
        }
        
        return $ary_result;
    }
    
    //Groupにユーザが所属しているか
    //SELECT * FROM `affiliation` WHERE `groupNo` = 1 and `userNo` = 2
    public function isGroupMember($groupNo, $userNo){
        
         //引数の中身があるかどうか
        if(empty($groupNo) || empty($userNo)){
                return false;
        }
        
        
        //過去のuserNoを取得
        $array = $this->getUserNoBeforeAll($userNo);
        
        foreach($array as $value){
            
            //バインド機構
            $sql = 'select count(*) as count from affiliation '
                    .'where groupNo = ? '
                    .'and userNo = ?';
                    
            $value = array(
                $groupNo,
                $value,
                );
            
            //クエリの実行
            $query = $this->db->query($sql, $value);
            
            $row = $query->row();
            
            if($row->count == 1){
                return true;
            }else{
                //return false;
            }
            
        }
        
        return false;
       
    }
    
    public function getGroupData($email){
        
        //emailからUserNoを取り出す
        $userNo = $this->User->getUserNo($email);
        
        //userNoから前のuserNoも取り出す
        $userNos = $this->getUserNoBeforeAll($userNo);
        
        //グループ名をとってくる
        $array = $this->getGroupNameAll($userNos);
        
        //重複削除
        $array = $this->unipue($array);
        
        $data = array();
        foreach($array as $row){
            $data = array('data' => $array);
        }
        
        return $data;
    }
    
    
    //グループ作成
    public function insertGroup($groupName){
        
        //バインド
        //INSERT INTO `group`( `groupName`) VALUES ('test')
        $sql = 'insert into `group`(`groupName`) values (?)';
        
        //データ入力
        $values = array(
           $groupName
            );
        
        //sqlの実行
        $query = $this->db->query($sql, $values);
    }
    
    //引数のgroupを削除する
    public function deleteGroup($groupNo){
        
        //バインド
        $sql = 'delete from  `group` where `groupNo` = ?';
        
        //データ入力
        $values = array(
           $groupNo
            );
        
        //sqlの実行
        $query = $this->db->query($sql, $values);
    }
    
    //グループ名をグループNoから取ってくる
    public function getGroupNameByGroupNo($groupNo){
        
        //バインド
        $sql = 'select * from  `group` where `groupNo` = ?';
        
        //データ入力
        $values = array(
           $groupNo
            );
        
        //sqlの実行
        $query = $this->db->query($sql, $values);
        
        return $query->row()->groupName;
    }
    
    //userNoから自分が所属するグループがあるか調べる　あったらtrue
    public function isGroup($userNo){
        
        $array = $this->getUserNoBeforeAll($userNo);
        
        foreach($array as $value){
            
             //バインド機構
            $sql = 'select count(*) as count from affiliation '
                    .'where userNo = ?';
                    
            $value = array(
                $value,
                );
            
            //クエリの実行
            $query = $this->db->query($sql, $value);
            
            $row = $query->row();
            
            if($row->count > 0){
                return true;
            }else{
                //nasi
            }
        }
        
        return false;
    }
    
    
    
}