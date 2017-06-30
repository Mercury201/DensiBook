<?php
class TestTakuma extends CI_Controller {
    
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
    
    
    
    public function resultDisplay(){
        //////////1打席目の投球内容///////////                
        //1球目
        $kyume1 = array('x' => 170,
        'y' => 240,
        '判定' => 1,
        '球種' => 2);
        
        //2球目
        $kyume2 = array('x' => 200,
        'y' => 234,
        '判定' => 2,
        '球種' => 3);
        //3球目
        $kyume3 = array('x' => 110,
        'y' => 20,
        '判定' => 1,
        '球種' => 2);
        
        //4球目
        $kyume4 = array('x' => 64,
        'y' => 70,
        '判定' => 4,
        '球種' => 3);
        
        //1打席目の投球内容
        $naiyou[] = $kyume1;
        $naiyou[] = $kyume2;//以下続く
        $naiyou[] = $kyume3;
        $naiyou[] = $kyume4;
        
        ////////////2打席目の投球内容/////////////
        //1球目
        $kyume1 = array('x' => 107,
        'y' => 200,
        '判定' => 3,
        '球種' => 2);
        
        //2球目
        $kyume2 = array('x' => 62,
        'y' => 136,
        '判定' => 1,
        '球種' => 3);
        //3球目
        $kyume3 = array('x' => 110,
        'y' => 20,
        '判定' => 3,
        '球種' => 2);
        
        //4球目
        $kyume4 = array('x' => 64,
        'y' => 70,
        '判定' => 10,
        '球種' => 6);
        
        //2打席目の投球内容
        $naiyou2[] = $kyume1;
        $naiyou2[] = $kyume2;//以下続く
        $naiyou2[] = $kyume3;
        $naiyou2[] = $kyume4;
        
        /////////////3打席目の投球内容//////////////
        //1球目
        $kyume1 = array('x' => 150,
        'y' => 246,
        '判定' => 3,
        '球種' => 1);
        
        //2球目
        $kyume2 = array('x' => 62,
        'y' => 136,
        '判定' => 1,
        '球種' => 2);
        //3球目
        $kyume3 = array('x' => 110,
        'y' => 20,
        '判定' => 2,
        '球種' => 3);
        
        //4球目
        $kyume4 = array('x' => 64,
        'y' => 70,
        '判定' => 2,
        '球種' => 4);
        //5球目
        $kyume5 = array('x' => 251,
        'y' => 200,
        '判定' => 3,
        '球種' => 5);
        
        //6球目
        $kyume6 = array('x' => 76,
        'y' => 136,
        '判定' => 3,
        '球種' => 6);
        //7球目
        $kyume7 = array('x' => 179,
        'y' => 78,
        '判定' => 3,
        '球種' => 4);
        
        //8球目
        $kyume8 = array('x' => 77,
        'y' => 111,
        '判定' => 7,
        '球種' => 6);
        
        //3打席目の投球内容
        $naiyou3[] = $kyume1;
        $naiyou3[] = $kyume2;
        $naiyou3[] = $kyume3;
        $naiyou3[] = $kyume4;
        $naiyou3[] = $kyume5;
        $naiyou3[] = $kyume6;
        $naiyou3[] = $kyume7;
        $naiyou3[] = $kyume8;
        
        
        //ランナー状況
        $joukyou1 = array('firstRunnerNo' => 0,
                            'firstRunnerName' => "",
                            'secondRunnerNo' => 13,
                            'secondRunnerName' => "中田 翔",
                            'thirdRunnerNo' => 0,
                            'thirdRunnerName' => "");
                            
        $joukyou2 = array('firstRunnerNo' => 176,
                            'firstRunnerName' => "イチロー",
                            'secondRunnerNo' => 245,
                            'secondRunnerName' => "阿部 慎之介",
                            'thirdRunnerNo' => 0,
                            'thirdRunnerName' => "");
        
        
        $joukyou3 = array('firstRunnerNo' => 5555,
                            'firstRunnerName' => "松井 秀樹",
                            'secondRunnerNo' => 5151,
                            'secondRunnerName' => "イチロー",
                            'thirdRunnerNo' => 2323,
                            'thirdRunnerName' => "山口 拓真");
        
        //1打席目のデータ
        $daseki1 = array('打者名' => '山口拓真',
        '打者利き打ち' => '左',
        '対戦投手' => '田中 将大',
        '投手利き手' => '右',
        'イニング' => '1回裏',
        '投球内容' => $naiyou,//多次元配列
        //'玉数' => '2', 投球内容の数を参照
        'ランナー状況'=> $joukyou1,
        //'打席結果' => '安打', これは投球内容の中の球目にはいってる
        '打球方向x' => 97,
        '打球方向y' => 105,
        '得点' => '0',
        '打点' => '0',
        'ストライクカウント' => 1,
        'ボールカウント' => 2,
        'アウトカウント' => 0);
        
        //2打席目のデータ
        $daseki2 = array('打者名' => '山口拓真',
        '打者利き打ち' => '左',
        '対戦投手' => '田中 将大',
        '投手利き手' => '右',
        'イニング' => '3回裏',
        '投球内容' => $naiyou2,
        //'玉数' => '2', 投球内容の数を参照
        'ランナー状況'=> $joukyou2,
        //'打席結果' => '安打', これは投球内容の中の球目にはいってる
        '打球方向x' => 219,
        '打球方向y' => 187,
        '得点' => '0',
        '打点' => '1',
        'ストライクカウント' => 2,
        'ボールカウント' => 3,
        'アウトカウント' => 2);
        
        //3打席目のデータ
        $daseki3 = array('打者名' => '山口拓真',
        '打者利き打ち' => '左',
        '対戦投手' => 'ダルビッシュ有',
        '投手利き手' => '右',
        'イニング' => '6回裏',
        '投球内容' => $naiyou3,
        //'玉数' => '2', 投球内容の数を参照
        'ランナー状況'=> $joukyou3,
        //'打席結果' => '安打', これは投球内容の中の球目にはいってる
        '打球方向x' => 298,
        '打球方向y' => 21,
        '得点' => '4',
        '打点' => '4',
        'ストライクカウント' => 2,
        'ボールカウント' => 2,
        'アウトカウント' => 2);
        
        
        //全ての打席データをまとめる
        $allDaseki[] = $daseki1;
        $allDaseki[] = $daseki2;
        $allDaseki[] = $daseki3;
        
        $match1 = array('日付' => "2016-02-12",
                        '対戦校' => "津田中学校");
                        
        $match2 = array('日付' => "2016-02-23",
                        '対戦校' => "道後中学校");
        
        $match3 = array('日付' => "2016-02-04",
                        '対戦校' => "松山西中学校");
        
        $match[] = $match1;
        $match[] = $match2;
        $match[] = $match3;
        
        $opponent[] = "津田中学校";
        $opponent[] = "道後中学校";
        $opponent[] = "松山西中学校";
        
        $date[] = "2016-02-12";
        $date[] = "2016-02-23";
        $date[] = "2016-02-04";
        
        $userNo[] = "1";
        $userNo[] = "2";
        $userNo[] = "3";
        $userNo[] = "4";
        
        $userName[] = "山口拓真";
        $userName[] = "斉藤祐樹";
        $userName[] = "藤波新太郎";
        $userName[] = "山田哲人";
        
        
        
        $data = array(
                    '試合' => $match,
                    '日付' => $date,
                    'ユーザNo' => $userNo,
                    'ユーザ名' => $userName,
                    'グループNo' => "1");
                    
        $array = array(
                    'select' => $data,
                    'atbatsum' => $allDaseki);
                    
        
        
        $this->load->View('resultDisplay',$array);
    }
    
