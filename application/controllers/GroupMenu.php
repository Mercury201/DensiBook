<?php 
class GroupMenu extends MY_Controller{
    
    private $userNo;
    private $groupNo;
    
     public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Group');
        $this->load->model('User');
        $this->load->model('Match');
        
    }
    
    
    
    public function index($val=null){
        
        $this->groupNo = $val;
        $this->userNo = $this->User->getUserNo($this->session->userdata('email'));
        
        
        if($this->Group->isGroupMember($this->groupNo, $this->userNo)){
            
            //viewに渡すデータ
            $data = array('groupNo' => $this->groupNo,
            'groupName' => $this->Group->getGroupNameByGroupNo($this->groupNo),
            'firstTime' => !$this->Match->isMatch($this->groupNo)
            );
            
            $this->load->view('groupMenu', $data);
            
        }else{
            echo 'グループメンバーではありません。';
        }
    }
    
}