<?php 
class Record extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        
        //必要なものをロード
        $this->load->model('Match');
        $this->load->model('User');
        $this->load->model('Player');
        $this->load->model('Position');
        $this->load->model('Situation');
        $this->load->model('Course');
        $this->load->model('BattedBall');
        $this->load->model('Decision');
        $this->load->model('TypeOfPitch');
        $this->load->model('Scoring');
        $this->load->library('session');
    }
    
    
    public function index($groupNo=null){
        
        $groupNo;
         //post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $res =  $this->DasekiResult($_POST['date'], $_POST['opponent'], $_POST['name']);
            
            $data = array('select' => $this->saisyo($groupNo),
             'atbatsum' => $res
             );
            
            $this->load->view('resultDisplay', $data);
            
        //get     
        }else{
            $data = array('select' => $this->saisyo($groupNo),
             'atbatsum' => null
             );
            
            
            
            $this->load->view('resDisp', $data);
            // $this->load->view('resDisp',$this->saisyo());
            // $this->load->view('resultDisplay', $this->saisyo());
        }
        
    }
    
    public function DasekiResult($hiduke, $taisenkou, $userNo){
        //処理
        // var_dump($hiduke.$taisenkou.$userNo);
        //日付と対戦校から試合Noを取得する
        $matchNo = $this->Match->searchMatchNo($hiduke, $taisenkou);
        
        //試合NoとユーザNoからプレイヤーNoを取得する
        $playerNo = $this->Player->getMatchPlayerNo($matchNo,$userNo);
        
        $player = $this->Player->getPlayerData($playerNo);
        //選手名取得
        $userName = $player['playerName'];
        //利き打ち取得
        $battingHanded = $player['battingHanded'];
        
        //選手の打席結果確定直前の状況を打席数分返す
        $situation = $this->Situation->getBatterSituation($playerNo);
        foreach($situation as $daseki){
            //投手データ取得
            $pitcher = $this->Player->getPlayerData($daseki['pitcher']);
            //投手のプレイヤーNoを入れる
            $pitcherNo = $daseki['pitcher'];
            //投手名
            $pitcherName = $pitcher['playerName'];
            //投手の利き投げ
            $pitcherHanded = $pitcher['throwHanded'];
            
            //表か裏かが１(表)か０(裏)で格納されているので文字に直す
            if($daseki['topBottom']){
                $topBottom = "表";
            }else{
                $topBottom = "裏";
            }
            
            //イニングを成形する
            $inning = $daseki['inning']."回".$topBottom;
            
            //打席に対応した状況Noを取得する
            $atbatSituationNo = $this->Situation->getSameAtbat($daseki['matchNo'], $daseki['topBottom'], $daseki['inning'],
                                                               $daseki['plateAppearance']);
            //1打席分の投球情報を取得する
            $pitch = $this->Course->getAtbatCourse($atbatSituationNo);
            
            //打球位置座標の取得に用いるため打席確定時のコースNoを取得する
            $battedCourseNo = $pitch[count($pitch) - 1]['courseNo'];
            //前打席の投球データを削除する
            unset($naiyou);
            //投球数分の投球データを取得する
            foreach($pitch as $row){
                //判定名を取得する
                // $decisionName = $this->Decision->getDecisionName($row['decisionNo']);
                //球種名を取得する
                $typeOfPitchName = $this->TypeOfPitch->getTypeOfPitchName($row['typeOfPitchNo']);
                //１球分のデータを入れる
                $kyume1= array(
                                'x' => $row['coordinateX'],     //投球のⅹ軸
                                'y' => $row['coordinateY'],     //投球のy軸
                                '判定' => $row['decisionNo'],    //判定No
                                '球種' => $row['typeOfPitchNo']      //球種No
                                );
                //投球内容に１球分のデータを追加する
                $naiyou[] = $kyume1;
            }
            //ランナー情報を取得する
            
            //１塁ランナーがいるか
            if($daseki['firstRunner'] != null){
                //１塁ランナーのプレイヤーNoを入れる
                $firstRunnerNo = $daseki['firstRunner'];
                //１塁ランナーの名前を取得する
                $firstRunnerName = $this->Player->getPlayerName($daseki['firstRunner'])[0];
            }else{
                //いない場合はナンバーと名前に０を入れる
                $firstRunnerNo = 0;
                $firstRunnerName = 0;
            }
            
            //２塁ランナーがいるか
            if($daseki['secondRunner'] != null){
                $secondRunnerNo = $daseki['secondRunner'];
                $secondRunnerName = $this->Player->getPlayerName($daseki['secondRunner'])[0];
            }else{
                $secondRunnerNo = 0;
                $secondRunnerName = 0;
            }
            
            //３塁ランナーがいるか
            if($daseki['thirdRunner'] != null){
                $thirdRunnerNo = $daseki['thirdRunner'];
                $thirdRunnerName = $this->Player->getPlayerName($daseki['thirdRunner'])[0];
            }else{
                $thirdRunnerNo = 0;
                $thirdRunnerName = 0;
            }
            
            //ランナー情報を入れる
            $joukyou = array(
                        'firstRunnerNo' => $firstRunnerNo,
                        'firstRunnerName' => $firstRunnerName,
                        'secondRunnerNo' => $secondRunnerNo,
                        'secondRunnerName' => $secondRunnerName,
                        'thirdRunnerNo' => $thirdRunnerNo,
                        'thirdRunnerName' => $thirdRunnerName);
            
            //打席の得点を取得する
            $run = $this->Scoring->getAtbatRun($atbatSituationNo);
            //打席の打点を取得する
            $rbi = $this->Scoring->getAtbatRbi($atbatSituationNo);
            
            //打球方向の座標を取得する
            // x172,y310
            
            $coordinate = $this->BattedBall->getCoordinate($battedCourseNo);
            $coordinateX = $coordinate['coordinateX'];
            $coordinateY = $coordinate['coordinateY'];
            
            
            //打席確定直前のストライクカウント
            $strike = $daseki['strike'];
            //打席確定直前のボールカウント
            $ball = $daseki['ball'];
            //打席確定直前のアウトカウント
            $out = $daseki['out'];
            
            if($strike == 3){
                $strike = 2;
            }
            
            if($ball == 4){
                $ball = 3;
            }
            
            //１打席の情報を入れる
            $daseki1 = array('対戦投手' => $pitcherName,
            '打者名' => $userName,
            '打者利き打ち' => $battingHanded,
            '投手利き手' => $pitcherHanded,
            'イニング' => $inning,
            '投球内容' => $naiyou,//多次元配列
            //'玉数' => '2', 投球内容の数を参照 　コード：count($allDaseki[0]['投球内容'])
            'ランナー状況'=> $joukyou,
            //'打席結果' => '安打', これは投球内容の中の球目にはいってる
            '得点' => $run,
            '打点' => $rbi,
            '打球方向x' => $coordinateX,
            '打球方向y' => $coordinateY,
            'ストライクカウント' => $strike,
            'ボールカウント' => $ball,
            'アウトカウント' => $out);
            
            //全打席を格納する配列に１打席の情報を追加する
            $allDaseki[] = $daseki1;
        }
        
        
        $data = $allDaseki;
        
        // var_dump(count($allDaseki[0]['投球内容']));
        
        // var_dump($data);
        
        // $data = array('全ての打席' => $syori);
        
        return $data;
    }
    
    public function saisyo($groupNo){
        //処理
        
        //選択されたグループによる試合を取得する
        $groupMatch = $this->Match->getGroupMatch($groupNo);
        
        foreach($groupMatch as $key => $value){
            //日付
            $match[$key]['日付'] = $value['date'];
            //対戦校
            $match[$key]['対戦校'] = $value['opponent'];
            //試合No
            $matchNo[] = $value['matchNo'];
            //重複排除した火つけの取得
            $uniqueDate[$key] = $value['date'];
        }
        //重複排除
        $uniqueDate = array_unique($uniqueDate);
        //キーを0から昇順にふる
        $uniqueDate = array_values($uniqueDate);
        
        //試合に参加したことのあるユーザを取得する
        $userNo = $this->Player->getparticipateUser($matchNo);
        //現行ユーザを取得
        $userNo = $this->User->getActiveUserNo($userNo);
        $user = $this->User->getPlayerData($userNo);
        $userName = $user['name'];
        
        
        $data = array(
                    '試合' => $match,
                    '日付' => $uniqueDate,
                    'ユーザNo' => $userNo,
                    'ユーザ名' => $userName,
                    'グループNo' => $groupNo);
                    
        // var_dump($data);
        
        return $data;
    }
    
    public function testData(){
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
        '球種' => 2);
        
        //2球目
        $kyume2 = array('x' => 62,
        'y' => 136,
        '判定' => 1,
        '球種' => 3);
        //3球目
        $kyume3 = array('x' => 110,
        'y' => 20,
        '判定' => 2,
        '球種' => 2);
        
        //4球目
        $kyume4 = array('x' => 64,
        'y' => 70,
        '判定' => 2,
        '球種' => 3);
        //5球目
        $kyume5 = array('x' => 251,
        'y' => 200,
        '判定' => 3,
        '球種' => 2);
        
        //6球目
        $kyume6 = array('x' => 76,
        'y' => 136,
        '判定' => 3,
        '球種' => 3);
        //7球目
        $kyume7 = array('x' => 179,
        'y' => 78,
        '判定' => 3,
        '球種' => 2);
        
        //8球目
        $kyume8 = array('x' => 77,
        'y' => 111,
        '判定' => 7,
        '球種' => 3);
        
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
        $joukyou1 = array('firstNo' => 0,
                            'firstName' => "",
                            'secondNo' => 13,
                            'secondName' => "中田 翔",
                            'thirdNo' => 0,
                            'thirdName' => "");
                            
        $joukyou2 = array('firstNo' => 176,
                            'firstName' => "イチロー",
                            'secondNo' => 245,
                            'secondName' => "阿部 慎之介",
                            'thirdNo' => 0,
                            'thirdName' => "");
        
        
        $joukyou3 = array('firstNo' => 5555,
                            'firstName' => "松井 秀樹",
                            'secondNo' => 5151,
                            'secondName' => "イチロー",
                            'thirdNo' => 2323,
                            'thirdName' => "山口 拓真");
        
        //1打席目のデータ
        $daseki1 = array('対戦投手' => '田中 将大',
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
        $daseki2 = array('対戦投手' => '田中 将大',
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
        $daseki3 = array('対戦投手' => 'ダルビッシュ有',
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
                    
        $array = array(
                    'atbatsum' => $allDaseki);
        
        return $array;
    }
}


?>