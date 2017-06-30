<?php
class TestKojima extends CI_Controller{
    
    public function TestAddUser(){
        $this->load->model('User');
        $user = $_POST;
        $this->load->helper('form');
        $this->User->addUser($user);
        //TestSQL();
    }
    
     public function showPostData(){
        var_dump($_POST);
    }
    
    public function URIdata($group){
        
        echo $group;
    }
    
    public function checkFunction($groupNo){
         $this->load->model('Group');
         
         
         if($this->Group->isGroupMember($groupNo, 2)){
             echo 'TRUE';
         }else{
             echo 'FALSE';
         }
    }
    
    public function TestRow(){
        //$val = $this->db->escape($email);
        $sql = 'select count(*) as count from user where email = "aaa@gmail.com"';
        
        //クエリ実行
        $query = $this->db->query($sql);
        
        $row = $query->row();
        
        var_dump($query);
        
        //echo $row->count;
        //echo $query->num_rows();
        
    }
    
    public function GetNowTime(){
        echo date("Y-m-d");
    }
    
    public function TestNav(){
        $this->load->model('User');
        $this->load->model('Group');
        
        $userNo = $this->User->getUserNo('y-otaki@gmail.com');
        //echo $userNo;
        
        $is = $this->Group->isGroup($userNo);
        
        if($is){
            echo 'true';
        }
    }
    
    public function sessionDel(){
        $this->load->library('session');
        $this->session->sess_destroy();
    }
    
    public function TestSQL(){
        $this->load->model('Affiliation');
        
         echo $this->Affiliation->getAuthorityNo(7, 85);
        
    }
    
    public function View(){
        $this->load->view('groupMenu');
    }
    
    
    
    //Viewへのデータ受け渡しサンプル
    public function TestView(){
        
        //受け渡すデータの作成
        $integer = 12345;
        $ary1 = array('data11' => "string11",
                    'data12' => "string12",
                    'data13' => "string13");
                    
        $ary2 = array('data21' => "string21",
                    'data22' => "string22",
                    'data23' => "string23");
                    
        $arys = array('ary1' => $ary1,
                        'ary2' => $ary2);
        
        //受け渡すための配列にデータをセット
        $data = array(
                'dataInt' => $integer,
                'dataAry'  => $ary1,
                'arys' => $arys);
                
        
        
        
        //viewへのデータの受け渡し
        $this->load->view('/samplePage', $data);
    }
    
    
    private function TestData(){
        
        //1球目
        $kyume1 = array('x' => '110',
        'y' => '20',
        'desition' => 'ストライク',
        '球種' => 'ストレート');
        
        //2球目
        $kyume2 = array('x' => '10',
        'y' => '30',
        'desition' => 'ヒット',
        '球種' => 'スライダー');
        
        //全ての投球内容
        $naiyou[] =  $kyume1;
        $naiyou[] = $kyume2;//以下続く
        
        //状況
        $joukyou = array('firstNo' => 0,
                            'firstName' => "",
                            'secondNo' => 13,
                            'secondName' => "ウサイン・ボルト",
                            'thardNo' => 0);
        
        //1打席目のデータ
        $daseki1 = array('対戦投手' => '田中 将大',
        '投手利き手' => '右',
        'イニング' => '1回表',
        '投球内容' => $naiyou,//多次元配列
        //'玉数' => '2', 投球内容の数を参照
        'ランナー状況'=> $joukyou,
        //'打席結果' => '安打', これは投球内容の中の球目にはいってる
        '得点' => '1',
        '打点' => '1',
        '打球方向x' => '90',
        '打球方向y' => '90',
        'ストライクカウント' => '2',
        'ボールカウント' => '3',
        'アウトカウント' => 0);
        
        //1球目
        $kyume1 = array('x' => '110',
        'y' => '20',
        'desition' => 'ストライク',
        '球種' => 'ストレート');
        
        //2球目
        $kyume2 = array('x' => '10',
        'y' => '30',
        'desition' => 'ヒット',
        '球種' => 'スライダー');
        
        //全ての投球内容
        $naiyou[] =  $kyume1;
        $naiyou[] = $kyume2;//以下続く
        
        
        //状況
        $joukyou = array('first' => '0',
        'second' => '13',
        'thard' => '0');
        
        //2打席目のデータ
        $daseki2 = array('対戦投手' => 'ダルビッシュ有',
        '投手利き手' => '右',
        'イニング' => '3回裏',
        '投球内容' => $naiyou,
        //'玉数' => '2', 投球内容の数を参照
        'ランナー状況'=> $joukyou,
        //'打席結果' => '安打', これは投球内容の中の球目にはいってる
        '得点' => '4',
        '打点' => '4',
        '打球方向x' => '100',
        '打球方向y' => '80',
        'ストライクカウント' => '2',
        'ボールカウント' => '3',
        'アウトカウント' => 2);
        
        
        //全ての打席をいれる
        $allDaseki[] = $daseki1;
        $allDaseki[] = $daseki2;
        
        //$data = array('data' => $Alldaseki);
        
        return $allDaseki;
    }
    
    public function ViewTestData(){
        
        $allDaseki = $this->TestData();
        
        echo $allDaseki[0]['投球内容'][0]['x']. '<br/>';
        
        //echo count($allDaseki[0]['投球内容']);
        
        $array = array('1' => 'aaa',
        'key' => 'keyString'
        );
        
        foreach($array as $key => $value){
            
            echo '$value=' . $value. ' ';
            echo '$key='.$key. ' ';
            echo '$array[$key]='. $array[$key];
            echo '<br/>';
            
        }
        
        foreach($array as $value){
            
        }
    }
}