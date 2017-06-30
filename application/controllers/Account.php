<?php
class Account extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Group');
        $this->load->model('User');
        $this->load->model('Affiliation');
    }
    
    public function index(){
        
        $userNo = $this->User->getUserNo($this->session->userdata('email'));
        
        //グループがないときの表示
        if(!$this->Group->isGroup($userNo)){
            $this->load->view('AccountPage/header', array('title' => 'トップ'));
            $this->load->view('AccountPage/NoDataNav');
            $this->load->view('AccountPage/main');
            $this->load->view('AccountPage/footer');
            return;
        }
        
        $this->load->view('AccountPage/header', array('title' => 'トップ'));
        $this->load->view('AccountPage/nav',$this->Group->getGroupData($this->session->userdata('email')));
        $this->load->view('AccountPage/main');
        $this->load->view('AccountPage/footer');
        
    }
    
    //ログアウト
    //セションを削除する
    public function logout(){
        $this->session->sess_destroy();
         redirect(site_url('Account/'));
    }
    
    //個人設定
    public function mySetting(){
        
        //POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            
            
            //更新時にセション更新する
            $userData = $this->_updateValidation();
            $this->sessionUpdate($userData['email']);
            
            $userNo = $this->User->getUserNo($this->session->userdata('email'));
            
            //変更時に全てのグループに追加
            $this->addAffiliation($userNo);
            
            //グループがないときの表示
            if(!$this->Group->isGroup($userNo)){
                
                $this->load->view('AccountPage/header', array('title' => '個人設定'));
                $this->load->view('AccountPage/NoDataNav');
                $this->load->view('AccountPage/mySetting', $userData);
                $this->load->view('AccountPage/footer');
            
            //グループがあるときの表示    
            }else{
                
                $this->load->view('AccountPage/header',array('title' => '個人設定'));
                $this->load->view('AccountPage/nav',$this->Group->getGroupData($this->session->userdata('email')));
                $this->load->view('AccountPage/mySetting', $userData);
                $this->load->view('AccountPage/footer');
                
            }
            
       
        //GET
        }else{
            
            $userNo = $this->User->getUserNo($this->session->userdata('email'));
            $userData = $this->User->getUserDataAll($userNo);
            
            //グループがないときの表示
            if(!$this->Group->isGroup($userNo)){
                $this->load->view('AccountPage/header', array('title' => '個人設定'));
                $this->load->view('AccountPage/NoDataNav');
                $this->load->view('AccountPage/mySetting', $userData);
                $this->load->view('AccountPage/footer');
                
            //あるとき
            }else{
                
            $this->load->view('AccountPage/header',array('title' => '個人設定'));
            $this->load->view('AccountPage/nav',$this->Group->getGroupData($this->session->userdata('email')));
            $this->load->view('AccountPage/mySetting', $userData);
            $this->load->view('AccountPage/footer');
            
                
            }
                                                
            
        }
        
    }
    
    //グループ作成
    public function makingGroup(){
        
        $userNo = $this->User->getUserNo($this->session->userdata('email'));
        
         //POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            //グループ作成
            $this->createGroup($_POST);
            
            //グループがないときの表示
            if(!$this->Group->isGroup($userNo)){
                $this->load->view('AccountPage/header', array('title' => 'トップ'));
                $this->load->view('AccountPage/NoDataNav');
                $this->load->view('AccountPage/makingGroup');
                $this->load->view('AccountPage/footer');
                return;
            }
            //グループがある
            $this->load->view('AccountPage/header',array('title' => 'グループ作成'));
            $this->load->view('AccountPage/nav',$this->Group->getGroupData($this->session->userdata('email')));
            $this->load->view('AccountPage/makingGroup');
            $this->load->view('AccountPage/footer');
            
        //GET
        }else{
            
            //グループがないときの表示
            if(!$this->Group->isGroup($userNo)){
                $this->load->view('AccountPage/header', array('title' => 'トップ'));
                $this->load->view('AccountPage/NoDataNav');
                $this->load->view('AccountPage/makingGroup');
                $this->load->view('AccountPage/footer');
                return;
            }
            
            
            $this->load->view('AccountPage/header',array('title' => 'グループ作成'));
            $this->load->view('AccountPage/nav',$this->Group->getGroupData($this->session->userdata('email')));
            $this->load->view('AccountPage/makingGroup');
            $this->load->view('AccountPage/footer');
            
        }
        
    }
    
    //グループ削除
    public function GroupDel(){
        
        $userNo = $this->User->getUserNo($this->session->userdata('email'));
        
         //POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            //管理者かどうかの確認
            $userNo = $this->User->getUserNo($this->session->userdata('email'));
            $isMaster = $this->Affiliation->isMaster($_POST['delNo'], $userNo);
            
            //管理者じゃないなら
            if(!$isMaster){
                
                //グループがないときの表示
                if(!$this->Group->isGroup($userNo)){
                    $this->load->view('AccountPage/header', array('title' => 'トップ'));
                    $this->load->view('AccountPage/NoDataNav');
                    $this->load->view('AccountPage/errorPage');
                    $this->load->view('AccountPage/footer');
                    return;
                }
                
                $nav = $this->Group->getGroupData($this->session->userdata('email'));
                $this->load->view('AccountPage/header',array('title' => 'メンバー編集'));
                $this->load->view('AccountPage/nav',$nav);
                $this->load->view('AccountPage/errorPage');
                $this->load->view('AccountPage/footer');
                
            //管理者なら
            }else{
                
                //group削除
                $this->Group->deleteGroup($_POST['delNo']);
                
                //グループがないときの表示
                if(!$this->Group->isGroup($userNo)){
                    $this->load->view('AccountPage/header', array('title' => 'トップ'));
                    $this->load->view('AccountPage/NoDataNav');
                    $this->load->view('AccountPage/groupDel');
                    $this->load->view('AccountPage/footer');
                    return;
                }
                
                //navを取ってくる groupNo groupName
                $nav = $this->Group->getGroupData($this->session->userdata('email'));
                
                $this->load->view('AccountPage/header',array('title' => 'グループ削除'));
                $this->load->view('AccountPage/nav',$nav);
                $this->load->view('AccountPage/groupDel');
                $this->load->view('AccountPage/footer');
            }
            
            
            
        //GET
        }else{
            
            //navを取ってくる groupNo groupName
             $nav = $this->Group->getGroupData($this->session->userdata('email'));
            
            //グループがないときの表示
            if(!$this->Group->isGroup($userNo)){
                $this->load->view('AccountPage/header', array('title' => 'トップ'));
                $this->load->view('AccountPage/NoDataNav');
                $this->load->view('AccountPage/groupDel', $nav);
                $this->load->view('AccountPage/footer');
                return;
            }
            
            
            
            $this->load->view('AccountPage/header',array('title' => 'グループ削除'));
            $this->load->view('AccountPage/nav',$nav);
            $this->load->view('AccountPage/groupDel', $nav);
            $this->load->view('AccountPage/footer');
            
        }
    }
    
    //メンバー編集
    public function memberSetting($groupNo){
        
        //管理者かどうかの確認
        $userNo = $this->User->getUserNo($this->session->userdata('email'));
        $isMaster = $this->Affiliation->isMaster($groupNo, $userNo);
        
        //管理者じゃないなら
        if(!$isMaster){
            
            $nav = $this->Group->getGroupData($this->session->userdata('email'));
            $this->load->view('AccountPage/header',array('title' => 'メンバー編集'));
            $this->load->view('AccountPage/nav',$nav);
            $this->load->view('AccountPage/errorPage');
            $this->load->view('AccountPage/footer');
            
        //管理者なら
        }else{
            
            //POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                
                if(isset($_POST['chk'])){
                    
                    if($_POST['submitButton'] == "メンバー削除"){
                    
                        //チェックされたUserNo
                        $chk = $_POST['chk'];
                        foreach($chk as $value){
                            $this->Affiliation->memberDel($value, $groupNo);
                        }
                    
                    }else if($_POST['submitButton'] == "メンバー権限変更"){
                        
                        
                        //$selectBox 1|21のような形で全て入ってるので分離
                        $explode = array();
                        $selectBox = $_POST['selectBox'];
                        
                        foreach($selectBox as $option){
                            $explode[] = explode('|', $option);
                        }
                        
                    
                        $chk = $_POST['chk'];
                        $selectBox = $_POST['selectBox'];
                        
                        foreach($chk as $key => $value){
                            $this->Affiliation->memberUpdate($value, $groupNo, $explode);
                        }
                    }
                    
                }
                
                
                $ary =$this->Affiliation->getMemberSettingData($groupNo);
                $data = array('data' => $ary);
                //navを取ってくる groupNo groupName
                $nav = $this->Group->getGroupData($this->session->userdata('email'));
                
                $this->load->view('AccountPage/header',array('title' => 'メンバー編集'));
                $this->load->view('AccountPage/nav',$nav);
                $this->load->view('AccountPage/groupSetting',$data);
                $this->load->view('AccountPage/footer');
                
            //GET
            }else{
                
                //メンバー項目をとってくる
                $ary =$this->Affiliation->getMemberSettingData($groupNo);
                $data = array('data' => $ary);
                //navを取ってくる groupNo groupName
                $nav = $this->Group->getGroupData($this->session->userdata('email'));
                
                $this->load->view('AccountPage/header',array('title' => 'メンバー編集'));
                $this->load->view('AccountPage/nav',$nav);
                $this->load->view('AccountPage/groupSetting', $data);
                $this->load->view('AccountPage/footer');
                
            }
            
        }
        
    }
    
    //メンバー追加
    public function addMember($groupNo){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            if(isset($_POST['emailList'])){
                
                $isRegi = $this->insertMember($_POST, $groupNo);
                
                //登録した場合
                if($isRegi){
                    
                    echo <<< EOM
                    <script type="text/javascript">alert( "登録しました。" )</script>
EOM;
                    
                    
                }
                
            }else{
               //登録なし
            }
            
            //navを取ってくる groupNo groupName
            $nav = $this->Group->getGroupData($this->session->userdata('email'));
            
            $this->load->view('AccountPage/header',array('title' => 'メンバー追加'));
            $this->load->view('AccountPage/nav',$nav);
            $this->load->view('AccountPage/addMember');
            $this->load->view('AccountPage/footer');
            
        //GET
        }else{
            
            //navを取ってくる groupNo groupName
            $nav = $this->Group->getGroupData($this->session->userdata('email'));
            
            $this->load->view('AccountPage/header',array('title' => 'メンバー追加'));
            $this->load->view('AccountPage/nav',$nav);
            $this->load->view('AccountPage/addMember');
            $this->load->view('AccountPage/footer');
        }
        
    }
    
    
    //アカウント作成時に入力された値が正しいかどうかで代入する変数を変える
    private function _updateValidation(){
        $user = $_POST;
        
        //var_dump($user);
        
        //初期値
        $isEmail = false;
        
        //セッションとpostのemailを比較し、重複チェックが必要かどうか
        $email = $this->session->userdata('email');
        
        if($email == $user['email']){
            
        }else{
            $isEmail = $this->User->isEmail($user['email']);
        }
        
        
        //なければ
        if($isEmail != true){
            
            $this->User->updateUser($user);
            
            $user = array_merge($user, array('update' => true));
            return $user;
            
        }else{
            
            $user = array_merge($user, array('mailError' => '既にこのメールアドレスは登録されています。'));
            return $user;
            
        }
        
        
    }
    
    //個人情報変更時にグループにも追加する
    private function addAffiliation($userNo){
            
            //Groupがあるか
            if($this->Group->isGroup($userNo)){
                
                //array(groupNo=>'1','groupName'=>hoge)
                //ユーザNoからgroupNoを取得
                
                $userNos = $this->User->getAllUserNo($userNo);
                $array = $this->Group->getGroupName($userNos[1]);
                
                if(count($userNos) > 1){
                    
                    //全てのグループに追加
                    foreach($array as $value){
                        //自分の前のNoから前の権限を取り出す
                        $authorityNo = $this->Affiliation->getAuthorityNo($value['groupNo'], $userNos[1]);
                    
                        if($authorityNo != -1){
                            $this->Affiliation->insertAffiliation($value['groupNo'], $userNos[0], $authorityNo);
                        }
                    
                    }
                    
                }
                
                
                
                    
            //ない
            }else{
                //echo 'false';
                
            }
        
    }
    
    
    
    //グループを作成し、ユーザを登録する
    private function createGroup($array){
        
        $this->Group->insertGroup($array['groupName']);
        $insertId = $this->db->insert_id(); //↑のgroupNo
        
        
        //自分自身を作成
        $userNo = $this->User->getUserNo($this->session->userdata('email'));
        $this->Affiliation->insertAffiliation($insertId, $userNo, 2);
        
        if(isset($array['emailList'])){
            
            foreach($array['emailList'] as $value){
                    //ユーザが存在していた場合登録
                    $userNo = $this->User->getUserNo($value);
                    if($userNo != false){
                    $this->Affiliation->insertAffiliation($insertId, $userNo, 1);
                }
            }
            
        }
        
    }
    
    private function insertMember($array, $groupNo){
        
        $isRegi = false;
        
        foreach($array['emailList'] as $value){
            
            //emailListのユーザが存在していたかつ、ユーザが既に登録されてない場合登録
            $userNo = $this->User->getUserNo($value);
            $isData = $this->Affiliation->isRegi($groupNo, $userNo);
            if($userNo != false && $isData != true){
                $this->Affiliation->insertAffiliation($groupNo, $userNo, 1);
                $isRegi = true;
            }
        }
        
        return $isRegi;
    }
    
    public function sessionUpdate($email){
        
        $this->session->set_userdata(array(
            'is_login' => 'yes',
            'email' => $email));
    }
    
}