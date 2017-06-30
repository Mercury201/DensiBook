<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        
        //login check
        if($this->session->userdata('is_login') != 'yes')
        {
            redirect(site_url("Auth/login/"));
        }else{
            //echo $this->session->userdata('is_login'). "<br/>";
        }
    }
   
}
?>