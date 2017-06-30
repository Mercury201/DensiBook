        <?php
            class Auth extends CI_Controller{
                
                public function __construct(){
                    parent::__construct();
                    $this->load->model('User');
                    $this->load->library('session');
                    $this->load->helper('url');
                    //$this->load->library('form_validation');
                }
                
                public function login(){
                    
                    //既にログインしている
                    if($this->session->userdata('is_login') == 'yes'){
                        redirect(site_url('Account/'));
                    }
                    
                    //POSTでこのページにきた場合
                    elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
                        
                        $email = $this->input->post('email');
                        $password = $this->input->post('password');
                        
                        //認証
                        if($this->User->db_check($email, $password)){
                            $this->session->set_userdata(array('is_login' => 'yes',
                                                                'email' => $email));
                                                            
                            redirect(site_url('Account/'));
                        }else{
                            
                            $array = array('email' => $email,
                                            'message' => 'emailかpasswordが違います');
                            $this->load->view('login_form', $array);
                        }
                        
                    //get    
                    }else{
                        //echo var_dump($_SERVER['REQUEST_METHOD']);
                        $this->load->view('login_form');
                    }
                }
                
                public function createAccount(){
                    
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $this->_createAccountValidation();
                    }else{
                        $this->load->view('createAccountForm');
                    }
                    
                }
                
                //アカウント作成時に入力された値が正しいかどうかで遷移先を決定する
                public function _createAccountValidation(){
                    $user = $_POST;
                    
                    //var_dump($user);
                    
                    $isEmail = $this->User->isEmail($user['email']);
                    
                    //なければ
                    if($isEmail != true){
                        
                        //コメントはずしたら動く
                        $this->User->addUser($user);
                        $this->load->view('success');
                        //echo 'OK';
                        
                    }else{
                        $message = array('message' => '既にこのメールアドレスは登録されています。');
                        $this->load->view('createAccountForm', $message);
                        //$this->createAccount($message);
                    }
                }
                
        }