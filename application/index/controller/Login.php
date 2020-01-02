<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use think\Request;
use think\Db;
class Login extends HomeBase
{
    public function _initialize()
    {
        parent::_initialize();
           $this->assign('nav_id', 31);

    }
    public function index()
    {
        if(session('?user'))
        {
          //  $this->redirect('/');

        }
        return $this->fetch();
    }
    public function login()
    {
        $data= $this->request->param();
       //获取密码
       $password=db('user')->where('username',$data['username'])->whereOr('mobile',$data['username'])->find();
       if(empty($password))
       {
            return json(['status'=>0,'message'=>'密码或者账号有误']);
       }
       if($password['password']==md5($data['password']))
       {
        session('user',$password);
        return json(['status'=>1,'message'=>'登录成功']);
       }else{
        return json(['status'=>0,'message'=>'密码或者账号有误']);
       }
    }
    public function logon()
    {
        return $this->fetch();
    }





}