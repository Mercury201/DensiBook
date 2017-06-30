<?php

class User extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        //$this->load->database();
    }
    
    //ユーザーが存在するか、ユーザネームとパスワードから求める
    //存在する場合true, しない場合false
    //メアド複数存在する　訂正
    public function db_check($email='', $password=''){
        
        //引数の中身があるかどうか
        if(empty($email) || empty($password)){
                return false;
        }
            
        //バインド機構
        $sql = 'select userNo from user '
                .'where email = ? '
                .'and password = ?';
                
        $value = array(
            $email,
            $password,
            );
        
        //クエリの実行
        $query = $this->db->query($sql, $value);
        
        $chk = false;
        
        if($query->num_rows() > 0){
            
            foreach($query->result() as $row){
                
                $userNos = $this->getActiveUserNo($row->userNo);
                
                if(count($userNos) == 0){
                    
                }else{
                    $chk = true;
                }
            }
            
            }else{
                $chk = false;
            }
            
            return $chk;
            
        }
        
    //選手登録画面に入力するユーザー名・利き打ち・利き投げを返す
    public function getPlayerData($userno){
        
        
        $sql = 'select userNo, name, battingHanded, throwHanded '
                .'from user '
                .'where userNo in(' . substr(str_repeat(',?', count($userno)), 1) . ')';
                
        
        
        $value = $userno;
        
        $query = $this->db->query($sql, $value);
        
        $data['userNo'] = array_column($query->result('array'), 'userNo');
        $data['name'] = array_column($query->result('array'), 'name');
        $data['battingHanded'] = array_column($query->result('array'), 'battingHanded');
        $data['throwHanded'] = array_column($query->result('array'), 'throwHanded');
        
        return $data;
    }
    
    //ユーザーNoのうち現行のユーザーNoを返す
    public function getActiveUserNo($userno){
        $sql = 'SELECT `userNo` FROM `user` WHERE `userNo` not in 
                (select `beforeUserNo` from `user` where `beforeUserNo` is not null)
                AND `userNo` in (' . substr(str_repeat(',?', count($userno)), 1) . ')';
        
        $value = $userno;
        
        $query = $this->db->query($sql, $value);
        
        $userNo = array_column($query->result('array'), 'userNo');
        
        return $userNo;
    }
    
    
    //ユーザーをuserTableに追加する
    public function addUser($user){
        
        //バインド
        $sql = 'insert into user(birthday, name, email, password,
        schoolName, entryDate, throwHanded, battingHanded ) 
        values (?, ?, ?, ?, ?, ?, ?, ?)';
        
        //テストデータ入力
        $values = array(
            $user['birthday'],
            $user['name'],
            $user['email'],
            $user['password'],
            $user['school'],
            date("Y-m-d"),
            $user['throw'],
            $user['hit']
            );
        
        //sqlの実行
        $query = $this->db->query($sql, $values);
    }
    
    //emailが既に存在しているかどうかの確認
    //あったらtrue
    public function isEmail($email){
        
        //引数の中身があるかどうか
        if(empty($email)){
            return false;
        }
            
        //escape
        $val = $this->db->escape($email);
        $sql = 'select count(*) as count from user where email ='.$val;
        
        //クエリ実行
        $query = $this->db->query($sql);
        $row = $query->row();
        
        if($row->count > 0){
            return true;
        }else{
            return false;
        }
        
    }
    
    //emailからUserNameを取得する
    public function getName($email){
        
         //引数の中身があるかどうか
        if(empty($email)){
            return false;
        }
            
        //escape
        $val = $this->db->escape($email);
        $sql = 'select name from user where email ='.$val. 'order by userNo desc';
        
        //クエリ実行
        $query = $this->db->query($sql);
        $row = $query->num_rows();
        
        if($row > 0){
            return $query->row()->name;
        }else{
            return false;
        }
    }
    
    //emailから最新のUserNoを取得する
     public function getUserNo($email){
        
         //引数の中身があるかどうか
        if(empty($email)){
            return false;
        }
            
        //escape
        $val = $this->db->escape($email);
        $sql = 'select userNo from user where email ='.$val. 'order by userNo desc';
        
        //select userNo from `user` where `email` = "kbc12a05@stu.kawahara.ac.jp"
        
        //クエリ実行
        $query = $this->db->query($sql);
        $row = $query->num_rows();
        
        if($row > 0){
            return $query->row()->userNo;
        }else{
            return false;
        }
    }
    
    //UserNoからUserDataを取り出す
    public function getUserDataAll($userNo){
        
        if(empty($userNo)){
            return false;
        }
            
        //escape
        $val = $this->db->escape($userNo);
        
        
        $sql = 'select * from user '
                .'where userNo ='.$val;
         
        
        $query = $this->db->query($sql);
        
        $row = $query->row();
        
        $data = array();
        
        //$data['userNo'] = $row->userNo;
        $data['name'] = $row->name;
        $data['email'] = $row->email;
        $data['password'] = $row->password;
        $data['birthday'] = $row->birthday;
        $data['battingHanded'] = $row->battingHanded;
        $data['throwHanded'] = $row->throwHanded;
        $data['schoolName'] = $row->schoolName;
        
        return $data;
    }
    
    //ユーザーが個人情報を変更した場合にuser Tableに追加する
    public function updateUser($user){
        
        //バインド
        $sql = 'insert into user(birthday, name, email, password,
        schoolName, entryDate, throwHanded, battingHanded, beforeUserNo ) 
        values (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        
        //テストデータ入力
        $values = array(
            $user['birthday'],
            $user['name'],
            $user['email'],
            $user['password'],
            $user['schoolName'],
            date("Y-m-d"),
            $user['throwHanded'],
            $user['battingHanded'],
            $this->getUserNo($this->session->userdata('email'))
            );
        
        //sqlの実行
        $query = $this->db->query($sql, $values);
    }
    
    
    //与えられたuserNoからbeforeUserNoで関連付けられている全てのuserNoを返す
    public function getAllUserNo($userNo){
            
        //escape
        $val = $this->db->escape($userNo);
        
        //初期化
        $array = array();
        
        while(true){
            
            $sql = 'select `userNo`, `beforeUserNo` from `user` where `userNo` ='.$val. 'order by `userNo` desc';
            
            //クエリ実行
            $query = $this->db->query($sql);
            
            $bun = $query->row()->beforeUserNo;
            $un = $query->row()->userNo;
            
            $array[] = $un;
            
            if($bun == ""){
                return $array;
            }else{
                $val = $this->db->escape($bun);
            }
            
        }
        
        
    }
}