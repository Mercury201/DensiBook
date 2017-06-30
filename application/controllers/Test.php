<?php
class Test extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        
        //autoload設定したため、必要なくなった
        //$this->load->database();
    }
    
    public function showPostData(){
        var_dump($_POST);
    }

    public function index(){
        echo 'index';
    }
    
    public function TestAddUser(){
        $this->load->model('User');
        //User->addUser();
        //TestSQL();
    }
    
    
    public function TestView(){
        $this->load->view('createAccountForm');
    }
    
    public function AtbatView(){
        $this->load->view('atbatView');
    }
    
    
    //動作OK
    public function TestSQL(){
        
        //接続確認
        if($this->db->conn_id === false){
            echo 'dbに接続されていません';
        }else{
            
            $query = $this->db->query('select * from user');
        
            $result = $query->result('array');
            foreach($result as $row){
                foreach($row as $data){
                    print($data);
                }
                echo "<br/>";
            }
        }
    }
    
    //ダメみたいですね
    public function TestSQL2(){
        $this->db->like('name', '田村');
        $query = $this->db->get('user');
        $result = $query->row_array();
        
        foreach($result as $row){
            print($row->name);
            echo "<br/>";
        }
    }

}
