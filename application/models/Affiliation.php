<?php

class Affiliation extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //同じグループに所属しているメンバーのユーザIDを返す
    public function getGroupMember($userno){
        
        $sql = 'SELECT userNo FROM affiliation WHERE groupNo in (select groupNo from affiliation where userNo = ?)';
                
        $value = $userno;
        
        $query = $this->db->query($sql, array($value));
        
        $number = array_column($query->result('array'), 'userNo');
        
        return $number;
    }
    
    //選択されたグループのメンバーのユーザIDを返す
    public function getSelectedGroupMember($groupNo){
        $sql = 'SELECT userNo FROM affiliation WHERE groupNo = ?';
        $value = $groupNo;
        $query = $this->db->query($sql, $value);
        
        $users = array_column($query->result('array'), 'userNo');
        
        return $users;
    }
    
    //insert文
    public function insertAffiliation($groupNo, $userNo, $authorityNo){
        
        //バインド
        $sql = 'insert into Affiliation(groupNo, userNo, authorityNo) 
        values (?, ?, ?)';
        
        //データ入力
        $values = array(
           'groupNo' => $groupNo,
           'userNo' => $userNo,
           'authorityNo' => $authorityNo
            );
        
        //sqlの実行
        //$query = $this->db->query($sql, $values);
         $this->db->reconnect();
        
        //$this->db->set($values);
        $this->db->insert('affiliation', $values);
    }
    
    //groupNoからメンバー編集に必要なものを返す
    //user.Name authority authority.Name
    public function getMemberSettingData($groupNo){
        
        /**SELECT `groupNo`, `affiliation`.userNo, `name`, `affiliation`.authorityNo, `authorityName` FROM `affiliation` 
            left outer join `user` on affiliation.userNo = user.userNo
            left outer join `authority` on affiliation.authorityNo = authority.authorityNo
            WHERE `groupNo` = 1**/
            
        $sql = "SELECT `email`, `groupNo`, `affiliation`.userNo, `name`, `affiliation`.authorityNo, `authorityName` FROM `affiliation` 
                left outer join `user` on affiliation.userNo = user.userNo
                left outer join `authority` on affiliation.authorityNo = authority.authorityNo
                WHERE `groupNo` = ?";
                
        $value = array($groupNo);
        
        $query = $this->db->query($sql, $value);
        
        //初期化　宣言
        $array = array();
        //配列に格納
        foreach ($query->result() as $row){
            $array[] = array(
            'email'     => $row->email,
            'groupNo'   => $row->groupNo,
            'userNo'    => $row->userNo,
            'name'      => $row->name,
            'authorityNo'   => $row->authorityNo,
            'authorityName' => $row->authorityName
            );
        }
        
        
        //削除候補を格納する配列
        $delList = array();
        
        //削除候補を選出
        $i = 0; $j = 0;
        $data = $array;
        foreach($array as $value){
            
            foreach($array as $value2){
                if($value['name'] == $value2['name'] && $i != $j){
                    
                    if($value['userNo'] > $value2['userNo']){
                        $delList[] = $value2['userNo'];
                    }
                }
                $j++;
            }
            $i++;
            $j = 0;
        }
        
        //削除
        foreach($delList as $value){
            
            foreach($data as $key => $value2){
                if($data[$key]['userNo'] == $value){
                    unset($data[$key]);
                }
            }
        }
        
        return $data;
    }
    
        //与えられたuserNoとgroupNoを削除する
        //その際にbeforeUserNo繋がりがある場合それも削除
        public function memberDel($userNo, $groupNo){
            
            $userNos = $this->User->getAllUserNo($userNo);
            
            //SELECT count(*) as count FROM `affiliation` WHERE userNo = 1
            //あるなら消すないなら何もしない
            foreach($userNos as $value){
                $sql = 'SELECT count(*) as count FROM `affiliation` WHERE userNo = ? and groupNo = ?';
                $data = array($value, $groupNo);
                $query = $this->db->query($sql, $data);
                
                if($query->row()->count > 0){
                    
                    //削除
                    $sql = 'delete FROM `affiliation` WHERE userNo = ? and groupNo = ?';
                    $data = array($value, $groupNo);
                    $query = $this->db->query($sql, $data);
                    
                }else{
                   //処理なし
                }
            }
            
        }
        
        //メンバーの権限を更新する
        public function memberUpdate($userNo, $groupNo, $explode){
            
            $userNos = $this->User->getAllUserNo($userNo);
            
            //SELECT count(*) as count FROM `affiliation` WHERE userNo = 1
            //あるなら消すないなら何もしない
            foreach($userNos as $value){
                $sql = 'SELECT count(*) as count FROM `affiliation` WHERE `userNo` = ? and `groupNo` = ?';
                $data = array($value, $groupNo);
                $query = $this->db->query($sql, $data);
                
                //ある
                if($query->row()->count > 0){
                    
                    
                    foreach($explode as $exKey => $exValue){
                        
                        //userNoが一致するか
                        if($value == $exValue[1]){
                            //アップデート
                            $sql = 'update `affiliation` set `authorityNo` =  ? where `userNo` = ? and `groupNo` = ?';
                            $data = array(
                                $exValue[0],
                                $value,
                                $groupNo);
                            $query = $this->db->query($sql, $data);
                        }
                    }
                    
                    
                    
                }else{
                   //処理なし
                }
            }
            
        }
    
    //管理者であるか確認 管理者ならtrue
    public function isMaster($groupNo, $userNo){
        
        $sql = 'SELECT count(*) as count FROM affiliation WHERE groupNo = ? and userNo = ? and authorityNo = 2';
                
        $data = array($groupNo, $userNo);
        
        $query = $this->db->query($sql, $data);
        
        $row = $query->row();
        
        if($row->count > 0){
            return true;
        }else{
            return false;
        }
    }
    
    //データが登録されているか確認
    public function isRegi($groupNo, $userNo){
            
        //バインド
        $sql = 'select count(*) as count from affiliation where groupNO = ? and userNo = ?';
        
        //クエリ実行
        
        $data = array($groupNo, $userNo);
        
        $query = $this->db->query($sql, $data);
        
        $row = $query->row();
        
        if($row->count > 0){
            return true;
        }else{
            return false;
        }
    }
    
    //指定の引数からAuthorityNoを取得
    public function getAuthorityNo($groupNo, $userNo){
        
         //バインド
         //select authorityNo from affiliation where groupNo = 7 and userNo = 44
        $sql = 'select authorityNo from affiliation where groupNo = ? and userNo = ?';
        
        //クエリ実行
        
        $data = array($groupNo, $userNo);
        
        $query = $this->db->query($sql, $data);
        
        if($query->num_rows() == 1){
            
            return $query->row()->authorityNo;
        }else{
            return -1;
        }
    }
        
    
}