    public function atbatRecord(){
        
        $ary1 = array('data1' => "string1",
                    'data2' => "string2",
                    'data3' => "string3");
                    
        $ary2 = array('data1' => "string1",
                    'data2' => "string2",
                    'data3' => "string3");
        
        $ary3 = array('takuma' => "山口 拓真",
                    'data2' => "string2",
                    'data3' => "string3");
                    
        $sumarray = array('batted1' => $ary1,
                        'batted2' => $ary2,
                        'batted3' => $ary3);
        
        $array = array('sumary' => $sumarray,
                        'situationNo' => 1,
                        'inning' => 1,
                        'topBottom' => "表",
                        'battedOutcount' => 1,
                        'orderNo' => 3,
                        'batterNo' => 2323,
                        'batterName' => "山口 拓真",
                        'batterHanded' => "左打ち",
                        'pitcherNo' => 1111,
                        'pitcherName' => "大谷 翔平",
                        'pitcherHanded' => "右投げ",
                        'firstRunnerNo' => 11111,
                        'firstRunnerName' => "オコエ 瑠偉",
                        'secondRunnerNo' => 0,
                        'secondRunnerName' => "",
                        'thirdRunnerNo' => 0,
                        'thirdRunnerName' => "");
                    
        $this->load->view('atbatRecord', $array);
    }
    
