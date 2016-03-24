<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
      
      if(isset($_SESSION["ThinkUser"]))
      {
        $end_time=C("USER_AUTH_SESSION");
        if(time()-$_SESSION["ThinkUSer"]["Logintime"]>$end_time)
        {
          unset($_SESSION["ThinkUSer"]);
          $this->display();
        }
        else
        {
            $this->redirect("Index/main");
        }
      }else
      {
        $this->display();
      }
    
    }

    public function login()
    {
        if($this->isAjax())
        {
            $login=array();
            $username=I("post.username","","htmlspecialchars");
            $password=I("post.password");
            if(!preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_-]{2,16}$/u', $username))
            {
              R('Public.errjson',array('请输入合法的用户名'));
            }

            if(strlen($password)<6 || strlen($password)>18)
            {
              R('Public/errjson',array('请输入6位数以上的密码'));  
            }

            if($_SESSION["authcode"]!=I('post.code',''))
            {
                 R('Public/errjson',array('请输入正确的验证码')); 
            }
        }else
        {
            R("Public/errjson",array("非法请求"));
        }

    }
}