    public function maruchiTabu(){
        
        $ary1 = array('data1' => "string1",
                    'data2' => "string2",
                    'data3' => "string3");
                    
        $ary2 = array('data1' => "string1",
                    'data2' => "string2",
                    'data3' => "string3");
        
        $ary3 = array('data1' => "string1",
                    'data2' => "string2",
                    'data3' => "string3");
                    
        
        
        $this->load->View('maruchiTabu',$allDaseki);
    }
    
    public function resDisp(){
        
        $match1 = array('日付' => "2016-02-12",
                        '対戦校' => "津田中学校");
                        
        $match2 = array('日付' => "2016-02-23",
                        '対戦校' => "道後中学校");
        
        $match3 = array('日付' => "2016-02-04",
                        '対戦校' => "松山西中学校");
        
        $match[] = $match1;
        $match[] = $match2;
        $match[] = $match3;
        
        $opponent[] = "津田中学校";
        $opponent[] = "道後中学校";
        $opponent[] = "松山西中学校";
        
        $date[] = "2016-02-12";
        $date[] = "2016-02-23";
        $date[] = "2016-02-04";
        
        $userNo[] = "1";
        $userNo[] = "2";
        $userNo[] = "3";
        $userNo[] = "4";
        
        $userName[] = "山口拓真";
        $userName[] = "斉藤祐樹";
        $userName[] = "藤波新太郎";
        $userName[] = "山田哲人";
        
        
        
        $data = array(
                    '試合' => $match,
                    '日付' => $date,
                    'ユーザNo' => $userNo,
                    'ユーザ名' => $userName,
                    'グループNo' => "1");
        
        $array = array(
            'select' => $data);
        
        var_dump($data);
        
        $this->load->View('resDisp',$array);
    }
    
    //打席結果を取得
    public function atbatResult(){
        
        //$this->load->model('Course');
        
        var_dump($_POST);
        
        /*球数,試合No,状況No
        $pitchSum = $_POST['pitchNum'];
        $matchNo = $_POST['matchNo'];
        $situationNo = $_POST['situationNo'];
        
        //投球内容を配列に格納
        $array = explode(",",$_POST['array']);
        
        //echo "球数： $pitchSum";
        
        $j = 0;
        
        for($i = 0; $i < $pitchSum; ++$i){
            
            $X = $array[$j];
            $Y = $array[++$j];
            $countNo = $array[++$j];
            $decisionNo = $array[++$j];
            $j = ++$j;
            
            $this->Course->addCourse($matchNo,$situationNo,$X,$Y,$countNo,$decisionNo);
        }
        
        $this->AtbatView();
        */
        
    }
    
    //テスト用投球結果保存
    public function testDb(){
        
        $i = 2;
        for($num = 0; $num < $i; $num++){
            echo $num;
        }
        
        //$test = explode(",",$_POST['array']);
        //$test1 = $test[1];
        //echo "$test1";
        //var_dump($_POST['array']);
        //$course = $_POST;
        //$this->AtbatView();
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
